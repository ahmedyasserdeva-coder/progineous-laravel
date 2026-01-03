@extends('frontend.layout')

@section('title', __('frontend.terms_and_conditions'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 mb-8">
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('frontend.terms_and_conditions') }}
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                {{ __('Last updated') }}: {{ now()->format('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 prose prose-slate dark:prose-invert max-w-none">
            <h2>1. {{ __('Agreement to Terms') }}</h2>
            <p>
                {{ __('By accessing or using our services, you agree to be bound by these Terms and Conditions. If you disagree with any part of these terms, you may not access our services.') }}
            </p>

            <h2>2. {{ __('Use License') }}</h2>
            <p>
                {{ __('Permission is granted to temporarily access our services for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.') }}
            </p>
            <p>{{ __('Under this license you may not:') }}</p>
            <ul>
                <li>{{ __('Modify or copy the materials') }}</li>
                <li>{{ __('Use the materials for any commercial purpose') }}</li>
                <li>{{ __('Attempt to decompile or reverse engineer any software') }}</li>
                <li>{{ __('Remove any copyright or proprietary notations') }}</li>
                <li>{{ __('Transfer the materials to another person') }}</li>
            </ul>

            <h2>3. {{ __('User Account') }}</h2>
            <p>
                {{ __('When you create an account with us, you must provide accurate, complete, and current information. Failure to do so constitutes a breach of the Terms.') }}
            </p>
            <p>
                {{ __('You are responsible for safeguarding the password and for all activities that occur under your account.') }}
            </p>

            <h2>4. {{ __('Services') }}</h2>
            <p>
                {{ __('We provide web hosting, domain registration, and related services. We reserve the right to refuse service to anyone for any reason at any time.') }}
            </p>

            <h2>5. {{ __('Payment Terms') }}</h2>
            <p>
                {{ __('Payment is required for all services. Prices are subject to change with notice. Refunds are handled according to our refund policy.') }}
            </p>

            <h2>6. {{ __('Acceptable Use') }}</h2>
            <p>{{ __('You agree not to use our services to:') }}</p>
            <ul>
                <li>{{ __('Violate any laws or regulations') }}</li>
                <li>{{ __('Infringe on intellectual property rights') }}</li>
                <li>{{ __('Transmit harmful or malicious code') }}</li>
                <li>{{ __('Spam or send unsolicited communications') }}</li>
                <li>{{ __('Engage in any activity that disrupts our services') }}</li>
            </ul>

            <h2>7. {{ __('Service Availability') }}</h2>
            <p>
                {{ __('We strive for 99.9% uptime but do not guarantee uninterrupted service. We reserve the right to modify or discontinue services with or without notice.') }}
            </p>

            <h2>8. {{ __('Intellectual Property') }}</h2>
            <p>
                {{ __('The service and its original content, features, and functionality are owned by us and are protected by international copyright, trademark, and other intellectual property laws.') }}
            </p>

            <h2>9. {{ __('Limitation of Liability') }}</h2>
            <p>
                {{ __('In no event shall we be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of our services.') }}
            </p>

            <h2>10. {{ __('Termination') }}</h2>
            <p>
                {{ __('We may terminate or suspend your account immediately, without prior notice, for any breach of these Terms.') }}
            </p>

            <h2>11. {{ __('Governing Law') }}</h2>
            <p>
                {{ __('These Terms shall be governed by and construed in accordance with applicable laws, without regard to its conflict of law provisions.') }}
            </p>

            <h2>12. {{ __('Changes to Terms') }}</h2>
            <p>
                {{ __('We reserve the right to modify these terms at any time. We will notify users of any material changes via email or through our website.') }}
            </p>

            <h2>13. {{ __('Contact Information') }}</h2>
            <p>
                {{ __('If you have any questions about these Terms, please contact us at:') }}
            </p>
            <ul>
                <li>{{ __('Email') }}: support@progineous.com</li>
                <li>{{ __('Phone') }}: +20 123 456 7890</li>
            </ul>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('Go Back') }}
            </a>
        </div>
    </div>
</div>
@endsection
