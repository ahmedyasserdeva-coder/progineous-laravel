@extends('frontend.layout')

@section('title', __('frontend.home') . ' - ' . config('app.name'))
@section('description', __('frontend.hero_subtitle'))

@push('styles')
<style>
    /* Hero Background Animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes pulse-slow {
        0%, 100% { opacity: 0.3; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.05); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-delay { animation: float 6s ease-in-out infinite; animation-delay: 2s; }
    .animate-pulse-slow { animation: pulse-slow 4s ease-in-out infinite; }
    
    /* Search Bar Animation */
    @keyframes typing {
        from { width: 0; }
        to { width: 100%; }
    }
    
    /* Marquee Animation */
    @keyframes marquee {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .animate-marquee {
        animation: marquee 30s linear infinite;
    }
    .animate-marquee:hover {
        animation-play-state: paused;
    }

    /* Card Hover Effects */
    .hosting-card {
        transition: all 0.3s ease;
    }
    .hosting-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@section('content')
{{-- Domain Search Bar (Sticky Top) --}}
<div class="bg-white py-3 shadow-sm sticky top-0 z-40 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-4 lg:justify-between">
            {{-- Search Input --}}
            <div class="relative w-full lg:w-auto lg:flex-1 lg:max-w-lg">
                <svg class="pointer-events-none absolute {{ app()->getLocale() == 'ar' ? 'right-4' : 'left-4' }} top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <form action="{{ route('domains.search') }}" method="GET" class="flex">
                    <input
                        type="text"
                        name="domain"
                        placeholder="{{ __('frontend.enter_domain_name') }}..."
                        class="w-full rounded-full border border-gray-200 bg-gray-50 py-3 {{ app()->getLocale() == 'ar' ? 'pr-12 pl-28' : 'pl-12 pr-28' }} text-sm transition-all focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        dir="ltr"
                    >
                    <button 
                        type="submit"
                        class="absolute {{ app()->getLocale() == 'ar' ? 'left-1.5' : 'right-1.5' }} top-1/2 -translate-y-1/2 rounded-full bg-blue-600 px-6 py-2 text-sm font-semibold text-white transition-all hover:bg-blue-700"
                    >
                        {{ __('frontend.search') }}
                    </button>
                </form>
            </div>
            
            {{-- Popular TLDs --}}
            <div class="flex flex-wrap items-center justify-center gap-2">
                @php
                    $popularTlds = \App\Models\Tld::where('is_popular', true)->take(5)->get();
                @endphp
                @foreach($popularTlds as $index => $tld)
                <div class="flex items-center gap-2 rounded-full px-4 py-2 {{ $index < 2 ? 'bg-blue-50' : 'bg-gray-100' }}">
                    <span class="text-sm font-bold {{ $index < 2 ? 'text-blue-600' : 'text-gray-700' }}">{{ $tld->extension }}</span>
                    <span class="text-sm font-semibold text-blue-600">${{ number_format($tld->register_price, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Hero Section --}}
<section class="relative min-h-[600px] sm:min-h-[680px] lg:min-h-[750px] bg-gradient-to-br from-slate-900 via-blue-900 to-blue-800 overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
    
    {{-- Floating Elements --}}
    <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'left-10' : 'right-10' }} w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 {{ app()->getLocale() == 'ar' ? 'right-10' : 'left-10' }} w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl animate-float-delay"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid min-h-[600px] sm:min-h-[680px] lg:min-h-[750px] items-center gap-8 py-16 sm:py-20 lg:py-0 lg:grid-cols-2">
            
            {{-- Left Content --}}
            <div class="relative z-10 text-center lg:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                {{-- Trust Badges --}}
                <div class="mb-6 flex flex-wrap items-center justify-center gap-4 lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }}">
                    <div class="flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 backdrop-blur-sm">
                        <div class="flex">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="h-3.5 w-3.5 fill-amber-400 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="text-xs font-medium text-white">4.9/5 Trustpilot</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 backdrop-blur-sm">
                        <span class="text-xs font-medium text-white">+50,000 {{ __('frontend.happy_clients') }}</span>
                    </div>
                </div>

                {{-- Headline --}}
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight text-white">
                    {{ __('frontend.hero_title_speed') }}<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">{{ __('frontend.hero_title_hosting') }}</span>
                </h1>

                {{-- Subtitle --}}
                <p class="mx-auto lg:mx-0 mt-6 max-w-lg text-base sm:text-lg leading-relaxed text-white/70">
                    {{ __('frontend.hero_subtitle_new') }}
                </p>

                {{-- Features --}}
                <div class="mt-6 flex flex-wrap items-center justify-center gap-4 lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }}">
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="text-sm">{{ __('frontend.ultra_fast') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="text-sm">{{ __('frontend.full_security') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-white/80">
                        <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ __('frontend.support_247') }}</span>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }}">
                    <a href="{{ route('hosting.shared') }}" class="group inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 px-8 py-4 text-base font-semibold text-white shadow-lg shadow-blue-600/30 transition-all hover:bg-blue-700 hover:shadow-xl">
                        {{ __('frontend.start_now') }} $2
                        <svg class="h-4 w-4 transition-transform group-hover:{{ app()->getLocale() == 'ar' ? '-translate-x-1' : 'translate-x-1' }} {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="#hosting-plans" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-white/50 px-8 py-4 text-base font-semibold text-white transition-all hover:bg-white hover:text-blue-900">
                        {{ __('frontend.view_plans') }}
                    </a>
                </div>
            </div>

            {{-- Right Side - Globe Animation --}}
            <div class="relative hidden lg:flex items-center justify-center">
                <div class="relative w-[400px] h-[400px] xl:w-[500px] xl:h-[500px]">
                    {{-- Animated Globe --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-full h-full rounded-full border-2 border-white/20 animate-pulse-slow"></div>
                    </div>
                    <div class="absolute inset-8 flex items-center justify-center">
                        <div class="w-full h-full rounded-full border-2 border-white/15 animate-pulse-slow" style="animation-delay: 0.5s;"></div>
                    </div>
                    <div class="absolute inset-16 flex items-center justify-center">
                        <div class="w-full h-full rounded-full border-2 border-white/10 animate-pulse-slow" style="animation-delay: 1s;"></div>
                    </div>
                    {{-- Center Icon --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-full flex items-center justify-center shadow-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave Divider --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full" aria-hidden="true">
            <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
    </div>
</section>

{{-- TLD Marquee Section --}}
<section class="bg-white py-8 overflow-hidden border-b border-gray-100">
    <div class="relative">
        <div class="flex animate-marquee">
            @php
                $allTlds = \App\Models\Tld::where('status', 'active')->take(20)->get();
            @endphp
            @foreach($allTlds as $tld)
            <div class="flex items-center gap-3 px-6 py-3 mx-2 rounded-xl bg-gray-50 hover:bg-blue-50 transition-colors whitespace-nowrap">
                @if($tld->logo)
                <img src="{{ asset('storage/' . $tld->logo) }}" alt="{{ $tld->extension }}" class="h-6 w-auto">
                @endif
                <span class="font-bold text-gray-800">{{ $tld->extension }}</span>
                <span class="font-semibold text-blue-600">${{ number_format($tld->register_price, 2) }}</span>
            </div>
            @endforeach
            {{-- Duplicate for seamless loop --}}
            @foreach($allTlds as $tld)
            <div class="flex items-center gap-3 px-6 py-3 mx-2 rounded-xl bg-gray-50 hover:bg-blue-50 transition-colors whitespace-nowrap">
                @if($tld->logo)
                <img src="{{ asset('storage/' . $tld->logo) }}" alt="{{ $tld->extension }}" class="h-6 w-auto">
                @endif
                <span class="font-bold text-gray-800">{{ $tld->extension }}</span>
                <span class="font-semibold text-blue-600">${{ number_format($tld->register_price, 2) }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Hosting Plans Section --}}
<section id="hosting-plans" class="bg-white py-16 lg:py-24 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center mb-12">
            <h2 class="text-2xl lg:text-4xl font-bold text-gray-900">
                {{ __('frontend.choose_hosting_plan') }}
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                {{ __('frontend.hosting_plans_description') }}
            </p>
        </div>

        {{-- Hosting Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Shared Hosting --}}
            <a href="{{ route('hosting.shared') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 p-6 border border-blue-100 hover:border-blue-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.shared_hosting') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.shared_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-gray-900">$2</span>
                        <span class="text-sm text-gray-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.unlimited_ssd') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.free_ssl') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.unlimited_bandwidth') }}
                    </li>
                </ul>
            </a>

            {{-- Cloud Hosting --}}
            <a href="{{ route('hosting.cloud') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 p-6 border border-purple-100 hover:border-purple-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-purple-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.cloud_hosting') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.cloud_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-gray-900">$4</span>
                        <span class="text-sm text-gray-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.dedicated_resources') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.auto_scaling') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.daily_backups') }}
                    </li>
                </ul>
            </a>

            {{-- Reseller Hosting --}}
            <a href="{{ route('hosting.reseller') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-cyan-50 to-cyan-100 p-6 border border-cyan-100 hover:border-cyan-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.reseller_hosting') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.reseller_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-gray-900">$20</span>
                        <span class="text-sm text-gray-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.free_whm') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.white_label') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.unlimited_accounts') }}
                    </li>
                </ul>
            </a>

            {{-- VPS Hosting --}}
            <a href="{{ route('hosting.vps') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 border border-emerald-100 hover:border-emerald-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.vps_hosting') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.vps_hosting_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-gray-900">$14.99</span>
                        <span class="text-sm text-gray-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.full_root_access') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.choice_of_os') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.dedicated_ip') }}
                    </li>
                </ul>
            </a>

            {{-- Dedicated Servers --}}
            <a href="{{ route('hosting.dedicated') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-amber-50 to-amber-100 p-6 border border-amber-100 hover:border-amber-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.dedicated_servers') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.dedicated_servers_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">{{ __('frontend.starting_at') }}</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-gray-900">$140</span>
                        <span class="text-sm text-gray-500">/{{ __('frontend.month') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.entire_server') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.ultra_fast_performance') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.expert_support') }}
                    </li>
                </ul>
            </a>

            {{-- Migration Card --}}
            <a href="{{ route('migrate.hosting') }}" class="hosting-card group relative rounded-2xl bg-gradient-to-br from-rose-50 to-rose-100 p-6 border border-rose-100 hover:border-rose-200">
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-rose-600 shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-bold text-gray-900">{{ __('frontend.migrate_now') }}</h3>
                <p class="mt-1 text-sm text-gray-600">{{ __('frontend.migrate_now_desc') }}</p>
                <div class="mt-4">
                    <span class="text-xs text-gray-500">&nbsp;</span>
                    <div class="flex items-baseline gap-0.5">
                        <span class="text-3xl font-bold text-rose-600">{{ __('frontend.free') }}</span>
                    </div>
                </div>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.zero_downtime') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.expert_team') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ __('frontend.money_back_guarantee') }}
                    </li>
                </ul>
            </a>
        </div>
    </div>
</section>

{{-- Why Choose Us Section --}}
<section class="bg-gray-50 py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-600 text-sm font-semibold mb-4">
                {{ __('frontend.why_choose_us') }}
            </span>
            <h2 class="text-2xl lg:text-4xl font-bold text-gray-900">
                {{ __('frontend.why_choose_title') }}
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                {{ __('frontend.why_choose_description') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- 24/7 Availability --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('frontend.availability_247') }}</h3>
                <p class="text-sm text-gray-600">{{ __('frontend.availability_247_desc') }}</p>
            </div>

            {{-- Wider Reach --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('frontend.wider_reach') }}</h3>
                <p class="text-sm text-gray-600">{{ __('frontend.wider_reach_desc') }}</p>
            </div>

            {{-- Cost Effective --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('frontend.cost_effective') }}</h3>
                <p class="text-sm text-gray-600">{{ __('frontend.cost_effective_desc') }}</p>
            </div>

            {{-- 99.9% Uptime --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __('frontend.uptime_guarantee') }}</h3>
                <p class="text-sm text-gray-600">{{ __('frontend.uptime_guarantee_desc') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="bg-gradient-to-r from-blue-600 to-blue-800 py-16 lg:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl lg:text-4xl font-bold text-white mb-4">
            {{ __('frontend.ready_to_start') }}
        </h2>
        <p class="text-lg text-white/80 mb-8">
            {{ __('frontend.ready_to_start_desc') }}
        </p>
        <a href="{{ route('domains.search') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-8 py-4 text-base font-semibold text-blue-600 shadow-lg transition-all hover:bg-gray-100 hover:shadow-xl">
            {{ __('frontend.start_now') }}
            <svg class="h-4 w-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>

{{-- FAQ Section --}}
<section class="bg-white py-16 lg:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl lg:text-4xl font-bold text-gray-900">
                {{ __('frontend.faq_title') }}
            </h2>
        </div>

        <div x-data="{ openFaq: null }" class="space-y-4">
            @php
                $faqs = [
                    ['q' => __('frontend.faq_q1'), 'a' => __('frontend.faq_a1')],
                    ['q' => __('frontend.faq_q2'), 'a' => __('frontend.faq_a2')],
                    ['q' => __('frontend.faq_q3'), 'a' => __('frontend.faq_a3')],
                    ['q' => __('frontend.faq_q4'), 'a' => __('frontend.faq_a4')],
                ];
            @endphp
            
            @foreach($faqs as $index => $faq)
            <div class="bg-gray-50 rounded-xl overflow-hidden">
                <button 
                    @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}"
                    class="w-full px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} flex items-center justify-between"
                >
                    <span class="font-semibold text-gray-900">{{ $faq['q'] }}</span>
                    <svg 
                        class="w-5 h-5 text-gray-500 transition-transform"
                        :class="{ 'rotate-180': openFaq === {{ $index }} }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div 
                    x-show="openFaq === {{ $index }}"
                    x-collapse
                    class="px-6 pb-4"
                >
                    <p class="text-gray-600">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
