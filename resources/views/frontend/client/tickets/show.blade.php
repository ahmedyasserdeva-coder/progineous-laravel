@extends('frontend.client.layout')

@section('title', __('tickets.view_ticket') . ' - ' . $ticket->ticket_number)

@section('content')
<div class="min-h-screen bg-slate-50/50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Ticket Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-8">
            <!-- Navigation Bar -->
            <div class="px-6 py-3 bg-slate-50/80 border-b border-slate-100 flex items-center justify-between">
                <a href="{{ route('client.tickets.index') }}" 
                   class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-blue-600 transition-all duration-200 group">
                    <span class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center group-hover:border-blue-300 group-hover:bg-blue-50 transition-all duration-200">
                        <svg class="w-4 h-4 {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                    {{ __('tickets.back_to_tickets') }}
                </a>
                
                @if($ticket->isOpen())
                    <button type="button" 
                            onclick="openCloseModal()"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 hover:text-white bg-white hover:bg-red-500 border border-slate-200 hover:border-red-500 rounded-xl transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('tickets.close_ticket') }}
                    </button>
                @endif
            </div>
            
            <!-- Ticket Details -->
            <div class="p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    <!-- Main Info -->
                    <div class="flex-1 space-y-4">
                        <!-- Status Badges -->
                        <div class="flex flex-wrap items-center gap-3">
                            @php
                                $statusConfig = [
                                    'open' => ['bg' => 'bg-blue-500', 'ring' => 'ring-blue-500/20'],
                                    'customer_reply' => ['bg' => 'bg-orange-500', 'ring' => 'ring-orange-500/20'],
                                    'answered' => ['bg' => 'bg-emerald-500', 'ring' => 'ring-emerald-500/20'],
                                    'in_progress' => ['bg' => 'bg-cyan-500', 'ring' => 'ring-cyan-500/20'],
                                    'on_hold' => ['bg' => 'bg-amber-500', 'ring' => 'ring-amber-500/20'],
                                    'closed' => ['bg' => 'bg-slate-400', 'ring' => 'ring-slate-400/20'],
                                ];
                                $status = $statusConfig[$ticket->status] ?? $statusConfig['closed'];
                            @endphp
                            
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-slate-200 rounded-full text-xs font-semibold text-slate-700 shadow-sm">
                                <span class="w-2 h-2 rounded-full {{ $status['bg'] }} ring-4 {{ $status['ring'] }}"></span>
                                {{ $ticket->status_label }}
                            </span>
                            
                            @if($ticket->priority == 'urgent')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 border border-red-200 rounded-full text-xs font-semibold text-red-700">
                                    <svg class="w-3.5 h-3.5 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $ticket->priority_label }}
                                </span>
                            @elseif($ticket->priority == 'high')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-orange-50 border border-orange-200 rounded-full text-xs font-semibold text-orange-700">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $ticket->priority_label }}
                                </span>
                            @elseif($ticket->priority == 'medium')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 border border-amber-200 rounded-full text-xs font-semibold text-amber-700">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $ticket->priority_label }}
                                </span>
                            @elseif($ticket->priority == 'low')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-full text-xs font-semibold text-slate-600">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $ticket->priority_label }}
                                </span>
                            @endif
                        </div>
                        
                        <!-- Title -->
                        <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 leading-tight">{{ $ticket->subject }}</h1>
                        
                        <!-- Meta Information -->
                        <div class="flex flex-wrap items-center gap-6 text-sm">
                            <div class="flex items-center gap-2 text-slate-500">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                    </svg>
                                </div>
                                <span class="font-mono font-medium text-slate-700">{{ $ticket->ticket_number }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-slate-500">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                                    </svg>
                                </div>
                                <span class="font-medium text-slate-700">{{ $ticket->department->name }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-slate-500">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span>{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if($ticket->service)
                                <div class="flex items-center gap-2 text-slate-500">
                                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-slate-700">{{ $ticket->service->domain ?? $ticket->service->service_name }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <ul class="text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Conversation Timeline -->
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute {{ app()->getLocale() == 'ar' ? 'right-6' : 'left-6' }} top-0 bottom-0 w-px bg-gradient-to-b from-slate-200 via-slate-200 to-transparent hidden lg:block"></div>
            
            <div class="space-y-6">
                <!-- Original Message -->
                <div class="relative">
                    <div class="lg:{{ app()->getLocale() == 'ar' ? 'pr-16' : 'pl-16' }}">
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden hover:shadow-md transition-shadow duration-300">
                            <!-- Message Header -->
                            <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center shadow-lg shadow-slate-900/20">
                                            <span class="text-white font-bold text-sm">{{ strtoupper(substr($ticket->client->first_name, 0, 1) . substr($ticket->client->last_name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-slate-900">{{ $ticket->client->first_name }} {{ $ticket->client->last_name }}</h4>
                                            <p class="text-xs text-slate-500">{{ $ticket->created_at->format('M d, Y • h:i A') }}</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-full">
                                        {{ app()->getLocale() == 'ar' ? 'الرسالة الأصلية' : 'Original' }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Message Body -->
                            <div class="p-6">
                                <div class="prose prose-slate prose-sm max-w-none leading-relaxed">
                                    {!! $ticket->message !!}
                                </div>
                                
                                @if($ticket->attachments->count() > 0)
                                    <div class="mt-6 pt-6 border-t border-slate-100">
                                        <h5 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                            </svg>
                                            {{ __('tickets.attachments') }} ({{ $ticket->attachments->count() }})
                                        </h5>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach($ticket->attachments as $attachment)
                                                @php
                                                    $ext = strtolower(pathinfo($attachment->filename, PATHINFO_EXTENSION));
                                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                    $isPdf = $ext === 'pdf';
                                                @endphp
                                                <a href="{{ route('client.tickets.attachment.download', $attachment) }}" 
                                                   class="group flex items-center gap-3 p-3 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 rounded-xl transition-all duration-200">
                                                    <div class="w-10 h-10 rounded-lg {{ $isImage ? 'bg-purple-100' : ($isPdf ? 'bg-red-100' : 'bg-slate-100') }} flex items-center justify-center flex-shrink-0">
                                                        @if($isImage)
                                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                            </svg>
                                                        @elseif($isPdf)
                                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-slate-700 group-hover:text-blue-700 truncate">{{ $attachment->filename }}</p>
                                                        <p class="text-xs text-slate-400">{{ strtoupper($ext) }} • {{ $attachment->human_size ?? 'N/A' }}</p>
                                                    </div>
                                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                @foreach($ticket->replies as $index => $reply)
                    <div class="relative">

                        
                        <div class="lg:{{ app()->getLocale() == 'ar' ? 'pr-16' : 'pl-16' }}">
                            <div class="bg-white rounded-2xl shadow-sm border {{ $reply->isFromAdmin() ? 'border-blue-200/80 ring-1 ring-blue-100' : 'border-slate-200/80' }} overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <!-- Reply Header -->
                                <div class="px-6 py-4 {{ $reply->isFromAdmin() ? 'bg-gradient-to-r from-blue-50 via-indigo-50/30 to-white' : 'bg-gradient-to-r from-slate-50 to-white' }} border-b {{ $reply->isFromAdmin() ? 'border-blue-100' : 'border-slate-100' }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="relative">
                                                @if($reply->isFromAdmin())
                                                    <div class="w-12 h-12 rounded-full border-2 border-blue-200 shadow-lg shadow-blue-500/10 overflow-hidden">
                                                        <img src="{{ asset('logo/pro Gineous Blue_defult icon.png') }}" alt="Support" class="w-full h-full object-cover rounded-full">
                                                    </div>
                                                    <div class="absolute -bottom-1 -{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}-1 w-5 h-5 rounded-full bg-blue-500 border-2 border-white shadow-sm flex items-center justify-center">
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center shadow-lg shadow-slate-900/20">
                                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr($ticket->client->first_name, 0, 1) . substr($ticket->client->last_name, 0, 1)) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-semibold {{ $reply->isFromAdmin() ? 'text-blue-900' : 'text-slate-900' }}">
                                                        {{ $reply->isFromAdmin() ? ($reply->user->name ?? __('tickets.support_team')) : ($ticket->client->first_name . ' ' . $ticket->client->last_name) }}
                                                    </h4>
                                                    @if($reply->isFromAdmin())
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ app()->getLocale() == 'ar' ? 'الدعم الفني' : 'Support' }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-slate-500">{{ $reply->created_at->format('M d, Y • h:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Reply Body -->
                                <div class="p-6">
                                    <div class="prose prose-slate prose-sm max-w-none leading-relaxed {{ $reply->isFromAdmin() ? 'prose-blue' : '' }}">
                                        {!! $reply->message !!}
                                    </div>
                                    
                                    {{-- Rating Section for Admin Replies --}}
                                    @if($reply->isFromAdmin())
                                        <div class="mt-6 pt-4 border-t {{ $reply->isFromAdmin() ? 'border-blue-100' : 'border-slate-100' }}">
                                            @if($reply->rating)
                                                {{-- Already Rated --}}
                                                <div class="flex items-center gap-2">
                                                    @if($reply->rating === 'helpful')
                                                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                                            </svg>
                                                            {{ __('tickets.you_rated_helpful') }}
                                                        </div>
                                                    @else
                                                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 border border-slate-200 rounded-xl text-sm text-slate-600">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                                            </svg>
                                                            {{ __('tickets.you_rated_not_helpful') }}
                                                        </div>
                                                    @endif
                                                    <span class="text-xs text-slate-400">{{ __('tickets.thanks_for_feedback') }}</span>
                                                </div>
                                            @else
                                                {{-- Rating Buttons --}}
                                                <div class="flex items-center gap-4">
                                                    <span class="text-sm text-slate-500">{{ __('tickets.was_helpful') }}</span>
                                                    <div class="flex items-center gap-2">
                                                        <form action="{{ route('client.tickets.reply.rate', $reply) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="rating" value="helpful">
                                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 rounded-lg text-sm text-slate-600 hover:text-emerald-700 transition-all duration-200">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"/>
                                                                </svg>
                                                                {{ __('tickets.helpful') }}
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('client.tickets.reply.rate', $reply) }}" method="POST" class="inline">
                                                            @csrf
                                                            <input type="hidden" name="rating" value="not_helpful">
                                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-red-300 hover:bg-red-50 rounded-lg text-sm text-slate-600 hover:text-red-700 transition-all duration-200">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.106-1.79l-.05-.025A4 4 0 0011.057 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"/>
                                                                </svg>
                                                                {{ __('tickets.not_helpful') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    @if($reply->attachments->count() > 0)
                                        <div class="mt-6 pt-6 border-t {{ $reply->isFromAdmin() ? 'border-blue-100' : 'border-slate-100' }}">
                                            <h5 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                                </svg>
                                                {{ __('tickets.attachments') }} ({{ $reply->attachments->count() }})
                                            </h5>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                @foreach($reply->attachments as $attachment)
                                                    @php
                                                        $ext = strtolower(pathinfo($attachment->filename, PATHINFO_EXTENSION));
                                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                        $isPdf = $ext === 'pdf';
                                                    @endphp
                                                    <a href="{{ route('client.tickets.attachment.download', $attachment) }}" 
                                                       class="group flex items-center gap-3 p-3 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-300 rounded-xl transition-all duration-200">
                                                        <div class="w-10 h-10 rounded-lg {{ $isImage ? 'bg-purple-100' : ($isPdf ? 'bg-red-100' : 'bg-slate-100') }} flex items-center justify-center flex-shrink-0">
                                                            @if($isImage)
                                                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                            @elseif($isPdf)
                                                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                                                </svg>
                                                            @else
                                                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                                </svg>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-slate-700 group-hover:text-blue-700 truncate">{{ $attachment->filename }}</p>
                                                            <p class="text-xs text-slate-400">{{ strtoupper($ext) }} • {{ $attachment->human_size ?? 'N/A' }}</p>
                                                        </div>
                                                        <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                        </svg>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Reply Form -->
        @if($ticket->isOpen())
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-white border-b border-slate-100">
                    <h3 class="font-semibold text-slate-900 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        {{ app()->getLocale() == 'ar' ? 'أضف رداً' : 'Write a Reply' }}
                    </h3>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('client.tickets.reply', $ticket) }}" method="POST" enctype="multipart/form-data" x-data="{ files: [] }">
                        @csrf
                        
                        <div class="relative">
                            <textarea name="message" rows="5" required
                                      placeholder="{{ __('tickets.reply_placeholder') }}"
                                      class="w-full px-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl focus:ring-0 focus:border-blue-400 focus:bg-white resize-none text-slate-700 placeholder-slate-400 transition-all duration-200"></textarea>
                        </div>
                        
                        @error('message')
                            <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-xl flex items-center gap-2 text-sm text-red-700">
                                <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        
                        <!-- Actions Bar -->
                        <div class="mt-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-3">
                                <label class="cursor-pointer">
                                    <input type="file" name="attachments[]" multiple class="hidden" id="file-input" 
                                           accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx,.txt,.zip,.rar"
                                           @change="files = Array.from($event.target.files)">
                                    <span class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-xl transition-all duration-200 cursor-pointer">
                                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                        </svg>
                                        {{ app()->getLocale() == 'ar' ? 'إرفاق ملفات' : 'Attach files' }}
                                    </span>
                                </label>
                                <span id="file-count" class="text-sm text-slate-500"></span>
                            </div>
                            
                            <button type="submit" 
                                    class="group inline-flex items-center justify-center gap-2.5 px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110 {{ app()->getLocale() == 'ar' ? '-rotate-90' : 'rotate-90' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                                </svg>
                                {{ __('tickets.submit_reply') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <!-- Closed Ticket State -->
            <div class="mt-8 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-8 lg:p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-20 h-20 rounded-2xl bg-emerald-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">{{ app()->getLocale() == 'ar' ? 'تم إغلاق هذه التذكرة' : 'This Ticket is Closed' }}</h3>
                    <p class="text-slate-500 mb-6">{{ app()->getLocale() == 'ar' ? 'شكراً لتواصلك معنا. إذا كنت بحاجة إلى مساعدة إضافية، يرجى فتح تذكرة جديدة.' : 'Thank you for contacting us. If you need further assistance, please open a new ticket.' }}</p>
                    <a href="{{ route('client.tickets.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'فتح تذكرة جديدة' : 'Open New Ticket' }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Close Ticket Modal --}}
@if($ticket->isOpen())
<div id="closeTicketModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    {{-- Background overlay --}}
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" aria-hidden="true" onclick="closeCloseModal()"></div>
    
    {{-- Modal container --}}
    <div class="fixed inset-0 flex items-center justify-center p-4">
        {{-- Modal panel --}}
        <div class="relative w-full max-w-md overflow-hidden text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }} bg-white shadow-2xl rounded-2xl">
            {{-- Modal Header --}}
            <div class="px-6 py-5 bg-gradient-to-r from-red-50 to-orange-50 border-b border-red-100">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-900" id="modal-title">
                            {{ app()->getLocale() == 'ar' ? 'إغلاق التذكرة' : 'Close Ticket' }}
                        </h3>
                        <p class="text-sm text-slate-500">#{{ $ticket->ticket_number }}</p>
                    </div>
                </div>
            </div>
            
            {{-- Modal Body --}}
            <div class="px-6 py-5">
                <p class="text-slate-600 leading-relaxed">
                    {{ app()->getLocale() == 'ar' ? 'هل أنت متأكد من إغلاق هذه التذكرة؟ يمكنك إعادة فتحها لاحقاً إذا كنت بحاجة إلى مساعدة إضافية.' : 'Are you sure you want to close this ticket? You can reopen it later if you need further assistance.' }}
                </p>
            </div>
            
            {{-- Modal Footer --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                <button type="button" 
                        onclick="closeCloseModal()"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-all duration-200">
                    {{ app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
                <form action="{{ route('client.tickets.close', $ticket) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition-all duration-200 shadow-lg shadow-red-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'نعم، إغلاق التذكرة' : 'Yes, Close Ticket' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    // File input handler
    document.getElementById('file-input')?.addEventListener('change', function() {
        const count = this.files.length;
        const countEl = document.getElementById('file-count');
        if (count > 0) {
            countEl.textContent = count + ' {{ app()->getLocale() == "ar" ? "ملف مرفق" : "file(s) attached" }}';
        } else {
            countEl.textContent = '';
        }
    });
    
    // Close Ticket Modal functions
    function openCloseModal() {
        const modal = document.getElementById('closeTicketModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeCloseModal() {
        const modal = document.getElementById('closeTicketModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }
    
    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCloseModal();
        }
    });
</script>

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>
@endsection
