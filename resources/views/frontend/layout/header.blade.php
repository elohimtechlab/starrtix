@php
    if (session('locale') == 'ar') {
        $lang = 'rtl';
    } else {
        $lang = 'ltr';
    }
    $user = Auth::guard('appuser')->user();
    if (Auth::guard('appuser')->check()) {
        $user_id = $user->id;
    }
    $wallet = \App\Models\Setting::find(1)->wallet;
    $admin = \App\Models\User::find(1);
    $logo = \App\Models\Setting::find(1)->logo;
@endphp

<!-- Desktop Navigation -->
<div class="bg-white shadow-lg sticky top-0 z-50 font-sans w-full m-0" x-data="{ mobileMenuOpen: false, userDropdownOpen: false }">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between py-4">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ $logo ? url('images/upload/' . $logo) : asset('/images/logo.png') }}"
                        class="h-10 w-auto object-contain" alt="Logo">
                </a>
            </div>

            <!-- Main Navigation -->
            <nav class="hidden md:flex items-center space-x-1">
                <a href="{{ url('/') }}" 
                   class="nav-link px-3 py-2 rounded-md font-poppins font-medium text-base text-gray-700 hover:bg-primary hover:text-white transition-colors duration-300 {{ Request::is('/') ? 'bg-primary text-white' : '' }}">
                    {{ __('Home') }}
                </a>
                
                <a href="{{ url('/all-events') }}" 
                   class="nav-link px-3 py-2 rounded-md font-poppins font-medium text-base text-gray-700 hover:bg-primary hover:text-white transition-colors duration-300 {{ Request::is('all-events') ? 'bg-primary text-white' : '' }}">
                    {{ __('All Events') }}
                </a>
                
                <a href="{{ route('how-it-works') }}" 
                   class="nav-link px-3 py-2 rounded-md font-poppins font-medium text-base text-gray-700 hover:bg-primary hover:text-white transition-colors duration-300 {{ Request::is('how-it-works') ? 'bg-primary text-white' : '' }}">
                    {{ __('How it Works') }}
                </a>
                
                <a href="{{ route('pricing') }}" 
                   class="nav-link px-3 py-2 rounded-md font-poppins font-medium text-base text-gray-700 hover:bg-primary hover:text-white transition-colors duration-300 {{ Request::is('pricing') ? 'bg-primary text-white' : '' }}">
                    {{ __('Pricing') }}
                </a>
                
                <a href="{{ route('about-us') }}" 
                   class="nav-link px-3 py-2 rounded-md font-poppins font-medium text-base text-gray-700 hover:bg-primary hover:text-white transition-colors duration-300 {{ Request::is('about-us') ? 'bg-primary text-white' : '' }}">
                    {{ __('About Us') }}
                </a>
            </nav>

            <!-- Search and User Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="hidden lg:block">
                    <form action="{{ url('user/search_event') }}" method="post" class="relative">
                        @csrf
                        <input type="text" name="search" placeholder="{{ __('Search events...') }}"
                               class="w-48 px-4 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </form>
                </div>

                <!-- User Authentication -->
                @if (Auth::guard('appuser')->check())
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center space-x-2 text-sm font-medium text-gray-700 hover:text-primary focus:outline-none">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <span class="hidden lg:block">{{ $user->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform scale-95"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ url('/user/profile') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <i class="fas fa-user mr-2"></i>{{ __('My Dashboard') }}
                            </a>
                            <a href="{{ url('/user/profile') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                <i class="fas fa-ticket-alt mr-2"></i>{{ __('My Tickets') }}
                            </a>
                            @if($wallet == 1)
                                <a href="{{ url('/user/wallet') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors duration-200">
                                    <i class="fas fa-wallet mr-2"></i>{{ __('My Wallet') }}
                                </a>
                            @endif
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <button onclick="handleLogout()" 
                                        class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Logout') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('user.login') }}" 
                           class="px-4 py-2 text-white rounded-lg font-medium hover:bg-primary transition-all duration-300 ease-in-out transform hover:scale-105"
                           style="background-color: #f7941d;">
                            {{ __('Sign In') }}
                        </a>
                        <a href="{{ url('user/register') }}" 
                           class="px-4 py-2 bg-primary text-white rounded-lg font-medium hover:bg-opacity-90 transition-all duration-300 ease-in-out transform hover:scale-105">
                            {{ __('Register') }}
                        </a>
                    </div>
                @endif

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="text-gray-700 hover:text-primary focus:outline-none">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="md:hidden border-t border-gray-200 py-4">
            <div class="space-y-2">
                <a href="{{ url('/') }}" class="block px-4 py-2 text-base rounded-md text-gray-700 hover:bg-primary hover:text-white {{ Request::is('/') ? 'bg-primary text-white' : '' }}">{{ __('Home') }}</a>
                <a href="{{ url('/all-events') }}" class="block px-4 py-2 text-base rounded-md text-gray-700 hover:bg-primary hover:text-white {{ Request::is('all-events') ? 'bg-primary text-white' : '' }}">{{ __('All Events') }}</a>
                <a href="{{ route('how-it-works') }}" class="block px-4 py-2 text-base rounded-md text-gray-700 hover:bg-primary hover:text-white {{ Request::is('how-it-works') ? 'bg-primary text-white' : '' }}">{{ __('How it Works') }}</a>
                <a href="{{ route('pricing') }}" class="block px-4 py-2 text-base rounded-md text-gray-700 hover:bg-primary hover:text-white {{ Request::is('pricing') ? 'bg-primary text-white' : '' }}">{{ __('Pricing') }}</a>
                <a href="{{ route('about-us') }}" class="block px-4 py-2 text-base rounded-md text-gray-700 hover:bg-primary hover:text-white {{ Request::is('about-us') ? 'bg-primary text-white' : '' }}">{{ __('About Us') }}</a>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Navigation -->
