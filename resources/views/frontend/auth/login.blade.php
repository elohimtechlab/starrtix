<!doctype HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Login') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <?php $primary_color = \App\Models\Setting::find(1)->primary_color; ?>
    @php
        $favicon = \App\Models\Setting::find(1)->favicon;
    @endphp
    <meta charset="utf-8">
    <link href="{{ $favicon ? url('images/upload/' . $favicon) : asset('/images/logo.png') }}" rel="icon"
        type="image/png">
    <style>
        :root {
            --primary_color: <?php echo $primary_color; ?>;
            --light_primary_color: <?php echo $primary_color . '1a'; ?>;
            --profile_primary_color: <?php echo $primary_color . '52'; ?>;
            --middle_light_primary_color: <?php echo $primary_color . '85'; ?>;
        }

        .bg-primary {
            --tw-bg-opacity: 1;
            background-color: var(--primary_color);
        }

        .bg-primary-dark {
            --tw-bg-opacity: 1;
            background-color: var(--profile_primary_color);
            /* Use the profile_primary_color variable */
        }

        .navbar-nav>.active>a {
            color: var(--primary_color);
        }

        .text-primary {
            --tw-text-opacity: 1;
            color: var(--primary_color);
        }

        .border-primary {
            --tw-border-opacity: 1;
            border-color: var(--primary_color);
        }

        input[type="radio"]:checked {
            background-color: var(--primary_color) !important;
            color: var(--primary_color) !important;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    @php
        $setting = \App\Models\Setting::find(1);
    @endphp
    
    <div class="min-h-screen flex">
        <!-- Left Side - Login Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Logo -->
                <div class="mb-8">
                    <a href="{{ url('/') }}" class="hover:opacity-80 transition-opacity duration-200">
                        <img src="{{ $setting->logo ? url('images/upload/' . $setting->logo) : asset('/images/logo.png') }}"
                            alt="{{ $setting->app_name ?? 'Starrtix' }} Logo" class="h-12 w-auto">
                    </a>
                </div>

                <!-- Welcome Message -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Welcome back!') }}</h2>
                    <p class="text-sm text-gray-600">{{ __('Continue with the email address used to create your account') }}</p>
                </div>

                <!-- Success Alert -->
                @if (Session::has('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ Session::get('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form action="{{ url('user/login') }}" method="post" data-qa="form-login" name="login" class="space-y-6">
                    @csrf
                    <input type="hidden" value="{{ url()->previous() }}" name="url">

                    <!-- User Type Selection - Inside Form -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Login as') }}</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative">
                                <input type="radio" name="type" value="user" checked class="sr-only user-type-radio" id="user-radio">
                                <div class="w-full px-5 py-2 text-white text-center font-poppins font-normal text-base leading-6 rounded-md cursor-pointer transition duration-200 hover:opacity-90 user-type-btn" id="user-btn" style="background-color: #007bff;">
                                    <span class="text-sm font-medium">{{ __('User') }}</span>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="type" value="org" class="sr-only user-type-radio" id="org-radio">
                                <div class="w-full px-5 py-2 text-white text-center font-poppins font-normal text-base leading-6 rounded-md cursor-pointer transition duration-200 hover:opacity-90 user-type-btn" id="org-btn" style="background-color: #f7941d;">
                                    <span class="text-sm font-medium">{{ __('Organizer') }}</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email address') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200"
                            placeholder="{{ __('Enter your email address') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                class="w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-200"
                                placeholder="{{ __('Enter your password') }}">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-200 transform hover:scale-105 hover:opacity-90" style="background-color: #f7941d;">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>

                <!-- Forgot Password Link -->
                <div class="mt-4">
                    <a href="{{ url('user/resetPassword') }}"
                        class="text-sm text-orange-600 hover:text-orange-700 font-medium transition duration-200">{{ __('Forgot password?') }}</a>
                </div>

                <!-- Sign Up Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Don\'t have an account?') }}
                        <a href="{{ url('/user/register') }}"
                            class="font-medium text-orange-600 hover:text-orange-700 transition duration-200">{{ __('Create one') }}</a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hidden lg:block relative w-0 flex-1">
            <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-orange-400 via-pink-300 to-purple-400">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-black bg-opacity-20">
                    <!-- Abstract geometric shapes -->
                    <div class="absolute top-20 left-20 w-32 h-32 bg-white bg-opacity-20 rounded-full animate-pulse"></div>
                    <div class="absolute top-40 right-32 w-16 h-16 bg-white bg-opacity-30 transform rotate-45"></div>
                    <div class="absolute bottom-32 left-32 w-24 h-24 bg-white bg-opacity-25 rounded-lg transform rotate-12"></div>
                    <div class="absolute top-1/3 right-1/4 w-8 h-8 bg-white bg-opacity-40 rounded-full"></div>
                    <div class="absolute bottom-1/4 right-20 w-12 h-12 bg-white bg-opacity-20 transform rotate-45"></div>
                    
                    <!-- Main illustration area -->
                    <div class="flex items-center justify-center h-full relative">
                        <!-- Background Image -->
                        <div class="absolute inset-0 opacity-60">
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" 
                                 alt="People enjoying events" 
                                 class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle functionality
        const togglePassword = document.querySelector("#togglePassword");
        const passwordField = document.querySelector("#password");

        if (togglePassword && passwordField) {
            togglePassword.addEventListener("click", function(e) {
                e.preventDefault();
                // toggle the type attribute
                const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
                passwordField.setAttribute("type", type);
                
                // toggle the eye icon
                const svg = this.querySelector('svg');
                if (type === "text") {
                    // Show eye-slash icon when password is visible
                    svg.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                    `;
                } else {
                    // Show eye icon when password is hidden
                    svg.innerHTML = `
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    `;
                }
            });
        }

        // User type selection functionality
        const userBtn = document.getElementById('user-btn');
        const orgBtn = document.getElementById('org-btn');
        const userRadio = document.getElementById('user-radio');
        const orgRadio = document.getElementById('org-radio');

        function updateButtonColors() {
            if (userRadio.checked) {
                userBtn.style.backgroundColor = '#007bff'; // Blue for selected
                orgBtn.style.backgroundColor = '#f7941d';  // Orange for unselected
            } else {
                userBtn.style.backgroundColor = '#f7941d'; // Orange for unselected
                orgBtn.style.backgroundColor = '#007bff';  // Blue for selected
            }
        }

        if (userBtn && orgBtn && userRadio && orgRadio) {
            userBtn.addEventListener('click', function() {
                userRadio.checked = true;
                updateButtonColors();
            });

            orgBtn.addEventListener('click', function() {
                orgRadio.checked = true;
                updateButtonColors();
            });

            // Initialize colors
            updateButtonColors();
        }
    });
</script>
<script src="https://unpkg.com/flowbite@1.5.5/dist/flowbite.js"></script>

</html>
