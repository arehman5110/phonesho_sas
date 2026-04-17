<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
 <?php $__env->slot('title', null, []); ?> Vouchers <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .badge-green  { background:#dcfce7;color:#166534; }
    .badge-red    { background:#fee2e2;color:#991b1b; }
    .badge-orange { background:#ffedd5;color:#9a3412; }
    .badge-gray   { background:#f1f5f9;color:#475569; }
</style>
<?php $__env->stopPush(); ?>


<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Vouchers','subtitle' => 'Manage discount vouchers and promo codes','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Vouchers'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vouchers','subtitle' => 'Manage discount vouchers and promo codes','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Vouchers'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('vouchers.create')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Voucher
        </a>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>


<?php if(session('success')): ?>
<div x-data="{ show: true }"
     x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20
            border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none"
         stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">

    <?php $__currentLoopData = [
        ['label' => 'Total',    'value' => $summary['total'],   'color' => 'indigo', 'icon' => 'M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z'],
        ['label' => 'Active',   'value' => $summary['active'],  'color' => 'green',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Expired',  'value' => $summary['expired'], 'color' => 'red',    'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Used Up',  'value' => $summary['usedUp'],  'color' => 'orange', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636'],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $bgMap = [
            'indigo' => 'bg-indigo-100 dark:bg-indigo-900/40',
            'green'  => 'bg-green-100 dark:bg-green-900/40',
            'red'    => 'bg-red-100 dark:bg-red-900/40',
            'orange' => 'bg-orange-100 dark:bg-orange-900/40',
        ];
        $textMap = [
            'indigo' => 'text-indigo-600 dark:text-indigo-400',
            'green'  => 'text-green-600 dark:text-green-400',
            'red'    => 'text-red-600 dark:text-red-400',
            'orange' => 'text-orange-600 dark:text-orange-400',
        ];
    ?>
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl <?php echo e($bgMap[$stat['color']]); ?>

                    flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 <?php echo e($textMap[$stat['color']]); ?>"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="<?php echo e($stat['icon']); ?>"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500
                       dark:text-gray-400 uppercase tracking-wider">
                <?php echo e($stat['label']); ?>

            </p>
            <p class="text-2xl font-black <?php echo e($textMap[$stat['color']]); ?>">
                <?php echo e($stat['value']); ?>

            </p>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">
    <form method="GET" action="<?php echo e(route('vouchers.index')); ?>"
          class="flex flex-wrap gap-3 items-end">

        
        <div class="flex-1 min-w-48 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   name="search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search voucher code..."
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        
        <select name="status"
                class="px-3 py-2.5
                       border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all
                       cursor-pointer">
            <option value="">All Status</option>
            <option value="active"   <?php echo e(request('status') === 'active'   ? 'selected' : ''); ?>>
                ✅ Active
            </option>
            <option value="expired"  <?php echo e(request('status') === 'expired'  ? 'selected' : ''); ?>>
                ❌ Expired
            </option>
            <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>
                ⏸ Inactive
            </option>
        </select>

        <button type="submit"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold
                       bg-indigo-600 hover:bg-indigo-700 text-white
                       transition-all">
            Filter
        </button>

        <?php if(request()->hasAny(['search', 'status'])): ?>
        <a href="<?php echo e(route('vouchers.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 transition-all">
            Clear
        </a>
        <?php endif; ?>

    </form>
</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Code
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Discount
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden sm:table-cell">
                        Usage
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Expiry
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden lg:table-cell">
                        Customer
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">

                <?php $__empty_1 = true; $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $badgeClass = match($voucher->status_color) {
                        'green'  => 'badge-green',
                        'red'    => 'badge-red',
                        'orange' => 'badge-orange',
                        default  => 'badge-gray',
                    };
                ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50
                            transition-colors group">

                    
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            <code class="text-sm font-black text-indigo-600
                                         dark:text-indigo-400 bg-indigo-50
                                         dark:bg-indigo-900/30 px-2.5 py-1
                                         rounded-lg tracking-wider">
                                <?php echo e($voucher->code); ?>

                            </code>
                        </div>
                        <?php if($voucher->notes): ?>
                        <p class="text-xs text-gray-400 dark:text-gray-500
                                   mt-0.5 truncate max-w-40">
                            <?php echo e($voucher->notes); ?>

                        </p>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-4 py-4">
                        <p class="text-base font-black text-gray-900
                                   dark:text-white">
                            <?php echo e($voucher->formatted_value); ?>

                            <span class="text-xs font-semibold
                                         text-gray-400 ml-1">
                                <?php echo e($voucher->type === 'percentage'
                                    ? 'off' : 'fixed'); ?>

                            </span>
                        </p>
                        <?php if($voucher->min_order_amount > 0): ?>
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            Min: £<?php echo e(number_format($voucher->min_order_amount, 2)); ?>

                        </p>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-4 py-4 hidden sm:table-cell">
                        <p class="text-sm font-semibold text-gray-900
                                   dark:text-white">
                            <?php echo e($voucher->used_count); ?>

                            <?php if($voucher->usage_limit): ?>
                                / <?php echo e($voucher->usage_limit); ?>

                            <?php else: ?>
                                / ∞
                            <?php endif; ?>
                        </p>
                        <?php if($voucher->usage_limit): ?>
                        <div class="w-24 h-1.5 bg-gray-200 dark:bg-gray-700
                                    rounded-full mt-1.5 overflow-hidden">
                            <div class="h-full rounded-full transition-all
                                        <?php echo e($voucher->isUsageLimitReached()
                                            ? 'bg-red-500'
                                            : 'bg-indigo-500'); ?>"
                                 style="width:<?php echo e(min(100, ($voucher->used_count / $voucher->usage_limit) * 100)); ?>%">
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-4 py-4 hidden md:table-cell">
                        <?php if($voucher->expiry_date): ?>
                        <p class="text-sm font-semibold
                                   <?php echo e($voucher->isExpired()
                                       ? 'text-red-500 dark:text-red-400'
                                       : 'text-gray-900 dark:text-white'); ?>">
                            <?php echo e($voucher->expiry_date->format('d/m/Y')); ?>

                        </p>
                        <?php if(!$voucher->isExpired()): ?>
                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            <?php echo e($voucher->expiry_date->diffForHumans()); ?>

                        </p>
                        <?php endif; ?>
                        <?php else: ?>
                        <span class="text-xs text-gray-400 italic">
                            No expiry
                        </span>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <?php if($voucher->assignedCustomer): ?>
                        <p class="text-sm font-semibold text-gray-900
                                   dark:text-white">
                            <?php echo e($voucher->assignedCustomer->name); ?>

                        </p>
                        <p class="text-xs text-gray-400">
                            <?php echo e($voucher->assignedCustomer->phone); ?>

                        </p>
                        <?php else: ?>
                        <span class="text-xs text-gray-400 italic">
                            Anyone
                        </span>
                        <?php endif; ?>
                    </td>

                    
                    <td class="px-4 py-4">
                        <span class="inline-flex items-center gap-1.5
                                     px-2.5 py-1 rounded-full text-xs
                                     font-bold <?php echo e($badgeClass); ?>">
                            <span class="w-1.5 h-1.5 rounded-full
                                         bg-current opacity-70">
                            </span>
                            <?php echo e($voucher->status_label); ?>

                        </span>
                    </td>

                    
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-1.5
                                    opacity-0 group-hover:opacity-100
                                    transition-opacity">

                            
                            <a href="<?php echo e(route('vouchers.edit', $voucher)); ?>"
                               class="w-7 h-7 rounded-lg flex items-center
                                      justify-center bg-indigo-50
                                      dark:bg-indigo-900/30
                                      text-indigo-600 dark:text-indigo-400
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0
                                             002 2h11a2 2 0 002-2v-5m-1.414
                                             -9.414a2 2 0 112.828 2.828L11.828
                                             15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            
                            <form method="POST"
                                  action="<?php echo e(route('vouchers.destroy', $voucher)); ?>"
                                  onsubmit="return confirm('Delete voucher <?php echo e($voucher->code); ?>?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="w-7 h-7 rounded-lg flex
                                               items-center justify-center
                                               bg-red-50 dark:bg-red-900/30
                                               text-red-500 dark:text-red-400
                                               hover:bg-red-100 transition-colors
                                               border-none cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0
                                                 0116.138 21H7.862a2 2 0
                                                 01-1.995-1.858L5 7m5 4v6m4
                                                 -6v6m1-10V4a1 1 0 00-1-1h-4a1
                                                 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7">
                        <div class="flex flex-col items-center justify-center
                                    py-16 text-gray-400 dark:text-gray-600">
                            <svg class="w-16 h-16 mb-4 opacity-40"
                                 fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0
                                         00-2 2v3a2 2 0 110 4v3a2 2 0 002
                                         2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2
                                         2 0 00-2-2H5z"/>
                            </svg>
                            <p class="text-sm font-semibold
                                       text-gray-500 dark:text-gray-400">
                                No vouchers found
                            </p>
                            <a href="<?php echo e(route('vouchers.create')); ?>"
                               class="mt-2 text-sm text-indigo-500
                                      hover:text-indigo-700 font-semibold">
                                Create your first voucher
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

    
    <?php if($vouchers->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        <?php echo e($vouchers->links()); ?>

    </div>
    <?php endif; ?>

</div>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/vouchers/index.blade.php ENDPATH**/ ?>