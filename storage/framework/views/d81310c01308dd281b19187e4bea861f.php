<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href'   => '#',
    'active' => false,
    'icon'   => '',
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
    'href'   => '#',
    'active' => false,
    'icon'   => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<a href="<?php echo e($href); ?>"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm
          font-medium transition-all duration-150 group
          <?php echo e($active
            ? 'bg-blue-600 text-white'
            : 'text-gray-600 dark:text-gray-400
               hover:bg-gray-100 dark:hover:bg-gray-800
               hover:text-gray-900 dark:hover:text-white'); ?>">

    
    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0
                 <?php echo e($active
                   ? 'bg-white'
                   : 'bg-gray-300 dark:bg-gray-600
                      group-hover:bg-blue-500'); ?>">
    </span>

    <span><?php echo e($slot); ?></span>

</a><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/sidebar-link.blade.php ENDPATH**/ ?>