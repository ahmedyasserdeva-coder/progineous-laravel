@extends('frontend.layout')

@section('title', __('frontend.privacy_policy'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 mb-8">
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-4">
                {{ __('frontend.privacy_policy') }}
            </h1>
            <p class="text-slate-600 dark:text-slate-400">
                {{ __('Last updated') }}: {{ now()->format('F d, Y') }}
            </p>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 prose prose-slate dark:prose-invert max-w-none">
            <h2>1. {{ __('Information We Collect') }}</h2>
            <p>
                {{ __('We collect information that you provide directly to us, including:') }}
            </p>
            <ul>
                <li>{{ __('Personal information (name, email, phone number)') }}</li>
                <li>{{ __('Account credentials (username, password)') }}</li>
                <li>{{ __('Billing information (address, payment details)') }}</li>
                <li>{{ __('Communication preferences') }}</li>
            </ul>

            <h2>2. {{ __('How We Use Your Information') }}</h2>
            <p>{{ __('We use the information we collect to:') }}</p>
            <ul>
                <li>{{ __('Provide and maintain our services') }}</li>
                <li>{{ __('Process transactions and send related information') }}</li>
                <li>{{ __('Send administrative information and updates') }}</li>
                <li>{{ __('Respond to your comments and questions') }}</li>
                <li>{{ __('Improve our services and develop new features') }}</li>
                <li>{{ __('Detect and prevent fraud and abuse') }}</li>
            </ul>

            <h2>3. {{ __('Information Sharing') }}</h2>
            <p>
                {{ __('We do not sell or rent your personal information to third parties. We may share your information only in the following circumstances:') }}
            </p>
            <ul>
                <li>{{ __('With your consent') }}</li>
                <li>{{ __('With service providers who assist in our operations') }}</li>
                <li>{{ __('To comply with legal obligations') }}</li>
                <li>{{ __('To protect our rights and prevent fraud') }}</li>
            </ul>

            <h2>4. {{ __('Data Security') }}</h2>
            <p>
                {{ __('We implement appropriate technical and organizational security measures to protect your personal information. However, no method of transmission over the Internet is 100% secure.') }}
            </p>

            <h2>5. {{ __('Cookies and Tracking') }}</h2>
            <p>
                {{ __('We use cookies and similar tracking technologies to track activity on our service and hold certain information. You can control cookies through your browser settings.') }}
            </p>

            <h2>6. {{ __('Data Retention') }}</h2>
            <p>
                {{ __('We retain your personal information for as long as necessary to provide our services and comply with legal obligations. When data is no longer needed, we securely delete it.') }}
            </p>

            <h2>7. {{ __('Your Rights') }}</h2>
            <p>{{ __('You have the right to:') }}</p>
            <ul>
                <li>{{ __('Access your personal information') }}</li>
                <li>{{ __('Correct inaccurate data') }}</li>
                <li>{{ __('Request deletion of your data') }}</li>
                <li>{{ __('Object to processing of your data') }}</li>
                <li>{{ __('Export your data') }}</li>
                <li>{{ __('Withdraw consent') }}</li>
            </ul>

            <h2>8. {{ __('Children\'s Privacy') }}</h2>
            <p>
                {{ __('Our services are not intended for children under 18. We do not knowingly collect personal information from children.') }}
            </p>

            <h2>9. {{ __('International Data Transfers') }}</h2>
            <p>
                {{ __('Your information may be transferred to and maintained on servers located outside of your country. We ensure appropriate safeguards are in place.') }}
            </p>

            <h2>10. {{ __('Third-Party Links') }}</h2>
            <p>
                {{ __('Our service may contain links to third-party websites. We are not responsible for the privacy practices of these sites.') }}
            </p>

            <h2>11. {{ __('Changes to Privacy Policy') }}</h2>
            <p>
                {{ __('We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.') }}
            </p>

            <h2>12. {{ __('Contact Us') }}</h2>
            <p>
                {{ __('If you have any questions about this Privacy Policy, please contact us:') }}
            </p>
            <ul>
                <li>{{ __('Email') }}: privacy@progineous.com</li>
                <li>{{ __('Phone') }}: +20 123 456 7890</li>
                <li>{{ __('Address') }}: Cairo, Egypt</li>
            </ul>

            <h2>13. {{ __('GDPR Compliance') }}</h2>
            <p>
                {{ __('For users in the European Union, we comply with GDPR requirements. You have additional rights under GDPR, including the right to lodge a complaint with a supervisory authority.') }}
            </p>
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
