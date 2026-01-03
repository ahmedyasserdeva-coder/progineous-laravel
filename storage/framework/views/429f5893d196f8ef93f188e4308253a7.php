<?php
    // Set default language if not already set in session
    if (!session()->has('locale')) {
        $defaultLanguage = setting('default_language', 'ar');
        app()->setLocale($defaultLanguage);
        session()->put('locale', $defaultLanguage);
    }
?>
<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', app()->getLocale() == 'ar' ? 'لوحة التحكم - Pro Gineous' : 'Dashboard - Pro Gineous'); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', app()->getLocale() == 'ar' ? 'لوحة تحكم إدارة شركة Pro Gineous' : 'Pro Gineous Company Management Dashboard'); ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('logo/pro Gineous Blue_defult icon.png')); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo e(asset('logo/pro Gineous Blue_defult icon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('logo/pro Gineous Blue_defult icon.png')); ?>">
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Flag Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php if(app()->getLocale() == 'ar'): ?>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php else: ?>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php endif; ?>
    
    <style>
        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }
        
        body {
            font-family: <?php echo e(app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif"); ?>;
        }
        
        /* Flag Icons - Rounded Corners */
        .fi {
            border-radius: 0.375rem; /* 6px rounded corners */
            overflow: hidden;
            display: inline-block;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(148, 163, 184, 0.1);
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.5);
            border-radius: 2px;
        }
        
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.7);
        }

        /* Sidebar transition */
        .sidebar-collapsed {
            width: 4rem !important;
        }
        
        .sidebar-item-icon {
            transition: all 0.3s ease;
        }
        
        /* Header height adjustments */
        .header-height {
            height: 60px;
        }
        
        @media (min-width: 640px) {
            .header-height {
                height: 68px;
            }
        }
        
        /* Smooth animations */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Custom backdrop blur */
        .backdrop-blur-custom {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        
        /* Enhanced shadows */
        .shadow-custom {
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        /* Improved focus states */
        .focus-ring:focus {
            outline: 2px solid rgb(59 130 246);
            outline-offset: 2px;
        }
        
        /* تحسين التدرجات اللونية */
        .avatar-gradient-smooth {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease-in-out infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        /* تأثير النعومة والإضاءة */
        .avatar-glow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 
                        0 1px 4px rgba(0, 0, 0, 0.1),
                        inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        
        .avatar-glow:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2), 
                        0 2px 8px rgba(0, 0, 0, 0.15),
                        inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 overflow-x-hidden">
    <div class="min-h-screen flex overflow-x-hidden" x-data="sidebarController()" x-init="init()">
        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-all ease-out duration-400"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition-all ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-105"
             @click="closeMobileMenu()"
             class="fixed inset-0 glass-overlay backdrop-blur-enhanced z-40 lg:hidden"
             style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));">
        </div>
        
        <!-- Sidebar -->
        <div class="fixed inset-y-0 <?php echo e(app()->getLocale() == 'ar' ? 'right-0 border-l' : 'left-0 border-r'); ?> bg-gradient-to-b from-slate-900/95 via-slate-800/95 to-slate-900/95 backdrop-blur-xl shadow-2xl border-slate-700/50 transition-all duration-300 ease-in-out z-50 lg:z-30 transform lg:translate-x-0"
             :class="{
                'w-64': !sidebarCollapsed || window.innerWidth < 1024,
                'w-16': sidebarCollapsed && window.innerWidth >= 1024,
                'translate-x-0': mobileMenuOpen,
                '<?php echo e(app()->getLocale() == 'ar' ? 'translate-x-full' : '-translate-x-full'); ?>': !mobileMenuOpen && window.innerWidth < 1024
             }"
             style="backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);"
             x-cloak>
            <div class="flex flex-col h-full relative">
                <!-- Logo & Toggle -->
                <div class="flex items-center justify-between h-16 px-4 border-b border-slate-700/50">
                    <div class="flex items-center space-x-3 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> overflow-hidden">
                        <!-- Logo when expanded -->
                        <div x-show="!sidebarCollapsed" 
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in-out duration-200"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="flex items-center space-x-3 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?>">
                            <?php if(setting('sidebar_admin_logo')): ?>
                                <img src="<?php echo e(asset('storage/' . setting('sidebar_admin_logo'))); ?>" 
                                     alt="<?php echo e(setting('company_name', 'Admin Panel')); ?>" 
                                     class="h-8 w-auto object-contain max-w-[180px]">
                            <?php else: ?>
                                <img src="<?php echo e(asset('logo/pro Gineous_white logo.svg')); ?>" 
                                     alt="Pro Gineous" 
                                     class="h-8 w-auto object-contain">
                            <?php endif; ?>
                        </div>
                        
                        <!-- Icon when collapsed -->
                        <div x-show="sidebarCollapsed" 
                             x-transition:enter="transition ease-in-out duration-300"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in-out duration-200"
                             x-transition:leave-start="opacity-100 transform scale-100"
                             x-transition:leave-end="opacity-0 transform scale-90"
                             class="flex items-center justify-center">
                            <?php if(setting('sidebar_admin_logo_collapsed')): ?>
                                <img src="<?php echo e(asset('storage/' . setting('sidebar_admin_logo_collapsed'))); ?>" 
                                     alt="<?php echo e(setting('company_name', 'Admin')); ?>" 
                                     class="h-8 w-8 object-contain">
                            <?php elseif(setting('sidebar_admin_logo')): ?>
                                <img src="<?php echo e(asset('storage/' . setting('sidebar_admin_logo'))); ?>" 
                                     alt="<?php echo e(setting('company_name', 'Admin')); ?>" 
                                     class="h-8 w-8 object-contain">
                            <?php else: ?>
                                <img src="<?php echo e(asset('logo/pro Gineous Blue_white icon - Copy.png')); ?>" 
                                     alt="PG" 
                                     class="h-8 w-8 object-contain">
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Close button for mobile -->
                    <button @click="closeMobileMenu()" class="lg:hidden p-2 rounded-md hover:bg-slate-800 transition-colors text-slate-300 hover:text-white">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Toggle Button (Desktop only) -->
                <div class="hidden lg:block absolute <?php echo e(app()->getLocale() == 'ar' ? '-left-3' : '-right-3'); ?> top-20 z-10">
                    <button @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="w-6 h-6 bg-slate-800 border border-slate-600 rounded-full flex items-center justify-center text-slate-300 hover:text-white hover:bg-slate-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-3 h-3 transition-transform duration-200" 
                             fill="currentColor" viewBox="0 0 20 20">
                            <?php if(app()->getLocale() == 'ar'): ?>
                            
                            <path x-show="!sidebarCollapsed" fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            <path x-show="sidebarCollapsed" fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            <?php else: ?>
                            
                            <path x-show="!sidebarCollapsed" fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            <path x-show="sidebarCollapsed" fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            <?php endif; ?>
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 px-3 py-6 space-y-2 overflow-y-auto sidebar-scroll">
                <!-- Dashboard -->
                <a href="<?php echo e(route('admin.dashboard')); ?>" 
                   class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative overflow-hidden <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600/20 to-blue-500/10 text-white border-l-2 border-blue-500' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white'); ?>"
                   :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                   x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.dashboard')); ?>' : ''">
                    <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                         :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                        <svg class="w-5 h-5 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'group-hover:text-blue-400'); ?> transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                    <span x-show="!sidebarCollapsed" 
                          x-transition:enter="transition ease-in-out duration-300 delay-100"
                          x-transition:enter-start="opacity-0 transform translate-x-4"
                          x-transition:enter-end="opacity-100 transform translate-x-0"
                          x-transition:leave="transition ease-in-out duration-150"
                          x-transition:leave-start="opacity-100 transform translate-x-0"
                          x-transition:leave-end="opacity-0 transform translate-x-4"
                          class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                        <?php echo e(__('crm.dashboard')); ?>

                    </span>
                </a>
                
                    <!-- Divider -->
                    <div class="border-t border-slate-700/50 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                    <!-- Add New Dropdown -->
                    <div x-data="{ addNewOpen: false }" class="relative">
                        <button @click="addNewOpen = !addNewOpen" 
                           class="group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                           :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                           x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.add_new')); ?>' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                <svg class="w-5 h-5 group-hover:text-green-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                <?php echo e(__('crm.add_new')); ?>

                            </span>
                            <svg x-show="!sidebarCollapsed" 
                                 :class="addNewOpen ? 'rotate-180' : ''"
                                 class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="addNewOpen && !sidebarCollapsed" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             @click.away="addNewOpen = false"
                             class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                            <a href="<?php echo e(route('admin.clients.create')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <?php echo e(__('crm.new_client')); ?>

                            </a>
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                </svg>
                                <?php echo e(__('crm.new_order')); ?>

                            </a>
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                    <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.new_invoice')); ?>

                            </a>
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.new_quote')); ?>

                            </a>
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.new_ticket')); ?>

                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-slate-700/50 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                    <!-- Clients Dropdown -->
                    <div x-data="{ clientsOpen: false }" class="relative">
                        <button @click="clientsOpen = !clientsOpen" 
                           class="group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                           :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                           x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.clients')); ?>' : ''">
                            <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                 :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                <svg class="w-5 h-5 group-hover:text-blue-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                            </div>
                            <span x-show="!sidebarCollapsed" 
                                  x-transition:enter="transition ease-in-out duration-300 delay-100"
                                  x-transition:enter-start="opacity-0 transform translate-x-4"
                                  x-transition:enter-end="opacity-100 transform translate-x-0"
                                  x-transition:leave="transition ease-in-out duration-150"
                                  x-transition:leave-start="opacity-100 transform translate-x-0"
                                  x-transition:leave-end="opacity-0 transform translate-x-4"
                                  class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                <?php echo e(__('crm.clients')); ?>

                            </span>
                            <svg x-show="!sidebarCollapsed" 
                                 :class="clientsOpen ? 'rotate-180' : ''"
                                 class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="clientsOpen && !sidebarCollapsed" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2"
                             @click.away="clientsOpen = false"
                             class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                            
                            <!-- View/Search Clients -->
                            <a href="<?php echo e(route('admin.clients.index')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200 <?php echo e(request()->routeIs('admin.clients.index') ? 'bg-slate-800/50 text-white' : ''); ?>">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                <?php echo e(__('crm.view_search_clients')); ?>

                            </a>
                            
                            <!-- Manage Users -->
                            <a href="<?php echo e(route('admin.clients.index')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                <?php echo e(__('crm.manage_users')); ?>

                            </a>
                            
                            <!-- Add New Client -->
                            <a href="<?php echo e(route('admin.clients.create')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                </svg>
                                <?php echo e(__('crm.add_new_client')); ?>

                            </a>
                            
                            <!-- Products/Services Nested Dropdown -->
                            <div x-data="{ productsOpen: false }" class="relative">
                                <button @click="productsOpen = !productsOpen" 
                                        class="flex items-center w-full px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>"><?php echo e(__('crm.products_services')); ?></span>
                                    <svg class="w-3 h-3 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>"
                                         :class="productsOpen ? 'rotate-180' : ''"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Sub-dropdown Menu -->
                                <div x-show="productsOpen" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                                     x-transition:enter-end="opacity-100 transform translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform translate-y-0"
                                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                                     class="mt-1 <?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?> space-y-1 border-<?php echo e(app()->getLocale() == 'ar' ? 'r' : 'l'); ?> border-slate-700/50 <?php echo e(app()->getLocale() == 'ar' ? 'pr-3' : 'pl-3'); ?>">
                                    
                                    <!-- Shared Hosting -->
                                    <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('crm.shared_hosting')); ?>

                                    </a>
                                    
                                    <!-- Reseller Accounts -->
                                    <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 7H7v6h6V7z"/>
                                            <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('crm.reseller_hosting')); ?>

                                    </a>
                                    
                                    <!-- VPS/Servers -->
                                    <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 12v3c0 1.657 3.134 3 7 3s7-1.343 7-3v-3c0 1.657-3.134 3-7 3s-7-1.343-7-3z"/>
                                            <path d="M3 7v3c0 1.657 3.134 3 7 3s7-1.343 7-3V7c0 1.657-3.134 3-7 3S3 8.657 3 7z"/>
                                            <path d="M17 5c0 1.657-3.134 3-7 3S3 6.657 3 5s3.134-3 7-3 7 1.343 7 3z"/>
                                        </svg>
                                        <?php echo e(__('crm.vps_servers')); ?>

                                    </a>
                                    
                                    <!-- Other Services -->
                                    <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('crm.other_services')); ?>

                                    </a>
                                </div>
                            </div>
                            
                            <!-- Service Addons -->
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.service_addons')); ?>

                            </a>
                            
                            <!-- Domain Registrations -->
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.domain_registrations')); ?>

                            </a>
                            
                            <!-- Cancellation Requests -->
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                </svg>
                                <?php echo e(__('crm.cancellation_requests')); ?>

                            </a>
                            
                            <!-- Manage Affiliates -->
                            <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z"/>
                                </svg>
                                <?php echo e(__('crm.manage_affiliates')); ?>

                            </a>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-slate-700/50 my-4" 
                         :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                    <!-- Hosting Management -->
                    <div class="space-y-2">

                        <!-- Orders Dropdown -->
                        <div x-data="{ ordersOpen: false }" class="relative">
                            <button @click="ordersOpen = !ordersOpen" 
                               class="group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                               :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                               x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.orders')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-purple-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.orders')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="ordersOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="ordersOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="ordersOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- List All Orders -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.list_all_orders')); ?>

                                </a>
                                
                                <!-- Pending Orders -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.pending_orders')); ?>

                                </a>
                                
                                <!-- Active Orders -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.active_orders')); ?>

                                </a>
                                
                                <!-- Fraud Orders -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.fraud_orders')); ?>

                                </a>
                                
                                <!-- Cancelled Orders -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.cancelled_orders')); ?>

                                </a>
                                
                                <!-- Add New Order -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.add_new_order')); ?>

                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Billing Dropdown -->
                        <div x-data="{ billingOpen: false }" class="relative">
                            <button @click="billingOpen = !billingOpen" 
                               class="group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                               :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                               x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.billing')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-green-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.billing')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="billingOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div x-show="billingOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="billingOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- Transactions List -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"/>
                                    </svg>
                                    <?php echo e(__('crm.transactions_list')); ?>

                                </a>
                                
                                <!-- Invoices Nested Dropdown -->
                                <div x-data="{ invoicesOpen: false }" class="relative">
                                    <button @click="invoicesOpen = !invoicesOpen" 
                                            class="flex items-center w-full px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>"><?php echo e(__('crm.invoices')); ?></span>
                                        <svg class="w-3 h-3 transition-transform duration-200"
                                             :class="invoicesOpen ? 'rotate-180' : ''"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Invoices Sub-dropdown -->
                                    <div x-show="invoicesOpen" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                                         class="mt-1 <?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?> space-y-1 border-<?php echo e(app()->getLocale() == 'ar' ? 'r' : 'l'); ?> border-slate-700/50 <?php echo e(app()->getLocale() == 'ar' ? 'pr-3' : 'pl-3'); ?>">
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.paid_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.draft_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.unpaid_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.overdue_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.cancelled_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.refunded_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.collections_invoices')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.payment_pending_invoices')); ?>

                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Billable Items Nested Dropdown -->
                                <div x-data="{ billableItemsOpen: false }" class="relative">
                                    <button @click="billableItemsOpen = !billableItemsOpen" 
                                            class="flex items-center w-full px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>"><?php echo e(__('crm.billable_items')); ?></span>
                                        <svg class="w-3 h-3 transition-transform duration-200"
                                             :class="billableItemsOpen ? 'rotate-180' : ''"
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Billable Items Sub-dropdown -->
                                    <div x-show="billableItemsOpen" 
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 transform translate-y-0"
                                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                                         class="mt-1 <?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?> space-y-1 border-<?php echo e(app()->getLocale() == 'ar' ? 'r' : 'l'); ?> border-slate-700/50 <?php echo e(app()->getLocale() == 'ar' ? 'pr-3' : 'pl-3'); ?>">
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zM12 13.5a1.5 1.5 0 103 0 1.5 1.5 0 00-3 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.uninvoiced_items')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.recurring_items')); ?>

                                        </a>
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-white hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.add_new_billable_item')); ?>

                                        </a>
                                    </div>
                                </div>
                                
                                <!-- Quotes -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.quotes')); ?>

                                </a>
                                
                                <!-- Offline CC Processing -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.offline_cc_processing')); ?>

                                </a>
                                
                                <!-- Disputes -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.disputes')); ?>

                                </a>
                                
                                <!-- Gateway Log -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.gateway_log')); ?>

                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Support Menu -->
                        <div x-data="{ supportOpen: false }">
                            <button @click="supportOpen = !supportOpen" 
                                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                                    :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                    x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.support')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-blue-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C15.802 8.249 16 9.1 16 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-2.516-.552l1.562-1.562a4.006 4.006 0 001.789.027zm-4.677-2.796a4.002 4.002 0 01-.041-2.08l-.08.08-1.53-1.533A5.98 5.98 0 004 10c0 .954.223 1.856.619 2.657l1.54-1.54zm1.088-6.45A5.974 5.974 0 0110 4c.954 0 1.856.223 2.657.619l-1.54 1.54a4.002 4.002 0 00-2.346.033L7.246 4.668zM12 10a2 2 0 11-4 0 2 2 0 014 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.support')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="supportOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-2' : 'ml-2'); ?>" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="supportOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="supportOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- Support Overview -->
                                <a href="<?php echo e(route('admin.tickets.overview')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200 <?php echo e(request()->routeIs('admin.tickets.overview') ? 'bg-slate-800/50 text-white' : ''); ?>">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.support_overview')); ?>

                                </a>

                                <!-- Support Tickets Nested Dropdown -->
                                <div x-data="{ supportTicketsOpen: false }" class="relative">
                                    <button @click="supportTicketsOpen = !supportTicketsOpen" 
                                            class="flex items-center w-full px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"/>
                                            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"/>
                                        </svg>
                                        <span class="flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>"><?php echo e(__('crm.support_tickets')); ?></span>
                                        <svg :class="supportTicketsOpen ? 'rotate-180' : ''"
                                             class="w-4 h-4 transition-transform duration-200" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>

                                    <div x-show="supportTicketsOpen"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-1"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="mt-1 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?>">
                                        
                                        <a href="<?php echo e(route('admin.tickets.index', ['flagged' => 1])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <?php echo e(__('crm.flagged_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['active' => 1])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.all_active_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'open'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.open_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'answered'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.answered_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'customer_reply'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                            <?php echo e(__('crm.customer_reply_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'on_hold'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-pink-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.on_hold_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'in_progress'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.in_progress_tickets')); ?>

                                        </a>

                                        <a href="<?php echo e(route('admin.tickets.index', ['status' => 'closed'])); ?>" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.closed_tickets')); ?>

                                        </a>
                                    </div>
                                </div>

                                <!-- Open New Ticket -->
                                <a href="<?php echo e(route('admin.tickets.create')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.open_new_ticket')); ?>

                                </a>

                                <!-- Predefined Replies -->
                                <a href="<?php echo e(route('admin.predefined-replies.index')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200 <?php echo e(request()->routeIs('admin.predefined-replies.*') ? 'bg-slate-800/50 text-white' : ''); ?>">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.predefined_replies')); ?>

                                </a>


                                <!-- Announcements -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/>
                                    </svg>
                                    <?php echo e(__('crm.announcements')); ?>

                                </a>

                                <!-- Downloads -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.downloads')); ?>

                                </a>

                                <!-- Knowledgebase -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                    </svg>
                                    <?php echo e(__('crm.knowledgebase')); ?>

                                </a>

                                <!-- Network Issues -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.network_issues')); ?>

                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Reports Menu -->
                        <div x-data="{ reportsOpen: false }">
                            <button @click="reportsOpen = !reportsOpen" 
                                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                                    :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                    x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.reports')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-indigo-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.reports')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="reportsOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="reportsOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="reportsOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- Daily Performance -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.daily_performance')); ?>

                                </a>

                                <!-- Income Forecast -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.income_forecast')); ?>

                                </a>

                                <!-- Annual Income Report -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.annual_income_report')); ?>

                                </a>

                                <!-- New Customers -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                                    </svg>
                                    <?php echo e(__('crm.new_customers')); ?>

                                </a>

                                <!-- Ticket Feedback Scores -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <?php echo e(__('crm.ticket_feedback_scores')); ?>

                                </a>

                                <!-- Batch Invoice PDF Export -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.batch_invoice_pdf_export')); ?>

                                </a>

                                <!-- More... -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    </svg>
                                    <?php echo e(__('crm.more_reports')); ?>

                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Utilities Menu -->
                        <div x-data="{ utilitiesOpen: false }">
                            <button @click="utilitiesOpen = !utilitiesOpen" 
                                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                                    :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                    x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.utilities')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-purple-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.utilities')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="utilitiesOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="utilitiesOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="utilitiesOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- Automation Status -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.automation_status')); ?>

                                </a>

                                <!-- Addon Queue -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                    </svg>
                                    <?php echo e(__('crm.addon_queue')); ?>

                                </a>

                                <!-- Registrar TLD Sync -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.registrar_tld_sync')); ?>

                                </a>

                                <!-- Email Campaigns -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                    <?php echo e(__('crm.email_campaigns')); ?>

                                </a>

                                <!-- Email Marketer -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.243 5.757a6 6 0 10-.986 9.284 1 1 0 111.087 1.678A8 8 0 1118 10a3 3 0 01-4.8 2.401A4 4 0 1114 10a1 1 0 102 0c0-1.537-.586-3.07-1.757-4.243zM12 10a2 2 0 10-4 0 2 2 0 004 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.email_marketer')); ?>

                                </a>

                                <!-- Link Tracking -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.link_tracking')); ?>

                                </a>

                                <!-- Calendar -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.calendar')); ?>

                                </a>

                                <!-- Todo List -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.todo_list')); ?>

                                </a>

                                <!-- WHOIS Lookup -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.whois_lookup')); ?>

                                </a>

                                <!-- Domain Resolver -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.817 14.769 2.156 18 4.828 18h10.343c2.673 0 4.012-3.231 2.122-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171.102l-.47.156a4 4 0 01-2.53 0l-.563-.187a1.993 1.993 0 00-.114-.035l1.063-1.063A3 3 0 009 8.172z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.domain_resolver')); ?>

                                </a>

                                <!-- Integration Code -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.integration_code')); ?>

                                </a>

                                <!-- System Nested Dropdown -->
                                <div x-data="{ systemOpen: false }" class="relative">
                                    <button @click="systemOpen = !systemOpen" 
                                            class="flex items-center w-full px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="flex-1 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>"><?php echo e(__('crm.system')); ?></span>
                                        <svg :class="systemOpen ? 'rotate-180' : ''"
                                             class="w-4 h-4 transition-transform duration-200" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>

                                    <div x-show="systemOpen"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 transform -translate-y-1"
                                         x-transition:enter-end="opacity-100 transform translate-y-0"
                                         class="mt-1 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'mr-6' : 'ml-6'); ?>">
                                        
                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm14 1a1 1 0 11-2 0 1 1 0 012 0zM2 13a2 2 0 012-2h12a2 2 0 012 2v2a2 2 0 01-2 2H4a2 2 0 01-2-2v-2zm14 1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.database_status')); ?>

                                        </a>

                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.system_cleanup')); ?>

                                        </a>

                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.php_info')); ?>

                                        </a>

                                        <a href="#" class="flex items-center px-3 py-2 text-xs text-slate-500 hover:text-slate-300 hover:bg-slate-800/20 rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?> text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                                            </svg>
                                            <?php echo e(__('crm.php_version_compatibility')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Addons Menu -->
                        <div x-data="{ addonsOpen: false }">
                            <button @click="addonsOpen = !addonsOpen" 
                                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                                    :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                    x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.addons')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-pink-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.addons')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="addonsOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="addonsOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="addonsOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- Support PIN -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.support_pin')); ?>

                                </a>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-slate-700/50 my-4" 
                             :class="sidebarCollapsed ? 'mx-2' : 'mx-0'"></div>

                        <!-- Configuration Menu -->
                        <div x-data="{ configurationOpen: false }">
                            <button @click="configurationOpen = !configurationOpen" 
                                    class="w-full group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 text-slate-400 hover:bg-slate-800/50 hover:text-white"
                                    :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                                    x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.configuration')); ?>' : ''">
                                <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                                     :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                                    <svg class="w-5 h-5 group-hover:text-amber-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span x-show="!sidebarCollapsed" 
                                      x-transition:enter="transition ease-in-out duration-300 delay-100"
                                      x-transition:enter-start="opacity-0 transform translate-x-4"
                                      x-transition:enter-end="opacity-100 transform translate-x-0"
                                      x-transition:leave="transition ease-in-out duration-150"
                                      x-transition:leave-start="opacity-100 transform translate-x-0"
                                      x-transition:leave-end="opacity-0 transform translate-x-4"
                                      class="flex-1 whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3 text-right' : 'ml-3 text-left'); ?>">
                                    <?php echo e(__('crm.configuration')); ?>

                                </span>
                                <svg x-show="!sidebarCollapsed" 
                                     :class="configurationOpen ? 'rotate-180' : ''"
                                     class="w-4 h-4 transition-transform duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'mr-auto' : 'ml-auto'); ?>" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="configurationOpen && !sidebarCollapsed" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 @click.away="configurationOpen = false"
                                 class="mt-2 space-y-1 <?php echo e(app()->getLocale() == 'ar' ? 'ml-9' : 'mr-9'); ?>">
                                
                                <!-- System Settings -->
                                <a href="<?php echo e(route('admin.system-settings.index')); ?>" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.system_settings')); ?>

                                </a>

                                <!-- Manage Admins -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                    </svg>
                                    <?php echo e(__('crm.manage_admins')); ?>

                                </a>

                                <!-- System Health -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.system_health')); ?>

                                </a>

                                <!-- System Logs -->
                                <a href="#" class="flex items-center px-3 py-2 text-sm text-slate-400 hover:text-white hover:bg-slate-800/30 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                    </svg>
                                    <?php echo e(__('crm.system_logs')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Footer -->
                <div class="px-3 py-4 border-t border-slate-700/50">
                    <a href="<?php echo e(route('home')); ?>" 
                       class="group flex items-center px-3 py-3 text-sm font-medium rounded-xl transition-all duration-200 text-slate-400 hover:bg-slate-800/30 hover:text-slate-200"
                       :class="sidebarCollapsed ? 'justify-center px-0' : ''"
                       x-tooltip="sidebarCollapsed ? '<?php echo e(__('crm.back_to_website')); ?>' : ''">
                        <div class="flex items-center justify-center w-6 h-6 flex-shrink-0" 
                             :class="sidebarCollapsed ? 'mx-auto' : '<?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>'">
                            <svg class="w-5 h-5 group-hover:text-cyan-400 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span x-show="!sidebarCollapsed" 
                              x-transition:enter="transition ease-in-out duration-300 delay-100"
                              x-transition:enter-start="opacity-0 transform translate-x-4"
                              x-transition:enter-end="opacity-100 transform translate-x-0"
                              x-transition:leave="transition ease-in-out duration-150"
                              x-transition:leave-start="opacity-100 transform translate-x-0"
                              x-transition:leave-end="opacity-0 transform translate-x-4"
                              class="whitespace-nowrap <?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?>">
                            <?php echo e(__('crm.back_to_website')); ?>

                        </span>
                    </a>
                    
                    <!-- User Profile -->
                    <div class="flex items-center mt-4 px-3 py-2" :class="sidebarCollapsed ? 'justify-center' : ''">
                        <div :class="sidebarCollapsed ? 'mx-auto' : ''">
                            <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['name' => 'Pro Gineous Admin','initials' => 'PG','size' => 'sm','gradient' => 'green-blue','status' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'Pro Gineous Admin','initials' => 'PG','size' => 'sm','gradient' => 'green-blue','status' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $attributes = $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $component = $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
                        </div>
                        <div x-show="!sidebarCollapsed" 
                             x-transition:enter="transition ease-in-out duration-300 delay-100"
                             x-transition:enter-start="opacity-0 transform translate-x-4"
                             x-transition:enter-end="opacity-100 transform translate-x-0"
                             x-transition:leave="transition ease-in-out duration-150"
                             x-transition:leave-start="opacity-100 transform translate-x-0"
                             x-transition:leave-end="opacity-0 transform translate-x-4"
                             class="<?php echo e(app()->getLocale() == 'ar' ? 'mr-3' : 'ml-3'); ?> flex-1">
                            <p class="text-sm font-medium text-white"><?php echo e(__('crm.admin')); ?></p>
                            <p class="text-xs text-slate-400">Pro Gineous Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 ease-in-out overflow-x-hidden min-w-0" 
             :class="sidebarCollapsed ? '<?php echo e(app()->getLocale() == 'ar' ? 'lg:mr-16' : 'lg:ml-16'); ?>' : '<?php echo e(app()->getLocale() == 'ar' ? 'lg:mr-64' : 'lg:ml-64'); ?>'" 
             :style="{ <?php echo e(app()->getLocale() == 'ar' ? 'marginRight' : 'marginLeft'); ?>: mobileMenuOpen ? '0' : '' }">
            <!-- Top Navigation -->
            <header class="bg-gradient-to-r from-slate-800/95 via-slate-700/95 to-slate-800/95 backdrop-blur-xl shadow-xl border-b border-slate-600/50 sticky top-0 z-20">
                <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                    <div class="flex items-center justify-between h-12 sm:h-14">
                        <!-- Left Section -->
                        <div class="flex items-center space-x-3 sm:space-x-4 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> min-w-0 flex-1">
                            <!-- Mobile menu button -->
                            <button @click="toggleMobileMenu()" 
                                    class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200 border border-slate-600/30 hover:border-slate-500/50 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            
                            <!-- Page Title -->
                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-white truncate"><?php echo $__env->yieldContent('page-title', __('crm.dashboard')); ?></h2>
                                <p class="text-xs sm:text-sm text-slate-300 hidden sm:block truncate"><?php echo e(__('crm.system_and_content_management')); ?></p>
                            </div>
                        </div>
                        
                        <!-- Right Section -->
                        <div class="flex items-center space-x-2 sm:space-x-3 lg:space-x-4 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> flex-shrink-0">
                            <!-- Language Switcher Dropdown -->
                            <?php if(setting('enable_language_menu', true)): ?>
                            <div x-data="{ languageOpen: false }" class="relative">
                                <button @click="languageOpen = !languageOpen" 
                                        class="flex items-center space-x-2 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> px-3 py-2 bg-slate-700/30 border border-slate-600/30 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200">
                                    <!-- Globe Icon -->
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline"><?php echo e(app()->getLocale() == 'ar' ? 'العربية' : 'English'); ?></span>
                                    <!-- Dropdown Arrow -->
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 transition-transform duration-200" 
                                         :class="languageOpen ? 'rotate-180' : ''"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="languageOpen" 
                                     @click.away="languageOpen = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute <?php echo e(app()->getLocale() == 'ar' ? 'left-0' : 'right-0'); ?> mt-2 w-40 bg-slate-800 border border-slate-700/50 rounded-lg shadow-xl z-50 overflow-hidden">
                                    
                                    <!-- Arabic Option -->
                                    <a href="<?php echo e(route('language.switch', 'ar')); ?>" 
                                       class="flex items-center space-x-3 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> px-4 py-3 text-sm transition-all duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'bg-blue-600/20 text-white border-l-2 border-blue-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'); ?>">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                        <span class="flex-1">العربية</span>
                                        <?php if(app()->getLocale() == 'ar'): ?>
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <!-- English Option -->
                                    <a href="<?php echo e(route('language.switch', 'en')); ?>" 
                                       class="flex items-center space-x-3 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> px-4 py-3 text-sm transition-all duration-200 <?php echo e(app()->getLocale() == 'en' ? 'bg-blue-600/20 text-white border-l-2 border-blue-500' : 'text-slate-300 hover:bg-slate-700/50 hover:text-white'); ?>">
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                        </svg>
                                        <span class="flex-1">English</span>
                                        <?php if(app()->getLocale() == 'en'): ?>
                                        <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Search Button (Hidden on mobile) -->
                            <button class="hidden md:flex p-2 lg:p-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200 border border-slate-600/30 hover:border-slate-500/50">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 lg:p-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200 border border-slate-600/30 hover:border-slate-500/50">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                                <span class="absolute -top-0.5 -right-0.5 h-3 w-3 sm:h-3.5 sm:w-3.5 bg-red-500 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-xs text-white font-bold leading-none">3</span>
                                </span>
                            </button>
                            
                            <!-- Settings (Hidden on mobile) -->
                            <button class="hidden sm:flex p-2 lg:p-2.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-200 border border-slate-600/30 hover:border-slate-500/50">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            
                            <!-- User Avatar & Dropdown -->
                            <div class="relative" x-data="{ userDropdown: false }">
                                <button @click="userDropdown = !userDropdown" 
                                        class="flex items-center space-x-2 <?php echo e(app()->getLocale() == 'ar' ? 'space-x-reverse' : ''); ?> p-1.5 sm:p-2 rounded-lg hover:bg-slate-700/50 transition-all duration-200 group">
                                    <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['name' => ''.e(auth('admin')->user()->name ?? __('crm.admin')).'','initials' => ''.e(auth('admin')->user()->initials ?? 'M').'','size' => 'responsive','gradient' => 'blue-purple','status' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e(auth('admin')->user()->name ?? __('crm.admin')).'','initials' => ''.e(auth('admin')->user()->initials ?? 'M').'','size' => 'responsive','gradient' => 'blue-purple','status' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $attributes = $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $component = $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
                                    
                                    <!-- User Info (Hidden on mobile) -->
                                    <div class="hidden lg:block text-right min-w-0">
                                        <p class="text-sm font-medium text-white truncate"><?php echo e(auth('admin')->user()->name ?? 'المدير'); ?></p>
                                        <p class="text-xs text-slate-300 truncate"><?php echo e(__('crm.' . (auth('admin')->user()->role ?? 'admin'))); ?></p>
                                    </div>
                                    
                                    <!-- Dropdown Arrow -->
                                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-200 transition-colors duration-200 hidden sm:block" 
                                         :class="userDropdown ? 'rotate-180' : ''" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div x-show="userDropdown" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     @click.away="userDropdown = false"
                                     class="absolute <?php echo e(app()->getLocale() == 'ar' ? 'left-0' : 'right-0'); ?> mt-2 w-48 bg-slate-800/95 backdrop-blur-sm rounded-xl shadow-xl border border-slate-600/50 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-slate-600/50">
                                        <p class="text-sm font-medium text-white"><?php echo e(auth('admin')->user()->name ?? __('crm.admin')); ?></p>
                                        <p class="text-xs text-slate-300"><?php echo e(auth('admin')->user()->email ?? 'admin@progineous.com'); ?></p>
                                    </div>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('crm.profile')); ?>

                                    </a>
                                    <a href="#" class="flex items-center px-4 py-3 text-sm text-slate-300 hover:text-white hover:bg-slate-700/50 transition-colors duration-200">
                                        <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e(__('crm.settings')); ?>

                                    </a>
                                    <div class="border-t border-slate-600/50 mt-2">
                                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="w-full">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-400 hover:text-red-300 hover:bg-slate-700/50 transition-colors duration-200 <?php echo e(app()->getLocale() == 'ar' ? 'text-right' : 'text-left'); ?>">
                                                <svg class="w-4 h-4 <?php echo e(app()->getLocale() == 'ar' ? 'ml-3' : 'mr-3'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <?php echo e(__('crm.logout')); ?>

                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-gray-50 via-gray-100 to-gray-50 min-h-screen overflow-x-hidden">
                <div class="max-w-7xl mx-auto overflow-x-hidden">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Alpine.js with Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        // إدارة حالة القائمة الجانبية مع الاحتفاظ بالحالة عند تحديث الصفحة
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarController', () => ({
                sidebarCollapsed: false,
                mobileMenuOpen: false,
                
                init() {
                    // التحقق من دعم localStorage
                    if (this.isLocalStorageSupported()) {
                        // استرجاع حالة القائمة الجانبية من localStorage
                        this.loadSidebarState();
                    }
                    
                    // التحقق من حجم الشاشة عند التحميل
                    this.checkScreenSize();
                    
                    // إضافة مستمع للتغيير في حجم الشاشة
                    window.addEventListener('resize', () => {
                        this.checkScreenSize();
                    });

                    // مراقبة تغيير حالة القائمة الجانبية وحفظها
                    this.$watch('sidebarCollapsed', (value) => {
                        if (this.isLocalStorageSupported()) {
                            this.saveSidebarState(value);
                        }
                    });
                },

                // فحص دعم localStorage
                isLocalStorageSupported() {
                    try {
                        const test = 'test';
                        localStorage.setItem(test, test);
                        localStorage.removeItem(test);
                        return true;
                    } catch (e) {
                        return false;
                    }
                },

                // حفظ حالة القائمة الجانبية في localStorage
                saveSidebarState(collapsed) {
                    try {
                        localStorage.setItem('sidebarCollapsed', collapsed ? 'true' : 'false');
                    } catch (e) {
                        console.warn('Unable to save sidebar state to localStorage:', e);
                    }
                },

                // استرجاع حالة القائمة الجانبية من localStorage
                loadSidebarState() {
                    try {
                        const saved = localStorage.getItem('sidebarCollapsed');
                        if (saved !== null) {
                            this.sidebarCollapsed = saved === 'true';
                        } else {
                            // إذا لم تكن هناك حالة محفوظة، استخدم الحالة الافتراضية (مفتوحة)
                            this.sidebarCollapsed = false;
                        }
                    } catch (e) {
                        console.warn('Unable to load sidebar state from localStorage:', e);
                        // في حالة الخطأ، استخدم الحالة الافتراضية
                        this.sidebarCollapsed = false;
                    }
                },
                
                checkScreenSize() {
                    if (window.innerWidth >= 1024) {
                        this.mobileMenuOpen = false;
                        document.body.style.overflow = 'auto';
                    } else {
                        // على الشاشات الصغيرة، لا نحفظ حالة طي القائمة الجانبية
                        // لأنها تُخفى تلقائياً
                    }
                },
                
                toggleMobileMenu() {
                    this.mobileMenuOpen = !this.mobileMenuOpen;
                    
                    if (this.mobileMenuOpen) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                },
                
                closeMobileMenu() {
                    this.mobileMenuOpen = false;
                    document.body.style.overflow = 'auto';
                }
            }))
            
            // إضافة tooltip directive لـ Alpine.js
            Alpine.directive('tooltip', (el, { expression }, { evaluate }) => {
                const tooltipText = evaluate(expression);
                
                if (!tooltipText) return;
                
                let tooltip = null;
                
                const showTooltip = () => {
                    // إنشاء عنصر tooltip
                    tooltip = document.createElement('div');
                    tooltip.textContent = tooltipText;
                    tooltip.className = 'fixed z-[100] px-2 py-1 text-xs font-medium text-white bg-slate-900 rounded shadow-lg pointer-events-none whitespace-nowrap';
                    document.body.appendChild(tooltip);
                    
                    // حساب موضع tooltip
                    const rect = el.getBoundingClientRect();
                    const isRTL = document.documentElement.dir === 'rtl';
                    
                    if (isRTL) {
                        tooltip.style.right = `${window.innerWidth - rect.left + 10}px`;
                    } else {
                        tooltip.style.left = `${rect.right + 10}px`;
                    }
                    tooltip.style.top = `${rect.top + (rect.height / 2) - (tooltip.offsetHeight / 2)}px`;
                };
                
                const hideTooltip = () => {
                    if (tooltip) {
                        tooltip.remove();
                        tooltip = null;
                    }
                };
                
                el.addEventListener('mouseenter', showTooltip);
                el.addEventListener('mouseleave', hideTooltip);
                
                // تنظيف عند إزالة العنصر
                el._x_cleanups = el._x_cleanups || [];
                el._x_cleanups.push(() => {
                    el.removeEventListener('mouseenter', showTooltip);
                    el.removeEventListener('mouseleave', hideTooltip);
                    hideTooltip();
                });
            });
        });
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\laragon\www\resources\views/admin/layout.blade.php ENDPATH**/ ?>