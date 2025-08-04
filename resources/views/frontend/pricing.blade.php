@extends('frontend.master')
@section('title', __('Pricing'))
@section('content')

<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary to-blue-600 text-white py-20">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-5xl font-bold mb-6">{{ __('Simple, Transparent Pricing') }}</h1>
            <p class="text-xl mb-8 max-w-2xl mx-auto">{{ __('Choose the perfect plan for your events. No hidden fees, no surprises.') }}</p>
        </div>
    </div>

    <!-- Pricing Cards -->
    <div class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Free Plan -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-gray-100 hover:border-primary transition-colors duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Free') }}</h3>
                    <div class="text-4xl font-bold text-primary mb-2">$0</div>
                    <p class="text-gray-600">{{ __('Perfect for small events') }}</p>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Up to 50 tickets per event') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Basic event management') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('QR code tickets') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Email support') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-times text-gray-400 mr-3"></i>
                        <span class="text-gray-400">{{ __('Advanced analytics') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-times text-gray-400 mr-3"></i>
                        <span class="text-gray-400">{{ __('Custom branding') }}</span>
                    </li>
                </ul>
                
                <a href="{{ url('user/org-register') }}" 
                   class="block w-full text-center px-6 py-3 border-2 border-primary text-primary font-semibold rounded-lg hover:bg-primary hover:text-white transition-colors duration-200">
                    {{ __('Get Started Free') }}
                </a>
            </div>

            <!-- Pro Plan -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-primary relative transform scale-105">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-primary text-white px-4 py-1 rounded-full text-sm font-semibold">{{ __('Most Popular') }}</span>
                </div>
                
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Pro') }}</h3>
                    <div class="text-4xl font-bold text-primary mb-2">$29</div>
                    <p class="text-gray-600">{{ __('per month') }}</p>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Unlimited tickets') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Advanced event management') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('QR code tickets & check-in') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Priority support') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Advanced analytics') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Custom branding') }}</span>
                    </li>
                </ul>
                
                <a href="{{ url('user/org-register') }}" 
                   class="block w-full text-center px-6 py-3 bg-primary text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors duration-200">
                    {{ __('Start Pro Trial') }}
                </a>
            </div>

            <!-- Enterprise Plan -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border-2 border-gray-100 hover:border-primary transition-colors duration-300">
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('Enterprise') }}</h3>
                    <div class="text-4xl font-bold text-primary mb-2">{{ __('Custom') }}</div>
                    <p class="text-gray-600">{{ __('For large organizations') }}</p>
                </div>
                
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Everything in Pro') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('White-label solution') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('API access') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Dedicated support') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('Custom integrations') }}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-3"></i>
                        <span class="text-gray-700">{{ __('SLA guarantee') }}</span>
                    </li>
                </ul>
                
                <a href="{{ url('/contact') }}" 
                   class="block w-full text-center px-6 py-3 border-2 border-primary text-primary font-semibold rounded-lg hover:bg-primary hover:text-white transition-colors duration-200">
                    {{ __('Contact Sales') }}
                </a>
            </div>
        </div>

        <!-- Features Comparison -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Feature Comparison') }}</h2>
                <p class="text-lg text-gray-600">{{ __('See what\'s included in each plan') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-6 font-semibold text-gray-800">{{ __('Features') }}</th>
                            <th class="text-center py-4 px-6 font-semibold text-gray-800">{{ __('Free') }}</th>
                            <th class="text-center py-4 px-6 font-semibold text-primary">{{ __('Pro') }}</th>
                            <th class="text-center py-4 px-6 font-semibold text-gray-800">{{ __('Enterprise') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr>
                            <td class="py-4 px-6 font-medium">{{ __('Events per month') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('5') }}</td>
                            <td class="py-4 px-6 text-center text-primary font-semibold">{{ __('Unlimited') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('Unlimited') }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-4 px-6 font-medium">{{ __('Tickets per event') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('50') }}</td>
                            <td class="py-4 px-6 text-center text-primary font-semibold">{{ __('Unlimited') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('Unlimited') }}</td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-medium">{{ __('Transaction fee') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('3%') }}</td>
                            <td class="py-4 px-6 text-center text-primary font-semibold">{{ __('2%') }}</td>
                            <td class="py-4 px-6 text-center">{{ __('Custom') }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-4 px-6 font-medium">{{ __('Custom branding') }}</td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-times text-red-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-check text-green-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-check text-green-500"></i></td>
                        </tr>
                        <tr>
                            <td class="py-4 px-6 font-medium">{{ __('Advanced analytics') }}</td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-times text-red-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-check text-green-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-check text-green-500"></i></td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="py-4 px-6 font-medium">{{ __('API access') }}</td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-times text-red-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-times text-red-500"></i></td>
                            <td class="py-4 px-6 text-center"><i class="fas fa-check text-green-500"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-12 mb-16">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ __('Frequently Asked Questions') }}</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Can I change plans anytime?') }}</h4>
                    <p class="text-gray-600 mb-6">{{ __('Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately.') }}</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Are there any setup fees?') }}</h4>
                    <p class="text-gray-600 mb-6">{{ __('No, there are no setup fees or hidden charges. You only pay the monthly subscription.') }}</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('What payment methods do you accept?') }}</h4>
                    <p class="text-gray-600 mb-6">{{ __('We accept all major credit cards, PayPal, and bank transfers for Enterprise plans.') }}</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">{{ __('Is there a free trial?') }}</h4>
                    <p class="text-gray-600 mb-6">{{ __('Yes, we offer a 14-day free trial for the Pro plan with no credit card required.') }}</p>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center bg-gradient-to-r from-primary to-blue-600 rounded-3xl p-12 text-white">
            <h2 class="text-4xl font-bold mb-4">{{ __('Ready to Start Selling Tickets?') }}</h2>
            <p class="text-xl mb-8">{{ __('Join thousands of event organizers worldwide') }}</p>
            <div class="space-x-4">
                <a href="{{ url('user/org-register') }}" 
                   class="inline-block px-8 py-4 bg-white text-primary font-bold rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    {{ __('Start Free Trial') }}
                </a>
                <a href="{{ url('/contact') }}" 
                   class="inline-block px-8 py-4 border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-primary transition-colors duration-200">
                    {{ __('Contact Sales') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
