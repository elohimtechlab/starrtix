<!doctype HTML>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Create Account') }}</title>
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

        .focus\:ring-primary:focus {
            --tw-ring-opacity: 1;
            --tw-ring-color: var(--primary_color);
        }

        .focus\:border-primary:focus {
            --tw-border-opacity: 1;
            border-color: var(--primary_color);
        }

        .hover\:bg-primary:hover {
            --tw-bg-opacity: 1;
            background-color: var(--primary_color);
        }
    </style>
</head>

@php
    $setting = \App\Models\Setting::find(1);
@endphp

<body class="bg-gray-50 min-h-screen">
    @php
        $setting = \App\Models\Setting::find(1);
    @endphp
    
    <div class="min-h-screen flex">
        <!-- Left Side - Registration Form -->
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
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Create your account') }}</h2>
                    <p class="text-sm text-gray-600">{{ __('Join our community and start discovering amazing events') }}</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-red-800">
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-1">{{ $error }}</p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Registration Form -->
                <form action="{{ url('user/register') }}" method="post" class="space-y-6">
                    @csrf

                    <!-- User Type Selection - Inside Form -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Account type') }}</label>
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

                    <!-- Name Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('First Name') }}</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="{{ __('Enter your first name') }}">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Last Name') }}</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="{{ __('Enter your last name') }}">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email address') }}</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                            placeholder="{{ __('Enter your email address') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Number Fields -->
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label for="countrycode" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Country Code') }}</label>
                            <select name="Countrycode" id="countrycode" required
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200">
                                <option value="">{{ __('Select') }}</option>
                                <option value="1" {{ old('Countrycode') == '1' ? 'selected' : '' }}>+1 (US/CA)</option>
                                <option value="44" {{ old('Countrycode') == '44' ? 'selected' : '' }}>+44 (UK)</option>
                                <option value="91" {{ old('Countrycode') == '91' ? 'selected' : '' }}>+91 (IN)</option>
                                <option value="61" {{ old('Countrycode') == '61' ? 'selected' : '' }}>+61 (AU)</option>
                                <option value="49" {{ old('Countrycode') == '49' ? 'selected' : '' }}>+49 (DE)</option>
                                <option value="33" {{ old('Countrycode') == '33' ? 'selected' : '' }}>+33 (FR)</option>
                                <option value="39" {{ old('Countrycode') == '39' ? 'selected' : '' }}>+39 (IT)</option>
                                <option value="34" {{ old('Countrycode') == '34' ? 'selected' : '' }}>+34 (ES)</option>
                                <option value="81" {{ old('Countrycode') == '81' ? 'selected' : '' }}>+81 (JP)</option>
                                <option value="86" {{ old('Countrycode') == '86' ? 'selected' : '' }}>+86 (CN)</option>
                                <option value="82" {{ old('Countrycode') == '82' ? 'selected' : '' }}>+82 (KR)</option>
                                <option value="55" {{ old('Countrycode') == '55' ? 'selected' : '' }}>+55 (BR)</option>
                                <option value="52" {{ old('Countrycode') == '52' ? 'selected' : '' }}>+52 (MX)</option>
                                <option value="7" {{ old('Countrycode') == '7' ? 'selected' : '' }}>+7 (RU)</option>
                                <option value="27" {{ old('Countrycode') == '27' ? 'selected' : '' }}>+27 (ZA)</option>
                                <option value="233" {{ old('Countrycode') == '233' ? 'selected' : '' }}>+233 (Ghana)</option>
                                <option value="231" {{ old('Countrycode') == '231' ? 'selected' : '' }}>+231 (Liberia)</option>
                                <option value="234" {{ old('Countrycode') == '234' ? 'selected' : '' }}>+234 (Nigeria)</option>
                                <option value="232" {{ old('Countrycode') == '232' ? 'selected' : '' }}>+232 (Sierra Leone)</option>
                            </select>
                            @error('Countrycode')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Phone Number') }}</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="{{ __('Enter your phone number') }}">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                    class="w-full px-3 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    placeholder="{{ __('Create password') }}">
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
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                class="w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                placeholder="{{ __('Confirm password') }}">
                        </div>
                    </div>

                    <!-- Create Account Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-200 transform hover:scale-105 hover:opacity-90" style="background-color: #f7941d;">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        {{ __('Already have an account?') }}
                        <a href="{{ url('/user/login') }}"
                            class="font-medium text-orange-600 hover:text-orange-700 transition duration-200">{{ __('Sign in') }}</a>
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
