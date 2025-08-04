@extends('frontend.master', ['activePage' => 'user'])
@section('title', __('My Profile'))
@section('content')

<div class="user-dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="user-info">
                <img src="{{ Auth::guard('appuser')->user()->imagePath . Auth::guard('appuser')->user()->image }}" alt="User" class="user-avatar">
                <div class="user-details">
                    <h5>{{ Auth::guard('appuser')->user()->name }}</h5>
                    <p>{{ Auth::guard('appuser')->user()->email }}</p>
                </div>
            </div>
        </div>
        
        <ul class="sidebar-nav">
            <li><a href="{{ route('userDashboard') }}" class="{{ request()->routeIs('userDashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('userOrders') }}" class="{{ request()->routeIs('userOrders') ? 'active' : '' }}"><i class="fas fa-shopping-cart"></i> My orders</a></li>
            <li><a href="{{ route('userProfile') }}" class="{{ request()->routeIs('userProfile') ? 'active' : '' }}"><i class="fas fa-user"></i> My profile</a></li>
            <li><a href="{{ route('myWallet') }}" class="{{ request()->routeIs('myWallet') ? 'active' : '' }}"><i class="fas fa-wallet"></i> My wallet</a></li>
            <li><a href="{{ route('userChangePassword') }}" class="{{ request()->routeIs('userChangePassword') ? 'active' : '' }}"><i class="fas fa-key"></i> Change password</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h2><i class="fas fa-user"></i> My Profile</h2>
            <p>Manage your personal information and preferences</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-section">
                        <div class="current-avatar">
                            <img src="{{ $user->imagePath . $user->image }}" alt="Profile Picture" id="profilePreview">
                        </div>
                        <div class="avatar-info">
                            <h4>{{ $user->name }}</h4>
                            <p>{{ $user->email }}</p>
                            <span class="member-since">Member since {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="profile-body">
                    <form action="{{ route('userProfileUpdate') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-section">
                            <h5><i class="fas fa-user-edit"></i> Personal Information</h5>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Profile Picture</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                    <small class="form-text">Max file size: 2MB. Supported formats: JPG, PNG, GIF</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5><i class="fas fa-info-circle"></i> Account Information</h5>
                            
                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Account Status</label>
                                    <span class="status-badge status-active">Active</span>
                                </div>
                                
                                <div class="info-item">
                                    <label>Member Since</label>
                                    <span>{{ $user->created_at->format('d M Y') }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <label>Last Updated</label>
                                    <span>{{ $user->updated_at->format('d M Y') }}</span>
                                </div>
                                
                                <div class="info-item">
                                    <label>Account Type</label>
                                    <span>Customer</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                            <a href="{{ route('userChangePassword') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Stats Card -->
            <div class="stats-card">
                <h5><i class="fas fa-chart-bar"></i> Quick Stats</h5>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ \App\Models\Order::where('customer_id', $user->id)->whereIn('order_status', ['Pending', 'Complete'])->count() }}</span>
                            <span class="stat-label">Total Tickets</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ \App\Models\Event::whereIn('id', \App\Models\Order::where('customer_id', $user->id)->whereIn('order_status', ['Pending', 'Complete'])->pluck('event_id'))->count() }}</span>
                            <span class="stat-label">Events Attended</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ $setting->currency }}{{ number_format(\App\Models\Order::where('customer_id', $user->id)->whereIn('order_status', ['Pending', 'Complete'])->sum('payment'), 2) }}</span>
                            <span class="stat-label">Total Spent</span>
                        </div>
                    </div>
                    
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-info">
                            <span class="stat-number">{{ count(array_filter(explode(',', $user->favorite))) }}</span>
                            <span class="stat-label">Liked Events</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.user-dashboard {
    display: flex;
    min-height: 100vh;
    background-color: #f8f9fa;
}

.sidebar {
    width: 280px;
    background: white;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.sidebar-header {
    padding: 30px 20px;
    border-bottom: 1px solid #eee;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.user-details h5 {
    margin: 0;
    font-weight: 600;
    color: #333;
}

.user-details p {
    margin: 5px 0 0 0;
    color: #666;
    font-size: 14px;
}

.sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li a {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    color: #666;
    text-decoration: none;
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
}

.sidebar-nav li a:hover,
.sidebar-nav li a.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-left-color: #4f46e5;
}

.sidebar-nav li a i {
    margin-right: 12px;
    width: 20px;
}

.main-content {
    flex: 1;
    margin-left: 280px;
    padding: 30px;
}

.content-header {
    margin-bottom: 30px;
}

.content-header h2 {
    color: #333;
    margin-bottom: 5px;
    font-weight: 600;
}

.content-header p {
    color: #666;
    margin: 0;
}

.alert {
    padding: 15px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert ul {
    list-style: none;
    padding: 0;
}

.profile-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    max-width: 1200px;
}

.profile-card,
.stats-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.profile-header {
    padding: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.profile-avatar-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

.current-avatar {
    position: relative;
}

.current-avatar img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.2);
}

.avatar-info h4 {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.avatar-info p {
    margin: 0 0 10px 0;
    opacity: 0.9;
}

.member-since {
    font-size: 14px;
    opacity: 0.8;
}

.profile-body {
    padding: 30px;
}

.form-section {
    margin-bottom: 30px;
}

.form-section h5 {
    color: #333;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.form-control {
    padding: 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #4f46e5;
}

.form-text {
    margin-top: 5px;
    font-size: 12px;
    color: #666;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.info-item label {
    font-weight: 500;
    color: #666;
    font-size: 14px;
}

.info-item span {
    color: #333;
    font-weight: 500;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    width: fit-content;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.form-actions {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: #4f46e5;
    color: white;
}

.btn-primary:hover {
    background: #4338ca;
}

.btn-outline-secondary {
    background: transparent;
    color: #666;
    border: 2px solid #e0e0e0;
}

.btn-outline-secondary:hover {
    background: #f8f9fa;
    border-color: #ccc;
}

.stats-card {
    height: fit-content;
}

.stats-card h5 {
    padding: 20px;
    margin: 0;
    background: #f8f9fa;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.stats-grid {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-number {
    font-size: 20px;
    font-weight: 600;
    color: #333;
}

.stat-label {
    font-size: 14px;
    color: #666;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .main-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .profile-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .profile-avatar-section {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('profilePreview').src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection
