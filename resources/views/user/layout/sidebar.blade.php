@php
    $setting = App\Models\Setting::find(1);
    $user = Auth::guard('appuser')->user();
    
    // Get user statistics for sidebar display
    $userStats = [
        'total_orders' => App\Models\Order::where('customer_id', $user->id)->count(),
        'active_tickets' => App\Models\Order::where('customer_id', $user->id)
                                          ->where('order_status', 'Complete')
                                          ->whereHas('event', function($q) {
                                              $q->where('start_time', '>', now());
                                          })->count(),
        'upcoming_events' => App\Models\Event::where('start_time', '>', now())
                                            ->whereIn('id', function($query) use ($user) {
                                                $query->select('event_id')
                                                      ->from('orders')
                                                      ->where('customer_id', $user->id)
                                                      ->where('order_status', 'Complete');
                                            })->count()
    ];
@endphp

<!-- Modern Sidebar Styles -->
<style>
    .header-logo {
        filter: brightness(0) invert(1) !important; /* Makes logo white */
    }
    .modern-sidebar {
        background: #ffffff;
        box-shadow: 0 0 35px rgba(0,0,0,0.05);
        border-right: 1px solid #e9ecef;
    }

    .logo-wrapper {
        padding: 1.5rem 1rem;
        text-align: center;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 1rem;
    }
    .logo-link .small-logo {
        display: none;
    }
    .sidebar-brand-sm .logo-link .large-logo {
        display: none;
    }
    .sidebar-brand-sm .logo-link .small-logo {
        display: inline-block;
    }

    .modern-sidebar .sidebar-brand {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem 1rem;
        margin-bottom: 1rem;
    }

    .modern-sidebar .sidebar-brand:hover {
        background: #f1f3f5;
        transition: all 0.3s ease;
    }

    .user-profile-card {
        background: #f8f9fa;
        border-radius: 15px;
        padding: 1.5rem;
        margin: 0 1rem 2rem 1rem;
        border: 1px solid #e9ecef;
        text-align: center;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 3px solid #dee2e6;
        margin-bottom: 1rem;
        object-fit: cover;
    }

    .user-name {
        color: #343a40;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    .user-email {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .user-stats {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    .stat-item {
        text-align: center;
        flex: 1;
    }

    .stat-number {
        color: #343a40;
        font-weight: bold;
        font-size: 1.2rem;
        display: block;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-sidebar .sidebar-menu {
        padding: 0 1rem;
    }

    .modern-sidebar .menu-header {
        color: #6c757d;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 1rem 0 0.5rem 1rem;
        margin-bottom: 0.5rem;
        border-bottom: 1px solid #e9ecef;
    }

    .modern-sidebar .sidebar-menu li {
        margin-bottom: 0.5rem;
    }

    .modern-sidebar .sidebar-menu li a {
        background: transparent;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        color: #495057;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        text-decoration: none;
    }

    .modern-sidebar .sidebar-menu li a:hover {
        background: #f1f3f5;
        transform: translateX(5px);
        color: #212529;
        text-decoration: none;
    }

    .modern-sidebar .sidebar-menu li.active a {
        background: var(--primary_color);
        color: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .modern-sidebar .sidebar-menu li.active a i {
        color: white;
    }

    .modern-sidebar .sidebar-menu li a i {
        width: 20px;
        text-align: center;
        margin-right: 1rem;
        font-size: 1.1rem;
        color: #6c757d;
    }

    .modern-sidebar .sidebar-menu li a span {
        font-weight: 500;
        font-size: 0.95rem;
    }

    .sidebar-footer {
        position: absolute;
        bottom: 2rem;
        left: 1rem;
        right: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        border: 1px solid #e9ecef;
    }

    .sidebar-footer-text {
        color: #6c757d;
        font-size: 0.8rem;
        margin-bottom: 0.5rem;
    }

    .sidebar-footer-link {
        color: #343a40;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .sidebar-footer-link:hover {
        color: var(--primary_color);
        text-decoration: none;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .user-profile-card {
            margin: 0 0.5rem 1rem 0.5rem;
            padding: 1rem;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
        }
        
        .modern-sidebar .sidebar-menu {
            padding: 0 0.5rem;
        }
    }
</style>

<div class="main-sidebar sidebar-style-2 modern-sidebar">
    <aside id="sidebar-wrapper">
        <div class="logo-wrapper">
            <a href="{{ route('userDashboard') }}" class="logo-link">
                <img alt="image" src="{{ $setting->logo ? asset('images/upload/' . $setting->logo) : asset('frontend/images/logo.png') }}" class="header-logo large-logo">
                <img alt="image" src="{{ $setting->favicon ? asset('images/upload/' . $setting->favicon) : asset('frontend/images/favicon.png') }}" class="header-logo small-logo">
            </a>
        </div>
        <!-- User Profile Card -->
        <div class="user-profile-card">
            <img src="{{ $user->image && $user->image != 'defaultuser.png' ? asset('images/upload/' . $user->image) : asset('frontend/images/defaultuser.png') }}" 
                 alt="{{ $user->name }}" class="user-avatar">
            <div class="user-name">{{ $user->name ?? 'User' }}</div>
            <div class="user-email">{{ $user->email }}</div>
            
            <!-- User Statistics -->
            <div class="user-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ $userStats['total_orders'] }}</span>
                    <span class="stat-label">Orders</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $userStats['active_tickets'] }}</span>
                    <span class="stat-label">Tickets</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $userStats['upcoming_events'] }}</span>
                    <span class="stat-label">Events</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Navigation Menu -->
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Navigation') }}</li>
            
            <li class="{{ request()->is('user-tickets') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userDashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> 
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            
            <li class="{{ request()->is('user-orders') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userOrders') }}">
                    <i class="fas fa-shopping-bag"></i> 
                    <span>{{ __('My Orders') }}</span>
                </a>
            </li>
            
            <li class="{{ request()->is('my-tickets') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('myTickets') }}">
                    <i class="fas fa-ticket-alt"></i> 
                    <span>{{ __('My Tickets') }}</span>
                </a>
            </li>

            <li class="menu-header">{{ __('Account') }}</li>
            
            <li class="{{ request()->is('user-profile') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userProfile') }}">
                    <i class="fas fa-user-circle"></i> 
                    <span>{{ __('My Profile') }}</span>
                </a>
            </li>

            <li class="{{ request()->is('user-change-password') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('userChangePassword') }}">
                    <i class="fas fa-shield-alt"></i> 
                    <span>{{ __('Security') }}</span>
                </a>
            </li>
        </ul>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-footer-text">{{ __('Need help?') }}</div>
            <a href="{{ url('/all-events') }}" class="sidebar-footer-link">
                <i class="fas fa-calendar-alt mr-1"></i>{{ __('Browse Events') }}
            </a>
        </div>
    </aside>
</div>
