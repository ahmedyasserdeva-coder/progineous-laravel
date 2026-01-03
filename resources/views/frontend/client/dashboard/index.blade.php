@extends('frontend.client.layout')

@section('title', __('frontend.dashboard'))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 p-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">
            {{ __('frontend.dashboard') }}
        </h1>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-8">
            <div class="text-center">
                <svg class="w-16 h-16 mx-auto text-blue-600 dark:text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-semibold text-slate-900 dark:text-white mb-2">
                    {{ __('frontend.welcome_back') }}, {{ auth('client')->user()->first_name }}!
                </h2>
                <p class="text-slate-600 dark:text-slate-400">
                    {{ __('frontend.dashboard') }} - {{ __('frontend.member_since') }} {{ auth('client')->user()->created_at->format('M Y') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
