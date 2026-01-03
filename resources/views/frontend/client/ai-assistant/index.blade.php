@extends('frontend.client.layout')

@section('title', 'Pro Gineous AI')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="bg-gradient-to-br from-blue-50 via-white to-cyan-50 dark:from-slate-950 dark:via-slate-900 dark:to-blue-950">
    <div class="max-w-6xl mx-auto flex flex-col" style="height: calc(80vh - 160px);">
        
        <!-- Modern Header -->
        <div class="flex items-center justify-between px-8 py-6 backdrop-blur-xl bg-white/80 dark:bg-slate-900/80 border-b border-blue-200/50 dark:border-blue-700/50">
            <div class="flex items-center gap-4 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                    <div class="relative w-12 h-12 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center shadow-md shadow-blue-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Pro Gineous AI</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ app()->getLocale() == 'ar' ? 'مساعدك الذكي الاحترافي' : 'Your Professional AI Assistant' }}</p>
                </div>
            </div>
            <button onclick="clearChat()" class="group relative p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200" title="{{ app()->getLocale() == 'ar' ? 'محادثة جديدة' : 'New Chat' }}">
                <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-600 group-hover:rotate-180 transition-all duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </button>
        </div>

        <!-- Chat Container -->
        <div class="flex-1 overflow-y-auto px-8 py-6" id="chat-messages" style="min-height: 300px;">
            <!-- Messages will be added here dynamically -->
        </div>

        <!-- Enhanced Input Area -->
        <div class="px-8 pb-6">
            <div class="max-w-4xl mx-auto">
                <!-- Quick Prompt Suggestions -->
                <div class="mb-4 animate-fade-in">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button onclick="quickPrompt('{{ app()->getLocale() == 'ar' ? 'كم رصيدي الحالي؟' : 'What is my current wallet balance?' }}')" class="group relative px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border border-blue-200 dark:border-blue-700/50 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-2 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ app()->getLocale() == 'ar' ? 'رصيد المحفظة' : 'Wallet Balance' }}</span>
                            </div>
                        </button>

                        <button onclick="quickPrompt('{{ app()->getLocale() == 'ar' ? 'اعرض فواتيري الأخيرة' : 'Show my recent invoices' }}')" class="group relative px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 border border-cyan-200 dark:border-cyan-700/50 hover:border-cyan-400 dark:hover:border-cyan-500 hover:shadow-md hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-2 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ app()->getLocale() == 'ar' ? 'الفواتير' : 'Invoices' }}</span>
                            </div>
                        </button>

                        <button onclick="quickPrompt('{{ app()->getLocale() == 'ar' ? 'كم أنفقت إجمالاً؟' : 'How much have I spent in total?' }}')" class="group relative px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 border border-blue-200 dark:border-blue-700/50 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-2 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ app()->getLocale() == 'ar' ? 'الإنفاق الكلي' : 'Total Spending' }}</span>
                            </div>
                        </button>

                        <button onclick="quickPrompt('{{ app()->getLocale() == 'ar' ? 'ما آخر معاملاتي المالية؟' : 'What are my recent transactions?' }}')" class="group relative px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20 border border-cyan-200 dark:border-cyan-700/50 hover:border-cyan-400 dark:hover:border-cyan-500 hover:shadow-md hover:shadow-cyan-500/10 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="flex items-center gap-2 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                <svg class="w-4 h-4 text-cyan-600 dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ app()->getLocale() == 'ar' ? 'المعاملات' : 'Transactions' }}</span>
                            </div>
                        </button>
                    </div>
                </div>

                <form id="chat-form" class="relative">
                    @csrf
                    <div class="relative group">
                        <!-- Animated gradient border on focus -->
                        <div class="absolute -inset-[2px] bg-gradient-to-r from-blue-600 via-cyan-600 to-blue-600 rounded-3xl opacity-0 group-focus-within:opacity-100 blur-sm transition-all duration-500 animate-gradient"></div>
                        
                        <!-- Main input container -->
                        <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-lg border-2 border-slate-200 dark:border-slate-700 group-focus-within:border-transparent transition-all duration-300">
                            <div class="flex items-end gap-3 p-4 {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                <!-- Textarea with character count -->
                                <div class="flex-1 relative">
                                    <textarea 
                                        id="message-input" 
                                        rows="1" 
                                        maxlength="2000"
                                        class="w-full bg-transparent text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-0 resize-none text-base leading-relaxed {{ app()->getLocale() == 'ar' ? 'text-right' : 'text-left' }} py-2"
                                        placeholder="{{ app()->getLocale() == 'ar' ? 'اكتب رسالتك هنا... (اضغط Enter للإرسال)' : 'Type your message here... (Press Enter to send)' }}"
                                        style="max-height: 200px; min-height: 44px;"
                                    ></textarea>
                                    <!-- Character counter -->
                                    <div class="absolute {{ app()->getLocale() == 'ar' ? 'left-0' : 'right-0' }} bottom-0 text-[10px] text-slate-400 dark:text-slate-500 font-mono">
                                        <span id="char-count">0</span>/2000
                                    </div>
                                </div>
                                
                                <!-- Send button -->
                                <button 
                                    type="submit" 
                                    id="send-btn"
                                    class="relative flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-600 text-white rounded-2xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-md shadow-blue-500/30 hover:shadow-lg hover:shadow-blue-500/40 hover:scale-110 active:scale-95 disabled:hover:scale-100 group/send"
                                >
                                    <svg id="send-icon" class="w-5 h-5 absolute inset-0 m-auto transform group-hover/send:translate-x-0.5 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                    </svg>
                                    <svg id="loading-icon" class="w-5 h-5 absolute inset-0 m-auto animate-spin hidden" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Keyboard shortcuts hint -->
                    <div class="flex items-center justify-between mt-3 px-2">
                        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800/50 px-2.5 py-1.5 rounded-lg">
                                <kbd class="px-1.5 py-0.5 bg-white dark:bg-slate-700 rounded border border-slate-300 dark:border-slate-600 font-mono text-[10px] shadow-sm">Enter</kbd>
                                <span>{{ app()->getLocale() == 'ar' ? 'إرسال' : 'Send' }}</span>
                            </span>
                            <span class="flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800/50 px-2.5 py-1.5 rounded-lg">
                                <kbd class="px-1.5 py-0.5 bg-white dark:bg-slate-700 rounded border border-slate-300 dark:border-slate-600 font-mono text-[10px] shadow-sm">Shift</kbd>
                                <span>+</span>
                                <kbd class="px-1.5 py-0.5 bg-white dark:bg-slate-700 rounded border border-slate-300 dark:border-slate-600 font-mono text-[10px] shadow-sm">Enter</kbd>
                                <span>{{ app()->getLocale() == 'ar' ? 'سطر جديد' : 'New line' }}</span>
                            </span>
                        </div>
                        <div class="text-xs text-slate-400 dark:text-slate-500">
                            <span class="hidden sm:inline">{{ app()->getLocale() == 'ar' ? 'مدعوم بتقنية الذكاء الاصطناعي المتقدمة' : 'Powered by advanced AI technology' }}</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    const sendIcon = document.getElementById('send-icon');
    const loadingIcon = document.getElementById('loading-icon');
    
    let chatHistory = [];
    const isRTL = {{ app()->getLocale() == 'ar' ? 'true' : 'false' }};
    let hasMessages = false;
    
    // Show welcome message from AI on page load
    setTimeout(() => {
        const userName = '{{ auth("client")->user()->first_name ?? "عزيزي" }}';
        const welcomeMessage = isRTL 
            ? `مرحباً ${userName}! 👋 يسعدني جداً مساعدتك اليوم!\n\nأنا ممثل خدمة العملاء الخاص بك في ProGineous AI، وأنا هنا لتقديم أفضل تجربة لك. 😊\n\n✨ يمكنني مساعدتك في:\n\n💰 الاستعلام عن رصيد محفظتك والمعاملات المالية\n📄 عرض وشرح تفاصيل فواتيرك بوضوح\n💳 تتبع جميع معاملاتك وإجراءاتك\n📊 تقديم ملخصات شاملة عن نشاطك\n\n🎯 هدفي الأساسي هو توفير تجربة سلسة ومريحة لك!\n\nلا تتردد أبداً في سؤالي عن أي شيء، فأنا هنا للمساعدة. يمكنك استخدام الأزرار السريعة أدناه أو كتابة استفسارك مباشرة. 🌟`
            : `Hello ${userName}! 👋 I'm delighted to assist you today!\n\nI'm your dedicated customer service representative at ProGineous AI, and I'm here to provide you with the best experience possible. 😊\n\n✨ I'm happy to help you with:\n\n💰 Checking your wallet balance and financial transactions\n📄 Viewing and explaining your invoice details clearly\n💳 Tracking all your transactions and activities\n📊 Providing comprehensive summaries of your account\n\n🎯 My main goal is to ensure a smooth and comfortable experience for you!\n\nPlease don't hesitate to ask me anything - I'm here to help! You can use the quick buttons below or type your question directly. 🌟`;
        
        addMessage('ai', welcomeMessage);
    }, 800);
    
    // Auto-resize textarea with smooth animation
    messageInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 200) + 'px';
        
        // Update character count
        const charCount = this.value.length;
        document.getElementById('char-count').textContent = charCount;
        
        // Change color based on character limit
        const counter = document.getElementById('char-count');
        if (charCount > 1800) {
            counter.classList.add('text-red-500', 'font-bold');
            counter.classList.remove('text-slate-400');
        } else if (charCount > 1500) {
            counter.classList.add('text-amber-500');
            counter.classList.remove('text-slate-400', 'text-red-500', 'font-bold');
        } else {
            counter.classList.remove('text-amber-500', 'text-red-500', 'font-bold');
            counter.classList.add('text-slate-400');
        }
    });
    
    // Quick prompts - Send directly
    window.quickPrompt = async function(text) {
        console.log('Quick prompt clicked:', text);
        
        // Mark that we have messages (don't clear welcome)
        hasMessages = true;
        
        // Add user message
        addMessage('user', text);
        chatHistory.push({ role: 'user', content: text });
        
        // Show loading
        setLoading(true);
        
        try {
            const response = await fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ messages: chatHistory })
            });
            
            const data = await response.json();
            console.log('API Response:', data);
            
            if (data.success) {
                // Check if response contains Intercom trigger
                if (data.response.includes('[OPEN_INTERCOM]')) {
                    // Remove the marker from the message
                    const cleanResponse = data.response.replace('[OPEN_INTERCOM]', '').trim();
                    addMessage('ai', cleanResponse);
                    chatHistory.push({ role: 'model', content: cleanResponse });
                    
                    // Open Intercom after a short delay
                    setTimeout(() => {
                        if (typeof showIntercom === 'function') {
                            showIntercom();
                        } else if (typeof Intercom !== 'undefined') {
                            Intercom('show');
                        } else {
                            console.log('Intercom not available');
                        }
                    }, 1000);
                } else {
                    addMessage('ai', data.response);
                    chatHistory.push({ role: 'model', content: data.response });
                }
            } else {
                addMessage('error', isRTL ? 'حدث خطأ في الاتصال' : 'Connection error');
            }
        } catch (error) {
            console.error('Error in quickPrompt:', error);
            addMessage('error', isRTL ? 'حدث خطأ، حاول مرة أخرى' : 'An error occurred');
        } finally {
            setLoading(false);
        }
    };
    
    // Clear chat
    window.clearChat = function() {
        if (hasMessages && confirm(isRTL ? 'هل تريد بدء محادثة جديدة؟' : 'Start a new conversation?')) {
            location.reload();
        }
    };
    
    // Handle Enter key
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });
    
    // Handle form submit
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;
        
        // Mark that we have messages
        hasMessages = true;
        
        // Add user message
        addMessage('user', message);
        
        // Clear input
        messageInput.value = '';
        messageInput.style.height = 'auto';
        
        // Add to history
        chatHistory.push({ role: 'user', content: message });
        
        // Show loading
        setLoading(true);
        
        try {
            const response = await fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ messages: chatHistory })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Check if response contains Intercom trigger
                if (data.response.includes('[OPEN_INTERCOM]')) {
                    // Remove the marker from the message
                    const cleanResponse = data.response.replace('[OPEN_INTERCOM]', '').trim();
                    addMessage('ai', cleanResponse);
                    chatHistory.push({ role: 'model', content: cleanResponse });
                    
                    // Open Intercom after a short delay
                    setTimeout(() => {
                        if (typeof showIntercom === 'function') {
                            showIntercom();
                        } else if (typeof Intercom !== 'undefined') {
                            Intercom('show');
                        } else {
                            console.log('Intercom not available');
                        }
                    }, 1000);
                } else {
                    addMessage('ai', data.response);
                    chatHistory.push({ role: 'model', content: data.response });
                }
            } else {
                addMessage('error', isRTL ? 'حدث خطأ في الاتصال' : 'Connection error');
            }
        } catch (error) {
            addMessage('error', isRTL ? 'حدث خطأ، حاول مرة أخرى' : 'An error occurred');
        } finally {
            setLoading(false);
        }
    });
    
    function addMessage(type, content) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message-fade-in mb-6';
        
        // Detect if content is RTL (Arabic, Hebrew, etc.)
        const isContentRTL = /[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/.test(content);
        const textDirection = isContentRTL ? 'rtl' : 'ltr';
        
        if (type === 'user') {
            messageDiv.innerHTML = `
                <div class="flex ${isRTL ? 'justify-start' : 'justify-end'}">
                    <div class="max-w-2xl group">
                        <div class="relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-3xl blur opacity-10 group-hover:opacity-20 transition duration-300"></div>
                            <div class="relative bg-gradient-to-br from-blue-600 to-cyan-600 text-white rounded-3xl ${isRTL ? 'rounded-tr-md' : 'rounded-tl-md'} px-5 py-4 shadow-md shadow-blue-500/15">
                                <p class="text-sm leading-relaxed whitespace-pre-wrap" dir="${textDirection}">${escapeHtml(content)}</p>
                            </div>
                        </div>
                        <div class="text-xs text-slate-400 mt-2 px-2 ${isRTL ? 'text-left' : 'text-right'}">${getTimestamp()}</div>
                    </div>
                </div>
            `;
        } else if (type === 'ai') {
            const messageId = 'ai-msg-' + Date.now();
            messageDiv.innerHTML = `
                <div class="flex ${isRTL ? 'justify-end' : 'justify-start'}">
                    <div class="max-w-2xl group">
                        <div class="flex items-start gap-3 ${isRTL ? 'flex-row-reverse' : ''}">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-2xl flex items-center justify-center shadow-md shadow-blue-500/15">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="bg-white dark:bg-slate-800 rounded-3xl ${isRTL ? 'rounded-tr-md' : 'rounded-tl-md'} px-5 py-4 shadow-md border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-sm font-semibold text-blue-600 dark:text-cyan-400">Pro Gineous AI</div>
                                        <button onclick="copyResponse('${messageId}')" class="flex items-center gap-1.5 px-2 py-1 rounded-lg text-xs text-slate-500 hover:text-blue-600 dark:text-slate-400 dark:hover:text-cyan-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200 group/copy">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="hidden group-hover/copy:inline">${isRTL ? 'نسخ' : 'Copy'}</span>
                                        </button>
                                    </div>
                                    <div id="${messageId}" class="text-sm leading-relaxed text-slate-700 dark:text-slate-200 whitespace-pre-wrap" dir="${textDirection}">${formatAIResponse(content)}</div>
                                </div>
                                <div class="text-xs text-slate-400 mt-2 px-2 ${isRTL ? 'text-right' : 'text-left'}">${getTimestamp()}</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (type === 'error') {
            messageDiv.innerHTML = `
                <div class="flex justify-center">
                    <div class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-2xl px-4 py-3 text-sm flex items-center gap-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        ${escapeHtml(content)}
                    </div>
                </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTo({
            top: chatMessages.scrollHeight,
            behavior: 'smooth'
        });
    }
    
    function setLoading(loading) {
        if (sendBtn) sendBtn.disabled = loading;
        if (messageInput) messageInput.disabled = loading;
        if (loading) {
            if (sendIcon) sendIcon.classList.add('hidden');
            if (loadingIcon) loadingIcon.classList.remove('hidden');
            
            // Add typing indicator
            const typingDiv = document.createElement('div');
            typingDiv.id = 'typing-indicator';
            typingDiv.className = 'flex items-start gap-3 mb-4 animate-fade-in';
            typingDiv.innerHTML = `
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center shadow-md shadow-blue-500/20 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7zm2.85 11.1l-.85.6V16h-4v-2.3l-.85-.6C7.8 12.16 7 10.63 7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.15 4.1z"/>
                    </svg>
                </div>
                <div class="flex-1 backdrop-blur-sm bg-white/80 dark:bg-slate-800/80 rounded-2xl px-5 py-4 shadow-sm border border-blue-100/50 dark:border-blue-800/50">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="font-semibold text-blue-600 dark:text-cyan-400">Pro Gineous AI</span>
                        <span class="text-xs text-slate-400">${isRTL ? 'يكتب' : 'Typing'}...</span>
                    </div>
                    <div class="flex gap-1.5">
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-2 h-2 bg-blue-500 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                </div>
            `;
            chatMessages.appendChild(typingDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        } else {
            if (sendIcon) sendIcon.classList.remove('hidden');
            if (loadingIcon) loadingIcon.classList.add('hidden');
            
            // Remove typing indicator
            const typingIndicator = document.getElementById('typing-indicator');
            if (typingIndicator) {
                typingIndicator.remove();
            }
        }
    }
    
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    function formatAIResponse(text) {
        text = escapeHtml(text);
        
        // Bold text
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong class="font-bold text-slate-900 dark:text-white">$1</strong>');
        
        // Inline code
        text = text.replace(/`([^`]+)`/g, '<code class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-cyan-300 px-2 py-1 rounded-lg text-xs font-mono">$1</code>');
        
        // Lists
        text = text.replace(/^- (.+)$/gm, '<li class="ml-4 mb-1">• $1</li>');
        
        return text;
    }
    
    function getTimestamp() {
        const now = new Date();
        return now.toLocaleTimeString(isRTL ? 'ar-EG' : 'en-US', { 
            hour: '2-digit', 
            minute: '2-digit'
        });
    }
    
    // Copy response function
    window.copyResponse = async function(messageId) {
        const element = document.getElementById(messageId);
        if (!element) return;
        
        const text = element.textContent;
        const button = event.target.closest('button');
        if (!button) return;
        
        try {
            await navigator.clipboard.writeText(text);
            
            // Show success feedback
            const originalHTML = button.innerHTML;
            
            button.innerHTML = `
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span class="text-green-500 font-medium">${isRTL ? 'تم النسخ!' : 'Copied!'}</span>
            `;
            button.disabled = true;
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }, 2000);
        } catch (err) {
            console.error('Failed to copy:', err);
            // Show error feedback
            const originalHTML = button.innerHTML;
            button.innerHTML = `
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                <span class="text-red-500">${isRTL ? 'فشل النسخ' : 'Failed'}</span>
            `;
            setTimeout(() => {
                button.innerHTML = originalHTML;
            }, 2000);
        }
    };
});
</script>

<style>
.message-fade-in {
    animation: messageFadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes messageFadeIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

#chat-messages {
    scrollbar-width: thin;
    scrollbar-color: rgba(139, 92, 246, 0.3) transparent;
}

#chat-messages::-webkit-scrollbar {
    width: 6px;
}

#chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, rgba(37, 99, 235, 0.4), rgba(6, 182, 212, 0.4));
    border-radius: 3px;
}

#chat-messages::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, rgba(37, 99, 235, 0.6), rgba(6, 182, 212, 0.6));
}

/* Smooth transitions */
* {
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Glassmorphism effect */
.backdrop-blur-xl {
    backdrop-filter: blur(16px);
}

/* Animated gradient for input border */
@keyframes gradient {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.animate-gradient {
    background-size: 200% 200%;
    animation: gradient 3s ease infinite;
}

/* Input focus glow effect */
#chat-form .group:focus-within {
    filter: drop-shadow(0 0 20px rgba(37, 99, 235, 0.15));
}

/* Remove all focus outlines and rings */
textarea:focus,
input:focus,
button:focus {
    outline: none !important;
    box-shadow: none !important;
    border-color: inherit !important;
}

#message-input:focus {
    outline: 0 !important;
    box-shadow: none !important;
    ring: 0 !important;
}
</style>
@endpush
@endsection
