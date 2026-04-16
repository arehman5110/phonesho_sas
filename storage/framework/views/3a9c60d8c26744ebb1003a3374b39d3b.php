
<?php if(session('success')): ?>
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition
     class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
            bg-green-50 dark:bg-green-900/30
            text-green-800 dark:text-green-300
            border border-green-200 dark:border-green-800">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

    <button @click="show = false" class="ml-auto text-green-600 dark:text-green-400
                                         hover:text-green-800 dark:hover:text-green-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
<?php endif; ?>


<?php if(session('error')): ?>
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition
     class="mb-4 flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium
            bg-red-50 dark:bg-red-900/30
            text-red-800 dark:text-red-300
            border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('error')); ?>

    <button @click="show = false" class="ml-auto text-red-600 dark:text-red-400
                                         hover:text-red-800 dark:hover:text-red-200">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
<?php endif; ?>


<?php if($errors->any()): ?>
<div x-data="{ show: true }"
     x-show="show"
     x-transition
     class="mb-4 px-4 py-3 rounded-xl text-sm
            bg-red-50 dark:bg-red-900/30
            text-red-800 dark:text-red-300
            border border-red-200 dark:border-red-800">
    <div class="flex items-center gap-2 font-medium mb-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Please fix the following errors:
    </div>
    <ul class="list-disc list-inside space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/alert.blade.php ENDPATH**/ ?>