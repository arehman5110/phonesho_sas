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
 <?php $__env->slot('title', null, []); ?> <?php echo e($customer->name); ?> <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => ''.e($customer->name).'','subtitle' => 'Customer Profile','breadcrumbs' => [
        ['label' => 'Dashboard',  'route' => 'dashboard'],
        ['label' => 'Customers',  'route' => 'customers.index'],
        ['label' => $customer->name],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($customer->name).'','subtitle' => 'Customer Profile','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard',  'route' => 'dashboard'],
        ['label' => 'Customers',  'route' => 'customers.index'],
        ['label' => $customer->name],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button type="button"
                data-customer='<?php echo e(str_replace("'", "&#39;", json_encode(["id"=>$customer->id,"name"=>$customer->name,"phone"=>$customer->phone??"","email"=>$customer->email??"","address"=>$customer->address??"","notes"=>$customer->notes??""]))); ?>'
                onclick="openEditCustomerModal(this)"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                       bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </button>
        <form method="POST" action="<?php echo e(route('customers.destroy', $customer)); ?>"
              onsubmit="return confirm('Delete <?php echo e(addslashes($customer->name)); ?>?')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                           bg-red-600 hover:bg-red-700 active:scale-95 text-white transition-all
                           border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </button>
        </form>
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
<div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    
    <div class="lg:col-span-2 space-y-5">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Profile</span>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-4">
                <?php $__currentLoopData = [
                    ['Phone',   $customer->phone],
                    ['Email',   $customer->email],
                    ['Address', $customer->address],
                    ['Member since', $customer->created_at->format('d/m/Y')],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($value): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1"><?php echo e($label); ?></p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($value); ?></p>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($customer->notes): ?>
                <div class="col-span-2 sm:col-span-3">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-amber-50 dark:bg-amber-900/20
                               rounded-lg px-3 py-2 border border-amber-100 dark:border-amber-800">
                        <?php echo e($customer->notes); ?>

                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Repairs</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400">
                        <?php echo e($customer->repairs->count()); ?>

                    </span>
                </div>
                <a href="<?php echo e(route('repairs.create')); ?>?customer_id=<?php echo e($customer->id); ?>"
                   class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold
                          bg-indigo-600 hover:bg-indigo-700 text-white transition-all">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Repair
                </a>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $customer->repairs->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $repair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $paid = (float) $repair->payments->sum('amount');
                $owed = max(0, (float) $repair->final_price - $paid);
                $statusColors = [
                    'green'  => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                    'blue'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                    'yellow' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                    'orange' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                    'red'    => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                    'purple' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                    'gray'   => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                ];
            ?>
            <a href="<?php echo e(route('repairs.show', $repair)); ?>"
               class="flex items-start justify-between px-5 py-3.5
                      border-b border-gray-100 dark:border-gray-800 last:border-0
                      hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            <?php echo e($repair->reference); ?>

                        </p>
                        <p class="text-xs text-gray-400">· <?php echo e($repair->created_at->format('d/m/Y')); ?></p>
                    </div>
                    
                    <?php $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $dColor = $statusColors[$device->status?->color ?? 'gray'] ?? $statusColors['gray'];
                    ?>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-40">
                            <?php echo e($device->device_name ?: 'Device'); ?>

                        </span>
                        <?php if($device->status): ?>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full <?php echo e($dColor); ?> whitespace-nowrap">
                            <?php echo e($device->status->name); ?>

                        </span>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        £<?php echo e(number_format($repair->final_price, 2)); ?>

                    </p>
                    <?php if($owed > 0): ?>
                    <p class="text-xs text-red-500">£<?php echo e(number_format($owed, 2)); ?> owed</p>
                    <?php else: ?>
                    <p class="text-xs text-emerald-500">Paid</p>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-600">
                No repairs yet
            </div>
            <?php endif; ?>

            <?php if($customer->repairs->count() > 10): ?>
            <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800">
                <a href="<?php echo e(route('repairs.index')); ?>?search=<?php echo e(urlencode($customer->phone ?? $customer->name)); ?>"
                   class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:underline">
                    View all <?php echo e($customer->repairs->count()); ?> repairs →
                </a>
            </div>
            <?php endif; ?>
        </div>

        
        <?php if($vouchers->isNotEmpty()): ?>
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Vouchers</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full
                             bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                    <?php echo e($vouchers->count()); ?>

                </span>
            </div>
            <?php $__currentLoopData = $vouchers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voucher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $expired = $voucher->expiry_date && \Carbon\Carbon::parse($voucher->expiry_date)->isPast();
                $used    = $voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit;
                $active  = $voucher->is_active && !$expired && !$used;
            ?>
            <div class="flex items-center justify-between px-5 py-3.5
                        border-b border-gray-100 dark:border-gray-800 last:border-0">
                <div class="flex items-center gap-3">
                    <div class="font-mono text-sm font-black px-3 py-1.5 rounded-lg
                                <?php echo e($active ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400'
                                           : 'bg-gray-100 dark:bg-gray-800 text-gray-400 line-through'); ?>">
                        <?php echo e($voucher->code); ?>

                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            <?php echo e($voucher->type === 'percent' ? $voucher->value . '%' : '£' . number_format($voucher->value, 2)); ?> off
                        </p>
                        <?php if($voucher->expiry_date): ?>
                        <p class="text-xs <?php echo e($expired ? 'text-red-400' : 'text-gray-400'); ?>">
                            <?php echo e($expired ? 'Expired' : 'Expires'); ?> <?php echo e(\Carbon\Carbon::parse($voucher->expiry_date)->format('d/m/Y')); ?>

                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-full
                             <?php echo e($active ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400'
                                        : 'bg-gray-100 dark:bg-gray-800 text-gray-400'); ?>">
                    <?php echo e($active ? 'Active' : ($expired ? 'Expired' : 'Used')); ?>

                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </div>

    
    <div class="space-y-4">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Stats</span>
            </div>
            <div class="p-5 space-y-4">

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Spent</span>
                    <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">
                        £<?php echo e(number_format($totalSpent, 2)); ?>

                    </span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Repairs</span>
                    <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">
                        <?php echo e($totalRepairs); ?>

                    </span>
                </div>

                <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-gray-800">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Balance Due</span>
                    <?php if($balance > 0): ?>
                    <span class="text-lg font-black text-red-500">
                        £<?php echo e(number_format($balance, 2)); ?>

                    </span>
                    <?php else: ?>
                    <span class="text-sm font-bold text-emerald-500">✓ Clear</span>
                    <?php endif; ?>
                </div>

                <?php if($vouchers->isNotEmpty()): ?>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Vouchers</span>
                    <span class="text-sm font-bold text-amber-600 dark:text-amber-400">
                        <?php echo e($vouchers->where('is_active', true)->count()); ?> active
                    </span>
                </div>
                <?php endif; ?>

            </div>
        </div>

        
        <a href="<?php echo e(route('repairs.create')); ?>"
           class="w-full py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  text-white transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Repair
        </a>

        <a href="<?php echo e(route('repairs.index')); ?>?search=<?php echo e(urlencode($customer->phone ?? $customer->name)); ?>"
           class="w-full py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                  flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            View All Repairs
        </a>

    </div>
</div>


<?php
    // Load the edit modal if it exists
?>


<script>
window.REPAIR_CONFIG = window.REPAIR_CONFIG || {
    routes: {
        customerStore : '<?php echo e(route("customers.store")); ?>',
        customerUpdate: '/api/customers/{id}',
    },
    csrf: '<?php echo e(csrf_token()); ?>',
};
</script>

<?php echo $__env->make('customers.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
function openEditCustomerModal(btn) {
    const raw = btn.getAttribute('data-customer');
    const data = JSON.parse(raw);
    document.dispatchEvent(new CustomEvent('open-edit-customer-modal', { detail: data }));
}
</script>
<?php $__env->startPush('scripts'); ?>
<script>
// Reload after edit to refresh stats
document.addEventListener('customer-updated', () => {
    setTimeout(() => window.location.reload(), 600);
});
</script>
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/customers/show.blade.php ENDPATH**/ ?>