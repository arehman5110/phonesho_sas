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
 <?php $__env->slot('title', null, []); ?> Sales History <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ── Expandable rows ─────────────────────────── */
    .sale-expand {
        display: none;
    }
    .sale-expand.open {
        display: table-row;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ── Row hover ───────────────────────────────── */
    .sale-row {
        cursor: pointer;
        transition: background 0.1s;
    }

    /* ── Status badges ───────────────────────────── */
    .badge-paid    { background:#dcfce7;color:#166534; }
    .badge-pending { background:#fef9c3;color:#713f12; }
    .badge-partial { background:#dbeafe;color:#1e40af; }
    .badge-refunded{ background:#fee2e2;color:#991b1b; }

    /* ── Method badges ───────────────────────────── */
    .method-cash  { background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
    .method-card  { background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe; }
    .method-split { background:#faf5ff;color:#6b21a8;border:1px solid #e9d5ff; }
    .method-trade { background:#fff7ed;color:#9a3412;border:1px solid #fed7aa; }
    .method-other { background:#f8fafc;color:#475569;border:1px solid #e2e8f0; }

    /* ── Filter tag ──────────────────────────────── */
    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #c7d2fe;
        white-space: nowrap;
    }
    .dark .filter-tag {
        background: #1e1b4b;
        color: #a5b4fc;
        border-color: #3730a3;
    }
    .stat-card.active {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 2px rgba(99,102,241,0.2);
    }
    .dark .stat-card.active {
        border-color: #818cf8 !important;
    }
</style>
<?php $__env->stopPush(); ?>


<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Sales History','subtitle' => 'View and manage all completed sales','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Sales'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sales History','subtitle' => 'View and manage all completed sales','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Sales'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('pos.index')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7
                         13l-2.293 2.293c-.63.63-.184 1.707.707
                         1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8
                         2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Open POS
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


<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-4">

    <div onclick="SalesIndex.filterByMethod('')"
         class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 cursor-pointer hover:border-indigo-400 hover:shadow-md
                transition-all group" data-stat="all">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Sales</p>
        <p id="stat-total" class="text-2xl font-black text-gray-900 dark:text-white">
            <?php echo e($stats['total'] ?? 0); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">transactions</p>
    </div>

    <div onclick="SalesIndex.filterByMethod('')"
         class="stat-card col-span-1 sm:col-span-1 bg-white dark:bg-gray-900 border border-gray-200
                dark:border-gray-700 rounded-2xl p-4 cursor-pointer hover:border-indigo-400
                hover:shadow-md transition-all" data-stat="revenue">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Revenue</p>
        <p id="stat-revenue" class="text-2xl font-black text-indigo-600 dark:text-indigo-400">
            £<?php echo e(number_format($stats['revenue'] ?? 0, 2)); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">total</p>
    </div>

    <div onclick="SalesIndex.filterByMethod('cash')"
         class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 cursor-pointer hover:border-emerald-400 hover:shadow-md
                transition-all" data-stat="cash">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">💵 Cash</p>
        <p id="stat-cash" class="text-2xl font-black text-emerald-600 dark:text-emerald-400">
            £<?php echo e(number_format($stats['cash'] ?? 0, 2)); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">payments</p>
    </div>

    <div onclick="SalesIndex.filterByMethod('card')"
         class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 cursor-pointer hover:border-amber-400 hover:shadow-md
                transition-all" data-stat="card">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">💳 Card</p>
        <p id="stat-card" class="text-2xl font-black text-amber-600 dark:text-amber-400">
            £<?php echo e(number_format($stats['card'] ?? 0, 2)); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">payments</p>
    </div>

    <div onclick="SalesIndex.filterByMethod('split')"
         class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 cursor-pointer hover:border-purple-400 hover:shadow-md
                transition-all" data-stat="split">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">✂️ Split</p>
        <p id="stat-split" class="text-2xl font-black text-purple-600 dark:text-purple-400">
            £<?php echo e(number_format($stats['split'] ?? 0, 2)); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">payments</p>
    </div>

    <div onclick="SalesIndex.filterByMethod('trade')"
         class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 cursor-pointer hover:border-orange-400 hover:shadow-md
                transition-all" data-stat="trade">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">🔄 Trade</p>
        <p id="stat-trade" class="text-2xl font-black text-orange-600 dark:text-orange-400">
            £<?php echo e(number_format($stats['trade'] ?? 0, 2)); ?>

        </p>
        <p class="text-xs text-gray-400 mt-0.5">payments</p>
    </div>

</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">

    <div class="flex flex-wrap gap-3 items-end">

        
        <div class="flex-1 min-w-48 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   id="filter-search"
                   placeholder="Reference, customer name or phone..."
                   value="<?php echo e(request('search')); ?>"
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400 dark:placeholder-gray-500
                          focus:border-indigo-500
                          focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900
                          transition-all">
        </div>

        
        <div>
            <select id="filter-payment-status"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Statuses</option>
                <option value="paid"     <?php echo e(request('payment_status') === 'paid'     ? 'selected' : ''); ?>>
                    ✅ Paid
                </option>
                <option value="partial"  <?php echo e(request('payment_status') === 'partial'  ? 'selected' : ''); ?>>
                    🔵 Partial
                </option>
                <option value="pending"  <?php echo e(request('payment_status') === 'pending'  ? 'selected' : ''); ?>>
                    🟡 Pending
                </option>
                <option value="refunded" <?php echo e(request('payment_status') === 'refunded' ? 'selected' : ''); ?>>
                    🔴 Refunded
                </option>
            </select>
        </div>

        
        <div>
            <select id="filter-payment-method"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Methods</option>
                <option value="cash"  <?php echo e(request('payment_method') === 'cash'  ? 'selected' : ''); ?>>
                    💵 Cash
                </option>
                <option value="card"  <?php echo e(request('payment_method') === 'card'  ? 'selected' : ''); ?>>
                    💳 Card
                </option>
                <option value="split" <?php echo e(request('payment_method') === 'split' ? 'selected' : ''); ?>>
                    ✂️ Split
                </option>
                <option value="trade" <?php echo e(request('payment_method') === 'trade' ? 'selected' : ''); ?>>
                    🔄 Trade
                </option>
            </select>
        </div>

        
        <div class="flex items-center gap-2">
            <label class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 whitespace-nowrap">
                From
            </label>
            <input type="date"
                   id="filter-date-from"
                   value="<?php echo e(request('date_from', date('Y-m-d'))); ?>"
                   class="px-3 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        
        <div class="flex items-center gap-2">
            <label class="text-xs font-semibold text-gray-500
                           dark:text-gray-400 whitespace-nowrap">
                To
            </label>
            <input type="date"
                   id="filter-date-to"
                   value="<?php echo e(request('date_to')); ?>"
                   class="px-3 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

    </div>

</div>


<div id="active-filters-wrapper"
     style="display:none;"
     class="flex items-center gap-2 flex-wrap mb-3 px-1">
    <span class="text-xs font-bold text-gray-400 dark:text-gray-500
                 uppercase tracking-wider whitespace-nowrap">
        Showing:
    </span>
    <div id="active-filters"
         class="flex items-center gap-2 flex-wrap flex-1">
    </div>
</div>


<div class="flex items-center justify-between mb-3 px-1">
    <p id="results-info"
       class="text-sm text-gray-500 dark:text-gray-400">
        Showing <?php echo e($sales->firstItem() ?? 0); ?>–<?php echo e($sales->lastItem() ?? 0); ?>

        of <?php echo e($sales->total()); ?> sales
    </p>
    <div id="loading-indicator"
         style="display:none;"
         class="flex items-center gap-2 text-sm
                text-indigo-500 font-semibold">
        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        Loading...
    </div>
</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <th class="w-8 px-4 py-3"></th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Ref / Date
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden sm:table-cell">
                        Items
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Method
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Status
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden lg:table-cell">
                        Total
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody id="sales-tbody"
       class="divide-y divide-gray-100 dark:divide-gray-800">
    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make('sales.partials.index-row', compact('sale'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <?php echo $__env->make('sales.partials.index-empty', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
</tbody>
        </table>
    </div>

    
    <div id="pagination-wrapper"
         class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        <?php echo e($sales->links()); ?>

    </div>

</div>


<iframe id="print-frame" style="display:none;position:absolute;"></iframe>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/sales-index.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    SalesIndex.init({
        fetchUrl : '<?php echo e(route("sales.index")); ?>',
        csrf     : '<?php echo e(csrf_token()); ?>',
    });
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/sales/index.blade.php ENDPATH**/ ?>