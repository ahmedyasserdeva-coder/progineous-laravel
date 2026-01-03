@extends('frontend.client.layout')

@section('title', __('tickets.my_tickets'))

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('tickets.my_tickets') }}</h1>
                <p class="text-gray-500 mt-1 text-sm">{{ app()->getLocale() == 'ar' ? 'تتبع وإدارة طلبات الدعم الفني الخاصة بك' : 'Track and manage your support requests' }}</p>
            </div>
            <a href="{{ route('client.tickets.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('tickets.new_ticket') }}
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
        <!-- Total Tickets -->
        <div class="bg-white rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-all duration-200 group">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('tickets.total_tickets') }}</p>
                </div>
            </div>
        </div>

        <!-- Open Tickets -->
        <div class="bg-white rounded-xl p-4 border border-emerald-100 hover:border-emerald-200 transition-all duration-200 group">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-emerald-600">{{ $stats['open'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('tickets.open_tickets') }}</p>
                </div>
            </div>
        </div>

        <!-- Answered Tickets -->
        <div class="bg-white rounded-xl p-4 border border-blue-100 hover:border-blue-200 transition-all duration-200 group">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-blue-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-blue-600">{{ $stats['answered'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('tickets.answered_tickets') }}</p>
                </div>
            </div>
        </div>

        <!-- Closed Tickets -->
        <div class="bg-white rounded-xl p-4 border border-gray-100 hover:border-gray-200 transition-all duration-200 group">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-gray-500 flex items-center justify-center group-hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xl font-bold text-gray-600">{{ $stats['closed'] }}</p>
                    <p class="text-xs text-gray-500">{{ __('tickets.closed_tickets') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tickets Card -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        
        <!-- Filter Bar -->
        <div class="px-5 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white">
            <form action="{{ route('client.tickets.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center gap-3">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="{{ __('tickets.search_placeholder') }}"
                           class="w-full {{ app()->getLocale() == 'ar' ? 'pr-10 pl-4' : 'pl-10 pr-4' }} py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <!-- Status Filter -->
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" 
                            class="appearance-none w-full lg:w-44 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer {{ app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10' }}">
                        <option value="">{{ __('tickets.all_statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('tickets.active_tickets') }}</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('tickets.status_open') }}</option>
                        <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>{{ __('tickets.status_answered') }}</option>
                        <option value="customer_reply" {{ request('status') == 'customer_reply' ? 'selected' : '' }}>{{ __('tickets.status_customer_reply') }}</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('tickets.status_closed') }}</option>
                    </select>
                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                <!-- Department Filter -->
                <div class="relative">
                    <select name="department" onchange="this.form.submit()" 
                            class="appearance-none w-full lg:w-44 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer {{ app()->getLocale() == 'ar' ? 'pl-10' : 'pr-10' }}">
                        <option value="">{{ __('tickets.all_departments') }}</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 {{ app()->getLocale() == 'ar' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                @if(request('search') || request('status') || request('department'))
                    <a href="{{ route('client.tickets.index') }}" 
                       class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ app()->getLocale() == 'ar' ? 'مسح' : 'Clear' }}
                    </a>
                @endif
            </form>
        </div>

        <!-- Tickets List -->
        @if($tickets->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($tickets as $ticket)
                    <a href="{{ route('client.tickets.show', $ticket) }}" 
                       class="flex items-center gap-4 px-5 py-4 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-transparent transition-all duration-200 group">
                        
                        <!-- Status Dot -->
                        <div class="flex-shrink-0">
                            @if($ticket->status == 'open')
                                <div class="relative">
                                    <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                                    <div class="absolute inset-0 w-3 h-3 rounded-full bg-emerald-500 animate-ping opacity-75"></div>
                                </div>
                            @elseif($ticket->status == 'answered')
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            @elseif($ticket->status == 'customer_reply')
                                <div class="relative">
                                    <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                    <div class="absolute inset-0 w-3 h-3 rounded-full bg-amber-500 animate-ping opacity-75"></div>
                                </div>
                            @elseif($ticket->status == 'on_hold')
                                <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            @else
                                <div class="w-3 h-3 rounded-full bg-gray-400"></div>
                            @endif
                        </div>

                        <!-- Ticket Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-mono font-medium bg-gray-100 text-gray-700">
                                    {{ $ticket->ticket_number }}
                                </span>
                                <span class="text-xs text-gray-400">•</span>
                                <span class="text-xs text-gray-500 font-medium">{{ $ticket->department->name }}</span>
                                @if($ticket->priority == 'urgent')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-red-50 text-red-700 ring-1 ring-red-100">
                                        <span class="flex items-center justify-center w-4 h-4 rounded-full bg-red-500">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v2m0 4h.01"/>
                                            </svg>
                                        </span>
                                        {{ $ticket->priority_label }}
                                    </span>
                                @elseif($ticket->priority == 'high')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-700 ring-1 ring-amber-100">
                                        <span class="flex items-center justify-center w-4 h-4 rounded-full bg-amber-500">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                            </svg>
                                        </span>
                                        {{ $ticket->priority_label }}
                                    </span>
                                @elseif($ticket->priority == 'medium')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-blue-100">
                                        <span class="flex items-center justify-center w-4 h-4 rounded-full bg-blue-500">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"/>
                                            </svg>
                                        </span>
                                        {{ $ticket->priority_label }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100">
                                        <span class="flex items-center justify-center w-4 h-4 rounded-full bg-emerald-500">
                                            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                            </svg>
                                        </span>
                                        {{ $ticket->priority_label }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                {{ $ticket->subject }}
                            </h3>
                            <div class="flex items-center gap-2 mt-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-500">
                                    {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <!-- Right Side -->
                        <div class="flex items-center gap-4 flex-shrink-0">
                            <span class="hidden sm:inline-flex px-2.5 py-1 text-xs font-semibold rounded-lg {{ $ticket->status_class }}">
                                {{ $ticket->status_label }}
                            </span>
                            <div class="w-8 h-8 rounded-lg bg-gray-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $tickets->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="py-20 px-4">
                <div class="max-w-sm mx-auto text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('tickets.messages.no_tickets') }}</h3>
                    <p class="text-sm text-gray-500 mb-8">
                        {{ app()->getLocale() == 'ar' ? 'لم يتم العثور على أي تذاكر دعم. أنشئ تذكرة جديدة للحصول على المساعدة من فريقنا.' : 'No support tickets found. Create a new ticket to get help from our team.' }}
                    </p>
                    <a href="{{ route('client.tickets.create') }}" 
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-sm font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-lg shadow-blue-500/25">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('tickets.new_ticket') }}
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Help Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Knowledge Base -->
        <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ app()->getLocale() == 'ar' ? 'قاعدة المعرفة' : 'Knowledge Base' }}</h4>
                    <p class="text-xs text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'اعثر على إجابات للأسئلة الشائعة' : 'Find answers to common questions' }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-blue-500 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>

        <!-- Live Chat -->
        <div class="group relative bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all duration-300 cursor-pointer overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <h4 class="text-sm font-semibold text-gray-900 group-hover:text-emerald-600 transition-colors">{{ app()->getLocale() == 'ar' ? 'الدردشة المباشرة' : 'Live Chat' }}</h4>
                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-emerald-100 text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ app()->getLocale() == 'ar' ? 'متاح' : 'Online' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ app()->getLocale() == 'ar' ? 'تحدث مع فريق الدعم مباشرة' : 'Chat with our support team' }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-300 group-hover:text-emerald-500 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
    </div>

</div>
@endsection
