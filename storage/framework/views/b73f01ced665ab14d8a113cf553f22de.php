







<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title'  => '',
    'color'  => 'indigo',
    'badge'  => null,
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
    'title'  => '',
    'color'  => 'indigo',
    'badge'  => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$colors = [
    'blue'    => ['bg' => 'bg-blue-100 dark:bg-blue-900/40',    'text' => 'text-blue-600 dark:text-blue-400'],
    'indigo'  => ['bg' => 'bg-indigo-100 dark:bg-indigo-900/40','text' => 'text-indigo-600 dark:text-indigo-400'],
    'green'   => ['bg' => 'bg-green-100 dark:bg-green-900/40',  'text' => 'text-green-600 dark:text-green-400'],
    'purple'  => ['bg' => 'bg-purple-100 dark:bg-purple-900/40','text' => 'text-purple-600 dark:text-purple-400'],
    'amber'   => ['bg' => 'bg-amber-100 dark:bg-amber-900/40',  'text' => 'text-amber-600 dark:text-amber-400'],
    'red'     => ['bg' => 'bg-red-100 dark:bg-red-900/40',      'text' => 'text-red-600 dark:text-red-400'],
    'emerald' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/40','text'=> 'text-emerald-600 dark:text-emerald-400'],
    'gray'    => ['bg' => 'bg-gray-100 dark:bg-gray-800',       'text' => 'text-gray-600 dark:text-gray-400'],
];
$c = $colors[$color] ?? $colors['indigo'];
?>

<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl">

    
    <div class="flex items-center gap-3 px-5 py-3.5
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700">

        
        <?php if(isset($icon)): ?>
        <div class="w-7 h-7 rounded-lg <?php echo e($c['bg']); ?>

                    flex items-center justify-center flex-shrink-0">
            <span class="<?php echo e($c['text']); ?> flex items-center justify-center">
                <?php echo e($icon); ?>

            </span>
        </div>
        <?php endif; ?>

        
        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
            <?php echo e($title); ?>

        </span>

        
        <?php if($badge): ?>
        <span class="ml-1 text-xs font-bold px-2 py-0.5 rounded-full
                     <?php echo e($c['bg']); ?> <?php echo e($c['text']); ?>">
            <?php echo e($badge); ?>

        </span>
        <?php endif; ?>

        
        <?php if(isset($badgeSlot)): ?>
        <div class="ml-1"><?php echo e($badgeSlot); ?></div>
        <?php endif; ?>

        
        <?php if(isset($actionSlot)): ?>
        <div class="ml-auto"><?php echo e($actionSlot); ?></div>
        <?php endif; ?>

    </div>

    
    <div class="p-5">
        <?php echo e($slot); ?>

    </div>

</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/form-section.blade.php ENDPATH**/ ?>