<nav class="navbar rounded m-0 bg-white z-30 shadow-md relative md:hidden">
    <div
        class="flex xxsm:space-y-2 xmd:space-y-0 md:space-y-2 msm:flex-col md:flex-col xmd:flex-col xxsm:flex-col lg:flex-wrap xmd:flex-wrap justify-between
     3xl:mx-52 2xl:mx-28 1xl:mx-28 xl:mx-10 xlg:mx-10 lg:mx-35 xxmd:mx-24 xmd:mx-32 sm:mx-20 msm:mx-16 xsm:mx-5 xxsm:mx-5 py-3 pt-4 z-30 xl2:flex-row">
        <div class="flex items-center lg:items-left w-auto">
            <ul
                class="navbar-nav flex lg:flex-row xmd:flex-row md:flex-row md:text-xs md:space-x-3 sm:flex-row msm:flex-col xsm:flex-col xxsm:flex-col msm:space-x-2 sm:space-x-2 lg:space-x-10 temp:max-temp2:space-x-5 md:mt-0">
                {{-- App Logo --}}
                <a href="{{ url('/') }}" class="object-cover ">
                    <img src="{{ $logo ? url('images/upload/' . $logo) : asset('/images/logo.png') }}"
                        class="object-scale-down h-10 " alt="Logo">
                </a>
            </ul>
            <div class="w-full text-right xxsm:max-lg:block hidden">
                <button class="btn text-gray bg-white text-left font-poppins font-normal nav-toggle">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="hidden nav-content" id="nav-content">
            <ul class="list-reset lg:flex justify-end flex-1 items-center text-end">
                <li class="mt-2 nav-item {{ $activePage == 'home' ? 'active' : '' }} ">
                    <a href="{{ url('/') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Home') }}</a>
                </li>
                <li class="mt-2 nav-item {{ Request::is('all-events') ? 'active' : '' }}">
                    <a href="{{ url('/all-events') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Events') }}</a>
                </li>
                <li class="mt-2 nav-item {{ $activePage == 'blog' ? 'active' : '' }}">
                    <a href="{{ url('/all-blogs') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Blog') }}</a>
                </li>
                <li class="mt-2 nav-item {{ $activePage == 'contact' ? 'active' : '' }}">
                    <a href="{{ url('/contact') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('contact Us') }}</a>
                </li>
            </ul>
        </div>
        {{-- Search Button and Login button --}}
        <div class="">
            <div class="flex justify-between sm:space-x-6 xxsm:flex-col sm:flex-row">
                <div>
                    <form action="{{ url('user/search_event') }}" method="post">
                        @csrf
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <img src="{{ asset('images/search.svg') }}" class="w-5 h-5" alt="">
                            </div>
                            <input type="search" id="default-search" name="search"
                                class="block p-2 pl-10 text-gray bg-white border border-gray-light text-left font-poppins font-normal
                            text-base leading-6 rounded-md mx-1 focus:outline-none xxsm:w-full sm:w-48 lg:w-72"
                                placeholder="{{ __('Search..') }}" required>
                        </div>
                    </form>
                </div>
                @if (Auth::guard('appuser')->check())
                    <div class="flex justify-end mt-2 dropdownScreenButton">
                        <div class="pt-3 mr-5">
                            <p class="font-poppins font-medium text-sm leading-5 text-black">
                                {{ $user->name ?? ' ' }}</p>
                        </div>
                        <div class="ml-3 pt-1 dropdown relative flex">
                            <div class="relative inline-block text-left">
                                <div
                                    class="dropdownMenuClass hidden rigin-top-right absolute right-0 w-56 rounded-md shadow-2xl z-30 mt-10">
                                    <div class="rounded-md bg-white shadow-xs">
                                        <div class="py-1">
                                            <div
                                                class="overflow-y-auto py-4 px-3 bg-gray-50 rounded pt-10 border-b border-gray-light pb-5">
                                                <ul class="space-y-8 ">
                                                    <li>
                                                        <a href="{{ url('/my-tickets') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('My tickets') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/user/profile') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('Profile') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/change-password') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('Change password') }}
                                                        </a>
                                                    </li>
                                                    @if ($wallet == 1)
                                                        <li>
                                                            <a href="{{ route('myWallet') }}"
                                                                class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('My Wallet') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="px-3 py-5">
                                                <button type="button"
                                                    class="flex items-center  font-poppins font-medium leading-4 text-danger capitalize">
                                                    <i class="fa-solid fa-right-from-bracket mr-2"></i><span
                                                        id="logout-btn-1"
                                                        class="flex-1  whitespace-nowrap">{{ __('Logout') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="sm:px-4 flex xxsm:flex-wrap justify-end mt-2 sm:mt-0">
                        <a type="button" href="{{ route('user.login') }}"
                            class="px-5 py-2 text-white text-center font-poppins font-normal text-base leading-6 rounded-md"
                            style="background-color: #f7941d;">{{ __('Sign In') }}</a>
                        <a type="button" href="{{ url('user/register') }}"
                            class="ml-2 px-5 py-2 text-white bg-secondary text-center font-poppins font-normal text-base leading-6 rounded-md">{{ __('Register') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    // Handle both logout buttons
    function handleLogout() {
        Swal.fire({
            title: 'Are you sure to logout!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/user/logoutuser') }}";
            }
        })
    }
    
    // Add event listeners to both logout buttons
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn1 = document.getElementById("logout-btn-1");
        const logoutBtn2 = document.getElementById("logout-btn-2");
        
        if (logoutBtn1) {
            logoutBtn1.addEventListener('click', handleLogout);
        }
        if (logoutBtn2) {
            logoutBtn2.addEventListener('click', handleLogout);
        }
    });
