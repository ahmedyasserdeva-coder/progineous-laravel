<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'user' => null,
    'name' => '',
    'size' => 'md',
    'status' => false,
    'gradient' => null,
    'initials' => '',
    'class' => '',
    'animated' => false,
    'glow' => true
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'user' => null,
    'name' => '',
    'size' => 'md',
    'status' => false,
    'gradient' => null,
    'initials' => '',
    'class' => '',
    'animated' => false,
    'glow' => true
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // تحديد الحجم
    $sizeClasses = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-12 h-12 text-base',
        'xl' => 'w-14 h-14 text-lg',
        '2xl' => 'w-16 h-16 text-xl',
        'responsive' => 'w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 text-sm sm:text-base'
    ];

    // تدرجات الألوان المختلفة مع انسيابية محسنة
    $gradients = [
        'blue-purple' => 'from-blue-400 via-blue-500 to-purple-600',
        'green-blue' => 'from-emerald-400 via-teal-500 to-blue-500',
        'pink-orange' => 'from-pink-400 via-rose-500 to-orange-500',
        'purple-pink' => 'from-purple-400 via-violet-500 to-pink-500',
        'cyan-blue' => 'from-cyan-400 via-sky-500 to-blue-500',
        'emerald-green' => 'from-emerald-300 via-emerald-500 to-green-600',
        'rose-red' => 'from-rose-400 via-pink-500 to-red-500',
        'amber-yellow' => 'from-amber-400 via-orange-500 to-yellow-500',
        'indigo-purple' => 'from-indigo-400 via-purple-500 to-violet-600',
        'teal-cyan' => 'from-teal-400 via-cyan-500 to-sky-500'
    ];

    // تحديد التدرج
    if (!$gradient) {
        // إنشاء تدرج بناءً على الاسم
        $nameHash = crc32($name ?: $initials);
        $gradientKeys = array_keys($gradients);
        $gradient = $gradientKeys[abs($nameHash) % count($gradientKeys)];
    }

    $gradientClass = $gradients[$gradient] ?? $gradients['blue-purple'];
    $sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
    
    // إضافة كلاسات التأثيرات
    $effectClasses = '';
    if ($glow) {
        $effectClasses .= ' avatar-glow';
    }
    if ($animated) {
        $effectClasses .= ' avatar-gradient-smooth';
    }

    // استخراج الأحرف الأولى
    if (!$initials && $name) {
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            $initials = mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1);
        } else {
            $initials = mb_substr($words[0], 0, 2);
        }
    }

    // إذا كان المستخدم موجود، استخدم بياناته
    if ($user) {
        $displayName = $user->name ?? $name;
        if (!$initials) {
            $words = explode(' ', trim($displayName));
            if (count($words) >= 2) {
                $initials = mb_substr($words[0], 0, 1) . mb_substr($words[1], 0, 1);
            } else {
                $initials = mb_substr($words[0], 0, 2);
            }
        }
    }
?>

<div class="relative <?php echo e($class); ?>">
    <div class="<?php echo e($sizeClass); ?> bg-gradient-to-br <?php echo e($gradientClass); ?><?php echo e($effectClasses); ?> rounded-full flex items-center justify-center hover:shadow-xl transition-all duration-300 border border-white/20 hover:border-white/30 cursor-pointer group relative overflow-hidden">
        <!-- تدرج خلفي إضافي للانسيابية -->
        <div class="absolute inset-0 bg-gradient-to-tr from-white/15 via-white/5 to-transparent rounded-full"></div>
        <!-- تأثير الإضاءة العلوية -->
        <div class="absolute inset-x-0 top-0 h-1/2 bg-gradient-to-b from-white/10 to-transparent rounded-full"></div>
        <span class="text-white font-bold uppercase relative z-10 drop-shadow-sm"><?php echo e($initials ?: 'U'); ?></span>
    </div>
    
    <?php if($status): ?>
        <?php
            $statusSizes = [
                'xs' => 'w-2 h-2',
                'sm' => 'w-3 h-3',
                'md' => 'w-3 h-3',
                'lg' => 'w-4 h-4',
                'xl' => 'w-5 h-5',
                '2xl' => 'w-6 h-6',
                'responsive' => 'w-3 h-3 sm:w-3 sm:h-3 lg:w-3 lg:h-3'
            ];
            $statusSize = $statusSizes[$size] ?? $statusSizes['md'];
        ?>
        <div class="absolute -bottom-0.5 -right-0.5 <?php echo e($statusSize); ?> bg-green-500 border-2 border-slate-700 rounded-full shadow-sm"></div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\resources\views/components/user-avatar.blade.php ENDPATH**/ ?>