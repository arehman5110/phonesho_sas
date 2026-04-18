<div class="overflow-x-auto">
<table class="w-full">
    <thead>
        <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Device</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Condition</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">IMEI / Serial</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Buy Price</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Sell Price</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Profit</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
            <th class="px-5 py-3"></th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
    <?php $__empty_1 = true; $__currentLoopData = $devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $profit      = $device->selling_price ? (float)$device->selling_price - (float)$device->purchase_price : null;
        $condColors  = [
            'new'         => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
            'used'        => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
            'refurbished' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
            'faulty'      => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
        ];
        $statusColors = [
            'in_stock'    => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
            'sold'        => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400',
            'reserved'    => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
            'under_repair'=> 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
        ];
    ?>
    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">

        <td class="px-5 py-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-100 dark:bg-indigo-900/40
                            flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900 dark:text-white"><?php echo e($device->model_name); ?></p>
                    <p class="text-xs text-gray-400">
                        <?php echo e($device->brand?->name ?? ''); ?>

                        <?php if($device->storage): ?> · <?php echo e($device->storage); ?> <?php endif; ?>
                        <?php if($device->color): ?> · <?php echo e($device->color); ?> <?php endif; ?>
                    </p>
                </div>
            </div>
        </td>

        <td class="px-5 py-4 hidden sm:table-cell">
            <span class="text-xs font-bold px-2.5 py-1 rounded-full <?php echo e($condColors[$device->condition] ?? 'bg-gray-100 text-gray-500'); ?>">
                <?php echo e($device->condition_label); ?>

            </span>
        </td>

        <td class="px-5 py-4 hidden md:table-cell">
            <?php if($device->imei): ?>
            <p class="text-xs font-mono text-gray-600 dark:text-gray-400"><?php echo e($device->imei); ?></p>
            <?php endif; ?>
            <?php if($device->serial_number): ?>
            <p class="text-xs font-mono text-gray-400"><?php echo e($device->serial_number); ?></p>
            <?php endif; ?>
            <?php if(!$device->imei && !$device->serial_number): ?>
            <span class="text-xs text-gray-300 dark:text-gray-600">—</span>
            <?php endif; ?>
        </td>

        <td class="px-5 py-4">
            <p class="text-sm font-bold text-gray-900 dark:text-white">£<?php echo e(number_format($device->purchase_price,2)); ?></p>
            <p class="text-xs text-gray-400"><?php echo e($device->created_at->format('d/m/Y')); ?></p>
        </td>

        <td class="px-5 py-4 hidden md:table-cell">
            <?php if($device->selling_price): ?>
            <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">£<?php echo e(number_format($device->selling_price,2)); ?></p>
            <?php else: ?>
            <span class="text-xs text-gray-400 italic">Not set</span>
            <?php endif; ?>
        </td>

        <td class="px-5 py-4 hidden lg:table-cell">
            <?php if($profit !== null): ?>
            <span class="text-sm font-black <?php echo e($profit >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-500'); ?>">
                <?php echo e($profit >= 0 ? '+' : ''); ?>£<?php echo e(number_format(abs($profit),2)); ?>

            </span>
            <?php else: ?>
            <span class="text-xs text-gray-300 dark:text-gray-600">—</span>
            <?php endif; ?>
        </td>

        <td class="px-5 py-4">
            <span class="text-xs font-bold px-2.5 py-1 rounded-full <?php echo e($statusColors[$device->status] ?? 'bg-gray-100 text-gray-500'); ?>">
                <?php echo e(match($device->status) {
                    'in_stock'    => '● In Stock',
                    'sold'        => 'Sold',
                    'reserved'    => '🔒 Reserved',
                    'under_repair'=> '🔧 Repair',
                    default       => ucfirst($device->status),
                }); ?>

            </span>
        </td>

        <td class="px-5 py-4">
            <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                <?php if($device->status === 'in_stock'): ?>
                <a href="<?php echo e(route('buy-sell.sell-page', $device)); ?>"
                   title="Sell"
                   class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold
                          bg-indigo-600 hover:bg-indigo-700 text-white transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Sell
                </a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('buy-sell.destroy', $device)); ?>"
                      onsubmit="return confirm('Remove <?php echo e(addslashes($device->model_name)); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" title="Delete"
                            class="w-7 h-7 rounded-lg flex items-center justify-center
                                   bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400
                                   hover:bg-red-100 transition-colors border-none cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="8" class="px-5 py-16 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">No devices found</p>
            <button type="button" onclick="window.location='<?php echo e(route('buy-sell.create')); ?>'"
                    class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold
                           text-emerald-600 dark:text-emerald-400 hover:underline bg-transparent border-none cursor-pointer">
                Buy your first device →
            </button>
        </td>
    </tr>
    <?php endif; ?>
    </tbody>
</table>
</div>
<?php if($devices->hasPages()): ?>
<div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
    <?php echo e($devices->links()); ?>

</div>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/buy-sell/partials/device-list.blade.php ENDPATH**/ ?>