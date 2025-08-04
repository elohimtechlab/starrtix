@extends('user-master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-user"></i> {{ __('My Profile') }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></div>
                <div class="breadcrumb-item">{{ __('My Profile') }}</div>
            </div>
        </div>

        <div class="section-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                        </button>
                        <i class="fas fa-exclamation-circle"></i>
                        <ul class="mb-0 ml-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Profile Information') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('userProfileUpdate') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('First Name') }}</label>
                                            <input type="text" class="form-control" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Last Name') }}</label>
                                            <input type="text" class="form-control" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('Full Name') }}</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('Email Address') }}</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Phone Number') }}</label>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label>{{ __('Date of Birth') }}</label>
                                            <input type="date" class="form-control" name="date_of_birth" value="{{ old('date_of_birth', $user->date_of_birth) }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('Address') }}</label>
                                    <textarea class="form-control" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label>{{ __('Profile Image') }}</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="profile-image" name="image" accept="image/*">
                                        <label class="custom-file-label" for="profile-image">{{ __('Choose file') }}</label>
                                    </div>
                                    <small class="form-text text-muted">{{ __('Upload a new profile image (JPG, PNG, max 2MB)') }}</small>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> {{ __('Update Profile') }}
                                    </button>
                                    <a href="{{ route('userDashboard') }}" class="btn btn-secondary ml-2">
                                        <i class="fas fa-arrow-left"></i> {{ __('Back to Dashboard') }}
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-md-4">
                    <!-- Profile Image Preview -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Profile Picture') }}</h4>
                        </div>
                        <div class="card-body text-center">
                            <div class="profile-image-preview mb-3">
                                <img id="current-profile-image" 
                                     src="{{ $user->imagePath . $user->image }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle img-fluid" 
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <h5 class="mb-1">{{ $user->name }}</h5>
                            <p class="text-muted">{{ $user->email }}</p>
                            <div class="mt-3">
                                <small class="text-muted">{{ __('Member since') }} {{ $user->created_at->format('M Y') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Account Actions') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('userChangePassword') }}" class="btn btn-warning btn-block">
                                    <i class="fas fa-key"></i> {{ __('Change Password') }}
                                </a>
                                <a href="{{ route('myWallet') }}" class="btn btn-info btn-block">
                                    <i class="fas fa-wallet"></i> {{ __('My Wallet') }}
                                </a>
                                <a href="{{ route('userOrders') }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-shopping-cart"></i> {{ __('View Orders') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
<script>
    // Profile image preview
    document.getElementById('profile-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('current-profile-image').src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            // Update file label
            const fileName = file.name;
            const label = document.querySelector('.custom-file-label');
            label.textContent = fileName;
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        const firstName = $('input[name="first_name"]').val().trim();
        const lastName = $('input[name="last_name"]').val().trim();
        const name = $('input[name="name"]').val().trim();
        const email = $('input[name="email"]').val().trim();
        
        if (!firstName || !lastName || !name || !email) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields.',
                confirmButtonText: 'OK'
            });
            return false;
        }
        
        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonText: 'OK'
            });
            return false;
        }
    });
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endsection
