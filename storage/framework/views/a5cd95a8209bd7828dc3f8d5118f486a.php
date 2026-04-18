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
 <?php $__env->slot('title', null, []); ?> Customers <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @keyframes fadeIn { from{opacity:0;transform:translateY(4px)} to{opacity:1;transform:none} }
    .stat-card.active { border-color:#6366f1!important;box-shadow:0 0 0 2px rgba(99,102,241,.2); }
    .dark .stat-card.active { border-color:#818cf8!important; }
    #customers-table-wrap { position:relative;transition:opacity .15s; }
    #customers-table-wrap.loading { opacity:.4;pointer-events:none; }
    #cust-loading-bar {
        display:none;position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#6366f1 0%,#a5b4fc 50%,#6366f1 100%);
        background-size:200% 100%;animation:custLoadSlide 1s linear infinite;
        z-index:10;border-radius:2px 2px 0 0;
    }
    @keyframes custLoadSlide { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
    #cust-loading-overlay {
        display:none;position:absolute;inset:0;align-items:center;
        justify-content:center;z-index:9;
    }
    .loading #cust-loading-bar    { display:block; }
    .loading #cust-loading-overlay{ display:flex; }
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Customers','subtitle' => 'Manage all customers','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Customers'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Customers','subtitle' => 'Manage all customers','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Customers'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button type="button"
                x-data
                @click="$dispatch('open-add-customer-modal')"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                       bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Customer
        </button>
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
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<?php $bf = request('balance_filter',''); ?>
<div class="grid grid-cols-3 gap-3 mb-4">

    <a href="<?php echo e(route('customers.index', array_merge(request()->except(['balance_filter','page']), []))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all
              <?php echo e($bf === '' ? 'active' : ''); ?>"
       onclick="showLoading()">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total</p>
        <p class="text-2xl font-black text-gray-900 dark:text-white"><?php echo e($stats['total']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">all customers</p>
    </a>

    <a href="<?php echo e(route('customers.index', array_merge(request()->except(['balance_filter','page']), ['balance_filter'=>'with_balance']))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-red-400 hover:shadow-md transition-all
              <?php echo e($bf === 'with_balance' ? 'active' : ''); ?>"
       onclick="showLoading()">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Balance Due</p>
        <p class="text-2xl font-black text-red-500"><?php echo e($stats['with_balance']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">outstanding</p>
    </a>

    <a href="<?php echo e(route('customers.index', array_merge(request()->except(['balance_filter','page']), ['balance_filter'=>'no_balance']))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-emerald-400 hover:shadow-md transition-all
              <?php echo e($bf === 'no_balance' ? 'active' : ''); ?>"
       onclick="showLoading()">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Clear</p>
        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400"><?php echo e($stats['no_balance']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">no balance due</p>
    </a>

</div>


<div id="customers-table-wrap" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden" style="position:relative;">
    <div id="cust-loading-bar"></div>
    <div id="cust-loading-overlay">
        <div class="flex items-center gap-2 px-4 py-2 rounded-xl
                    bg-white dark:bg-gray-800 shadow-lg
                    text-sm font-semibold text-indigo-600 dark:text-indigo-400">
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            Loading...
        </div>
    </div>

    
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 space-y-3">
        <div class="flex items-center gap-3">
            <div class="relative flex-1 max-w-sm">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <form method="GET" action="<?php echo e(route('customers.index')); ?>" id="search-form">
                    <?php if(request('balance_filter')): ?>
                    <input type="hidden" name="balance_filter" value="<?php echo e(request('balance_filter')); ?>">
                    <?php endif; ?>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                           placeholder="Search name, phone or email..."
                           oninput="clearTimeout(window._st);window._st=setTimeout(()=>{showLoading();document.getElementById('search-form').submit()},350)"
                           class="w-full pl-9 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white placeholder-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </form>
            </div>
            <?php if(request()->hasAny(['search','balance_filter'])): ?>
            <a href="<?php echo e(route('customers.index')); ?>"
               onclick="showLoading()"
               class="text-xs font-semibold text-gray-400 hover:text-red-500 transition-colors whitespace-nowrap">
                Clear ✕
            </a>
            <?php endif; ?>
            <span class="ml-auto text-xs text-gray-400 whitespace-nowrap">
                <?php echo e($customers->total()); ?> <?php echo e(Str::plural('customer', $customers->total())); ?>

            </span>
        </div>

        
        <?php
            $tags = [];
            if(request('search'))         $tags[] = ['Search: '.request('search'), route('customers.index', request()->except(['search','page']))];
            if(request('balance_filter')) $tags[] = [
                match(request('balance_filter')) { 'with_balance'=>'Balance Due', 'no_balance'=>'Clear Balance', default=>request('balance_filter') },
                route('customers.index', request()->except(['balance_filter','page']))
            ];
        ?>
        <?php if(count($tags)): ?>
        <div class="flex items-center gap-2 flex-wrap">
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Showing:</span>
            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $url]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($url); ?>" onclick="showLoading()"
               class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                      bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400
                      border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100
                      transition-colors whitespace-nowrap">
                <?php echo e($label); ?> <span class="opacity-50">✕</span>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Customer</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Contact</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Repairs</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Balance</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group cursor-pointer"
                    onclick="window.location='<?php echo e(route('customers.show', $customer)); ?>'">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center
                                        flex-shrink-0 text-white text-sm font-black
                                        bg-gradient-to-br from-indigo-500 to-purple-600">
                                <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    <?php echo e($customer->name); ?>

                                </p>
                                <?php if($customer->notes): ?>
                                <p class="text-xs text-gray-400 truncate max-w-48">📝 <?php echo e($customer->notes); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden sm:table-cell">
                        <p class="text-sm text-gray-700 dark:text-gray-300"><?php echo e($customer->phone ?: '—'); ?></p>
                        <?php if($customer->email): ?>
                        <p class="text-xs text-gray-400"><?php echo e($customer->email); ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                                     bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <?php echo e($customer->repairs_count); ?> <?php echo e(Str::plural('repair', $customer->repairs_count)); ?>

                        </span>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <?php if($customer->balance > 0): ?>
                        <span class="text-sm font-bold text-red-500">
                            £<?php echo e(number_format($customer->balance, 2)); ?> due
                        </span>
                        <?php else: ?>
                        <span class="text-xs text-gray-400">Clear</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-4" onclick="event.stopPropagation()">
                        <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="<?php echo e(route('customers.show', $customer)); ?>"
                               title="View"
                               class="w-7 h-7 rounded-lg flex items-center justify-center
                                      bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    title="Edit"
                                    data-customer='<?php echo e(str_replace("'", "&#39;", json_encode(["id"=>$customer->id,"name"=>$customer->name,"phone"=>$customer->phone??"","email"=>$customer->email??"","address"=>$customer->address??"","notes"=>$customer->notes??""]))); ?>'
                                    onclick="openEditCustomerModal(this)"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center
                                           bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400
                                           hover:bg-amber-100 transition-colors border-none cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="<?php echo e(route('customers.destroy', $customer)); ?>"
                                  onsubmit="return confirm('Delete <?php echo e(addslashes($customer->name)); ?>?')">
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
                    <td colspan="5" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No customers found</p>
                        <button type="button" x-data @click="$dispatch('open-add-customer-modal')"
                                class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold
                                       text-indigo-600 dark:text-indigo-400 hover:underline
                                       bg-transparent border-none cursor-pointer">
                            Add your first customer →
                        </button>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($customers->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        <?php echo e($customers->links()); ?>

    </div>
    <?php endif; ?>
</div>



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
<script>
function showLoading() {
    const wrap = document.getElementById('customers-table-wrap');
    if (wrap) wrap.classList.add('loading');
}
// Clear loading on back/forward navigation
window.addEventListener('pageshow', () => {
    const wrap = document.getElementById('customers-table-wrap');
    if (wrap) wrap.classList.remove('loading');
});
</script>

<?php $__env->startPush('scripts'); ?>
<script>
// Reload page after customer created/updated
document.addEventListener('customer-created', () => {
    setTimeout(() => window.location.reload(), 800);
});
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/customers/index.blade.php ENDPATH**/ ?>