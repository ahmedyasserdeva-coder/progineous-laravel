@extends('frontend.layout')

@section('title', __('frontend.careers'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    
    <!-- Hero Section -->
    <section class="relative py-20 overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-96 h-96 bg-gradient-to-br from-blue-400/30 to-purple-500/30 rounded-full blur-3xl animate-blob"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-gradient-to-tr from-cyan-400/30 to-blue-500/30 rounded-full blur-3xl animate-blob animation-delay-2000"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    {{ __('frontend.join_our_team') }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 mb-8">
                    {{ __('frontend.careers_subtitle') }}
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#openings" class="px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        {{ __('frontend.view_openings') }}
                    </a>
                    <a href="#culture" class="px-8 py-4 bg-white/80 backdrop-blur-sm text-gray-800 rounded-xl font-semibold hover:shadow-xl transition-all duration-300 border border-gray-200 hover:border-purple-300">
                        {{ __('frontend.our_culture') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Join Us Section -->
    <section id="culture" class="py-16 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                    {{ __('frontend.why_join_us') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ __('frontend.why_join_us_description') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Benefit 1 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.innovative_environment') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.innovative_environment_desc') }}
                    </p>
                </div>

                <!-- Benefit 2 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.competitive_salary') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.competitive_salary_desc') }}
                    </p>
                </div>

                <!-- Benefit 3 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.learning_opportunities') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.learning_opportunities_desc') }}
                    </p>
                </div>

                <!-- Benefit 4 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.team_collaboration') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.team_collaboration_desc') }}
                    </p>
                </div>

                <!-- Benefit 5 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.flexible_hours') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.flexible_hours_desc') }}
                    </p>
                </div>

                <!-- Benefit 6 -->
                <div class="group relative p-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">
                        {{ __('frontend.global_opportunities') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.global_opportunities_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Positions Section -->
    <section id="openings" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                    {{ __('frontend.open_positions') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ __('frontend.open_positions_description') }}
                </p>
            </div>

            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Job Position 1 -->
                <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                                    {{ __('frontend.senior_backend_developer') }}
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                                        {{ __('frontend.full_time') }}
                                    </span>
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                                        {{ __('frontend.remote') }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">
                                        {{ __('frontend.experience_3_years') }}
                                    </span>
                                </div>
                            </div>
                            <a href="#apply" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                {{ __('frontend.apply_now') }}
                            </a>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            {{ __('frontend.senior_backend_developer_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Job Position 2 -->
                <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                                    {{ __('frontend.frontend_developer') }}
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                                        {{ __('frontend.full_time') }}
                                    </span>
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                                        {{ __('frontend.hybrid') }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">
                                        {{ __('frontend.experience_2_years') }}
                                    </span>
                                </div>
                            </div>
                            <a href="#apply" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                {{ __('frontend.apply_now') }}
                            </a>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            {{ __('frontend.frontend_developer_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Job Position 3 -->
                <div class="group bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                                    {{ __('frontend.customer_support_specialist') }}
                                </h3>
                                <div class="flex flex-wrap gap-3">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">
                                        {{ __('frontend.full_time') }}
                                    </span>
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">
                                        {{ __('frontend.on_site') }}
                                    </span>
                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">
                                        {{ __('frontend.experience_1_year') }}
                                    </span>
                                </div>
                            </div>
                            <a href="#apply" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                {{ __('frontend.apply_now') }}
                            </a>
                        </div>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            {{ __('frontend.customer_support_specialist_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Form Section -->
    <section id="apply" class="py-16 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold mb-4 text-gray-800 dark:text-white">
                        {{ __('frontend.apply_now') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('frontend.apply_form_description') }}
                    </p>
                </div>

                <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl border border-gray-200 dark:border-gray-700 p-8 shadow-xl">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.full_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="full_name" name="full_name" required 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.email') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.phone') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="phone" name="phone" required 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.position_applying_for') }} <span class="text-red-500">*</span>
                                </label>
                                <select id="position" name="position" required 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                    <option value="">{{ __('frontend.select_position') }}</option>
                                    <option value="backend">{{ __('frontend.senior_backend_developer') }}</option>
                                    <option value="frontend">{{ __('frontend.frontend_developer') }}</option>
                                    <option value="support">{{ __('frontend.customer_support_specialist') }}</option>
                                    <option value="other">{{ __('frontend.other') }}</option>
                                </select>
                            </div>

                            <!-- Resume -->
                            <div>
                                <label for="resume" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.resume_cv') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" required 
                                       class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    {{ __('frontend.accepted_formats') }}: PDF, DOC, DOCX ({{ __('frontend.max_size') }}: 5MB)
                                </p>
                            </div>

                            <!-- Cover Letter -->
                            <div>
                                <label for="cover_letter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('frontend.cover_letter') }}
                                </label>
                                <textarea id="cover_letter" name="cover_letter" rows="5" 
                                          class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center pt-4">
                                <button type="submit" 
                                        class="px-12 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                                    {{ __('frontend.submit_application') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>
@endpush
@endsection
