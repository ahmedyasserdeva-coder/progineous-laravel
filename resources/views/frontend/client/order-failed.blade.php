@extends('frontend.client.layout')

@section('title', __('frontend.order_failed') ?? 'Order Failed')

@section('content')
<section class="py-8">
    <div class="w-full">
        <div class="max-w-4xl mx-auto">
            <!-- Error Icon -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-gradient-to-br from-red-500 to-orange-500 rounded-full shadow-2xl mb-6">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white mb-4">
                    {{ __('frontend.payment_failed_title') ?? 'Payment Failed' }}
                </h1>
                <p class="text-xl text-slate-600 dark:text-slate-400">
                    {{ __('frontend.payment_failed_subtitle') ?? 'Unfortunately, your payment could not be processed.' }}
                </p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border border-slate-200 dark:border-slate-700 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-orange-500 rounded-xl flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    {{ __('frontend.order_information') ?? 'Order Information' }}
                </h2>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ __('frontend.order_number') ?? 'Order Number' }}</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ __('frontend.payment_status') ?? 'Payment Status' }}</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ __('frontend.order_date') ?? 'Order Date' }}</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">{{ __('frontend.total_amount') ?? 'Total Amount' }}</p>
                        <p class="text-lg font-bold text-slate-900 dark:text-white">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- What Happened -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8 border border-slate-200 dark:border-slate-700 mb-8">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ __('frontend.what_happened') ?? 'What Happened?' }}
                </h2>
                
                @if(session('error'))
                    <!-- Display specific error message from payment gateway -->
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="flex-1">
                                <p class="font-semibold text-red-800 dark:text-red-300 mb-1">{{ __('frontend.payment_error') ?? 'Payment Error' }}</p>
                                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="space-y-3 text-slate-600 dark:text-slate-400">
                    <p>{{ __('frontend.payment_failed_reasons') ?? 'Your payment could not be completed. This could be due to:' }}</p>
                    <ul class="list-disc list-inside space-y-2 ml-4">
                        <li>{{ __('frontend.insufficient_funds') ?? 'Insufficient funds in your account' }}</li>
                        <li>{{ __('frontend.card_declined') ?? 'Your card was declined by the issuing bank' }}</li>
                        <li>{{ __('frontend.incorrect_payment_info') ?? 'Incorrect payment information' }}</li>
                        <li>{{ __('frontend.technical_issue') ?? 'A technical issue occurred' }}</li>
                    </ul>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl shadow-xl p-8 text-white mb-8">
                <h2 class="text-2xl font-bold mb-4">{{ __('frontend.what_can_you_do') ?? 'What Can You Do?' }}</h2>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>{{ __('frontend.try_again_different_method') ?? 'Try again with a different payment method' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>{{ __('frontend.check_payment_info') ?? 'Check your payment information and card details' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-6 h-6 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>{{ __('frontend.contact_support_help') ?? 'Contact our support team for assistance' }}</span>
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <form action="{{ route('order.retry-payment', ['order' => $order->id]) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        {{ __('frontend.try_again') ?? 'Try Again' }}
                    </button>
                </form>
                <a href="{{ route('client.dashboard') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold rounded-xl border-2 border-slate-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    {{ __('frontend.go_to_dashboard') ?? 'Go to Dashboard' }}
                </a>
            </div>

            <!-- Support Info -->
            <div class="mt-8 text-center">
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('frontend.need_immediate_help') ?? 'Need immediate help?' }}
                    <a href="mailto:support@example.com" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                        {{ __('frontend.email_us') ?? 'Email us' }}
                    </a>
                    {{ __('frontend.or') ?? 'or' }}
                    <a href="tel:+1234567890" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">
                        {{ __('frontend.call_us') ?? 'call us' }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
