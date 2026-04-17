
















<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title'       => '',
    'subtitle'    => '',
    'breadcrumbs' => [],
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
    'title'       => '',
    'subtitle'    => '',
    'breadcrumbs' => [],
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="mb-6">

    
    <?php if(count($breadcrumbs) > 0): ?>
    <nav class="flex items-center gap-1.5 text-xs mb-3 flex-wrap">
        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($index > 0): ?>
                <svg class="w-3 h-3 text-gray-300 dark:text-gray-600 flex-shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            <?php endif; ?>

            <?php if(isset($crumb['route'])): ?>
                <a href="<?php echo e(route($crumb['route'], $crumb['params'] ?? [])); ?>"
                   class="text-gray-400 hover:text-indigo-600
                          dark:text-gray-500 dark:hover:text-indigo-400
                          transition-colors font-medium">
                    <?php echo e($crumb['label']); ?>

                </a>
            <?php else: ?>
                <span class="text-gray-700 dark:text-gray-300 font-semibold">
                    <?php echo e($crumb['label']); ?>

                </span>
            <?php endif; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
    <?php endif; ?>

    
    <div class="flex flex-col sm:flex-row sm:items-center
                justify-between gap-4">

        
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white
                       leading-tight">
                <?php echo e($title); ?>

            </h1>
            <?php if($subtitle): ?>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                <?php echo e($subtitle); ?>

            </p>
            <?php endif; ?>
        </div>

        
        <?php if(isset($actions)): ?>
        <div class="flex items-center gap-3 flex-shrink-0">
            <?php echo e($actions); ?>

        </div>
        <?php endif; ?>

    </div>

</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/page-header.blade.php ENDPATH**/ ?>