</script>

@php
    if (session('locale') == 'ar') {
        $lang = 'rtl';
    } else {
        $lang = 'ltr';
    }
    $user = Auth::guard('appuser')->user();
    if (Auth::guard('appuser')->check()) {
        $user_id = $user->id;
    }
    $wallet = \App\Models\Setting::find(1)->wallet;
    $admin = \App\Models\User::find(1);
    $logo = \App\Models\Setting::find(1)->logo;
@endphp

<nav class="md:hidden">
    <div id="main-nav" class="-translate-x-full duration-500 z-50 fixed top-0 left-0 h-screen bg-white w-full">
        <div class="border-b border-gray-light py-4 px-5">
            <div class="flex justify-between">
                <a href="{{ url('/') }}">
                    <img src="{{ $logo }}" alt="" class="h-10 w-auto">
                </a>
                <button class="focus:outline-none" id="nav-close">
                    <i class="fa-solid fa-xmark text-2xl"></i>
                </button>
            </div>
        </div>
        <div class="p-5">
            <ul class="list-reset flex-col justify-end flex-1 items-center text-end pb-5 space-y-5">
                <li class="nav-item {{ $activePage == 'home' ? 'active' : '' }} ">
                    <a href="{{ url('/') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Home') }}</a>
                </li>
                <li class="nav-item {{ Request::is('all-events') ? 'active' : '' }}">
                    <a href="{{ url('/all-events') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Events') }}</a>
                </li>
                <li class="mt-2 nav-item {{ $activePage == 'blog' ? 'active' : '' }}">
                    <a href="{{ url('/all-blogs') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('Blog') }}</a>
                </li>
                <li class="mt-2 nav-item {{ $activePage == 'contact' ? 'active' : '' }}">
                    <a href="{{ url('/contact') }}"
                        class="nav-link md:px-1 capitalize font-poppins font-normal text-base leading-6 text-gray hover:bg-primary hover:text-white">{{ __('contact Us') }}</a>
                </li>
            </ul>
        </div>
        {{-- Search Button and Login button --}}
        <div class="">
            <div class="flex justify-between sm:space-x-6 xxsm:flex-col sm:flex-row">
                <div>
                    <form action="{{ url('user/search_event') }}" method="post">
                        @csrf
                        <div class="relative">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <img src="{{ asset('images/search.svg') }}" class="w-5 h-5" alt="">
                            </div>
                            <input type="search" id="default-search" name="search"
                                class="block p-2 pl-10 text-gray bg-white border border-gray-light text-left font-poppins font-normal
                                text-base leading-6 rounded-md mx-1 focus:outline-none xxsm:w-full sm:w-48 lg:w-72"
                                placeholder="{{ __('Search..') }}" required>
                        </div>
                    </form>
                </div>
                @if (Auth::guard('appuser')->check())
                    <div class="flex justify-end mt-2 dropdownScreenButton">
                        <div class="pt-3 mr-5">
                            <p class="font-poppins font-medium text-sm leading-5 text-black">
                                {{ $user->name ?? ' ' }}</p>
                        </div>
                        <div class="">
                            <img src="{{ asset('images/upload/' . $user->image) }}"
                                class="w-10 h-10 bg-cover object-contain border border-gray-light rounded-full"
                                alt="">
                        </div>
                        <div class="ml-3 pt-1 dropdown relative flex">
                            <div class="relative inline-block text-left">
                                <div
                                    class="dropdownMenuClass hidden rigin-top-right absolute right-0 w-56 rounded-md shadow-2xl z-30 mt-10">
                                    <div class="rounded-md bg-white shadow-xs">
                                        <div class="py-1">
                                            <div
                                                class="overflow-y-auto py-4 px-3 bg-gray-50 rounded pt-10 border-b border-gray-light pb-5">
                                                <ul class="space-y-8 ">
                                                    <li>
                                                        <a href="{{ url('/my-tickets') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('My tickets') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/user/profile') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('Profile') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ url('/change-password') }}"
                                                            class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('Change password') }}
                                                        </a>
                                                    </li>
                                                    @if ($wallet == 1)
                                                        <li>
                                                            <a href="{{ route('myWallet') }}"
                                                                class="flex items-center font-normal font-poppins leading-6 text-black text-base capitalize">{{ __('My Wallet') }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="px-3 py-5">
                                                <button type="button"
                                                    class="flex items-center  font-poppins font-medium leading-4 text-danger capitalize">
                                                    <i class="fa-solid fa-right-from-bracket mr-3"></i><span id="logout-btn-2"
                                                        class="flex-1  whitespace-nowrap">{{ __('Logout') }}</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="sm:px-4 flex xxsm:flex-wrap justify-end mt-2 sm:mt-0">
                        <a type="button" href="{{ route('user.login') }}"
                            class="px-5 py-2 text-white text-center font-poppins font-normal text-base leading-6 rounded-md"
                            style="background-color: #f7941d;">{{ __('Sign In') }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    // Handle both logout buttons
    function handleLogout() {
        Swal.fire({
            title: 'Are you sure to logout!!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ url('/user/logoutuser') }}";
            }
        })
    }
    
    // Add event listeners to both logout buttons
    document.addEventListener('DOMContentLoaded', function() {
        const logoutBtn1 = document.getElementById("logout-btn-1");
        const logoutBtn2 = document.getElementById("logout-btn-2");
        
        if (logoutBtn1) {
            logoutBtn1.addEventListener('click', handleLogout);
        }
        if (logoutBtn2) {
            logoutBtn2.addEventListener('click', handleLogout);
        }
    });
</script>
