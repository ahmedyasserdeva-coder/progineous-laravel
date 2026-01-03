@extends('frontend.layout')

@section('title', __('frontend.register'))

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-purple-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <div class="max-w-md w-full space-y-8">
        <!-- Referral Banner -->
        @if(isset($referrer) && $referrer)
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z" clip-rule="evenodd" />
                        <path d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-green-800 dark:text-green-300">
                        {{ app()->getLocale() == 'ar' ? 'تمت إحالتك بواسطة' : 'Referred by' }}
                    </p>
                    <p class="text-base font-semibold text-green-900 dark:text-green-200">{{ $referrer }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Logo & Title -->
        <div class="text-center">
            <div class="flex justify-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl shadow-purple-500/30">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">
                {{ __('frontend.create_account') }}
            </h2>
            <p class="text-slate-600 dark:text-slate-400">
                {{ __('frontend.join_us_today') }}
            </p>
        </div>

        <!-- Register Form -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-8">
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('frontend.full_name') }}
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="{{ __('frontend.your_name') }}">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('frontend.email') }}
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="your@email.com">
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('frontend.phone') }}
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="+20 123 456 7890">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('frontend.password') }}
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="••••••••">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        {{ __('frontend.confirm_password') }}
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:border-purple-500 focus:ring-2 focus:ring-purple-500/20 transition-all"
                        placeholder="••••••••">
                </div>

                <!-- Terms & Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" name="terms" required class="w-4 h-4 mt-1 text-purple-600 border-slate-300 rounded focus:ring-purple-500">
                    <label class="mr-2 text-sm text-slate-600 dark:text-slate-400">
                        {{ __('frontend.i_agree_to') }}
                        <a href="#" class="font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400">{{ __('frontend.terms_and_conditions') }}</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg shadow-purple-500/30 hover:shadow-purple-500/50 transition-all transform hover:-translate-y-0.5">
                    {{ __('frontend.create_account') }}
                </button>

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-slate-600 dark:text-slate-400">{{ __('frontend.already_have_account') }}</span>
                    <a href="{{ route('login') }}" class="font-medium text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300">
                        {{ __('frontend.login_now') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Social Login (Optional) -->
        <div class="text-center">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-300 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-gradient-to-br from-purple-50 via-white to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 text-slate-500 dark:text-slate-400">
                        {{ __('frontend.or_register_with') }}
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-4">
                <button class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Google</span>
                </button>

                <button class="w-full px-4 py-3 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Facebook</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
