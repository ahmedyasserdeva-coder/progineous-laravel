@extends('admin.layout')

@section('title', __('crm.support_overview'))

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ __('crm.support_overview') }}</h1>
                <p class="text-slate-500 mt-1">{{ app()->getLocale() == 'ar' ? 'نظرة عامة على نظام الدعم الفني' : 'Overview of support system' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500">{{ now()->format('M d, Y') }}</span>
                <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    {{ app()->getLocale() == 'ar' ? 'كل التذاكر' : 'All Tickets' }}
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Action Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Needs Response -->
        <a href="{{ route('admin.tickets.index', ['status' => 'customer_reply']) }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 p-5 transition-all hover:shadow-lg hover:shadow-orange-500/20 hover:-translate-y-0.5">
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 {{ app()->getLocale() == 'ar' ? '-translate-x-1/2' : 'translate-x-1/2' }}"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/70 group-hover:translate-x-1 transition-transform {{ app()->getLocale() == 'ar' ? 'rotate-180 group-hover:-translate-x-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['customer_reply'] }}</p>
                <p class="text-sm text-white/90 font-medium">{{ app()->getLocale() == 'ar' ? 'تحتاج ردك' : 'Need Response' }}</p>
            </div>
        </a>

        <!-- Open Tickets -->
        <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 p-5 transition-all hover:shadow-lg hover:shadow-blue-500/20 hover:-translate-y-0.5">
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 {{ app()->getLocale() == 'ar' ? '-translate-x-1/2' : 'translate-x-1/2' }}"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/70 group-hover:translate-x-1 transition-transform {{ app()->getLocale() == 'ar' ? 'rotate-180 group-hover:-translate-x-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['open'] }}</p>
                <p class="text-sm text-white/90 font-medium">{{ app()->getLocale() == 'ar' ? 'مفتوحة' : 'Open' }}</p>
            </div>
        </a>

        <!-- Unassigned -->
        <a href="{{ route('admin.tickets.index', ['assigned' => 'unassigned']) }}" class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 p-5 transition-all hover:shadow-lg hover:shadow-red-500/20 hover:-translate-y-0.5">
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 {{ app()->getLocale() == 'ar' ? '-translate-x-1/2' : 'translate-x-1/2' }}"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-white/70 group-hover:translate-x-1 transition-transform {{ app()->getLocale() == 'ar' ? 'rotate-180 group-hover:-translate-x-1' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $stats['unassigned'] }}</p>
                <p class="text-sm text-white/90 font-medium">{{ app()->getLocale() == 'ar' ? 'غير مُسندة' : 'Unassigned' }}</p>
            </div>
        </a>

        <!-- Resolved Today -->
        <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="block relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-5 transition-all hover:shadow-lg hover:shadow-emerald-500/20 hover:scale-[1.02]">
            <div class="absolute top-0 {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 {{ app()->getLocale() == 'ar' ? '-translate-x-1/2' : 'translate-x-1/2' }}"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs text-white/80 font-semibold bg-white/20 px-2 py-1 rounded-lg">{{ app()->getLocale() == 'ar' ? 'اليوم' : 'Today' }}</span>
                </div>
                <p class="text-3xl font-bold text-white mb-1">{{ $todayStats['closed'] }}</p>
                <p class="text-sm text-white/90 font-medium">{{ app()->getLocale() == 'ar' ? 'تم حلها' : 'Resolved' }}</p>
            </div>
        </a>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Left Column -->
        <div class="col-span-12 xl:col-span-8 space-y-6">
            <!-- Status Overview -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="text-base font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'حالة التذاكر' : 'Ticket Status' }}</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                        <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="text-center p-4 rounded-xl bg-blue-50 hover:bg-blue-100 border-2 border-transparent hover:border-blue-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mx-auto mb-3 ring-4 ring-blue-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-blue-600 transition-colors">{{ $stats['open'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'مفتوحة' : 'Open' }}</p>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['status' => 'customer_reply']) }}" class="text-center p-4 rounded-xl bg-orange-50 hover:bg-orange-100 border-2 border-transparent hover:border-orange-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-orange-500 mx-auto mb-3 ring-4 ring-orange-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-orange-600 transition-colors">{{ $stats['customer_reply'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'رد العميل' : 'Customer Reply' }}</p>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['status' => 'answered']) }}" class="text-center p-4 rounded-xl bg-emerald-50 hover:bg-emerald-100 border-2 border-transparent hover:border-emerald-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 mx-auto mb-3 ring-4 ring-emerald-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $stats['answered'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'تم الرد' : 'Answered' }}</p>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}" class="text-center p-4 rounded-xl bg-cyan-50 hover:bg-cyan-100 border-2 border-transparent hover:border-cyan-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-cyan-500 mx-auto mb-3 ring-4 ring-cyan-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-cyan-600 transition-colors">{{ $stats['in_progress'] ?? 0 }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'قيد المعالجة' : 'In Progress' }}</p>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['status' => 'on_hold']) }}" class="text-center p-4 rounded-xl bg-amber-50 hover:bg-amber-100 border-2 border-transparent hover:border-amber-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-amber-500 mx-auto mb-3 ring-4 ring-amber-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-amber-600 transition-colors">{{ $stats['on_hold'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'معلقة' : 'On Hold' }}</p>
                        </a>
                        <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="text-center p-4 rounded-xl bg-slate-50 hover:bg-slate-100 border-2 border-transparent hover:border-slate-200 transition-all group">
                            <div class="w-3 h-3 rounded-full bg-slate-400 mx-auto mb-3 ring-4 ring-slate-100"></div>
                            <p class="text-2xl font-bold text-slate-800 group-hover:text-slate-600 transition-colors">{{ $stats['closed'] }}</p>
                            <p class="text-xs text-slate-500 mt-1 font-medium">{{ app()->getLocale() == 'ar' ? 'مغلقة' : 'Closed' }}</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'نشاط آخر 7 أيام' : 'Last 7 Days Activity' }}</h2>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-xs text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'جديدة' : 'New' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'مغلقة' : 'Closed' }}</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <canvas id="ticketsChart" height="100"></canvas>
                </div>
            </div>

            <!-- Recent Tickets -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-base font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'أحدث التذاكر' : 'Recent Tickets' }}</h2>
                    <a href="{{ route('admin.tickets.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        {{ app()->getLocale() == 'ar' ? 'عرض الكل' : 'View All' }} →
                    </a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($recentTickets as $ticket)
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="flex items-center gap-4 px-6 py-4 hover:bg-slate-50 transition-colors group">
                        <!-- Priority -->
                        <div class="flex-shrink-0">
                            @if($ticket->priority == 'urgent')
                                <span class="relative flex h-3 w-3"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
                            @elseif($ticket->priority == 'high')
                                <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                            @elseif($ticket->priority == 'medium')
                                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            @else
                                <span class="w-3 h-3 rounded-full bg-slate-400"></span>
                            @endif
                        </div>
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-mono text-slate-400">#{{ $ticket->ticket_number }}</span>
                                @php
                                    $statusColors = [
                                        'open' => 'bg-blue-100 text-blue-700',
                                        'customer_reply' => 'bg-orange-100 text-orange-700',
                                        'answered' => 'bg-emerald-100 text-emerald-700',
                                        'in_progress' => 'bg-cyan-100 text-cyan-700',
                                        'on_hold' => 'bg-amber-100 text-amber-700',
                                        'closed' => 'bg-slate-100 text-slate-600',
                                    ];
                                @endphp
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full {{ $statusColors[$ticket->status] ?? $statusColors['open'] }}">
                                    {{ $ticket->status_label }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-700 truncate group-hover:text-slate-900 font-medium transition-colors">{{ $ticket->subject }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $ticket->client->full_name ?? 'N/A' }} · {{ $ticket->created_at->diffForHumans() }}</p>
                        </div>
                        <!-- Arrow -->
                        <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-500 transition-colors {{ app()->getLocale() == 'ar' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    @empty
                    <div class="px-6 py-16 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                        </div>
                        <p class="text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'لا توجد تذاكر حتى الآن' : 'No tickets yet' }}</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-span-12 xl:col-span-4 space-y-6">
            <!-- Urgent Attention -->
            @if($urgentTickets->isNotEmpty())
            <div class="bg-white rounded-2xl border-2 border-red-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-red-50 border-b border-red-100 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h2 class="text-sm font-semibold text-red-700">{{ app()->getLocale() == 'ar' ? 'تحتاج اهتمام عاجل' : 'Needs Urgent Attention' }}</h2>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach($urgentTickets->take(4) as $ticket)
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="block px-5 py-3 hover:bg-red-50 transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="w-2 h-2 rounded-full {{ $ticket->priority == 'urgent' ? 'bg-red-500 animate-pulse' : 'bg-orange-500' }}"></span>
                            <span class="text-xs text-slate-400 font-mono">#{{ $ticket->ticket_number }}</span>
                        </div>
                        <p class="text-sm text-slate-700 truncate font-medium">{{ $ticket->subject }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $ticket->created_at->diffForHumans() }}</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'إحصائيات سريعة' : 'Quick Stats' }}</h2>
                </div>
                <div class="p-5 space-y-4">
                    <!-- Avg Response -->
                    <div class="flex items-center justify-between p-4 rounded-xl bg-emerald-50 border border-emerald-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm text-slate-600 font-medium">{{ app()->getLocale() == 'ar' ? 'متوسط وقت الرد' : 'Avg Response' }}</span>
                        </div>
                        <span class="text-xl font-bold text-emerald-700">{{ $avgResponseTime }}<span class="text-xs text-emerald-600 font-medium {{ app()->getLocale() == 'ar' ? 'mr-0.5' : 'ml-0.5' }}">{{ app()->getLocale() == 'ar' ? 'س' : 'h' }}</span></span>
                    </div>

                    <!-- Today -->
                    <div class="p-4 rounded-xl bg-blue-50 border border-blue-100">
                        <p class="text-xs text-blue-600 uppercase tracking-wide font-semibold mb-3">{{ app()->getLocale() == 'ar' ? 'اليوم' : 'Today' }}</p>
                        <div class="grid grid-cols-3 gap-3">
                            <div class="text-center p-2 bg-white rounded-lg">
                                <p class="text-lg font-bold text-blue-600">{{ $todayStats['new'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'جديدة' : 'New' }}</p>
                            </div>
                            <div class="text-center p-2 bg-white rounded-lg">
                                <p class="text-lg font-bold text-emerald-600">{{ $todayStats['closed'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'مغلقة' : 'Closed' }}</p>
                            </div>
                            <div class="text-center p-2 bg-white rounded-lg">
                                <p class="text-lg font-bold text-slate-700">{{ $todayStats['replies'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'ردود' : 'Replies' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- This Week -->
                    <div class="p-4 rounded-xl bg-amber-50 border border-amber-100">
                        <p class="text-xs text-amber-600 uppercase tracking-wide font-semibold mb-3">{{ app()->getLocale() == 'ar' ? 'هذا الأسبوع' : 'This Week' }}</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="text-center p-2 bg-white rounded-lg">
                                <p class="text-lg font-bold text-blue-600">{{ $weekStats['new'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'جديدة' : 'New' }}</p>
                            </div>
                            <div class="text-center p-2 bg-white rounded-lg">
                                <p class="text-lg font-bold text-emerald-600">{{ $weekStats['closed'] }}</p>
                                <p class="text-[10px] text-slate-500 font-medium">{{ app()->getLocale() == 'ar' ? 'مغلقة' : 'Closed' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Priority Distribution -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'توزيع الأولويات' : 'Priority Distribution' }}</h2>
                </div>
                <div class="p-5 space-y-4">
                    @php
                        $totalPriority = max(1, $priorityStats['urgent'] + $priorityStats['high'] + $priorityStats['medium'] + $priorityStats['low']);
                    @endphp
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <span class="flex-1 text-sm text-slate-600 font-medium">{{ app()->getLocale() == 'ar' ? 'عاجل' : 'Urgent' }}</span>
                        <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-red-500 rounded-full transition-all" style="width: {{ ($priorityStats['urgent'] / $totalPriority) * 100 }}%"></div>
                        </div>
                        <span class="w-8 text-sm font-bold text-slate-700 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">{{ $priorityStats['urgent'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                        <span class="flex-1 text-sm text-slate-600 font-medium">{{ app()->getLocale() == 'ar' ? 'عالي' : 'High' }}</span>
                        <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-orange-500 rounded-full transition-all" style="width: {{ ($priorityStats['high'] / $totalPriority) * 100 }}%"></div>
                        </div>
                        <span class="w-8 text-sm font-bold text-slate-700 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">{{ $priorityStats['high'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <span class="flex-1 text-sm text-slate-600 font-medium">{{ app()->getLocale() == 'ar' ? 'متوسط' : 'Medium' }}</span>
                        <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full transition-all" style="width: {{ ($priorityStats['medium'] / $totalPriority) * 100 }}%"></div>
                        </div>
                        <span class="w-8 text-sm font-bold text-slate-700 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">{{ $priorityStats['medium'] }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="flex-1 text-sm text-slate-600 font-medium">{{ app()->getLocale() == 'ar' ? 'منخفض' : 'Low' }}</span>
                        <div class="w-24 h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all" style="width: {{ ($priorityStats['low'] / $totalPriority) * 100 }}%"></div>
                        </div>
                        <span class="w-8 text-sm font-bold text-slate-700 text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">{{ $priorityStats['low'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Departments -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'الأقسام' : 'Departments' }}</h2>
                </div>
                <div class="p-5 space-y-3">
                    @foreach($departmentStats as $dept)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                        <span class="text-sm text-slate-700 font-medium">{{ $dept->name }}</span>
                        <div class="flex items-center gap-2">
                            @if($dept->open_tickets_count > 0)
                            <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-0.5 rounded-full">{{ $dept->open_tickets_count }}</span>
                            @endif
                            <span class="text-sm font-bold text-slate-700 bg-white px-2.5 py-1 rounded-lg border border-slate-200">{{ $dept->tickets_count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Team Performance -->
            @if($staffPerformance->filter(fn($s) => $s->replies_count > 0)->isNotEmpty())
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100">
                    <h2 class="text-sm font-semibold text-slate-800">{{ app()->getLocale() == 'ar' ? 'أداء الفريق' : 'Team Performance' }}</h2>
                    <p class="text-xs text-slate-400 mt-0.5">{{ app()->getLocale() == 'ar' ? 'هذا الشهر' : 'This month' }}</p>
                </div>
                <div class="p-5 space-y-4">
                    @foreach($staffPerformance->filter(fn($s) => $s->replies_count > 0)->take(5) as $staff)
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-xs font-bold text-white shadow-sm">
                            {{ strtoupper(substr($staff->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-slate-700 truncate font-medium">{{ $staff->name }}</p>
                            <p class="text-xs text-slate-400">{{ $staff->replies_count }} {{ app()->getLocale() == 'ar' ? 'رد' : 'replies' }}</p>
                        </div>
                        <div class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                            <p class="text-base font-bold text-emerald-600">{{ $staff->closed_tickets }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">{{ app()->getLocale() == 'ar' ? 'مغلقة' : 'closed' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: '{{ app()->getLocale() == "ar" ? "جديدة" : "New" }}',
                    data: {!! json_encode($chartData['new']) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(59, 130, 246)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                },
                {
                    label: '{{ app()->getLocale() == "ar" ? "مغلقة" : "Closed" }}',
                    data: {!! json_encode($chartData['closed']) !!},
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgb(16, 185, 129)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 8,
                    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1)'
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { 
                        color: '#64748b',
                        font: { size: 11, weight: '500' }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: { 
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: { 
                        color: '#64748b',
                        stepSize: 1,
                        font: { size: 11, weight: '500' }
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
