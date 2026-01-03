

<?php $__env->startSection('title', $client->first_name . ' ' . $client->last_name . ' - ' . __('crm.clients')); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-slate-800 to-slate-700 rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute -top-24 <?php echo e(app()->getLocale() == 'ar' ? '-left-24' : '-right-24'); ?> w-48 sm:w-64 h-48 sm:h-64 bg-white/5 rounded-full blur-3xl"></div>
        
        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 sm:h-20 sm:w-20 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-2xl sm:text-3xl font-bold">
                    <?php echo e(strtoupper(substr($client->first_name, 0, 1))); ?><?php echo e(strtoupper(substr($client->last_name, 0, 1))); ?>

                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold"><?php echo e($client->first_name); ?> <?php echo e($client->last_name); ?></h1>
                    <p class="text-white/70 text-sm sm:text-base"><?php echo e('@' . $client->username); ?></p>
                    <?php if($client->company_name): ?>
                        <p class="text-white/60 text-xs sm:text-sm"><?php echo e($client->company_name); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 sm:gap-3">
                <a href="<?php echo e(route('admin.clients.edit', $client)); ?>" class="inline-flex items-center gap-2 bg-white text-slate-800 px-4 py-2 rounded-lg font-semibold hover:bg-slate-100 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <?php echo e(__('crm.edit')); ?>

                </a>
                <a href="<?php echo e(route('admin.clients.index')); ?>" class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-lg font-semibold hover:bg-white/30 transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <?php echo e(__('crm.back')); ?>

                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
        <!-- Status -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.status')); ?></p>
            <?php
                $statusConfig = [
                    'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                    'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'dot' => 'bg-gray-500'],
                    'suspended' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                    'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                ];
                $config = $statusConfig[$client->status] ?? $statusConfig['inactive'];
            ?>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-medium <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?>">
                <span class="w-2 h-2 rounded-full <?php echo e($config['dot']); ?>"></span>
                <?php echo e(ucfirst($client->status)); ?>

            </span>
        </div>

        <!-- Support PIN -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm" x-data="supportPinWidget(<?php echo e($client->id); ?>, '<?php echo e($client->support_pin); ?>', <?php echo e($client->support_pin_expires_at); ?>, <?php echo e(time()); ?>)">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.support_pin')); ?></p>
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold text-blue-600 font-mono tracking-wider" dir="ltr" x-text="pin"></span>
                <span class="text-xs" :class="secondsLeft <= 30 ? 'text-amber-500 font-medium' : 'text-gray-400'" x-text="'(' + formatTime(secondsLeft) + ')'"></span>
            </div>
            <!-- Progress bar -->
            <div class="mt-2 h-1 bg-gray-200 rounded-full overflow-hidden">
                <div class="h-full transition-all duration-1000 rounded-full"
                     :class="secondsLeft <= 30 ? 'bg-amber-500' : 'bg-blue-500'"
                     :style="'width: ' + (secondsLeft / 900 * 100) + '%'"></div>
            </div>
        </div>

        <!-- Online Status -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm" 
             x-data="onlineStatusWidget(<?php echo e($client->id); ?>)" 
             x-init="init()">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.online_status')); ?></p>
            
            <template x-if="isOnline">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <?php echo e(__('crm.online')); ?>

                </span>
            </template>
            
            <template x-if="!isOnline">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                        <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                        <?php echo e(__('crm.offline')); ?>

                    </span>
                    <p class="text-xs text-gray-400 mt-1" x-text="lastSeen || '<?php echo e(__('crm.never')); ?>'"></p>
                </div>
            </template>
        </div>

        <!-- Wallet Balance -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.wallet_balance')); ?></p>
            <p class="text-xl font-bold <?php echo e(($client->wallet_balance ?? 0) > 0 ? 'text-green-600' : 'text-gray-900'); ?>">
                $<?php echo e(number_format($client->wallet_balance ?? 0, 2)); ?>

            </p>
        </div>

        <!-- Services Count -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.services')); ?></p>
            <p class="text-xl font-bold text-blue-600"><?php echo e($client->services()->count()); ?></p>
        </div>

        <!-- Member Since -->
        <div class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
            <p class="text-xs text-gray-500 mb-1"><?php echo e(__('crm.registered')); ?></p>
            <p class="text-sm font-semibold text-gray-900"><?php echo e($client->created_at->format('M d, Y')); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Client Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <?php echo e(__('crm.personal_info')); ?>

                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.first_name')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->first_name); ?></p>
                            </div>
                        </div>

                        <!-- Last Name -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.last_name')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->last_name); ?></p>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.username')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e('@' . $client->username); ?></p>
                            </div>
                        </div>

                        <!-- Company Name -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.company_name')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->company_name ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200"
                             x-data="{
                                 editing: false,
                                 loading: false,
                                 email: '<?php echo e($client->email); ?>',
                                 originalEmail: '<?php echo e($client->email); ?>',
                                 error: '',
                                 async saveEmail() {
                                     if (!this.email || !this.email.includes('@')) {
                                         this.error = '<?php echo e(app()->getLocale() == "ar" ? "بريد إلكتروني غير صحيح" : "Invalid email"); ?>';
                                         return;
                                     }
                                     if (this.email === this.originalEmail) {
                                         this.editing = false;
                                         return;
                                     }
                                     this.loading = true;
                                     this.error = '';
                                     try {
                                         const res = await fetch('<?php echo e(route("admin.clients.update-email", $client)); ?>', {
                                             method: 'POST',
                                             headers: {
                                                 'Content-Type': 'application/json',
                                                 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                             },
                                             body: JSON.stringify({ email: this.email, reset_verification: true })
                                         });
                                         const data = await res.json();
                                         if (data.success) {
                                             this.originalEmail = this.email;
                                             this.editing = false;
                                             location.reload();
                                         } else {
                                             this.error = data.message;
                                         }
                                     } catch (e) {
                                         this.error = '<?php echo e(app()->getLocale() == "ar" ? "حدث خطأ" : "An error occurred"); ?>';
                                     }
                                     this.loading = false;
                                 },
                                 cancel() {
                                     this.email = this.originalEmail;
                                     this.editing = false;
                                     this.error = '';
                                 }
                             }">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.email_address')); ?></p>
                                <!-- View Mode -->
                                <div x-show="!editing" class="flex items-center gap-2 flex-wrap">
                                    <a href="mailto:<?php echo e($client->email); ?>" class="text-sm font-semibold text-blue-600 hover:text-blue-700 hover:underline truncate" x-text="email"></a>
                                    <?php if($client->email_verified_at): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.verified')); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>
                                <!-- Edit Mode -->
                                <div x-show="editing" x-cloak class="space-y-2">
                                    <input type="email" x-model="email" @keyup.enter="saveEmail()" @keyup.escape="cancel()"
                                        class="w-full px-3 py-1.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        :disabled="loading">
                                    <p x-show="error" x-text="error" class="text-xs text-red-600"></p>
                                    <div class="flex items-center gap-2">
                                        <button @click="saveEmail()" :disabled="loading" class="px-3 py-1 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg disabled:opacity-50 flex items-center gap-1">
                                            <svg x-show="loading" class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                            <?php echo e(app()->getLocale() == 'ar' ? 'حفظ' : 'Save'); ?>

                                        </button>
                                        <button @click="cancel()" :disabled="loading" class="px-3 py-1 text-xs font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg disabled:opacity-50">
                                            <?php echo e(app()->getLocale() == 'ar' ? 'إلغاء' : 'Cancel'); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Email Button -->
                            <button x-show="!editing" type="button" @click="editing = true; $nextTick(() => $el.previousElementSibling.querySelector('input')?.focus())" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="<?php echo e(__('crm.edit_email')); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Phone -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.phone')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate" dir="ltr"><?php echo e($client->phone ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- Preferred Language -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.preferred_language')); ?></p>
                                <div class="flex items-center gap-2">
                                    <span class="text-lg"><?php echo e($client->preferred_language == 'ar' ? '🇸🇦' : '🇺🇸'); ?></span>
                                    <p class="text-sm font-semibold text-gray-900"><?php echo e($client->preferred_language == 'ar' ? 'العربية' : 'English'); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Currency -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.currency')); ?></p>
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($client->currency ?? 'USD'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <?php echo e(__('crm.address_info')); ?>

                    </h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Address 1 -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.address')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->address1 ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- Address 2 -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.address2')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->address2 ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- City -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.city')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->city ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- State -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.state')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->state ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- Postcode -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.postcode')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->postcode ?? '-'); ?></p>
                            </div>
                        </div>

                        <!-- Country -->
                        <div class="group flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:bg-white hover:border-gray-200 hover:shadow-sm transition-all duration-200">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-cyan-100 text-cyan-600 flex items-center justify-center group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500 mb-0.5"><?php echo e(__('crm.country')); ?></p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e($client->country ?? '-'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoices/Billing Widget -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <?php echo e(__('crm.invoices_billing')); ?>

                    </h3>
                </div>
                <div class="p-5">
                    <!-- Invoice Status Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                        <!-- Paid -->
                        <div class="bg-green-50 rounded-lg p-3 border border-green-100">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                <span class="text-xs font-medium text-green-700"><?php echo e(__('crm.paid')); ?></span>
                            </div>
                            <p class="text-lg font-bold text-green-600" dir="ltr">$<?php echo e(number_format($invoiceStats['paid'], 2)); ?></p>
                        </div>
                        
                        <!-- Draft -->
                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <span class="text-xs font-medium text-gray-600"><?php echo e(__('crm.draft')); ?></span>
                            </div>
                            <p class="text-lg font-bold text-gray-600" dir="ltr">$<?php echo e(number_format($invoiceStats['draft'], 2)); ?></p>
                        </div>
                        
                        <!-- Unpaid/Due -->
                        <div class="bg-amber-50 rounded-lg p-3 border border-amber-100">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <span class="text-xs font-medium text-amber-700"><?php echo e(__('crm.unpaid')); ?></span>
                            </div>
                            <p class="text-lg font-bold text-amber-600" dir="ltr">$<?php echo e(number_format($invoiceStats['unpaid'], 2)); ?></p>
                        </div>
                        
                        <!-- Cancelled -->
                        <div class="bg-red-50 rounded-lg p-3 border border-red-100">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                <span class="text-xs font-medium text-red-700"><?php echo e(__('crm.cancelled')); ?></span>
                            </div>
                            <p class="text-lg font-bold text-red-600" dir="ltr">$<?php echo e(number_format($invoiceStats['cancelled'], 2)); ?></p>
                        </div>
                        
                        <!-- Refunded -->
                        <div class="bg-purple-50 rounded-lg p-3 border border-purple-100">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-2 h-2 rounded-full bg-purple-500"></div>
                                <span class="text-xs font-medium text-purple-700"><?php echo e(__('crm.refunded')); ?></span>
                            </div>
                            <p class="text-lg font-bold text-purple-600" dir="ltr">$<?php echo e(number_format($invoiceStats['refunded'], 2)); ?></p>
                        </div>
                    </div>
                    
                    <!-- Income Section -->
                    <div class="border-t border-gray-200 pt-4">
                        <h4 class="text-sm font-semibold text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo e(__('crm.income')); ?>

                        </h4>
                        <dl class="space-y-3">
                            <!-- Gross Revenue -->
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600"><?php echo e(__('crm.gross_revenue')); ?></dt>
                                <dd class="text-sm font-semibold text-gray-900" dir="ltr">$<?php echo e(number_format($incomeStats['gross_revenue'], 2)); ?></dd>
                            </div>
                            
                            <!-- Client Expenses -->
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600"><?php echo e(__('crm.client_expenses')); ?></dt>
                                <dd class="text-sm font-semibold text-red-600" dir="ltr">-$<?php echo e(number_format($incomeStats['expenses'], 2)); ?></dd>
                            </div>
                            
                            <!-- Net Income -->
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <dt class="text-sm font-medium text-gray-900"><?php echo e(__('crm.net_income')); ?></dt>
                                <dd class="text-base font-bold <?php echo e($incomeStats['net_income'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>" dir="ltr">
                                    $<?php echo e(number_format($incomeStats['net_income'], 2)); ?>

                                </dd>
                            </div>
                            
                            <!-- Recurring Income -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wide"><?php echo e(__('crm.recurring_income')); ?></span>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-blue-50 rounded-lg p-3">
                                        <span class="text-xs text-blue-600"><?php echo e(__('crm.monthly')); ?></span>
                                        <p class="text-lg font-bold text-blue-700" dir="ltr">$<?php echo e(number_format($incomeStats['monthly_recurring'], 2)); ?></p>
                                    </div>
                                    <div class="bg-indigo-50 rounded-lg p-3">
                                        <span class="text-xs text-indigo-600"><?php echo e(__('crm.yearly')); ?></span>
                                        <p class="text-lg font-bold text-indigo-700" dir="ltr">$<?php echo e(number_format($incomeStats['yearly_recurring'], 2)); ?></p>
                                    </div>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Recent Emails Widget -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <?php echo e(__('crm.recent_emails')); ?>

                    </h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    <?php $__empty_1 = true; $__currentLoopData = $recentEmails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <?php if($email->status === 'sent'): ?>
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                    <?php elseif($email->status === 'failed'): ?>
                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                    <?php else: ?>
                                        <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate" title="<?php echo e($email->subject); ?>">
                                        <?php echo e($email->subject); ?>

                                    </p>
                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($email->type_badge['bg']); ?> <?php echo e($email->type_badge['text']); ?>">
                                            <?php echo e(ucfirst($email->type)); ?>

                                        </span>
                                        <?php
                                            $dateTime = $email->created_at;
                                        ?>
                                        <span class="text-xs text-gray-500"><?php echo e($dateTime->timezone(config('app.timezone'))->format('M d, Y')); ?></span>
                                        <span class="text-xs text-gray-400"><?php echo e($dateTime->timezone(config('app.timezone'))->format('h:i A')); ?></span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        <?php echo e(config('app.timezone')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-4 py-8 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500"><?php echo e(__('crm.no_emails_sent')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Wallet Card -->
            <a href="<?php echo e(route('admin.clients.wallet', $client)); ?>" class="block bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-5 text-white hover:from-slate-700 hover:to-slate-800 transition-all duration-200 group">
                <div class="flex items-center justify-between mb-6">
                    <span class="text-sm text-white/70"><?php echo e(__('crm.wallet_balance')); ?></span>
                    <svg class="w-8 h-8 text-white/30 group-hover:text-white/50 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8zm4-2.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold mb-4">$<?php echo e(number_format($client->wallet_balance ?? 0, 2)); ?></p>
                <?php if($client->wallet_card_number): ?>
                    <p class="text-sm text-white/50 font-mono"><?php echo e($client->wallet_card_number); ?></p>
                <?php endif; ?>
                <div class="mt-3 flex items-center text-xs text-white/50 group-hover:text-white/70 transition-colors">
                    <span><?php echo e(__('crm.view_wallet') ?? 'View Wallet'); ?></span>
                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'mr-1 rotate-180' : 'ml-1'); ?> group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <!-- Other Actions -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        <?php echo e(__('crm.other_actions')); ?>

                    </h3>
                </div>
                <div class="p-3 space-y-2">
                    <!-- View Account Statement -->
                    <a href="<?php echo e(route('admin.clients.statement', $client)); ?>" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium"><?php echo e(__('crm.view_account_statement')); ?></span>
                    </a>

                    <!-- Open New Support Ticket -->
                    <a href="#" onclick="alert('<?php echo e(__('crm.feature_coming_soon') ?? 'Feature coming soon'); ?>'); return false;"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium"><?php echo e(__('crm.open_new_support_ticket')); ?></span>
                    </a>

                    <!-- View All Support Tickets -->
                    <a href="#" onclick="alert('<?php echo e(__('crm.feature_coming_soon') ?? 'Feature coming soon'); ?>'); return false;"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:bg-purple-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium"><?php echo e(__('crm.view_all_support_tickets')); ?></span>
                    </a>

                    <!-- Affiliate Section -->
                    <?php if($client->is_affiliate ?? false): ?>
                        <a href="<?php echo e(route('admin.clients.affiliate', $client)); ?>" 
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors group">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium"><?php echo e(__('crm.view_affiliate_details')); ?></span>
                        </a>
                    <?php else: ?>
                        <button onclick="activateAffiliate(<?php echo e($client->id); ?>)" 
                                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors group">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center group-hover:bg-amber-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium"><?php echo e(__('crm.activate_as_affiliate')); ?></span>
                        </button>
                    <?php endif; ?>

                    <div class="border-t border-gray-200 my-2"></div>

                    <!-- Close Client's Account -->
                    <button onclick="closeClientAccount(<?php echo e($client->id); ?>)" 
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-colors group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center group-hover:bg-orange-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium"><?php echo e(__('crm.close_clients_account')); ?></span>
                    </button>

                    <!-- Delete Client's Account -->
                    <button onclick="deleteClientAccount(<?php echo e($client->id); ?>)" 
                            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors group">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:bg-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium"><?php echo e(__('crm.delete_clients_account')); ?></span>
                    </button>
                </div>
            </div>

            <!-- Security -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <?php echo e(__('crm.security')); ?>

                    </h3>
                </div>
                <div class="p-5 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600"><?php echo e(__('crm.two_factor_auth')); ?></span>
                        <?php if($client->google2fa_enabled): ?>
                            <span class="inline-flex items-center gap-1 text-green-600 text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.enabled')); ?>

                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-gray-400 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.disabled')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600"><?php echo e(__('crm.email_verified')); ?></span>
                        <?php if($client->email_verified_at): ?>
                            <span class="inline-flex items-center gap-1 text-green-600 text-sm font-medium">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.verified')); ?>

                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1 text-amber-500 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.not_verified')); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Activity / Login History -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden"
                 x-data="loginActivityWidget(<?php echo e($client->id); ?>)"
                 x-init="init()">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between flex-wrap gap-2">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <?php echo e(__('crm.login_activity')); ?>

                        </h3>
                        <div class="relative">
                            <select x-model="selectedTimezone" 
                                    @change="fetchActivities()"
                                    class="text-xs border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 pl-3 pr-8 appearance-none bg-white cursor-pointer">
                                <option value="Africa/Cairo">🇪🇬 Cairo</option>
                                <option value="UTC">🌍 UTC</option>
                                <option value="America/New_York">🇺🇸 New York</option>
                                <option value="America/Los_Angeles">🇺🇸 Los Angeles</option>
                                <option value="Europe/London">🇬🇧 London</option>
                                <option value="Europe/Paris">🇫🇷 Paris</option>
                                <option value="Europe/Berlin">🇩🇪 Berlin</option>
                                <option value="Asia/Dubai">🇦🇪 Dubai</option>
                                <option value="Asia/Riyadh">🇸🇦 Riyadh</option>
                                <option value="Asia/Tokyo">🇯🇵 Tokyo</option>
                                <option value="Asia/Singapore">🇸🇬 Singapore</option>
                                <option value="Australia/Sydney">🇦🇺 Sydney</option>
                            </select>
                            <div class="absolute inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'left-0 pl-2' : 'right-0 pr-2'); ?> flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                    <template x-if="activities.length > 0">
                        <template x-for="activity in activities" :key="activity.ip + activity.date + activity.time">
                            <div class="px-4 py-3 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 mt-0.5">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-xs font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded" dir="ltr" x-text="activity.ip"></span>
                                            <span class="text-xs text-gray-500" x-text="activity.date"></span>
                                            <span class="text-xs text-gray-400" x-text="activity.time"></span>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1">
                                            <span x-text="activity.browser + ' on ' + activity.os"></span>
                                        </p>
                                        <p class="text-xs text-blue-500 mt-0.5" x-text="selectedTimezone"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </template>
                    <template x-if="activities.length === 0">
                        <div class="px-4 py-8 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm text-gray-500"><?php echo e(__('crm.no_login_activity')); ?></p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900"><?php echo e(__('crm.quick_actions')); ?></h3>
                </div>
                <div class="p-4 space-y-2">
                    <a href="<?php echo e(route('admin.clients.edit', $client)); ?>" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <?php echo e(__('crm.edit_client')); ?>

                    </a>
                    <a href="#" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <?php echo e(__('crm.send_email')); ?>

                    </a>
                    <a href="#" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <?php echo e(__('crm.add_funds')); ?>

                    </a>
                    <form action="<?php echo e(route('admin.clients.destroy', $client)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_client')); ?>')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            <?php echo e(__('crm.delete_client')); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
        // Categorize services by type
        $sharedHosting = $client->services->filter(function($s) {
            if ($s->type !== 'hosting') return false;
            $productType = $s->orderItem?->configuration['product_type'] ?? null;
            return !in_array(strtolower($productType ?? ''), ['cloud', 'reseller']);
        });
        $cloudHosting = $client->services->filter(function($s) {
            if ($s->type !== 'hosting') return false;
            $productType = $s->orderItem?->configuration['product_type'] ?? null;
            return strtolower($productType ?? '') === 'cloud';
        });
        $resellerHosting = $client->services->filter(function($s) {
            if ($s->type !== 'hosting') return false;
            $productType = $s->orderItem?->configuration['product_type'] ?? null;
            return strtolower($productType ?? '') === 'reseller';
        });
        $vpsServices = $client->services->where('type', 'vps');
        $dedicatedServices = $client->services->where('type', 'dedicated');
    ?>

    <!-- Shared Hosting Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
                <?php echo e(__('crm.shared_hosting') ?? 'Shared Hosting'); ?> (<?php echo e($sharedHosting->count()); ?>)
            </h3>
        </div>
        <?php if($sharedHosting->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.service')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.domain') ?? 'Domain'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.next_due_date')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.amount')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.actions') ?? 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $sharedHosting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900"><?php echo e($service->service_name); ?></td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->domain ?? '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php
                                $serviceStatusConfig = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                    'terminated' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($serviceStatusConfig[$service->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') : '-'); ?></td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">$<?php echo e(number_format($service->recurring_amount ?? 0, 2)); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.services.show', $service->id)); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo e(__('crm.manage') ?? 'Manage'); ?>

                                </a>
                                <form action="<?php echo e(route('admin.services.destroy', $service->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_service') ?? 'Are you sure you want to delete this service?'); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <?php echo e(__('crm.delete') ?? 'Delete'); ?>

                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
            </svg>
            <?php echo e(__('crm.no_shared_hosting') ?? 'No shared hosting services'); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Cloud Hosting Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                </svg>
                <?php echo e(__('crm.cloud_hosting') ?? 'Cloud Hosting'); ?> (<?php echo e($cloudHosting->count()); ?>)
            </h3>
        </div>
        <?php if($cloudHosting->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.service')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.domain') ?? 'Domain'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.next_due_date')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.amount')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.actions') ?? 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $cloudHosting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900"><?php echo e($service->service_name); ?></td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->domain ?? '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php
                                $serviceStatusConfig = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                    'terminated' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($serviceStatusConfig[$service->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') : '-'); ?></td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">$<?php echo e(number_format($service->recurring_amount ?? 0, 2)); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.services.show', $service->id)); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-cyan-700 bg-cyan-50 rounded-lg hover:bg-cyan-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo e(__('crm.manage') ?? 'Manage'); ?>

                                </a>
                                <form action="<?php echo e(route('admin.services.destroy', $service->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_service') ?? 'Are you sure you want to delete this service?'); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <?php echo e(__('crm.delete') ?? 'Delete'); ?>

                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
            </svg>
            <?php echo e(__('crm.no_cloud_hosting') ?? 'No cloud hosting services'); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Reseller Hosting Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <?php echo e(__('crm.reseller_hosting') ?? 'Reseller Hosting'); ?> (<?php echo e($resellerHosting->count()); ?>)
            </h3>
        </div>
        <?php if($resellerHosting->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.service')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.domain') ?? 'Domain'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.next_due_date')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.amount')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.actions') ?? 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $resellerHosting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900"><?php echo e($service->service_name); ?></td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->domain ?? '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php
                                $serviceStatusConfig = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                    'terminated' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($serviceStatusConfig[$service->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') : '-'); ?></td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">$<?php echo e(number_format($service->recurring_amount ?? 0, 2)); ?></td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.services.reseller.show', $service->id)); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-purple-700 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo e(__('crm.manage') ?? 'Manage'); ?>

                                </a>
                                <form action="<?php echo e(route('admin.services.destroy', $service->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_service') ?? 'Are you sure you want to delete this service?'); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <?php echo e(__('crm.delete') ?? 'Delete'); ?>

                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <?php echo e(__('crm.no_reseller_hosting') ?? 'No reseller hosting services'); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- VPS Services Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                </svg>
                <?php echo e(__('crm.vps_servers') ?? 'VPS Servers'); ?> (<?php echo e($vpsServices->count()); ?>)
            </h3>
        </div>
        <?php if($vpsServices->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.service')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.ip_address') ?? 'IP Address'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.next_due_date')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.amount')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $vpsServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900"><?php echo e($service->service_name); ?></td>
                        <td class="px-5 py-4 text-sm text-gray-600 font-mono"><?php echo e($service->ip_address ?? '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php
                                $serviceStatusConfig = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                    'terminated' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($serviceStatusConfig[$service->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') : '-'); ?></td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">$<?php echo e(number_format($service->recurring_amount ?? 0, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
            </svg>
            <?php echo e(__('crm.no_vps_servers') ?? 'No VPS servers'); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Dedicated Servers Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
                <?php echo e(__('crm.dedicated_servers') ?? 'Dedicated Servers'); ?> (<?php echo e($dedicatedServices->count()); ?>)
            </h3>
        </div>
        <?php if($dedicatedServices->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.service')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.ip_address') ?? 'IP Address'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.next_due_date')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.amount')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $dedicatedServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900"><?php echo e($service->service_name); ?></td>
                        <td class="px-5 py-4 text-sm text-gray-600 font-mono"><?php echo e($service->ip_address ?? '-'); ?></td>
                        <td class="px-5 py-4">
                            <?php
                                $serviceStatusConfig = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'suspended' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                    'terminated' => 'bg-gray-100 text-gray-700',
                                    'failed' => 'bg-red-100 text-red-700',
                                ];
                            ?>
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($serviceStatusConfig[$service->status] ?? 'bg-gray-100 text-gray-700'); ?>">
                                <?php echo e(ucfirst($service->status)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($service->next_due_date ? \Carbon\Carbon::parse($service->next_due_date)->format('M d, Y') : '-'); ?></td>
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">$<?php echo e(number_format($service->recurring_amount ?? 0, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
            </svg>
            <?php echo e(__('crm.no_dedicated_servers') ?? 'No dedicated servers'); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Domains Section -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                <?php echo e(__('crm.domains') ?? 'Domains'); ?> (<?php echo e($domains->count()); ?>)
            </h3>
        </div>
        <?php if($domains->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.domain_name') ?? 'Domain Name'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.tld') ?? 'TLD'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.status')); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.registration_date') ?? 'Registration Date'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.expiry_date') ?? 'Expiry Date'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.auto_renew') ?? 'Auto Renew'); ?></th>
                        <th class="px-5 py-3 text-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> text-xs font-semibold text-gray-600 uppercase"><?php echo e(__('crm.actions') ?? 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $domains; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $domain): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-4 text-sm font-medium text-gray-900">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <?php echo e($domain->domain_name); ?>

                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600"><?php echo e($domain->tld); ?></td>
                        <td class="px-5 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($domain->status_color); ?>">
                                <?php echo e($domain->status_label); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">
                            <?php echo e($domain->registration_date ? \Carbon\Carbon::parse($domain->registration_date)->format('M d, Y') : '-'); ?>

                        </td>
                        <td class="px-5 py-4 text-sm text-gray-600">
                            <?php if($domain->expiry_date): ?>
                                <?php
                                    $expiryDate = \Carbon\Carbon::parse($domain->expiry_date);
                                    $daysUntilExpiry = now()->diffInDays($expiryDate, false);
                                ?>
                                <span class="<?php echo e($daysUntilExpiry < 30 ? 'text-red-600 font-semibold' : ($daysUntilExpiry < 90 ? 'text-amber-600' : 'text-gray-600')); ?>">
                                    <?php echo e($expiryDate->format('M d, Y')); ?>

                                    <?php if($daysUntilExpiry < 30 && $daysUntilExpiry > 0): ?>
                                        <span class="text-xs">(<?php echo e($daysUntilExpiry); ?> <?php echo e(__('crm.days_left') ?? 'days left'); ?>)</span>
                                    <?php elseif($daysUntilExpiry <= 0): ?>
                                        <span class="text-xs text-red-600">(<?php echo e(__('crm.expired') ?? 'Expired'); ?>)</span>
                                    <?php endif; ?>
                                </span>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <?php if($domain->auto_renew): ?>
                                <span class="inline-flex items-center gap-1 text-green-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <?php echo e(__('crm.yes') ?? 'Yes'); ?>

                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <?php echo e(__('crm.no') ?? 'No'); ?>

                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.domains.show', $domain->id)); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php echo e(__('crm.manage') ?? 'Manage'); ?>

                                </a>
                                <form action="<?php echo e(route('admin.domains.destroy', $domain->id)); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e(__('crm.confirm_delete_domain') ?? 'Are you sure you want to delete this domain?'); ?>');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <?php echo e(__('crm.delete') ?? 'Delete'); ?>

                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="px-5 py-8 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
            </svg>
            <?php echo e(__('crm.no_domains') ?? 'No domains registered'); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function onlineStatusWidget(clientId) {
        return {
            isOnline: false,
            lastSeen: null,
            interval: null,
            
            init() {
                this.fetchStatus();
                // Update every 10 seconds
                this.interval = setInterval(() => {
                    this.fetchStatus();
                }, 10000);
            },
            
            async fetchStatus() {
                try {
                    const response = await fetch(`/unleasha/clients/${clientId}/online-status`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await response.json();
                    this.isOnline = data.is_online;
                    this.lastSeen = data.last_seen;
                } catch (error) {
                    console.error('Error fetching online status:', error);
                }
            },
            
            destroy() {
                if (this.interval) clearInterval(this.interval);
            }
        };
    }

    function loginActivityWidget(clientId) {
        return {
            activities: [],
            selectedTimezone: 'Africa/Cairo',
            interval: null,
            
            init() {
                this.fetchActivities();
                // Update every 30 seconds
                this.interval = setInterval(() => {
                    this.fetchActivities();
                }, 30000);
            },
            
            async fetchActivities() {
                try {
                    const response = await fetch(`/unleasha/clients/${clientId}/login-activities?timezone=${encodeURIComponent(this.selectedTimezone)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await response.json();
                    this.activities = data.activities;
                } catch (error) {
                    console.error('Error fetching login activities:', error);
                }
            },
            
            destroy() {
                if (this.interval) clearInterval(this.interval);
            }
        };
    }

    function supportPinWidget(clientId, initialPin, initialExpiresAt, initialServerTime) {
        return {
            pin: initialPin,
            expiresAt: initialExpiresAt,
            serverTimeDiff: Math.floor(Date.now() / 1000) - initialServerTime,
            secondsLeft: 0,
            interval: null,
            
            init() {
                this.calculateSecondsLeft();
                this.startTimer();
            },
            
            calculateSecondsLeft() {
                const currentServerTime = Math.floor(Date.now() / 1000) - this.serverTimeDiff;
                this.secondsLeft = Math.max(0, this.expiresAt - currentServerTime);
            },
            
            startTimer() {
                this.interval = setInterval(() => {
                    this.calculateSecondsLeft();
                    if (this.secondsLeft <= 0) {
                        this.fetchPin();
                    }
                }, 1000);
            },
            
            async fetchPin() {
                try {
                    const response = await fetch(`/unleasha/clients/${clientId}/support-pin`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await response.json();
                    this.pin = data.pin;
                    this.expiresAt = data.expires_at;
                    this.serverTimeDiff = Math.floor(Date.now() / 1000) - data.server_time;
                    this.calculateSecondsLeft();
                } catch (error) {
                    console.error('Error fetching support PIN:', error);
                }
            },
            
            formatTime(seconds) {
                if (isNaN(seconds) || seconds === null) return '0:00';
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            },
            
            destroy() {
                if (this.interval) clearInterval(this.interval);
            }
        };
    }

    // Other Actions Functions
    function activateAffiliate(clientId) {
        if (confirm('<?php echo e(__("crm.confirm_activate_affiliate") ?? "Are you sure you want to activate this client as an affiliate?"); ?>')) {
            fetch(`/unleasha/clients/${clientId}/activate-affiliate`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('<?php echo e(__("crm.affiliate_activated_successfully")); ?>');
                    window.location.reload();
                } else {
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while activating affiliate');
            });
        }
    }

    function closeClientAccount(clientId) {
        if (confirm('<?php echo e(__("crm.confirm_close_account")); ?>')) {
            fetch(`/unleasha/clients/${clientId}/close-account`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('<?php echo e(__("crm.account_closed_successfully")); ?>');
                    window.location.reload();
                } else {
                    alert(data.message || 'An error occurred');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while closing account');
            });
        }
    }

    function deleteClientAccount(clientId) {
        if (confirm('<?php echo e(__("crm.confirm_delete_account")); ?>')) {
            // Double confirmation for delete
            if (confirm('<?php echo e(app()->getLocale() == "ar" ? "تأكيد نهائي: هل تريد حذف هذا الحساب نهائياً؟" : "Final confirmation: Do you really want to permanently delete this account?"); ?>')) {
                fetch(`/unleasha/clients/${clientId}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('<?php echo e(__("crm.account_deleted_successfully")); ?>');
                        window.location.href = '<?php echo e(route("admin.clients.index")); ?>';
                    } else {
                        alert(data.message || 'An error occurred');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting account');
                });
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\resources\views/admin/clients/show.blade.php ENDPATH**/ ?>