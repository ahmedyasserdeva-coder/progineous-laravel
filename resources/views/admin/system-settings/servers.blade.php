@extends('admin.layout')

@section('title', __('crm.servers'))

@section('page-title', __('crm.servers'))

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        
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
                <span class="text-slate-700 dark:text-slate-300 font-medium">{{ __('crm.servers') }}</span>
            </nav>
        </div>

        <!-- Header Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center {{ app()->getLocale() == 'ar' ? 'ml-4' : 'mr-4' }}">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white">{{ __('crm.servers') }}</h1>
                            <p class="text-blue-100 text-sm mt-1">{{ __('crm.manage_your_servers') }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('admin.system-settings.servers.create') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-white hover:bg-blue-50 text-blue-600 font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">{{ __('crm.add_server') }}</span>
                        <span class="sm:hidden">{{ __('crm.add') }}</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Servers List -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-900">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ __('crm.name') }}
                        </th>
                        <th scope="col" class="hidden md:table-cell px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ __('crm.type') }}
                        </th>
                        <th scope="col" class="hidden lg:table-cell px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ __('crm.hostname') }}
                        </th>
                        <th scope="col" class="hidden sm:table-cell px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ __('crm.status') }}
                        </th>
                        <th scope="col" class="px-6 py-4 text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            {{ __('crm.actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($servers ?? [] as $server)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <div class="text-sm font-semibold text-slate-900 dark:text-white">
                                    {{ $server->name }}
                                </div>
                                <!-- Mobile: Show type and status -->
                                <div class="flex items-center gap-2 mt-1 md:hidden">
                                    <span class="px-2 py-0.5 text-xs font-medium rounded 
                                        {{ $server->type === 'cpanel' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : '' }}
                                        {{ $server->type === 'plesk' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300' : '' }}
                                        {{ $server->type === 'directadmin' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                                        {{ $server->type === 'custom' ? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' : '' }}">
                                        {{ ucfirst($server->type) }}
                                    </span>
                                    <span class="px-2 py-0.5 text-xs font-medium rounded 
                                        {{ $server->status ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $server->status ? __('crm.active') : __('crm.inactive') }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $server->type === 'cpanel' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                {{ $server->type === 'plesk' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}
                                {{ $server->type === 'directadmin' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                {{ $server->type === 'custom' ? 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-200' : '' }}">
                                {{ ucfirst($server->type) }}
                            </span>
                        </td>
                        <td class="hidden lg:table-cell px-6 py-4">
                            <div class="text-sm font-medium text-slate-900 dark:text-slate-200">
                                {{ $server->hostname }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                {{ $server->ip_address }}
                            </div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4">
                            <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full 
                                {{ $server->status ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $server->status ? __('crm.active') : __('crm.inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.system-settings.servers.edit', $server) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 rounded-lg transition-colors gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    <span class="text-xs font-medium hidden sm:inline">{{ __('crm.edit') }}</span>
                                </a>
                                <button type="button" 
                                        onclick="openDeleteModal({{ $server->id }}, '{{ $server->name }}')"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 dark:bg-red-900/30 dark:hover:bg-red-900/50 text-red-600 dark:text-red-400 rounded-lg transition-colors gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span class="text-xs font-medium hidden sm:inline">{{ __('crm.delete') }}</span>
                                </button>
                                <form id="delete-form-{{ $server->id }}" 
                                      action="{{ route('admin.system-settings.servers.delete', $server) }}" 
                                      method="POST" 
                                      class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-20 h-20 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                                    </svg>
                                </div>
                                <h3 class="text-slate-700 dark:text-slate-300 text-lg font-semibold mb-2">{{ __('crm.no_servers_found') }}</h3>
                                <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 max-w-md">{{ __('crm.add_your_first_server') }}</p>
                                <a href="{{ route('admin.system-settings.servers.create') }}" 
                                   class="inline-flex items-center px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('crm.add_server') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" onclick="closeDeleteModal(event)">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800" onclick="event.stopPropagation()">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-4">
                {{ __('crm.confirm_delete') }}
            </h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('crm.are_you_sure_delete_server') }} "<span id="serverNameToDelete" class="font-semibold"></span>"?
                </p>
                <p class="text-xs text-red-500 dark:text-red-400 mt-2">
                    {{ __('crm.action_cannot_be_undone') }}
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <div class="flex gap-3 justify-center">
                    <button onclick="closeDeleteModal()" 
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-base font-medium rounded-md shadow-sm hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        {{ __('crm.cancel') }}
                    </button>
                    <button onclick="confirmDelete()" 
                            class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        {{ __('crm.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let deleteFormId = null;

function openDeleteModal(serverId, serverName) {
    deleteFormId = 'delete-form-' + serverId;
    document.getElementById('serverNameToDelete').textContent = serverName;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal(event) {
    if (!event || event.target.id === 'deleteModal') {
        document.getElementById('deleteModal').classList.add('hidden');
        deleteFormId = null;
    }
}

function confirmDelete() {
    if (deleteFormId) {
        document.getElementById(deleteFormId).submit();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>

@endsection
