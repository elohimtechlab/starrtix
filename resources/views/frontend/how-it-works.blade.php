@extends('frontend.master')
@section('title', __('How it Works'))
@section('content')

<div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">{{ __('How it Works') }}</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">{{ __('Create, manage, and sell tickets for your events in just a few simple steps') }}</p>
        </div>
    </div>

    <!-- Steps Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Get Started in 3 Easy Steps') }}</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">{{ __('Whether you\'re organizing a small meetup or a large conference, our platform makes event management simple and efficient.') }}</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Step 1 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('1. Create Your Event') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('Set up your event details, add descriptions, images, and configure ticket types with our intuitive event creation wizard.') }}</p>
                <ul class="text-left text-sm text-gray-500 space-y-2">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Event details & description') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Multiple ticket types') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Custom pricing') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Image gallery') }}</li>
                </ul>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-secondary rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('2. Promote & Share') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('Share your event across social media, send invites, and use our built-in marketing tools to reach your audience.') }}</p>
                <ul class="text-left text-sm text-gray-500 space-y-2">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Social media sharing') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Email invitations') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('QR code generation') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Event listing') }}</li>
                </ul>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform hover:scale-105 transition-transform duration-300">
                <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('3. Manage & Collect') }}</h3>
                <p class="text-gray-600 mb-6">{{ __('Track sales, manage attendees, and collect payments securely. Get real-time analytics and insights.') }}</p>
                <ul class="text-left text-sm text-gray-500 space-y-2">
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Real-time analytics') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Secure payments') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Attendee management') }}</li>
                    <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>{{ __('Check-in system') }}</li>
                </ul>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Powerful Features') }}</h2>
                <p class="text-lg text-gray-600">{{ __('Everything you need to create successful events') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-ticket-alt text-2xl text-primary"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Digital Tickets') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('QR code tickets with PDF download') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-credit-card text-2xl text-green-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Secure Payments') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Multiple payment gateways') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-bar text-2xl text-purple-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Analytics') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Real-time sales and attendance data') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-orange-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Mobile Ready') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Responsive design for all devices') }}</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-primary to-blue-600 rounded-3xl p-12 text-white">
            <h2 class="text-4xl font-bold mb-4">{{ __('Ready to Get Started?') }}</h2>
            <p class="text-xl mb-8">{{ __('Join thousands of event organizers who trust our platform') }}</p>
            <div class="space-x-4">
                <a href="{{ url('user/org-register') }}" 
                   class="inline-block px-8 py-4 bg-white text-primary font-bold rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    {{ __('Create Your First Event') }}
                </a>
                <a href="{{ route('pricing') }}" 
                   class="inline-block px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-primary transition-colors duration-200">
                    {{ __('View Pricing') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
