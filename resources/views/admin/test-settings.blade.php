@extends('admin.layout')

@section('title', 'Test Settings')

@section('content')
<div class="p-6">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-6">Settings Usage Example</h1>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 space-y-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Company Name:</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ setting('company_name', 'Not Set') }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Email:</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ setting('email_address', 'Not Set') }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Domain:</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ setting('domain', 'Not Set') }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Activity Log Limit:</h3>
                <p class="text-slate-600 dark:text-slate-400">{{ setting('activity_log_limit', 1000) }}</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Maintenance Mode:</h3>
                <p class="text-slate-600 dark:text-slate-400">
                    @if(setting('maintenance_mode', false))
                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Enabled</span>
                    @else
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Disabled</span>
                    @endif
                </p>
            </div>

            @if(setting('sidebar_admin_logo'))
            <div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Admin Logo:</h3>
                <img src="{{ asset('storage/' . setting('sidebar_admin_logo')) }}" alt="Admin Logo" class="h-20 rounded-lg border border-slate-300">
            </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.system-settings.general') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Go to General Settings
            </a>
        </div>
    </div>
</div>
@endsection
