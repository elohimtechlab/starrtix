@extends('user-master')
@section('title', __('Change Password'))
@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">{{ __('Change Password') }}</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('userDashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Change Password') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>{{ __('Please fix the following errors:') }}</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <!-- Password Change Form -->
        <div class="col-xl-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm me-3">
                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                        </div>
                        <div>
                            <h4 class="card-title mb-0">{{ __('Password Security') }}</h4>
                            <p class="text-muted mb-0">{{ __('Keep your account secure with a strong password') }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('userPasswordUpdate') }}" method="POST" id="passwordForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">{{ __('Current Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="current_password" name="current_password" required placeholder="{{ __('Enter your current password') }}">
                                <button type="button" class="btn btn-outline-secondary password-toggle" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">{{ __('New Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8" placeholder="{{ __('Enter your new password') }}">
                                <button type="button" class="btn btn-outline-secondary password-toggle" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="mt-2">
                                <div class="password-strength-container">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <small class="text-muted">{{ __('Password Strength') }}</small>
                                        <small class="strength-text" id="strengthText">{{ __('Weak') }}</small>
                                    </div>
                                    <div class="progress" style="height: 4px;">
                                        <div class="progress-bar" id="strengthBar" role="progressbar" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">{{ __('Confirm New Password') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="8" placeholder="{{ __('Confirm your new password') }}">
                                <button type="button" class="btn btn-outline-secondary password-toggle" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-match mt-1" id="passwordMatch"></div>
                        </div>

                        <!-- Password Requirements -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="fas fa-info-circle me-1"></i> {{ __('Password Requirements') }}:</h6>
                            <ul class="mb-0 small">
                                <li id="req-length" class="text-danger"><i class="fas fa-times me-1"></i> {{ __('At least 8 characters long') }}</li>
                                <li id="req-uppercase" class="text-danger"><i class="fas fa-times me-1"></i> {{ __('Contains uppercase letter') }}</li>
                                <li id="req-lowercase" class="text-danger"><i class="fas fa-times me-1"></i> {{ __('Contains lowercase letter') }}</li>
                                <li id="req-number" class="text-danger"><i class="fas fa-times me-1"></i> {{ __('Contains number') }}</li>
                                <li id="req-special" class="text-danger"><i class="fas fa-times me-1"></i> {{ __('Contains special character') }}</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                <i class="fas fa-save me-1"></i> {{ __('Update Password') }}
                            </button>
                            <a href="{{ route('userProfile') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> {{ __('Back to Profile') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Tips Card -->
        <div class="col-xl-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-lightbulb me-2"></i> {{ __('Security Tips') }}</h4>
                </div>
                <div class="card-body">
                    <div class="security-tips">
                        <div class="tip-item mb-4">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-success-subtle text-success">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Use a Strong Password') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('Combine uppercase, lowercase, numbers, and special characters') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-4">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-warning-subtle text-warning">
                                        <i class="fas fa-sync-alt"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Don\'t Share') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('Never share your password with anyone, including support staff') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tip-item mb-4">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-info-subtle text-info">
                                        <i class="fas fa-mobile-alt"></i>
                                    </span>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ __('Enable 2FA') }}</h6>
                                    <p class="text-muted mb-0 small">{{ __('Consider enabling two-factor authentication for extra security') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Security Status -->
                    <div class="mt-4">
                        <div class="alert alert-success alert-sm">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-shield-check me-2"></i>
                                <small>{{ __('Your account is secure') }}</small>
                            </div>
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

.password-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
    max-width: 1000px;
}

.password-card,
.security-tips-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.password-header {
    padding: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
}

.security-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.security-info h4 {
    margin: 0 0 5px 0;
    font-weight: 600;
}

.security-info p {
    margin: 0;
    opacity: 0.9;
}

.password-body {
    padding: 30px;
}

.form-group {
    margin-bottom: 25px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #333;
}

.password-input-group {
    position: relative;
}

.form-control {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #4f46e5;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 16px;
}

.password-toggle:hover {
    color: #4f46e5;
}

.password-strength {
    margin-top: 10px;
}

.strength-bar {
    width: 100%;
    height: 4px;
    background: #e0e0e0;
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 5px;
}

.strength-fill {
    height: 100%;
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-text {
    font-size: 12px;
    color: #666;
}

.password-match {
    margin-top: 8px;
    font-size: 14px;
}

.password-requirements {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
}

.password-requirements h6 {
    margin: 0 0 15px 0;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.password-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.password-requirements li {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
    font-size: 14px;
    color: #666;
}

.password-requirements li i {
    width: 16px;
    color: #dc3545;
}

.password-requirements li.valid i {
    color: #28a745;
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

.btn-primary:disabled {
    background: #ccc;
    cursor: not-allowed;
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

.security-tips-card {
    height: fit-content;
}

.security-tips-card h5 {
    padding: 20px;
    margin: 0;
    background: #f8f9fa;
    color: #333;
    display: flex;
    align-items: center;
    gap: 10px;
}

.tips-list {
    padding: 20px;
}

.tip-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.tip-item:last-child {
    margin-bottom: 0;
}

.tip-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}

.tip-content h6 {
    margin: 0 0 5px 0;
    color: #333;
    font-weight: 600;
}

.tip-content p {
    margin: 0;
    color: #666;
    font-size: 14px;
    line-height: 1.4;
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
    
    .password-container {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .password-header {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
}
</style>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function checkPasswordStrength(password) {
    let score = 0;
    const requirements = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        number: /\d/.test(password),
        special: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
    };
    
    // Update requirement indicators
    Object.keys(requirements).forEach(req => {
        const element = document.getElementById(`req-${req}`);
        if (element) {
            const icon = element.querySelector('i');
            
            if (requirements[req]) {
                element.classList.remove('text-danger');
                element.classList.add('text-success');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-check');
                score++;
            } else {
                element.classList.remove('text-success');
                element.classList.add('text-danger');
                icon.classList.remove('fa-check');
                icon.classList.add('fa-times');
            }
        }
    });
    
    // Update strength bar
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (strengthBar && strengthText) {
        const percentage = (score / 5) * 100;
        strengthBar.style.width = percentage + '%';
        
        if (score === 0) {
            strengthBar.className = 'progress-bar bg-danger';
            strengthText.textContent = '{{ __("Very Weak") }}';
            strengthText.className = 'strength-text text-danger';
        } else if (score <= 2) {
            strengthBar.className = 'progress-bar bg-warning';
            strengthText.textContent = '{{ __("Weak") }}';
            strengthText.className = 'strength-text text-warning';
        } else if (score <= 3) {
            strengthBar.className = 'progress-bar bg-info';
            strengthText.textContent = '{{ __("Fair") }}';
            strengthText.className = 'strength-text text-info';
        } else if (score <= 4) {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = '{{ __("Good") }}';
            strengthText.className = 'strength-text text-success';
        } else {
            strengthBar.className = 'progress-bar bg-success';
            strengthText.textContent = '{{ __("Strong") }}';
            strengthText.className = 'strength-text text-success';
        }
    }
    
    return score;
}

function checkPasswordMatch() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    const matchElement = document.getElementById('passwordMatch');
    
    if (!matchElement) return false;
    
    if (confirmPassword === '') {
        matchElement.textContent = '';
        return false;
    }
    
    if (newPassword === confirmPassword) {
        matchElement.innerHTML = '<small class="text-success"><i class="fas fa-check me-1"></i>{{ __("Passwords match") }}</small>';
        return true;
    } else {
        matchElement.innerHTML = '<small class="text-danger"><i class="fas fa-times me-1"></i>{{ __("Passwords do not match") }}</small>';
        return false;
    }
}

function updateSubmitButton() {
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    const submitBtn = document.getElementById('submitBtn');
    
    if (!submitBtn) return;
    
    const strengthScore = checkPasswordStrength(newPassword);
    const passwordsMatch = checkPasswordMatch();
    
    if (currentPassword !== '' && strengthScore >= 3 && passwordsMatch && newPassword !== '' && confirmPassword !== '') {
        submitBtn.disabled = false;
        submitBtn.classList.remove('btn-secondary');
        submitBtn.classList.add('btn-primary');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.remove('btn-primary');
        submitBtn.classList.add('btn-secondary');
    }
}

// Event listeners
$(document).ready(function() {
    const currentPasswordField = $('#current_password');
    const newPasswordField = $('#new_password');
    const confirmPasswordField = $('#new_password_confirmation');
    
    // Add event listeners
    currentPasswordField.on('input', updateSubmitButton);
    newPasswordField.on('input', updateSubmitButton);
    confirmPasswordField.on('input', updateSubmitButton);
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut('slow');
    }, 5000);
    
    // Initialize form state
    updateSubmitButton();
});
</script>

@endsection
