<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('crm.document_verification') }} - {{ config('app.name') }}</title>
    
    <!-- Use Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Cairo', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-100 to-slate-200 min-h-screen">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800">{{ config('app.name') }}</h1>
            <p class="text-slate-600">{{ __('crm.document_verification') }}</p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
            @if($document)
                <!-- Document Found -->
                <div class="bg-gradient-to-r from-green-600 to-green-500 p-6 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-1">{{ __('crm.document_registered') }}</h2>
                    <p class="text-white/80 text-sm">{{ __('crm.document_found_in_system') }}</p>
                </div>

                <div class="p-6 space-y-4">
                    <!-- Document ID -->
                    <div class="bg-slate-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-slate-500 mb-1">{{ __('crm.document_id') }}</p>
                        <p class="font-mono text-2xl font-bold text-slate-800 tracking-wider">{{ $document->document_id }}</p>
                    </div>

                    <!-- Document Info -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-500 mb-1">{{ __('crm.issued_to') }}</p>
                            <p class="font-semibold text-slate-800">{{ $document->metadata['client_name'] ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-500 mb-1">{{ __('crm.generation_date') }}</p>
                            <p class="font-semibold text-slate-800">{{ $document->generated_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-500 mb-1">{{ __('crm.total_invoiced') }}</p>
                            <p class="font-semibold text-slate-800">${{ number_format($document->total_invoiced, 2) }}</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-500 mb-1">{{ __('crm.balance_due') }}</p>
                            <p class="font-semibold {{ $document->balance > 0 ? 'text-red-600' : 'text-green-600' }}">${{ number_format($document->balance, 2) }}</p>
                        </div>
                    </div>
                </div>

            @else
                <!-- Document Not Found -->
                <div class="bg-gradient-to-r from-red-600 to-red-500 p-6 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-1">{{ __('crm.document_not_found') }}</h2>
                    <p class="text-white/80 text-sm">{{ __('crm.document_id_invalid') }}</p>
                </div>

                <div class="p-6">
                    <div class="bg-red-50 rounded-xl p-4 text-center">
                        <p class="text-xs text-red-500 mb-1">{{ __('crm.searched_document_id') }}</p>
                        <p class="font-mono text-lg font-bold text-red-700 tracking-wider">{{ $documentId }}</p>
                    </div>

                    <div class="mt-4 p-4 bg-amber-50 rounded-xl">
                        <p class="text-sm text-amber-800">
                            <strong>⚠️ {{ __('crm.warning') }}:</strong> {{ __('crm.document_may_be_fake') }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-slate-500 text-sm">
            <p>{{ __('crm.powered_by') }} {{ config('app.name') }}</p>
            <p class="mt-1">&copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
