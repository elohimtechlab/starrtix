@extends('frontend.master')
@section('title', __('About Us'))
@section('content')

<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">{{ __('About Us') }}</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">{{ __('We\'re passionate about making event management simple, accessible, and powerful for everyone.') }}</p>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
            <div>
                <h2 class="text-4xl font-bold text-gray-800 mb-6">{{ __('Our Mission') }}</h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ __('At Starrtix, we believe that every event has the power to bring people together, create memories, and build communities. Our mission is to empower event organizers with the tools they need to create extraordinary experiences.') }}
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    {{ __('Whether you\'re organizing a small workshop, a corporate conference, or a large festival, we provide the technology and support to make your event successful.') }}
                </p>
                <div class="grid grid-cols-2 gap-6 mt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary mb-2">10K+</div>
                        <div class="text-gray-600">{{ __('Events Created') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-primary mb-2">500K+</div>
                        <div class="text-gray-600">{{ __('Tickets Sold') }}</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    <img src="{{ asset('images/about-mission.jpg') }}" alt="Our Mission" class="w-full h-64 object-cover rounded-lg mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('Trusted by Event Organizers Worldwide') }}</h3>
                    <p class="text-gray-600">{{ __('From startups to Fortune 500 companies, thousands of organizers trust us with their most important events.') }}</p>
                </div>
            </div>
        </div>

        <!-- Values Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Our Values') }}</h2>
                <p class="text-lg text-gray-600">{{ __('The principles that guide everything we do') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Customer First') }}</h3>
                    <p class="text-gray-600">{{ __('Every decision we make is guided by what\'s best for our customers. Your success is our success.') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-secondary rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lightbulb text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Innovation') }}</h3>
                    <p class="text-gray-600">{{ __('We continuously innovate to provide cutting-edge solutions that make event management easier and more effective.') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ __('Reliability') }}</h3>
                    <p class="text-gray-600">{{ __('We build robust, secure, and reliable systems that you can depend on for your most important events.') }}</p>
                </div>
            </div>
        </div>

        <!-- Story Section -->
        <div class="grid lg:grid-cols-2 gap-12 items-center mb-20">
            <div class="order-2 lg:order-1">
                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    <img src="{{ asset('images/about-story.jpg') }}" alt="Our Story" class="w-full h-64 object-cover rounded-lg mb-6">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2020</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ __('Founded') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Started with a vision to simplify event management') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-secondary rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2021</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ __('First 1000 Events') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Reached our first major milestone') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-bold">2024</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800">{{ __('Global Expansion') }}</h4>
                                <p class="text-sm text-gray-600">{{ __('Now serving customers worldwide') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-4xl font-bold text-gray-800 mb-6">{{ __('Our Story') }}</h2>
                <p class="text-lg text-gray-600 mb-6">
                    {{ __('Starrtix was born from a simple frustration: existing event management tools were either too complex or too limited. We set out to create a platform that would be powerful enough for large organizations yet simple enough for first-time event organizers.') }}
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    {{ __('What started as a small project has grown into a comprehensive platform trusted by thousands of event organizers worldwide. We\'ve helped create everything from intimate workshops to massive conferences, and we\'re just getting started.') }}
                </p>
                <p class="text-lg text-gray-600">
                    {{ __('Today, we continue to innovate and expand our platform, always with the goal of making event management more accessible and effective for everyone.') }}
                </p>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Why Choose Starrtix?') }}</h2>
                <p class="text-lg text-gray-600">{{ __('We\'re more than just a ticketing platform') }}</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-2xl text-primary"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Quick Setup') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Create your first event in minutes, not hours') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-green-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('24/7 Support') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Our team is always here to help you succeed') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-2xl text-purple-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Secure & Reliable') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Bank-level security for all transactions') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl text-orange-600"></i>
                    </div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Powerful Analytics') }}</h4>
                    <p class="text-sm text-gray-600">{{ __('Insights to help you grow your events') }}</p>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Meet Our Team') }}</h2>
                <p class="text-lg text-gray-600">{{ __('The passionate people behind Starrtix') }}</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('John Smith') }}</h4>
                    <p class="text-primary font-semibold mb-2">{{ __('CEO & Founder') }}</p>
                    <p class="text-sm text-gray-600">{{ __('Passionate about connecting people through amazing events') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('Sarah Johnson') }}</h4>
                    <p class="text-primary font-semibold mb-2">{{ __('CTO') }}</p>
                    <p class="text-sm text-gray-600">{{ __('Building scalable technology that powers millions of events') }}</p>
                </div>

                <div class="text-center">
                    <div class="w-32 h-32 bg-gray-300 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user text-4xl text-gray-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">{{ __('Mike Chen') }}</h4>
                    <p class="text-primary font-semibold mb-2">{{ __('Head of Customer Success') }}</p>
                    <p class="text-sm text-gray-600">{{ __('Ensuring every customer achieves their event goals') }}</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-primary to-blue-600 rounded-3xl p-12 text-white">
            <h2 class="text-4xl font-bold mb-4">{{ __('Ready to Join Our Community?') }}</h2>
            <p class="text-xl mb-8">{{ __('Start creating amazing events today') }}</p>
            <div class="space-x-4">
                <a href="{{ url('user/org-register') }}" 
                   class="inline-block px-8 py-4 bg-white text-primary font-bold rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    {{ __('Get Started') }}
                </a>
                <a href="{{ url('/contact') }}" 
                   class="inline-block px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-primary transition-colors duration-200">
                    {{ __('Contact Us') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
