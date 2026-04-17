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
 <?php $__env->slot('title', null, []); ?> Stock Management <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ── Stock indicators ────────────────────────── */
    .stock-ok  { color:#16a34a;font-weight:800; }
    .stock-low { color:#d97706;font-weight:800; }
    .stock-out { color:#dc2626;font-weight:800; }

    /* ── Row expand ──────────────────────────────── */
    .stock-expand {
        display: none;
    }
    .stock-expand.open {
        display: table-row;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn {
        from { opacity:0; }
        to   { opacity:1; }
    }

    .stock-row { cursor:pointer; transition:background 0.1s; }

    /* ── Movement type badges ────────────────────── */
    .move-topup   { background:#dcfce7;color:#166534; }
    .move-sale    { background:#fee2e2;color:#991b1b; }
    .move-repair  { background:#fef3c7;color:#92400e; }
    .move-manual  { background:#eff6ff;color:#1e40af; }
    .move-return  { background:#f3e8ff;color:#6b21a8; }
    .move-default { background:#f1f5f9;color:#475569; }
</style>
<?php $__env->stopPush(); ?>


<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Stock Management','subtitle' => 'Monitor and top up product inventory','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Stock'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stock Management','subtitle' => 'Monitor and top up product inventory','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Stock'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('products.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            All Products
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


<div class="grid grid-cols-3 gap-4 mb-5">

    
    <div class="bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-indigo-100
                    dark:bg-indigo-900/40 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4
                         7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500
                       dark:text-gray-400 uppercase tracking-wider">
                Total Products
            </p>
            <p class="text-2xl font-black text-gray-900 dark:text-white">
                <?php echo e($stats['total']); ?>

            </p>
        </div>
    </div>

    
    <div class="bg-white dark:bg-gray-900
                border border-amber-200 dark:border-amber-800
                rounded-2xl p-4 flex items-center gap-4
                cursor-pointer hover:bg-amber-50
                dark:hover:bg-amber-900/10 transition-colors"
         onclick="StockManager.filterBy('low')">
        <div class="w-10 h-10 rounded-xl bg-amber-100
                    dark:bg-amber-900/40 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0
                         2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694
                         -1.333-3.464 0L3.34 16c-.77 1.333.192 3
                         1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-amber-600
                       dark:text-amber-400 uppercase tracking-wider">
                Low Stock
            </p>
            <p class="text-2xl font-black text-amber-600
                       dark:text-amber-400">
                <?php echo e($stats['low']); ?>

            </p>
        </div>
    </div>

    
    <div class="bg-white dark:bg-gray-900
                border border-red-200 dark:border-red-800
                rounded-2xl p-4 flex items-center gap-4
                cursor-pointer hover:bg-red-50
                dark:hover:bg-red-900/10 transition-colors"
         onclick="StockManager.filterBy('out')">
        <div class="w-10 h-10 rounded-xl bg-red-100
                    dark:bg-red-900/40 flex items-center
                    justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-red-600
                       dark:text-red-400 uppercase tracking-wider">
                Out of Stock
            </p>
            <p class="text-2xl font-black text-red-600 dark:text-red-400">
                <?php echo e($stats['out']); ?>

            </p>
        </div>
    </div>

</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl p-4 mb-4">
    <form method="GET" action="<?php echo e(route('products.stock')); ?>"
          id="filter-form"
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
                   id="filter-search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search product name or SKU..."
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400
                          focus:border-indigo-500
                          focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900
                          transition-all">
        </div>

        
        <div>
            <select name="category_id"
                    id="filter-category"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Categories</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"
                            <?php echo e(request('category_id') == $category->id
                                ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        
        <div>
            <select name="stock_filter"
                    id="filter-stock"
                    class="px-3 py-2.5
                           border border-gray-200 dark:border-gray-700
                           rounded-xl text-sm outline-none
                           bg-gray-50 dark:bg-gray-800
                           text-gray-700 dark:text-gray-300
                           focus:border-indigo-500 transition-all
                           cursor-pointer">
                <option value="">All Stock Levels</option>
                <option value="ok"
                        <?php echo e(request('stock_filter') === 'ok'  ? 'selected' : ''); ?>>
                    ✅ In Stock
                </option>
                <option value="low"
                        <?php echo e(request('stock_filter') === 'low' ? 'selected' : ''); ?>>
                    ⚠️ Low Stock
                </option>
                <option value="out"
                        <?php echo e(request('stock_filter') === 'out' ? 'selected' : ''); ?>>
                    ❌ Out of Stock
                </option>
            </select>
        </div>

        
        <button type="submit"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold
                       bg-indigo-600 hover:bg-indigo-700 text-white
                       transition-all">
            Filter
        </button>

        <?php if(request()->hasAny(['search','category_id','stock_filter'])): ?>
        <a href="<?php echo e(route('stock.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            Clear
        </a>
        <?php endif; ?>

    </form>
</div>


<div class="flex items-center justify-between mb-3 px-1">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Showing <?php echo e($products->firstItem() ?? 0); ?>–<?php echo e($products->lastItem() ?? 0); ?>

        of <?php echo e($products->total()); ?> products
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
        Updating...
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
                        Product
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden sm:table-cell">
                        Category
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden md:table-cell">
                        Brand
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider
                                hidden lg:table-cell">
                        Price
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody id="stock-tbody"
                   class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php echo $__env->make('products.partials.stock-row',
                             compact('product'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7">
                            <div class="flex flex-col items-center
                                        justify-center py-16
                                        text-gray-400 dark:text-gray-600">
                                <svg class="w-16 h-16 mb-4 opacity-40"
                                     fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.5"
                                          d="M20 7l-8-4-8 4m16 0l-8
                                             4m8-4v10l-8 4m0-10L4 7m8
                                             4v10M4 7v10l8 4"/>
                                </svg>
                                <p class="text-sm font-semibold
                                           text-gray-500 dark:text-gray-400">
                                    No products found
                                </p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    
    <?php if($products->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        <?php echo e($products->links()); ?>

    </div>
    <?php endif; ?>

</div>


<div id="topup-modal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.75);align-items:center;
            justify-content:center;padding:16px;">

    <div id="topup-modal-box"
         style="transform:scale(0.95);opacity:0;transition:all 0.2s;
                width:100%;max-width:420px;"
         class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl
                overflow-hidden">

        
        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold text-gray-900 dark:text-white">
                    Top Up Stock
                </h3>
                <p id="topup-product-name"
                   class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                </p>
            </div>
            <button type="button"
                    onclick="StockManager.closeModal()"
                    class="w-8 h-8 rounded-full flex items-center
                           justify-center bg-gray-100 dark:bg-gray-800
                           text-gray-500 hover:bg-gray-200
                           dark:hover:bg-gray-700 hover:text-red-500
                           transition-all border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <div class="px-6 pt-5">
            <div class="flex items-center justify-between
                        bg-gray-50 dark:bg-gray-800 rounded-xl
                        px-4 py-3 mb-5">
                <span class="text-sm font-semibold text-gray-500
                             dark:text-gray-400">
                    Current Stock
                </span>
                <span id="topup-current-stock"
                      class="text-2xl font-black text-gray-900
                             dark:text-white">
                    0
                </span>
            </div>
        </div>

        
        <div class="px-6 pb-5 space-y-4">

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase
                               tracking-wider mb-2">
                    Quantity to Add
                    <span class="text-red-500 ml-0.5">*</span>
                </label>

                
                <div class="grid grid-cols-4 gap-2 mb-2">
                    <?php $__currentLoopData = [5, 10, 25, 50]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button"
                            onclick="StockManager.setQty(<?php echo e($qty); ?>)"
                            class="py-2 rounded-lg text-sm font-bold
                                   border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800
                                   text-gray-600 dark:text-gray-400
                                   hover:border-indigo-400
                                   hover:text-indigo-600
                                   hover:bg-indigo-50
                                   dark:hover:bg-indigo-900/20
                                   dark:hover:text-indigo-400
                                   transition-all">
                        +<?php echo e($qty); ?>

                    </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="flex items-stretch border-2
                            border-gray-200 dark:border-gray-700
                            rounded-xl overflow-hidden
                            focus-within:border-indigo-500 transition-all">
                    <button type="button"
                            onclick="StockManager.adjustQty(-1)"
                            class="px-4 bg-gray-50 dark:bg-gray-800
                                   border-r border-gray-200 dark:border-gray-700
                                   font-black text-xl text-gray-500
                                   hover:bg-gray-100 transition-colors
                                   border-none cursor-pointer flex-shrink-0">
                        −
                    </button>
                    <input type="number"
                           id="topup-quantity"
                           min="1"
                           max="9999"
                           value="1"
                           class="flex-1 px-4 py-3 text-xl font-black
                                  text-center outline-none bg-white
                                  dark:bg-gray-900 text-gray-900
                                  dark:text-white border-none">
                    <button type="button"
                            onclick="StockManager.adjustQty(1)"
                            class="px-4 bg-gray-50 dark:bg-gray-800
                                   border-l border-gray-200 dark:border-gray-700
                                   font-black text-xl text-gray-500
                                   hover:bg-gray-100 transition-colors
                                   border-none cursor-pointer flex-shrink-0">
                        +
                    </button>
                </div>

                
                <div class="flex items-center justify-between
                            mt-2 px-3 py-2 rounded-lg
                            bg-indigo-50 dark:bg-indigo-900/20
                            border border-indigo-100 dark:border-indigo-800">
                    <span class="text-xs font-semibold text-indigo-600
                                 dark:text-indigo-400">
                        New stock will be
                    </span>
                    <span id="topup-new-stock"
                          class="text-sm font-black text-indigo-700
                                 dark:text-indigo-300">
                        1
                    </span>
                </div>

            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase
                               tracking-wider mb-1.5">
                    Note (Optional)
                </label>
                <input type="text"
                       id="topup-note"
                       placeholder="e.g. New stock delivery..."
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              placeholder-gray-400
                              focus:border-indigo-500
                              focus:ring-2 focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900
                              transition-all">
            </div>

        </div>

        
        <div class="px-6 pb-6 flex gap-3">
            <button type="button"
                    onclick="StockManager.closeModal()"
                    class="flex-1 py-2.5 rounded-xl text-sm font-semibold
                           border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400
                           hover:bg-gray-50 dark:hover:bg-gray-800
                           transition-all">
                Cancel
            </button>
            <button type="button"
                    id="topup-submit-btn"
                    onclick="StockManager.submitTopup()"
                    class="flex-1 py-2.5 rounded-xl text-sm font-bold
                           bg-indigo-600 hover:bg-indigo-700
                           active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Stock
            </button>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/stock.js')); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    StockManager.init({
        csrf: '<?php echo e(csrf_token()); ?>',
        routes: {
            topup     : '/products/{id}/topup',
            movements : '/products/{id}/movements',
        },
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/products/stock.blade.php ENDPATH**/ ?>