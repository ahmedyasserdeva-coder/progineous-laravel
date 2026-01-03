@extends('frontend.client.layout')

@section('title', __('Payment Pending - Floating IP'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-100 rounded-full mb-4">
                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ __('Payment Pending') }}</h1>
            <p class="text-gray-600">{{ __('Please complete your payment to activate the Floating IP') }}</p>
        </div>

        <!-- Payment Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">{{ __('Payment Details') }}</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">{{ __('Service') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $service->service_name }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">{{ __('Floating IP Type') }}:</span>
                    <span class="font-semibold text-gray-900">{{ strtoupper($pendingData['protocol']) }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">{{ __('IP Name') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $pendingData['name'] }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">{{ __('Location') }}:</span>
                    <span class="font-semibold text-gray-900">{{ $pendingData['location'] }}</span>
                </div>
                
                <div class="flex justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">{{ __('Billing Cycle') }}:</span>
                    <span class="font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $pendingData['billing_cycle'])) }}</span>
                </div>
                
                <div class="flex justify-between py-3 bg-gray-50 rounded-lg px-4 mt-4">
                    <span class="text-lg font-semibold text-gray-900">{{ __('Total Amount') }}:</span>
                    <span class="text-2xl font-bold text-blue-600">${{ number_format($pendingData['total_amount'], 2) }}</span>
                </div>
            </div>
        </div>

        @if($pendingData['payment_method'] === 'fawry')
        <!-- Fawry Payment Instructions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">
                <i class="fas fa-info-circle mr-2"></i>{{ __('Fawry Payment Instructions') }}
            </h3>
            <div class="space-y-3 text-blue-800">
                <p>{{ __('To complete your payment, please visit any Fawry location and use the following reference number:') }}</p>
                
                @if(isset($pendingData['fawaterak_invoice_id']))
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('Reference Number') }}</p>
                    <p class="text-3xl font-bold text-gray-900 tracking-wider">{{ $pendingData['fawaterak_invoice_id'] }}</p>
                </div>
                @endif
                
                <ol class="list-decimal list-inside space-y-2 mt-4">
                    <li>{{ __('Visit any Fawry location or authorized agent') }}</li>
                    <li>{{ __('Provide the reference number above') }}</li>
                    <li>{{ __('Pay the amount in cash') }}</li>
                    <li>{{ __('Your Floating IP will be created automatically after payment confirmation') }}</li>
                </ol>
            </div>
        </div>
        @elseif($pendingData['payment_method'] === 'mobile_wallet')
        <!-- Mobile Wallet Payment Instructions -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-green-900 mb-3">
                <i class="fas fa-mobile-alt mr-2"></i>{{ __('Mobile Wallet Payment Instructions') }}
            </h3>
            <div class="space-y-3 text-green-800">
                <p>{{ __('Please complete the payment using your mobile wallet app') }}</p>
                
                @if(isset($pendingData['fawaterak_invoice_id']))
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">{{ __('Payment Reference') }}</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingData['fawaterak_invoice_id'] }}</p>
                </div>
                @endif
                
                <p class="mt-4">{{ __('Your Floating IP will be created automatically after payment confirmation') }}</p>
            </div>
        </div>
        @endif

        <!-- Status Check Info -->
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ __('What happens next?') }}</h3>
            <ul class="space-y-2 text-gray-700">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __('Complete your payment using the instructions above') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __('Our system will automatically verify your payment') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __('Your Floating IP will be created and attached to your server') }}</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ __('You will receive an email confirmation') }}</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('client.hosting.vps.show', $service->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>{{ __('Back to Service') }}
            </a>
            <a href="{{ route('client.dashboard') }}" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg text-center transition duration-200">
                <i class="fas fa-home mr-2"></i>{{ __('Dashboard') }}
            </a>
        </div>

        <!-- Note -->
        <div class="mt-6 text-center text-sm text-gray-600">
            <p>{{ __('Payment processing may take a few minutes. Please do not close this page until payment is confirmed.') }}</p>
        </div>
    </div>
</div>
@endsection
