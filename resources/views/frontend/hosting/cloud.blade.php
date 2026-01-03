@extends('frontend.layout')

@section('title', __('frontend.cloud_hosting') . ' - ' . config('app.name'))

@section('meta_description', __('frontend.cloud_hosting_meta_desc') ?? 'استضافة سحابية قوية وموثوقة مع موارد مخصصة، قابلية توسع فورية، أداء عالي، وحماية متقدمة. ابدأ مع Pro Gineous.')

@section('meta_keywords', __('frontend.cloud_hosting_keywords') ?? 'استضافة سحابية, cloud hosting, استضافة موثوقة, استضافة قابلة للتوسع, موارد مخصصة, استضافة آمنة, Pro Gineous')

@push('meta')
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ __('frontend.cloud_hosting') }} - {{ config('app.name') }}">
    <meta property="og:description" content="{{ __('frontend.cloud_hosting_meta_desc') ?? 'استضافة سحابية قوية وموثوقة مع موارد مخصصة وقابلية توسع فورية' }}">
    <meta property="og:image" content="{{ asset('assets/cloud-hosting.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ __('frontend.cloud_hosting') }} - {{ config('app.name') }}">
    <meta property="twitter:description" content="{{ __('frontend.cloud_hosting_meta_desc') ?? 'استضافة سحابية قوية وموثوقة' }}">
    <meta property="twitter:image" content="{{ asset('assets/cloud-hosting.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- AOS Library CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    
    <!-- Custom Styles -->
    <style>
        [x-cloak] { display: none !important; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .animate-shimmer {
            animation: shimmer 3s infinite;
        }
    </style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 overflow-hidden min-h-[90vh] flex items-center">
    <!-- Background with Enhanced Gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(59,130,246,0.1),transparent_50%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_80%,rgba(168,85,247,0.1),transparent_50%)]"></div>
    </div>
    
    <!-- Animated Blobs - Enhanced -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 {{ app()->getLocale() == 'ar' ? 'left-10' : 'right-10' }} w-72 h-72 bg-gradient-to-br from-blue-400/30 to-cyan-500/30 rounded-full blur-3xl animate-blob"></div>
        <div class="absolute bottom-20 {{ app()->getLocale() == 'ar' ? 'right-10' : 'left-10' }} w-96 h-96 bg-gradient-to-tr from-purple-400/30 to-pink-500/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute top-40 left-1/2 transform -translate-x-1/2 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-blue-500/20 rounded-full blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <!-- Floating Icons -->
        <div class="absolute top-1/4 {{ app()->getLocale() == 'ar' ? 'right-[10%]' : 'left-[10%]' }} opacity-20 animate-float" style="animation-delay: 0s;">
            <svg class="w-16 h-16 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
            </svg>
        </div>
        <div class="absolute top-1/3 {{ app()->getLocale() == 'ar' ? 'left-[15%]' : 'right-[15%]' }} opacity-20 animate-float" style="animation-delay: 1s;">
            <svg class="w-12 h-12 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
        </div>
        <div class="absolute bottom-1/4 {{ app()->getLocale() == 'ar' ? 'right-[20%]' : 'left-[20%]' }} opacity-20 animate-float" style="animation-delay: 2s;">
            <svg class="w-14 h-14 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <!-- Left Content -->
            <div class="text-center lg:text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} space-y-8">
                <!-- Badge with Animation -->
                <div data-aos="fade-down" data-aos-delay="100">
                    <div class="inline-flex items-center px-5 py-2.5 rounded-full bg-gradient-to-r from-blue-100 to-purple-100 border border-blue-200/50 backdrop-blur-sm shadow-lg">
                        <span class="relative flex h-3 w-3 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                        </svg>
                        <span class="text-sm font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('frontend.cloud_hosting') }}
                        </span>
                    </div>
                </div>

                <!-- Main Heading -->
                <div data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-black text-gray-900 leading-tight mb-6">
                        <span class="block mb-2">{{ __('frontend.cloud_hosting_title') ?? 'استضافة سحابية' }}</span>
                        <span class="block bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent animate-gradient">
                            {{ __('frontend.powerful_reliable') ?? 'قوية وموثوقة' }}
                        </span>
                    </h1>
                </div>
                
                <!-- Subtitle -->
                <div data-aos="fade-up" data-aos-delay="300">
                    <p class="text-lg sm:text-xl lg:text-2xl text-gray-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ __('frontend.cloud_hosting_subtitle') ?? 'موارد مخصصة، قابلية توسع فورية، وأداء استثنائي لمواقعك وتطبيقاتك' }}
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div data-aos="fade-up" data-aos-delay="400" class="flex flex-col sm:flex-row items-center justify-center lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }} gap-4 pt-4">
                    <a href="#plans" class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-bold rounded-2xl overflow-hidden shadow-2xl hover:shadow-blue-500/50 transform hover:scale-105 transition-all duration-300 w-full sm:w-auto justify-center">
                        <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-700 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></span>
                        <span class="relative flex items-center">
                            {{ __('frontend.view_plans') ?? 'اعرض الباقات' }}
                            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="#features" class="group inline-flex items-center px-8 py-4 bg-white/80 backdrop-blur-sm text-gray-700 font-bold rounded-2xl border-2 border-gray-300 hover:border-blue-500 hover:bg-white shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 w-full sm:w-auto justify-center">
                        <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('frontend.learn_more') ?? 'اعرف المزيد' }}
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div data-aos="fade-up" data-aos-delay="500" class="flex flex-wrap items-center justify-center lg:justify-{{ app()->getLocale() == 'ar' ? 'end' : 'start' }} gap-6 pt-8">
                    <div class="flex items-center gap-3">
                        <div class="flex {{ app()->getLocale() == 'ar' ? 'space-x-reverse -space-x-2' : '-space-x-2' }}">
                            <img src="https://i.pravatar.cc/150?img=12" alt="Client" class="w-10 h-10 rounded-full border-2 border-white shadow-lg object-cover">
                            <img src="https://i.pravatar.cc/150?img=25" alt="Client" class="w-10 h-10 rounded-full border-2 border-white shadow-lg object-cover">
                            <img src="https://i.pravatar.cc/150?img=33" alt="Client" class="w-10 h-10 rounded-full border-2 border-white shadow-lg object-cover">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 border-2 border-white shadow-lg flex items-center justify-center">
                                <span class="text-white font-bold text-xs">+7K</span>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-600">{{ __('frontend.trusted_by_thousands') ?? '+10,000 عميل' }}</span>
                    </div>
                    <div class="flex items-center space-x-1 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-sm font-semibold text-gray-600 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">4.9/5</span>
                    </div>
                </div>
            </div>

            <!-- Right Illustration -->
            <div class="relative hidden lg:block" data-aos="fade-left" data-aos-delay="300">
                <div class="relative">
                    <!-- Main Server Illustration -->
                    <div class="relative z-10">
                        <!-- Cloud Servers Stack -->
                        <div class="space-y-4">
                            <!-- Server 1 -->
                            <div class="group relative bg-gradient-to-br from-white to-blue-50 rounded-2xl p-6 shadow-2xl hover:shadow-blue-500/30 transition-all duration-500 transform hover:-translate-y-2 border border-blue-100">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ __('frontend.server') ?? 'Server' }} US-EAST-1</p>
                                            <p class="text-xs text-gray-500">{{ __('frontend.active') ?? 'Active' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">CPU</span>
                                        <span class="font-semibold text-gray-900">45%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full animate-pulse" style="width: 45%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">RAM</span>
                                        <span class="font-semibold text-gray-900">62%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-2 rounded-full animate-pulse" style="width: 62%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Server 2 -->
                            <div class="group relative bg-gradient-to-br from-white to-purple-50 rounded-2xl p-6 shadow-2xl hover:shadow-purple-500/30 transition-all duration-500 transform hover:-translate-y-2 border border-purple-100 {{ app()->getLocale() == 'ar' ? 'mr-8' : 'ml-8' }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ __('frontend.server') ?? 'Server' }} EU-WEST-1</p>
                                            <p class="text-xs text-gray-500">{{ __('frontend.active') ?? 'Active' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">CPU</span>
                                        <span class="font-semibold text-gray-900">38%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-2 rounded-full animate-pulse" style="width: 38%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">RAM</span>
                                        <span class="font-semibold text-gray-900">51%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 h-2 rounded-full animate-pulse" style="width: 51%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Server 3 -->
                            <div class="group relative bg-gradient-to-br from-white to-cyan-50 rounded-2xl p-6 shadow-2xl hover:shadow-cyan-500/30 transition-all duration-500 transform hover:-translate-y-2 border border-cyan-100 {{ app()->getLocale() == 'ar' ? 'mr-16' : 'ml-16' }}">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                                <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                                <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ __('frontend.server') ?? 'Server' }} ASIA-1</p>
                                            <p class="text-xs text-gray-500">{{ __('frontend.active') ?? 'Active' }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <span class="relative flex h-3 w-3">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">CPU</span>
                                        <span class="font-semibold text-gray-900">29%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-cyan-500 to-blue-600 h-2 rounded-full animate-pulse" style="width: 29%"></div>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-gray-600">RAM</span>
                                        <span class="font-semibold text-gray-900">44%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-2 rounded-full animate-pulse" style="width: 44%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Stats Cards -->
                        <div class="absolute -top-8 -{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}-8 bg-white rounded-2xl p-4 shadow-2xl border border-gray-100 animate-float">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">{{ __('frontend.uptime') ?? 'Uptime' }}</p>
                                    <p class="text-lg font-bold text-gray-900">99.99%</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-6 -{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}-6 bg-white rounded-2xl p-4 shadow-2xl border border-gray-100 animate-float" style="animation-delay: 1s;">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-orange-400 to-red-500 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">{{ __('frontend.speed') ?? 'Speed' }}</p>
                                    <p class="text-lg font-bold text-gray-900">2.3ms</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="relative py-20 lg:py-28 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-b from-white via-blue-50/30 to-white"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_70%_20%,rgba(59,130,246,0.08),transparent_50%)]"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_80%,rgba(168,85,247,0.08),transparent_50%)]"></div>

    <!-- Decorative Blobs -->
    <div class="absolute top-20 right-0 w-64 h-64 bg-blue-200/20 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-0 w-64 h-64 bg-purple-200/20 rounded-full blur-3xl"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 lg:mb-20">
            <!-- Badge -->
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 border border-blue-200 mb-6">
                <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-sm font-bold text-blue-700">{{ __('frontend.features') ?? 'المميزات' }}</span>
            </div>

            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-gray-900 mb-6">
                {{ __('frontend.cloud_hosting_features') ?? 'مميزات الاستضافة السحابية' }}
            </h2>
            <p class="text-lg lg:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ __('frontend.cloud_hosting_features_desc') ?? 'تقنيات متقدمة وأداء استثنائي لضمان نجاح مشروعك الرقمي' }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Feature 1 - High Performance -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-blue-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <!-- Icon Container -->
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-blue-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <!-- Decorative Element -->
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">
                        {{ __('frontend.high_performance') ?? 'أداء فائق' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.high_performance_desc') ?? 'سرعة تحميل استثنائية مع تقنيات SSD وذاكرة تخزين مؤقت متقدمة' }}
                    </p>
                    
                    <!-- Feature List -->
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.nvme_ssd_storage') ?? 'تخزين NVMe SSD' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.litespeed_cache') ?? 'كاش LiteSpeed' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 2 - Scalable Resources -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-purple-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-purple-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-purple-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-purple-600 transition-colors">
                        {{ __('frontend.scalable_resources') ?? 'موارد قابلة للتوسع' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.scalable_resources_desc') ?? 'زد موارد الخادم بنقرة واحدة دون أي توقف للخدمة' }}
                    </p>
                    
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.instant_scaling') ?? 'توسع فوري' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.zero_downtime') ?? 'بدون توقف' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 3 - Advanced Security -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute inset-0 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-cyan-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-cyan-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-cyan-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-cyan-600 transition-colors">
                        {{ __('frontend.advanced_security') ?? 'حماية متقدمة' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.advanced_security_desc') ?? 'جدران نار متطورة، حماية من DDoS، وشهادات SSL مجانية' }}
                    </p>
                    
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.ddos_protection') ?? 'حماية من DDoS' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.free_ssl_certificate') ?? 'شهادة SSL مجانية' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 4 - Uptime Guarantee -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-green-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-green-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors">
                        {{ __('frontend.uptime_guarantee') ?? 'ضمان وقت التشغيل' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.uptime_guarantee_desc') ?? 'ضمان 99.9% لوقت التشغيل مع مراقبة على مدار الساعة' }}
                    </p>
                    
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.uptime_sla') ?? 'ضمان 99.99%' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.monitoring_247') ?? 'مراقبة 24/7' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 5 - Auto Backup -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute inset-0 bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-orange-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-orange-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-orange-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-orange-600 transition-colors">
                        {{ __('frontend.auto_backup') ?? 'نسخ احتياطي تلقائي' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.auto_backup_desc') ?? 'نسخ احتياطية يومية تلقائية مع استرجاع سهل وسريع' }}
                    </p>
                    
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.daily_backups') ?? 'نسخ احتياطي يومي' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.one_click_restore') ?? 'استرجاع بنقرة واحدة' }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Feature 6 - 24/7 Support -->
            <div class="group relative" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl opacity-0 group-hover:opacity-10 transition-opacity duration-500"></div>
                <div class="relative h-full p-8 bg-white rounded-3xl border-2 border-gray-100 hover:border-indigo-200 shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-indigo-500 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity"></div>
                        <div class="relative w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                            <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-200 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    
                    <h3 class="text-xl lg:text-2xl font-bold text-gray-900 mb-3 group-hover:text-indigo-600 transition-colors">
                        {{ __('frontend.24_7_support') ?? 'دعم فني 24/7' }}
                    </h3>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ __('frontend.24_7_support_desc') ?? 'فريق دعم متخصص متاح على مدار الساعة لمساعدتك' }}
                    </p>
                    
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.live_chat_support') ?? 'دعم فوري' }}
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('frontend.expert_team') ?? 'فريق خبراء' }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Plans Section -->
<section id="plans" class="py-20 bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                {{ __('frontend.choose_your_plan') ?? 'اختر الباقة المناسبة' }}
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ __('frontend.cloud_plans_desc') ?? 'باقات متنوعة تناسب جميع الاحتياجات مع أفضل الأسعار' }}
            </p>
        </div>

        @if($plans && $plans->count() > 0)
            <div x-data="{ cycle: 'monthly', open: false }">
                <!-- Billing Cycle Dropdown -->
                <div class="flex justify-center mb-12">
                    <div class="relative inline-block w-full max-w-md">
                        <button @click="open = !open" type="button"
                            class="relative w-full cursor-pointer rounded-xl bg-white py-4 px-6 {{ app()->getLocale() == 'ar' ? 'pr-10 text-right' : 'pl-10 text-left' }} shadow-lg border-2 border-blue-100 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                            <span class="flex items-center justify-between">
                                <span class="flex items-center gap-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="block truncate font-bold text-gray-900" x-text="
                                        cycle === 'monthly' ? '{{ __('frontend.monthly') ?? 'شهري' }}' :
                                        cycle === 'quarterly' ? '{{ __('frontend.quarterly') ?? 'ربع سنوي' }}' :
                                        cycle === 'semiannually' ? '{{ __('frontend.semiannually') ?? 'نصف سنوي' }}' :
                                        cycle === 'annually' ? '{{ __('frontend.annually') ?? 'سنوي' }}' :
                                        cycle === 'biennially' ? '{{ __('frontend.biennially') ?? 'سنتين' }}' :
                                        cycle === 'triennially' ? '{{ __('frontend.triennially') ?? '3 سنوات' }}' : '{{ __('frontend.monthly') ?? 'شهري' }}'
                                    "></span>
                                </span>
                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute z-50 mt-2 w-full origin-top rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none" x-cloak>
                            <div class="py-2">
                                <button @click="cycle = 'monthly'; open = false" :class="cycle === 'monthly' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span>{{ __('frontend.monthly') ?? 'شهري' }}</span>
                                    <svg x-show="cycle === 'monthly'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                                <button @click="cycle = 'quarterly'; open = false" :class="cycle === 'quarterly' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span>{{ __('frontend.quarterly') ?? 'ربع سنوي' }}</span>
                                    <svg x-show="cycle === 'quarterly'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                                <button @click="cycle = 'semiannually'; open = false" :class="cycle === 'semiannually' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span>{{ __('frontend.semiannually') ?? 'نصف سنوي' }}</span>
                                    <svg x-show="cycle === 'semiannually'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                                <button @click="cycle = 'annually'; open = false" :class="cycle === 'annually' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span class="flex items-center gap-2">
                                        {{ __('frontend.annually') ?? 'سنوي' }}
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ __('frontend.save_20') ?? 'وفر 20%' }}</span>
                                    </span>
                                    <svg x-show="cycle === 'annually'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                                <button @click="cycle = 'biennially'; open = false" :class="cycle === 'biennially' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span class="flex items-center gap-2">
                                        {{ __('frontend.biennially') ?? 'سنتين' }}
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ __('frontend.save_30') ?? 'وفر 30%' }}</span>
                                    </span>
                                    <svg x-show="cycle === 'biennially'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                                <button @click="cycle = 'triennially'; open = false" :class="cycle === 'triennially' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                    class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-6 py-3 text-base transition-colors duration-150 flex items-center justify-between group">
                                    <span class="flex items-center gap-2">
                                        {{ __('frontend.triennially') ?? '3 سنوات' }}
                                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ __('frontend.save_40') ?? 'وفر 40%' }}</span>
                                    </span>
                                    <svg x-show="cycle === 'triennially'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plans Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($plans as $index => $plan)
                    @php
                        $pricing = is_array($plan->pricing) ? $plan->pricing : [];
                        $features = app()->getLocale() == 'ar' 
                            ? (is_array($plan->features_list_ar) ? $plan->features_list_ar : [])
                            : (is_array($plan->features_list) ? $plan->features_list : []);
                        
                        // Extract recurring prices
                        $monthlyPrice = $pricing['recurring']['monthly']['price'] ?? 0;
                        $quarterlyPrice = $pricing['recurring']['quarterly']['price'] ?? 0;
                        $semiannuallyPrice = $pricing['recurring']['semi_annually']['price'] ?? 0;
                        $annuallyPrice = $pricing['recurring']['annually']['price'] ?? 0;
                        $bienniallyPrice = $pricing['recurring']['biennially']['price'] ?? 0;
                        $trienniallyPrice = $pricing['recurring']['triennially']['price'] ?? 0;
                        
                        // Get datacenter locations and prices
                        $datacenterLocations = is_array($plan->datacenter_locations) ? $plan->datacenter_locations : [];
                        $datacenterPrices = is_array($plan->datacenter_price) ? $plan->datacenter_price : [];
                        
                        // Datacenter names mapping
                        $datacenterNames = [
                            'us-east' => __('frontend.datacenter_us_east') ?? 'الولايات المتحدة الشرقية',
                            'us-west' => __('frontend.datacenter_us_west') ?? 'الولايات المتحدة الغربية',
                            'eu-west' => __('frontend.datacenter_eu_west') ?? 'أوروبا الغربية',
                            'canada' => __('frontend.datacenter_canada') ?? 'كندا',
                            'uae' => __('frontend.datacenter_uae') ?? 'الإمارات',
                            'egypt' => __('frontend.datacenter_egypt') ?? 'مصر',
                        ];
                        
                        // Get free domain configuration
                        $freeDomainConfig = is_array($plan->free_domain_config) ? $plan->free_domain_config : (is_string($plan->free_domain_config) ? json_decode($plan->free_domain_config, true) : null);
                    @endphp
                    
                    <div class="relative group" data-aos="fade-up" data-aos-delay="{{ ($index + 1) * 100 }}" x-data="{ 
                        datacenter: '{{ $datacenterLocations[0] ?? '' }}', 
                        datacenterOpen: false,
                        datacenterPrice: {{ $datacenterPrices[$datacenterLocations[0] ?? ''] ?? 0 }},
                        monthlyPrice: {{ $monthlyPrice }},
                        quarterlyPrice: {{ $quarterlyPrice }},
                        semiannuallyPrice: {{ $semiannuallyPrice }},
                        annuallyPrice: {{ $annuallyPrice }},
                        bienniallyPrice: {{ $bienniallyPrice }},
                        trienniallyPrice: {{ $trienniallyPrice }}
                    }">
                        @if($plan->is_featured)
                            <!-- Popular Badge -->
                            <div class="absolute -top-5 left-1/2 transform -translate-x-1/2 z-10">
                                <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg">
                                    {{ __('frontend.most_popular') ?? 'الأكثر شعبية' }}
                                </div>
                            </div>
                        @endif

                        <!-- Plan Card -->
                        <div class="relative h-full bg-white rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border-2 {{ $plan->is_featured ? 'border-blue-500' : 'border-gray-200' }} overflow-hidden">
                            <!-- Gradient Overlay for Featured -->
                            @if($plan->is_featured)
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-50 to-purple-50 opacity-50"></div>
                            @endif

                            <div class="relative p-8">
                                <!-- Plan Header -->
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-black text-gray-900 mb-2">
                                        {{ $plan->name }}
                                    </h3>
                                    @if($plan->tagline)
                                    <p class="text-gray-600 text-sm">
                                        {{ $plan->tagline }}
                                    </p>
                                    @endif
                                </div>

                                <!-- Free Domain Badge (if exists) -->
                                @if($freeDomainConfig && isset($freeDomainConfig['type']) && in_array($freeDomainConfig['type'], ['reg_transfer', 'first_year']))
                                <div class="text-center mb-6">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-emerald-50 to-green-50 rounded-full border border-emerald-200">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                        </svg>
                                        <span class="text-xs font-bold text-emerald-700">
                                            {{ __('frontend.free_domain') ?? 'نطاق مجاني' }}
                                            @if(isset($freeDomainConfig['terms']) && in_array('annually', $freeDomainConfig['terms']))
                                                <span class="text-[10px] opacity-80">({{ __('frontend.first_year') ?? 'السنة الأولى' }})</span>
                                            @endif
                                        </span>
                                    </div>
                                    
                                    <!-- Free Domain TLDs -->
                                    @if(isset($freeDomainConfig['tlds']) && is_array($freeDomainConfig['tlds']) && count($freeDomainConfig['tlds']) > 0)
                                        <div class="mt-3 flex flex-wrap items-center justify-center gap-2">
                                            @foreach($freeDomainConfig['tlds'] as $tld)
                                                <span class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold bg-white text-slate-700 rounded-lg border border-slate-200 shadow-sm">
                                                    <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    .{{ strtolower($tld) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Pricing -->
                                <div class="text-center mb-8">
                                    <!-- Monthly Price -->
                                    <div x-show="cycle === 'monthly'" x-transition>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(monthlyPrice + (datacenterPrice * 1)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_month') ?? 'شهرياً' }}</p>
                                    </div>

                                    <!-- Quarterly Price -->
                                    <div x-show="cycle === 'quarterly'" x-transition x-cloak>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(quarterlyPrice + (datacenterPrice * 3)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_3_months') ?? 'كل 3 أشهر' }}</p>
                                    </div>

                                    <!-- Semiannually Price -->
                                    <div x-show="cycle === 'semiannually'" x-transition x-cloak>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(semiannuallyPrice + (datacenterPrice * 6)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_6_months') ?? 'كل 6 أشهر' }}</p>
                                    </div>

                                    <!-- Annually Price -->
                                    <div x-show="cycle === 'annually'" x-transition x-cloak>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(annuallyPrice + (datacenterPrice * 12)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_year') ?? 'سنوياً' }}</p>
                                    </div>

                                    <!-- Biennially Price -->
                                    <div x-show="cycle === 'biennially'" x-transition x-cloak>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(bienniallyPrice + (datacenterPrice * 24)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_2_years') ?? 'كل سنتين' }}</p>
                                    </div>

                                    <!-- Triennially Price -->
                                    <div x-show="cycle === 'triennially'" x-transition x-cloak>
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-5xl font-black text-gray-900">$<span x-text="(trienniallyPrice + (datacenterPrice * 36)).toFixed(2)"></span></span>
                                        </div>
                                        <p class="text-gray-500 mt-2">{{ __('frontend.per_3_years') ?? 'كل 3 سنوات' }}</p>
                                    </div>
                                </div>

                                <!-- Datacenter Selection -->
                                @if(count($datacenterLocations) > 0)
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                                        <svg class="w-5 h-5 inline {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }} text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ __('frontend.select_datacenter') ?? 'اختر مركز البيانات' }}
                                    </label>
                                    <p class="text-xs text-gray-500 mb-3 {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }}">
                                        {{ app()->getLocale() == 'ar' ? '* السعر الإضافي شهري' : '* Additional price is monthly' }}
                                    </p>
                                    <div class="relative">
                                        <button @click="datacenterOpen = !datacenterOpen" type="button"
                                            class="relative w-full cursor-pointer rounded-xl bg-gray-50 py-3 px-4 {{ app()->getLocale() == 'ar' ? 'pr-10 text-right' : 'pl-10 text-left' }} border-2 border-gray-200 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                                            <span class="flex items-center justify-between">
                                                <span class="block truncate text-gray-900 font-medium">
                                                    <span x-text="
                                                        @foreach($datacenterLocations as $loc)
                                                            datacenter === '{{ $loc }}' ? '{{ $datacenterNames[$loc] ?? $loc }}' :
                                                        @endforeach
                                                        '{{ $datacenterNames[$datacenterLocations[0] ?? ''] ?? '' }}'
                                                    "></span>
                                                    <span x-show="datacenterPrice > 0" class="text-green-600 font-bold text-sm {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}">
                                                        +$<span x-text="datacenterPrice.toFixed(2)"></span>{{ app()->getLocale() == 'ar' ? '/شهر' : '/mo' }}
                                                    </span>
                                                </span>
                                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-300" :class="datacenterOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </span>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div x-show="datacenterOpen" @click.away="datacenterOpen = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-50 mt-2 w-full origin-top rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none max-h-60 overflow-auto" x-cloak>
                                            <div class="py-2">
                                                @foreach($datacenterLocations as $location)
                                                    <button @click="datacenter = '{{ $location }}'; datacenterPrice = {{ $datacenterPrices[$location] ?? 0 }}; datacenterOpen = false" 
                                                        :class="datacenter === '{{ $location }}' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                                        class="w-full {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} px-4 py-3 text-sm transition-colors duration-150 flex items-center justify-between group">
                                                        <span class="flex items-center gap-2">
                                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            </svg>
                                                            <span>{{ $datacenterNames[$location] ?? $location }}</span>
                                                            @if(($datacenterPrices[$location] ?? 0) > 0)
                                                                <span class="text-green-600 font-semibold text-xs">
                                                                    +${{ number_format($datacenterPrices[$location], 2) }}{{ app()->getLocale() == 'ar' ? '/شهر' : '/mo' }}
                                                                </span>
                                                            @else
                                                                <span class="text-gray-500 text-xs">({{ __('frontend.free') ?? 'مجاني' }})</span>
                                                            @endif
                                                        </span>
                                                        <svg x-show="datacenter === '{{ $location }}'" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- CTA Button -->
                                <a href="{{ route('products.show', $plan->id) }}" class="block w-full text-center px-8 py-4 {{ $plan->is_featured ? 'bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700' : 'bg-gray-900 hover:bg-gray-800' }} text-white font-bold rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl mb-8">
                                    {{ __('frontend.order_now') ?? 'اطلب الآن' }}
                                </a>

                                <!-- Features List -->
                                @if(is_array($features) && count($features) > 0)
                                    <div class="space-y-4">
                                        <h4 class="font-bold text-gray-900 text-sm uppercase tracking-wider mb-4">
                                            {{ __('frontend.plan_includes') ?? 'تشمل الباقة' }}
                                        </h4>
                                        <ul class="space-y-3">
                                            @foreach($features as $feature)
                                                <li class="flex items-start">
                                                    <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }} text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="text-gray-700 text-sm leading-relaxed">{{ $feature }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        @else
            <!-- No Plans Available -->
            <div class="text-center py-20">
                <div class="inline-flex items-center px-6 py-3 bg-blue-100 text-blue-700 rounded-full mb-4">
                    <svg class="w-6 h-6 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    {{ __('frontend.coming_soon') ?? 'قريباً' }}
                </div>
                <p class="text-gray-600 text-lg">
                    {{ __('frontend.cloud_plans_coming_soon') ?? 'باقات الاستضافة السحابية ستكون متاحة قريباً' }}
                </p>
            </div>
        @endif
    </div>
</section>

<!-- Trust & Security Features Section -->
<section class="py-20 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Feature 1: Secured by Fortiguard Labs -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-32" data-aos="fade-up">
            <!-- Content -->
            <div class="{{ app()->getLocale() == 'ar' ? 'lg:order-2' : '' }}">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    {{ app()->getLocale() == 'ar' ? 'آمن بواسطة Fortiguard Labs' : 'Secured by Fortiguard Labs' }}
                </h2>
                <p class="text-lg text-gray-600 mb-4 leading-relaxed">
                    {{ app()->getLocale() == 'ar' 
                        ? 'تقدم استضافتنا السحابية عالية التوافر ضماناً لوقت تشغيل الشبكة بنسبة 100%، مما يضمن أن موقعك الإلكتروني وتطبيقاتك الحيوية دائماً متصلة ومتاحة لمستخدميك.'
                        : 'Our high-availability cloud hosting delivers an unmatched 100% network uptime guarantee, ensuring your website and mission-critical applications are always online and accessible to your users.' }}
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar'
                        ? 'مع أمان قوي مدعوم بواسطة Pro Gineous Labs وأداء محسّن، حلنا مثالي للشركات التي تتطلب موثوقية ومرونة.'
                        : 'With robust security powered by Pro Gineous Labs and optimized performance, our solution is ideal for businesses that demand reliability and resilience.' }}
                </p>
            </div>
            
            <!-- Interactive Animation -->
            <div class="{{ app()->getLocale() == 'ar' ? 'lg:order-1' : '' }}" data-aos="fade-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}" data-aos-delay="200">
                <div class="relative p-12">
                    <!-- Animated Shield -->
                    <div class="relative w-full aspect-square max-w-sm mx-auto">
                        <!-- Pulsing Circles -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="absolute w-64 h-64 bg-blue-500 rounded-full opacity-20 animate-ping"></div>
                            <div class="absolute w-56 h-56 bg-purple-500 rounded-full opacity-20 animate-ping" style="animation-delay: 0.5s"></div>
                            <div class="absolute w-48 h-48 bg-blue-600 rounded-full opacity-30 animate-pulse"></div>
                        </div>
                        
                        <!-- Main Shield -->
                        <div class="relative z-10 flex items-center justify-center h-full">
                            <div class="relative group">
                                <!-- Shield Background -->
                                <svg class="w-48 h-48 drop-shadow-2xl transform transition-transform duration-500 group-hover:scale-110" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2L3 7V11C3 16.55 6.84 21.74 12 23C17.16 21.74 21 16.55 21 11V7L12 2Z" fill="url(#shieldGradient)" stroke="#3B82F6" stroke-width="0.5"/>
                                    <defs>
                                        <linearGradient id="shieldGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                
                                <!-- Check Mark -->
                                <svg class="absolute inset-0 w-24 h-24 m-auto text-white animate-bounce" style="animation-duration: 2s" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                
                                <!-- Lock Icon -->
                                <div class="absolute -top-4 -right-4 bg-yellow-400 rounded-full p-3 shadow-lg animate-pulse">
                                    <svg class="w-6 h-6 text-gray-900" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Floating Icons -->
                        <div class="absolute top-8 left-8 bg-green-500 rounded-lg p-2 shadow-lg animate-float">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        
                        <div class="absolute bottom-8 right-8 bg-blue-500 rounded-lg p-2 shadow-lg animate-float" style="animation-delay: 1s">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feature 2: 100% Uptime SLA -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-32" data-aos="fade-up">
            <!-- Interactive Animation -->
            <div data-aos="fade-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}" data-aos-delay="200">
                <div class="relative h-96 flex items-center justify-center">
                    <!-- Animated Server Stack -->
                    <div class="relative">
                        <!-- Server 1 -->
                        <div class="relative mb-4">
                            <div class="w-48 h-16 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-1/2 left-6 -translate-y-1/2 flex gap-2">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                                </div>
                                <div class="absolute top-1/2 right-6 -translate-y-1/2 text-white font-bold text-sm">99.9%</div>
                            </div>
                        </div>

                        <!-- Server 2 -->
                        <div class="relative mb-4">
                            <div class="w-48 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" style="animation-delay: 0.3s">
                                <div class="absolute top-1/2 left-6 -translate-y-1/2 flex gap-2">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.1s"></div>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.3s"></div>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.5s"></div>
                                </div>
                                <div class="absolute top-1/2 right-6 -translate-y-1/2 text-white font-bold text-sm">100%</div>
                            </div>
                        </div>

                        <!-- Server 3 -->
                        <div class="relative">
                            <div class="w-48 h-16 bg-gradient-to-r from-indigo-600 to-blue-700 rounded-lg shadow-lg transform hover:scale-105 transition-transform duration-300" style="animation-delay: 0.6s">
                                <div class="absolute top-1/2 left-6 -translate-y-1/2 flex gap-2">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.4s"></div>
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.6s"></div>
                                </div>
                                <div class="absolute top-1/2 right-6 -translate-y-1/2 text-white font-bold text-sm">100%</div>
                            </div>
                        </div>

                        <!-- Uptime Badge -->
                        <div class="absolute -top-8 -right-8 w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-2xl animate-bounce" style="animation-duration: 3s;">
                            <div class="text-center">
                                <div class="text-2xl font-black text-white">100%</div>
                                <div class="text-xs font-bold text-white">Uptime</div>
                            </div>
                        </div>

                        <!-- Connection Lines -->
                        <div class="absolute -right-16 top-1/2 -translate-y-1/2">
                            <div class="w-16 h-0.5 bg-gradient-to-r from-blue-500 to-transparent animate-pulse"></div>
                        </div>
                    </div>

                    <!-- Status Monitor -->
                    <div class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-white px-6 py-3 rounded-full shadow-lg border-2 border-green-400">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-bold text-gray-700">All Systems Operational</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    {{ app()->getLocale() == 'ar' ? 'اتفاقية مستوى الخدمة 100% Uptime' : '100% Uptime SLA' }}
                </h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    {{ app()->getLocale() == 'ar'
                        ? 'تقدم استضافتنا السحابية موثوقية لا مثيل لها، مما يضمن أن موقعك الإلكتروني دائماً متاح لعملائك وزوارك. ركز على عملك، وليس على خادمك.'
                        : 'Our cloud hosting delivers unparalleled reliability, ensuring your website is always accessible to your customers and clients. Focus on your business, not your server.' }}
                </p>
            </div>
        </div>

        <!-- Feature 3: Built For Your Success -->
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center" data-aos="fade-up">
            <!-- Content -->
            <div class="{{ app()->getLocale() == 'ar' ? 'lg:order-2' : '' }}">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    {{ app()->getLocale() == 'ar' ? 'مصمم لنجاحك' : 'Built For Your Success' }}
                </h2>
                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                    {{ app()->getLocale() == 'ar'
                        ? 'تقدم استضافتنا السحابية موثوقية لا مثيل لها، مما يضمن أن موقعك الإلكتروني دائماً متاح لعملائك وزوارك. ركز على عملك، وليس على خادمك.'
                        : 'Our cloud hosting delivers unparalleled reliability, ensuring your website is always accessible to your customers and clients. Focus on your business, not your server.' }}
                </p>
            </div>
            
            <!-- Interactive Animation -->
            <div class="{{ app()->getLocale() == 'ar' ? 'lg:order-1' : '' }}" data-aos="fade-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}" data-aos-delay="200">
                <div class="relative h-96 flex items-center justify-center">
                    <!-- Team Members Circle -->
                    <div class="relative">
                        <!-- Center Support Hub -->
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center shadow-2xl animate-pulse" style="animation-duration: 2s;">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3m8.293 8.293l1.414 1.414"></path>
                            </svg>
                        </div>

                        <!-- User Avatar 1 (Top) -->
                        <div class="absolute -top-12 left-1/2 -translate-x-1/2 w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full shadow-lg flex items-center justify-center animate-float">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- User Avatar 2 (Right) -->
                        <div class="absolute top-1/2 -right-12 -translate-y-1/2 w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full shadow-lg flex items-center justify-center animate-float" style="animation-delay: 0.3s;">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- User Avatar 3 (Bottom) -->
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-600 rounded-full shadow-lg flex items-center justify-center animate-float" style="animation-delay: 0.6s;">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- User Avatar 4 (Left) -->
                        <div class="absolute top-1/2 -left-12 -translate-y-1/2 w-16 h-16 bg-gradient-to-br from-pink-400 to-purple-600 rounded-full shadow-lg flex items-center justify-center animate-float" style="animation-delay: 0.9s;">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <!-- Connection Lines -->
                        <svg class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 -z-10" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="35" fill="none" stroke="#E0E7FF" stroke-width="0.5" stroke-dasharray="2,2" class="animate-spin" style="animation-duration: 20s;"></circle>
                            <circle cx="50" cy="50" r="45" fill="none" stroke="#DDD6FE" stroke-width="0.5" stroke-dasharray="2,2" class="animate-spin" style="animation-duration: 30s; animation-direction: reverse;"></circle>
                        </svg>

                        <!-- Success Badge -->
                        <div class="absolute -top-8 -right-8 bg-gradient-to-br from-green-400 to-emerald-500 px-4 py-2 rounded-full shadow-lg animate-bounce" style="animation-duration: 3s;">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-bold text-white">24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>

<!-- Comparison Table Section -->
<section class="py-20 bg-white" x-data="{ showAll: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                {{ app()->getLocale() == 'ar' ? 'قارن بين خطط الاستضافة السحابية' : 'Compare Cloud Hosting Plans' }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ app()->getLocale() == 'ar' ? 'اختر الخطة المثالية لاحتياجاتك - جميع الميزات والمواصفات في مكان واحد' : 'Choose the perfect plan for your needs - all features and specifications in one place' }}
            </p>
        </div>

        <!-- Comparison Table -->
        <div class="overflow-x-auto" data-aos="fade-up" data-aos-delay="200">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden border border-gray-200 rounded-2xl shadow-xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-purple-600">
                            <tr>
                                <th scope="col" class="px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-sm font-bold text-white uppercase tracking-wider">
                                    {{ app()->getLocale() == 'ar' ? 'مميزات الخطة' : 'All Plan Features' }}
                                </th>
                                @foreach($plans as $plan)
                                <th scope="col" class="px-6 py-5 text-center">
                                    <div class="text-white">
                                        <div class="text-xl font-black mb-2">{{ $plan->name }}</div>
                                        <div class="text-3xl font-black mb-3">
                                            ${{ number_format($plan->pricing['recurring']['annually']['price'] ?? 0, 2) }}
                                            <span class="text-sm font-normal">/{{ __('frontend.year') ?? 'سنة' }}</span>
                                        </div>
                                        <a href="{{ route('products.show', $plan->id) }}" class="inline-block px-6 py-2 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                                            {{ app()->getLocale() == 'ar' ? 'اطلب الآن' : 'Order Now' }}
                                        </a>
                                    </div>
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $features = [
                                    ['name' => app()->getLocale() == 'ar' ? 'النطاقات المستضافة' : 'Hosted Domains', 'values' => ['5', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'الذاكرة (RAM)' : 'Memory (RAM)', 'values' => ['4GB', '8GB', '12GB']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تخزين NVME' : 'NVME Storage', 'values' => ['30GB', '40GB', '60GB']],
                                    ['name' => app()->getLocale() == 'ar' ? 'معالج - Gen 13' : 'CPU Cores - Gen 13', 'values' => ['2 Cores', '4 Cores', '8 Cores']],
                                    ['name' => app()->getLocale() == 'ar' ? 'النطاق الترددي' : 'Bandwidth', 'values' => ['Unmetered', 'Unmetered', 'Unmetered']],
                                    ['name' => app()->getLocale() == 'ar' ? 'النطاقات المتوقفة' : 'Parked Domains', 'values' => ['Unlimited', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تسجيل نطاق مجاني' : 'Free Domain Registration', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'النطاقات الفرعية' : 'Subdomains', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'شهادة SSL مجانية' : 'Free SSL Certificate', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تكامل Cloudflare' : 'Cloudflare Integration', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مدير الذاكرة المؤقتة' : 'Cache Manager', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تثبيت التطبيقات بنقرة واحدة' : '1-Click App Installer', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'نسخ احتياطي يومي' : 'Daily Backups', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'لوحة التحكم cPanel' : 'cPanel (Control Panel)', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'ضمان 99.9% Uptime' : '99.9% Uptime Guarantee', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'IP مخصص' : 'Dedicated IP', 'values' => ['$4.00/mo', '$4.00/mo', '$4.00/mo']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مستخدمي FTP' : 'FTP Users', 'values' => ['50', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'ضمان استرداد الأموال' : 'Money-Back Guarantee', 'values' => ['30 days', '30 days', '30 days']],
                                    ['name' => app()->getLocale() == 'ar' ? 'Name Servers شخصية' : 'Personal Nameservers', 'values' => ['x', 'x', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'حسابات البريد الإلكتروني' : 'Email Accounts', 'values' => ['50', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'BoxTrapper' : 'BoxTrapper', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'قواعد بيانات MySQL' : 'MySQL Databases', 'values' => ['50', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'قواعد بيانات PostgreSQL' : 'PostgreSQL Databases', 'values' => ['x', 'Unlimited', 'Unlimited']],
                                    ['name' => app()->getLocale() == 'ar' ? 'PHP PgAdmin' : 'PHP PgAdmin', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'خادم الويب' : 'Webserver', 'values' => ['Cloudlinux/Litespeed', 'Cloudlinux/Litespeed', 'Cloudlinux/Litespeed']],
                                    ['name' => 'PHP 5.X - 8.X', 'values' => ['check', 'check', 'check']],
                                    ['name' => 'Node.JS 6.X - 14.X', 'values' => ['check', 'check', 'check']],
                                    ['name' => 'Python 2.X - 3.X', 'values' => ['check', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'وصول SSH' : 'SSH Access (Jailed)', 'values' => ['check', 'check', 'check']],
                                    ['name' => 'eAccelerator', 'values' => ['x', 'x', 'check']],
                                    ['name' => 'xCache', 'values' => ['x', 'x', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مدير الصور' : 'Image Manager', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مدير حظر IP' : 'IP Deny Manager', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مدير MIME Types' : 'MIME Types Manager', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'أدوات الشبكة' : 'Network Tools', 'values' => ['x', 'check', 'check']],
                                    ['name' => 'PGP/GPG', 'values' => ['x', 'check', 'check']],
                                    ['name' => 'Simple CGI Wrapper', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تثبيت وحدات Perl' : 'Install Perl Modules', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'تثبيت Ruby Gems' : 'Install Ruby Gems', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'مساعدة النقل' : 'Transfer Assistance', 'values' => ['x', 'check', 'check']],
                                    ['name' => app()->getLocale() == 'ar' ? 'دعم فني 24/7' : '24/7 Live Chat', 'values' => ['check', 'check', 'check']],
                                ];
                            @endphp

                            @foreach($features as $index => $feature)
                            <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition-colors" 
                                x-show="showAll || {{ $index }} < 10"
                                x-transition>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                    {{ $feature['name'] }}
                                </td>
                                @foreach($feature['values'] as $value)
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($value === 'check')
                                        <svg class="w-6 h-6 text-green-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif($value === 'x')
                                        <svg class="w-6 h-6 text-red-500 mx-auto" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <span class="text-sm font-bold text-gray-900">{{ $value }}</span>
                                    @endif
                                </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- View All Features Button -->
        <div class="text-center mt-12" data-aos="fade-up" data-aos-delay="300">
            <button @click="showAll = !showAll" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                <span x-text="showAll ? '{{ app()->getLocale() == 'ar' ? 'إخفاء الميزات' : 'Hide Features' }}' : '{{ app()->getLocale() == 'ar' ? 'عرض جميع الميزات' : 'View All Features' }}'"></span>
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }} transition-transform duration-300" 
                     :class="{ 'rotate-180': showAll }" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                {{ app()->getLocale() == 'ar' ? 'لماذا تختار برو جينيوس للاستضافة السحابية؟' : 'Why Choose Pro Gineous For Your Cloud Hosting?' }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ app()->getLocale() == 'ar' ? 'نقدم لك أفضل الحلول السحابية مع أحدث التقنيات وأعلى معايير الأداء والأمان' : 'We provide you with the best cloud solutions with the latest technologies and highest performance and security standards' }}
            </p>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1: Performance -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'أداء فائق السرعة' : 'Lightning Fast Performance' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'أقراص SSD NVMe فائقة السرعة مع معالجات قوية لضمان تحميل سريع لموقعك' : 'Ultra-fast NVMe SSD drives with powerful processors ensure lightning-fast loading speeds' }}
                </p>
            </div>

            <!-- Feature 2: Reliability -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-500 to-teal-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-teal-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'موثوقية 99.9%' : '99.9% Uptime Guarantee' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'بنية تحتية متطورة مع ضمان وقت تشغيل 99.9% لضمان عمل موقعك دائماً' : 'Advanced infrastructure with 99.9% uptime guarantee ensuring your site is always online' }}
                </p>
            </div>

            <!-- Feature 3: Security -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-red-500 to-pink-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'أمان متقدم' : 'Advanced Security' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'حماية متعددة الطبقات مع جدار حماية، SSL مجاني، ونسخ احتياطي يومي' : 'Multi-layered protection with firewall, free SSL, and daily backups' }}
                </p>
            </div>

            <!-- Feature 4: Scalability -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="400">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-100 to-orange-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'قابلية التوسع' : 'Instant Scalability' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'قم بترقية مواردك فوراً عند الحاجة دون أي توقف في الخدمة' : 'Upgrade your resources instantly as needed without any service interruption' }}
                </p>
            </div>

            <!-- Feature 5: Support -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="500">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'دعم فني 24/7' : '24/7 Expert Support' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'فريق دعم فني محترف متاح على مدار الساعة لمساعدتك في أي وقت' : 'Professional support team available 24/7 to help you anytime' }}
                </p>
            </div>

            <!-- Feature 6: Global Network -->
            <div class="group relative bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="600">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-t-2xl"></div>
                <div class="mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                    {{ app()->getLocale() == 'ar' ? 'شبكة عالمية' : 'Global Network' }}
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'مراكز بيانات متعددة حول العالم لضمان أسرع وصول لزوار موقعك' : 'Multiple data centers worldwide ensuring fastest access for your visitors' }}
                </p>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8" data-aos="fade-up" data-aos-delay="700">
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-black text-blue-600 mb-2">10K+</div>
                <div class="text-gray-600 font-semibold">{{ app()->getLocale() == 'ar' ? 'عميل سعيد' : 'Happy Clients' }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-black text-green-600 mb-2">99.9%</div>
                <div class="text-gray-600 font-semibold">{{ app()->getLocale() == 'ar' ? 'وقت التشغيل' : 'Uptime' }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-black text-purple-600 mb-2">24/7</div>
                <div class="text-gray-600 font-semibold">{{ app()->getLocale() == 'ar' ? 'الدعم الفني' : 'Support' }}</div>
            </div>
            <div class="text-center">
                <div class="text-4xl md:text-5xl font-black text-orange-600 mb-2">6+</div>
                <div class="text-gray-600 font-semibold">{{ app()->getLocale() == 'ar' ? 'مراكز بيانات' : 'Data Centers' }}</div>
            </div>
        </div>
    </div>
</section>

<!-- FAQs Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                {{ app()->getLocale() == 'ar' ? 'الأسئلة الشائعة حول الاستضافة السحابية' : 'Cloud Hosting FAQs' }}
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                {{ app()->getLocale() == 'ar' ? 'إجابات على أكثر الأسئلة شيوعاً حول خدمات الاستضافة السحابية' : 'Answers to the most frequently asked questions about cloud hosting services' }}
            </p>
        </div>

        <!-- FAQ Accordion -->
        <div class="space-y-4" data-aos="fade-up" data-aos-delay="200">
            
            <!-- FAQ 1: What is Cloud Hosting? -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'ما هي الاستضافة السحابية؟' : 'What is Cloud Hosting?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'الاستضافة السحابية هي نوع من خدمات استضافة المواقع التي تستخدم موارد متعددة من خوادم افتراضية متصلة ببعضها البعض لاستضافة موقعك. بدلاً من الاعتماد على خادم واحد، توزع الاستضافة السحابية الموارد عبر شبكة من الخوادم، مما يوفر مرونة وموثوقية أكبر.'
                            : 'Cloud hosting is a type of web hosting service that uses multiple resources from virtual servers connected together to host your website. Instead of relying on a single server, cloud hosting distributes resources across a network of servers, providing greater flexibility and reliability.' }}
                    </p>
                </div>
            </div>

            <!-- FAQ 2: When Does Cloud Hosting Make Sense? -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'متى تكون الاستضافة السحابية مناسبة لي؟' : 'When Does Cloud Hosting Make Sense for Me?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ app()->getLocale() == 'ar' 
                            ? 'تكون الاستضافة السحابية مثالية في الحالات التالية:'
                            : 'Cloud hosting makes sense in the following situations:' }}
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 {{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }}">
                        <li>{{ app()->getLocale() == 'ar' ? 'موقعك يشهد زيارات متقلبة أو مواسم ذروة' : 'Your website experiences fluctuating traffic or peak seasons' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'تحتاج إلى موارد قابلة للتوسع حسب الطلب' : 'You need scalable resources on demand' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'تبحث عن أقصى قدر من الموثوقية ووقت التشغيل' : 'You seek maximum reliability and uptime' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'تدير تطبيقات أو مواقع حساسة للأداء' : 'You run performance-sensitive applications or websites' }}</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 3: Benefits of Managed Cloud Hosting -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'ما هي فوائد خدمة الاستضافة السحابية المُدارة؟' : 'What Are the Benefits of a Managed Cloud Web Hosting Service?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ app()->getLocale() == 'ar' 
                            ? 'توفر الاستضافة السحابية المُدارة العديد من المزايا:'
                            : 'Managed cloud hosting provides numerous benefits:' }}
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 {{ app()->getLocale() == 'ar' ? 'mr-4' : 'ml-4' }}">
                        <li>{{ app()->getLocale() == 'ar' ? 'إدارة تقنية كاملة من فريق الخبراء' : 'Full technical management by expert team' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'تحديثات أمنية تلقائية ومستمرة' : 'Automatic and continuous security updates' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'نسخ احتياطي يومي ومراقبة على مدار الساعة' : 'Daily backups and 24/7 monitoring' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'دعم فني متخصص متاح دائماً' : 'Specialized technical support always available' }}</li>
                        <li>{{ app()->getLocale() == 'ar' ? 'تحسين الأداء والسرعة باستمرار' : 'Continuous performance and speed optimization' }}</li>
                    </ul>
                </div>
            </div>

            <!-- FAQ 4: Control Panel -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'هل تأتي الاستضافة السحابية مع لوحة تحكم؟' : 'Does Cloud Website Hosting Come with a Control Panel?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'نعم، جميع خطط الاستضافة السحابية لدينا تأتي مع لوحة تحكم cPanel سهلة الاستخدام. تتيح لك لوحة التحكم إدارة موقعك الإلكتروني، وقواعد البيانات، وحسابات البريد الإلكتروني، والنطاقات، والمزيد - كل ذلك من واجهة رسومية بديهية دون الحاجة لخبرة تقنية متقدمة.'
                            : 'Yes, all our cloud hosting plans come with an easy-to-use cPanel control panel. The control panel allows you to manage your website, databases, email accounts, domains, and more - all from an intuitive graphical interface without requiring advanced technical expertise.' }}
                    </p>
                </div>
            </div>

            <!-- FAQ 5: Free Domain -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'هل يمكنني تسجيل نطاق مجاني مع خطة الاستضافة السحابية؟' : 'Can I Register a Free Domain with a Cloud Hosting Plan?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'نعم! جميع خطط الاستضافة السحابية لدينا تتضمن نطاقاً مجانياً لمدة عام واحد. يمكنك اختيار امتداد النطاق من بين مجموعة واسعة من الامتدادات المتاحة مثل .com و .net و .org وغيرها. هذا العرض يوفر لك التكاليف الإضافية ويسهل عملية بدء موقعك الإلكتروني.'
                            : 'Yes! All our cloud hosting plans include a free domain for one year. You can choose your domain extension from a wide range of available extensions such as .com, .net, .org, and more. This offer saves you additional costs and makes starting your website easier.' }}
                    </p>
                </div>
            </div>

            <!-- FAQ 6: Shared vs Cloud -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'ما الفرق بين الاستضافة المشتركة والاستضافة السحابية؟' : 'What Is the Difference Between Shared Hosting and Cloud Hosting?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed mb-4">
                        {{ app()->getLocale() == 'ar' 
                            ? 'الفروقات الرئيسية بين الاستضافة المشتركة والسحابية:'
                            : 'Key differences between shared and cloud hosting:' }}
                    </p>
                    <div class="space-y-3">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-bold text-blue-900 mb-2">{{ app()->getLocale() == 'ar' ? 'الاستضافة المشتركة:' : 'Shared Hosting:' }}</h4>
                            <p class="text-gray-700 text-sm">{{ app()->getLocale() == 'ar' ? 'موارد محدودة مشتركة مع مواقع أخرى على خادم واحد، مناسبة للمواقع الصغيرة والمبتدئين.' : 'Limited resources shared with other websites on a single server, suitable for small sites and beginners.' }}</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-bold text-purple-900 mb-2">{{ app()->getLocale() == 'ar' ? 'الاستضافة السحابية:' : 'Cloud Hosting:' }}</h4>
                            <p class="text-gray-700 text-sm">{{ app()->getLocale() == 'ar' ? 'موارد مخصصة قابلة للتوسع عبر شبكة من الخوادم، توفر أداء أعلى وموثوقية أكبر للمواقع المتطورة.' : 'Dedicated scalable resources across a network of servers, providing higher performance and greater reliability for advanced sites.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ 7: VPS vs Cloud -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'ما الفرق بين VPS والاستضافة السحابية؟' : 'What Is the Difference Between VPS and Cloud Server Hosting?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'الـ VPS (الخادم الافتراضي الخاص) يوفر بيئة افتراضية على خادم فعلي واحد، بينما الاستضافة السحابية تستخدم شبكة من الخوادم المترابطة. الاستضافة السحابية توفر مرونة أكبر في التوسع، وموثوقية أعلى (لأنها لا تعتمد على خادم واحد)، وإمكانية التوسع الفوري للموارد حسب الحاجة. VPS أكثر ملاءمة لمن يحتاج تحكماً كاملاً في الخادم، بينما السحابية أفضل للمرونة والتوسع.'
                            : 'VPS (Virtual Private Server) provides a virtual environment on a single physical server, while cloud hosting uses a network of interconnected servers. Cloud hosting offers greater scalability, higher reliability (as it doesn\'t depend on a single server), and instant resource scaling as needed. VPS is more suitable for those who need full server control, while cloud is better for flexibility and scalability.' }}
                    </p>
                </div>
            </div>

            <!-- FAQ 8: Upgrade from Shared to Cloud -->
            <div class="border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300" x-data="{ open: false }">
                <button @click="open = !open" class="w-full px-6 py-5 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-gray-50 hover:bg-gray-100 transition-colors duration-200 flex items-center justify-between">
                    <span class="text-lg font-bold text-gray-900">
                        {{ app()->getLocale() == 'ar' ? 'هل يمكنني الترقية من الاستضافة المشتركة إلى السحابية؟' : 'Can I Upgrade From Shared to Cloud Server Hosting?' }}
                    </span>
                    <svg class="w-6 h-6 text-blue-600 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" x-collapse class="px-6 py-5 bg-white text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                    <p class="text-gray-600 leading-relaxed">
                        {{ app()->getLocale() == 'ar' 
                            ? 'بالتأكيد! يمكنك الترقية من الاستضافة المشتركة إلى الاستضافة السحابية في أي وقت. فريقنا الفني سيساعدك في عملية النقل السلسة لموقعك وقواعد البيانات والملفات دون أي توقف. نوفر أيضاً مساعدة مجانية في النقل لضمان انتقال سلس وآمن لموقعك. ببساطة تواصل مع فريق الدعم وسنهتم بكل التفاصيل التقنية.'
                            : 'Absolutely! You can upgrade from shared hosting to cloud hosting at any time. Our technical team will assist you in the smooth migration of your website, databases, and files without any downtime. We also provide free migration assistance to ensure a seamless and secure transition for your site. Simply contact our support team and we\'ll handle all the technical details.' }}
                    </p>
                </div>
            </div>

        </div>

        <!-- Contact Support CTA -->
        <div class="mt-12 text-center bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8" data-aos="fade-up" data-aos-delay="400">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">
                {{ app()->getLocale() == 'ar' ? 'لديك المزيد من الأسئلة؟' : 'Have More Questions?' }}
            </h3>
            <p class="text-gray-600 mb-6">
                {{ app()->getLocale() == 'ar' ? 'فريق الدعم لدينا متاح على مدار الساعة للإجابة على استفساراتك' : 'Our support team is available 24/7 to answer your inquiries' }}
            </p>
            <button onclick="if(typeof Intercom !== 'undefined') { Intercom('show'); } else { alert('{{ app()->getLocale() == 'ar' ? 'جاري تحميل نظام الدعم...' : 'Loading support system...' }}'); }" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-semibold rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                {{ app()->getLocale() == 'ar' ? 'تواصل مع الدعم' : 'Contact Support' }}
            </button>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 mx-4 sm:mx-6 lg:mx-8 mb-16">
    <div class="max-w-5xl mx-auto bg-gradient-to-r from-blue-600 to-blue-700 rounded-3xl p-12 lg:p-16 text-center shadow-xl" data-aos="fade-up">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
            {{ app()->getLocale() == 'ar' ? 'هل أنت مستعد للبدء؟' : 'Ready to Get Started?' }}
        </h2>
        <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
            {{ app()->getLocale() == 'ar' 
                ? 'انضم إلى آلاف العملاء الذين يثقون في خدماتنا واحصل على استضافة سحابية موثوقة اليوم' 
                : 'Join thousands of customers who trust our services and get reliable cloud hosting today' }}
        </p>
        
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="#plans" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-xl hover:bg-gray-50 transform hover:scale-105 transition-all duration-300 shadow-lg">
                {{ __('frontend.get_started') ?? 'ابدأ الآن' }}
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() == 'ar' ? 'M15 19l-7-7 7-7' : 'M9 5l7 7-7 7' }}"></path>
                </svg>
            </a>
            
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-transparent text-white font-bold text-lg rounded-xl border-2 border-white hover:bg-white hover:text-blue-600 transition-all duration-300">
                {{ __('frontend.contact_us') ?? 'تواصل معنا' }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- AOS Library JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        offset: 100
    });
</script>
@endpush
