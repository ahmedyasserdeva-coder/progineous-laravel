@extends('admin.layout')

@section('title', __('tickets.predefined_replies.edit'))

@section('content')
<div class="max-w-3xl mx-auto p-6">
    
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.predefined-replies.index') }}" 
           class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 transition-colors mb-4">
            <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            {{ __('tickets.predefined_replies.back_to_list') }}
        </a>
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center shadow-lg shadow-purple-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('tickets.predefined_replies.edit') }}</h1>
                <p class="text-gray-500 text-sm">{{ $predefinedReply->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.predefined-replies.update', $predefinedReply) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            
            <!-- Name -->
            <div class="p-6 border-b border-gray-100">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('tickets.predefined_replies.name') }} <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $predefinedReply->name) }}" required
                       placeholder="{{ __('tickets.predefined_replies.name_placeholder') }}"
                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all @error('name') border-red-400 bg-red-50 @enderror">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Department & Status -->
            <div class="p-6 border-b border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Department -->
                    <div>
                        <label for="department_id" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('tickets.department') }}
                            <span class="text-gray-400 font-normal">({{ __('tickets.predefined_replies.optional') }})</span>
                        </label>
                        <div class="relative">
                            <select name="department_id" id="department_id"
                                    class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all cursor-pointer">
                                <option value="">{{ __('tickets.predefined_replies.global_all_departments') }}</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $predefinedReply->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-4' : 'right-0 pr-4' }} flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">{{ __('tickets.predefined_replies.department_hint') }}</p>
                    </div>

                    <!-- Sort Order -->
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('tickets.predefined_replies.sort_order') }}
                        </label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $predefinedReply->sort_order) }}" min="0"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all">
                        <p class="mt-1 text-xs text-gray-500">{{ __('tickets.predefined_replies.sort_order_hint') }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6 border-b border-gray-100">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('tickets.predefined_replies.content') }} <span class="text-red-500">*</span>
                </label>
                <div class="rounded-xl overflow-hidden @error('content') ring-2 ring-red-400 @enderror">
                    <textarea name="content" id="content">{{ old('content', $predefinedReply->content) }}</textarea>
                </div>
                @error('content')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="p-6 border-b border-gray-100">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $predefinedReply->is_active) ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500/20">
                    <div>
                        <p class="font-medium text-gray-900">{{ __('tickets.predefined_replies.active') }}</p>
                        <p class="text-sm text-gray-500">{{ __('tickets.predefined_replies.active_hint') }}</p>
                    </div>
                </label>
            </div>

            <!-- Submit -->
            <div class="p-6 bg-gray-50 flex items-center justify-between">
                <form action="{{ route('admin.predefined-replies.destroy', $predefinedReply) }}" method="POST" class="inline"
                      onsubmit="return confirm('{{ __('tickets.predefined_replies.confirm_delete') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        {{ __('tickets.delete') }}
                    </button>
                </form>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.predefined-replies.index') }}" 
                       class="px-6 py-2.5 text-gray-700 font-medium rounded-xl hover:bg-gray-100 transition-colors">
                        {{ __('tickets.cancel') }}
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/30">
                        {{ __('tickets.predefined_replies.update_reply') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .tox-tinymce {
        border: none !important;
        border-radius: 0.75rem !important;
    }
    .tox .tox-toolbar__primary {
        background: #f9fafb !important;
        border-bottom: 1px solid #e5e7eb !important;
    }
    .tox .tox-statusbar {
        background: #f9fafb !important;
        border-top: 1px solid #e5e7eb !important;
    }
    .tox .tox-edit-area__iframe {
        background: #fff !important;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('tinymce_8.3.1/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        selector: '#content',
        license_key: 'gpl',
        height: 300,
        menubar: false,
        language: '{{ app()->getLocale() == "ar" ? "ar" : "en" }}',
        directionality: '{{ app()->getLocale() == "ar" ? "rtl" : "ltr" }}',
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'charmap',
            'searchreplace', 'visualblocks', 'code',
            'insertdatetime', 'table', 'help', 'wordcount', 'emoticons', 'directionality'
        ],
        toolbar: 'undo redo | styles | bold italic underline | ' +
            'alignleft aligncenter alignright | ltr rtl | ' +
            'bullist numlist | emoticons link | removeformat',
        content_style: `
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                font-size: 14px;
                line-height: 1.7;
                color: #374151;
                padding: 16px;
                direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};
            }
        `,
        branding: false,
        promotion: false,
        statusbar: true,
        resize: 'both',
        placeholder: '{{ __("tickets.predefined_replies.content_placeholder") }}',
        setup: function(editor) {
            editor.on('change keyup', function() {
                editor.save();
            });
        }
    });
</script>
@endpush
