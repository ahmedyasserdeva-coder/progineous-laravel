@extends('admin.layout')

@section('title', __('crm.add_new_server'))

@section('page-title', __('crm.add_new_server'))

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Breadcrumb Navigation -->
        <div class="mb-6">
            <nav class="flex items-center space-x-2 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }} text-sm">
                <a href="{{ route('admin.dashboard') }}" class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors">
                    {{ __('crm.dashboard') }}
                </a>
                <svg class="w-4 h-4 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('admin.system-settings.index') }}" class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors">
                    {{ __('crm.system_settings') }}
                </a>
                <svg class="w-4 h-4 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('admin.system-settings.servers') }}" class="text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors">
                    {{ __('crm.servers') }}
                </a>
                <svg class="w-4 h-4 text-slate-400 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ __('crm.add_new_server') }}</span>
            </nav>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.system-settings.servers') }}" 
               class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 shadow-sm hover:shadow">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2 rotate-180' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('crm.back_to_servers') }}
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 px-6 py-4 rounded-xl shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-5">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }}">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ __('crm.add_new_server') }}</h2>
                        <p class="text-blue-100 text-sm mt-1">{{ __('crm.add_new_server_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.system-settings.servers.store') }}" method="POST" class="p-6 space-y-8">
                @csrf

                <!-- Basic Information Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-3">
                        {{ __('crm.basic_information') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Server Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.server_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="{{ __('crm.enter_server_name') }}">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Server Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.server_type') }} <span class="text-red-500">*</span>
                            </label>
                            <select id="type" 
                                    name="type" 
                                    required
                                    class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                <option value="">{{ __('crm.select_server_type') }}</option>
                                <option value="cpanel" {{ old('type') == 'cpanel' ? 'selected' : '' }}>cPanel/WHM</option>
                                <option value="plesk" {{ old('type') == 'plesk' ? 'selected' : '' }}>Plesk</option>
                                <option value="directadmin" {{ old('type') == 'directadmin' ? 'selected' : '' }}>DirectAdmin</option>
                                <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>{{ __('crm.custom') }}</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Monthly Cost -->
                        <div>
                            <label for="monthly_cost" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.monthly_cost') }}
                            </label>
                            <div class="relative">
                                <span class="absolute {{ app()->getLocale() == 'ar' ? 'right-3' : 'left-3' }} top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400">$</span>
                                <input type="number" 
                                       id="monthly_cost" 
                                       name="monthly_cost" 
                                       value="{{ old('monthly_cost') }}"
                                       step="0.01"
                                       min="0"
                                       class="w-full {{ app()->getLocale() == 'ar' ? 'pr-8' : 'pl-8' }} px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                       placeholder="99.99">
                            </div>
                            @error('monthly_cost')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.monthly_cost_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Connection Details Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-3">
                        {{ __('crm.connection_details') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hostname -->
                        <div>
                            <label for="hostname" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.hostname') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="hostname" 
                                   name="hostname" 
                                   value="{{ old('hostname') }}"
                                   required
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="server1.example.com">
                            @error('hostname')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- IP Address -->
                        <div>
                            <label for="ip_address" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.ip_address') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="ip_address" 
                                   name="ip_address" 
                                   value="{{ old('ip_address') }}"
                                   required
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="192.168.1.1">
                            @error('ip_address')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Port -->
                        <div>
                            <label for="port" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.port') }}
                            </label>
                            <input type="number" 
                                   id="port" 
                                   name="port" 
                                   value="{{ old('port', '2087') }}"
                                   min="1"
                                   max="65535"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="2087">
                            @error('port')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.port_desc') }}</p>
                        </div>

                        <!-- Max Accounts -->
                        <div>
                            <label for="max_accounts" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.max_accounts') }}
                            </label>
                            <input type="number" 
                                   id="max_accounts" 
                                   name="max_accounts" 
                                   value="{{ old('max_accounts') }}"
                                   min="0"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="100">
                            @error('max_accounts')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.max_accounts_desc') }}</p>
                        </div>

                        <!-- Datacenter/NOC -->
                        <div>
                            <label for="datacenter" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.datacenter_noc') }}
                            </label>
                            <input type="text" 
                                   id="datacenter" 
                                   name="datacenter" 
                                   value="{{ old('datacenter') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="{{ __('crm.datacenter_placeholder') }}">
                            @error('datacenter')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.datacenter_desc') }}</p>
                        </div>
                    </div>

                    <!-- Assigned IP Addresses (Full Width) -->
                    <div>
                        <label for="assigned_ips" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            {{ __('crm.assigned_ip_addresses') }}
                        </label>
                        <textarea id="assigned_ips" 
                                  name="assigned_ips" 
                                  rows="5"
                                  class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors font-mono text-sm"
                                  placeholder="{{ __('crm.assigned_ips_placeholder') }}">{{ old('assigned_ips') }}</textarea>
                        @error('assigned_ips')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.assigned_ips_desc') }}</p>
                    </div>
                </div>

                <!-- Authentication Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-3">
                        {{ __('crm.authentication') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Username -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.username') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}"
                                   required
                                   autocomplete="off"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="root">
                            @error('username')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.password') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       autocomplete="new-password"
                                       class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                       placeholder="••••••••">
                                <button type="button" 
                                        onclick="togglePassword()"
                                        class="absolute {{ app()->getLocale() == 'ar' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                    <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- API Token -->
                        <div>
                            <label for="api_token" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.api_token') }}
                            </label>
                            <input type="text" 
                                   id="api_token" 
                                   name="api_token" 
                                   value="{{ old('api_token') }}"
                                   autocomplete="off"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="{{ __('crm.api_token_placeholder') }}">
                            @error('api_token')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.api_token_desc') }}</p>
                        </div>

                        <!-- Port Override -->
                        <div>
                            <label for="port_override" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.port_override') }}
                            </label>
                            <input type="number" 
                                   id="port_override" 
                                   name="port_override" 
                                   value="{{ old('port_override', '2087') }}"
                                   min="1" max="65535"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="2087">
                            @error('port_override')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.port_override_desc') }}</p>
                        </div>
                    </div>

                    <!-- SSL Mode (Full Width) -->
                    <div class="flex items-start space-x-3 {{ app()->getLocale() == 'ar' ? 'space-x-reverse' : '' }}">
                        <div class="flex items-center h-5">
                            <input type="checkbox" 
                                   id="use_ssl" 
                                   name="use_ssl" 
                                   value="1" 
                                   {{ old('use_ssl', true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 bg-white dark:bg-slate-800 border-slate-300 dark:border-slate-600 rounded focus:ring-blue-500">
                        </div>
                        <div class="flex-1">
                            <label for="use_ssl" class="text-sm font-medium text-slate-700 dark:text-slate-300 cursor-pointer">
                                {{ __('crm.use_ssl') }}
                            </label>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ __('crm.use_ssl_desc') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Nameservers Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-3">
                        {{ __('crm.nameservers') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nameserver 1 -->
                        <div>
                            <label for="nameserver1" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 1
                            </label>
                            <input type="text" 
                                   id="nameserver1" 
                                   name="nameserver1" 
                                   value="{{ old('nameserver1') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="ns1.example.com">
                            @error('nameserver1')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 1 IP -->
                        <div>
                            <label for="nameserver1_ip" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 1 - {{ __('crm.ip_address') }}
                            </label>
                            <input type="text" 
                                   id="nameserver1_ip" 
                                   name="nameserver1_ip" 
                                   value="{{ old('nameserver1_ip') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="192.168.1.1">
                            @error('nameserver1_ip')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 2 -->
                        <div>
                            <label for="nameserver2" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 2
                            </label>
                            <input type="text" 
                                   id="nameserver2" 
                                   name="nameserver2" 
                                   value="{{ old('nameserver2') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="ns2.example.com">
                            @error('nameserver2')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 2 IP -->
                        <div>
                            <label for="nameserver2_ip" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 2 - {{ __('crm.ip_address') }}
                            </label>
                            <input type="text" 
                                   id="nameserver2_ip" 
                                   name="nameserver2_ip" 
                                   value="{{ old('nameserver2_ip') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="192.168.1.2">
                            @error('nameserver2_ip')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 3 -->
                        <div>
                            <label for="nameserver3" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 3
                            </label>
                            <input type="text" 
                                   id="nameserver3" 
                                   name="nameserver3" 
                                   value="{{ old('nameserver3') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="ns3.example.com">
                            @error('nameserver3')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 3 IP -->
                        <div>
                            <label for="nameserver3_ip" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 3 - {{ __('crm.ip_address') }}
                            </label>
                            <input type="text" 
                                   id="nameserver3_ip" 
                                   name="nameserver3_ip" 
                                   value="{{ old('nameserver3_ip') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="192.168.1.3">
                            @error('nameserver3_ip')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 4 -->
                        <div>
                            <label for="nameserver4" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 4
                            </label>
                            <input type="text" 
                                   id="nameserver4" 
                                   name="nameserver4" 
                                   value="{{ old('nameserver4') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="ns4.example.com">
                            @error('nameserver4')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nameserver 4 IP -->
                        <div>
                            <label for="nameserver4_ip" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                                {{ __('crm.nameserver') }} 4 - {{ __('crm.ip_address') }}
                            </label>
                            <input type="text" 
                                   id="nameserver4_ip" 
                                   name="nameserver4_ip" 
                                   value="{{ old('nameserver4_ip') }}"
                                   class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                   placeholder="192.168.1.4">
                            @error('nameserver4_ip')
                                <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white border-b border-slate-200 dark:border-slate-700 pb-3">
                        {{ __('crm.status') }}
                    </h3>

                    <div>
                        <label class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                                        {{ __('crm.server_active') }}
                                    </span>
                                </div>
                                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ __('crm.server_active_desc') }}</p>
                            </div>
                            <div class="relative">
                                <input type="checkbox" 
                                       id="status" 
                                       name="status" 
                                       value="1"
                                       {{ old('status', true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-500 peer-checked:bg-blue-600"></div>
                            </div>
                        </label>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 dark:border-slate-700">
                    <!-- Left side: Test Connection Button -->
                    <button type="button" 
                            onclick="testConnection()"
                            id="testConnectionBtn"
                            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="flex items-center" id="testBtnContent">
                            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            {{ __('crm.test_connection') }}
                        </span>
                    </button>

                    <!-- Right side: Cancel & Submit -->
                    <div class="flex items-center gap-4">
                        <a href="{{ route('admin.system-settings.servers') }}" 
                           class="px-6 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200">
                            {{ __('crm.cancel') }}
                        </a>
                        <button type="submit" 
                                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('crm.add_server') }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Connection Test Result -->
                <div id="connectionResult" class="hidden mt-4 p-4 rounded-lg"></div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>';
    } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}

async function testConnection() {
    const btn = document.getElementById('testConnectionBtn');
    const btnContent = document.getElementById('testBtnContent');
    const resultDiv = document.getElementById('connectionResult');
    
    // Disable button and show loading
    btn.disabled = true;
    btnContent.innerHTML = `
        <svg class="animate-spin w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        {{ __('crm.testing_connection') }}
    `;
    
    // Collect form data
    const formData = {
        hostname: document.getElementById('hostname').value,
        ip_address: document.getElementById('ip_address').value,
        type: document.getElementById('type').value,
        username: document.getElementById('username').value,
        password: document.getElementById('password').value,
        api_token: document.getElementById('api_token')?.value || '',
        port_override: document.getElementById('port_override')?.value || '',
        use_ssl: document.getElementById('use_ssl')?.checked || false,
        _token: '{{ csrf_token() }}'
    };
    
    try {
        const response = await fetch('{{ route("admin.system-settings.servers.test-connection") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        // Show result
        resultDiv.classList.remove('hidden');
        
        if (data.success) {
            resultDiv.className = 'mt-4 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800';
            resultDiv.innerHTML = `
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-green-800 dark:text-green-200">{{ __('crm.connection_successful') }}</h4>
                        <p class="text-xs text-green-700 dark:text-green-300 mt-1">${data.message}</p>
                        ${data.server_info ? `
                            <div class="mt-2 text-xs text-green-600 dark:text-green-400 space-y-1">
                                ${data.server_info.version ? `<p><strong>{{ __('crm.version') }}:</strong> <span dir="ltr">${data.server_info.version}</span></p>` : ''}
                                ${data.server_info.cpanel_accounts ? `<p><strong>{{ __('crm.cpanel_accounts') }}:</strong> <span dir="ltr">${data.server_info.cpanel_accounts}</span></p>` : ''}
                                ${data.server_info.response_time ? `<p><strong>{{ __('crm.response_time') }}:</strong> <span dir="ltr">${data.server_info.response_time}</span></p>` : ''}
                                ${data.server_info.os ? `<p><strong>{{ __('crm.os') }}:</strong> <span dir="ltr">${data.server_info.os}</span></p>` : ''}
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
        } else {
            resultDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800';
            resultDiv.innerHTML = `
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">{{ __('crm.connection_failed') }}</h4>
                        <p class="text-xs text-red-700 dark:text-red-300 mt-1">${data.message}</p>
                        ${data.errors ? `
                            <ul class="mt-2 text-xs text-red-600 dark:text-red-400 list-disc list-inside space-y-1">
                                ${Object.values(data.errors).flat().map(error => `<li>${error}</li>`).join('')}
                            </ul>
                        ` : ''}
                    </div>
                </div>
            `;
        }
        
    } catch (error) {
        resultDiv.classList.remove('hidden');
        resultDiv.className = 'mt-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800';
        resultDiv.innerHTML = `
            <div class="flex items-start">
                <svg class="w-6 h-6 text-red-600 dark:text-red-400 {{ app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3' }} flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-200">{{ __('crm.connection_error') }}</h4>
                    <p class="text-xs text-red-700 dark:text-red-300 mt-1">${error.message}</p>
                </div>
            </div>
        `;
    } finally {
        // Re-enable button
        btn.disabled = false;
        btnContent.innerHTML = `
            <svg class="w-5 h-5 {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            {{ __('crm.test_connection') }}
        `;
    }
}
</script>

@endsection
