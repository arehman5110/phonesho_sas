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
 <?php $__env->slot('title', null, []); ?> Products <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* ── Topup Modal ─────────────────────────────── */
    #topupModal {
        display: none;
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.5);
        align-items: center; justify-content: center; padding: 16px;
        animation: fadeIn 0.15s ease;
    }
    #topupModal.open { display: flex; }
    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }

    /* ── Loading overlay ─────────────────────────── */
    #products-loading {
        display: none;
        position: absolute; inset: 0; z-index: 10;
        background: rgba(255,255,255,0.6);
        dark:background: rgba(17,24,39,0.6);
        align-items: center; justify-content: center;
        border-radius: 1rem;
    }
    #products-loading.show { display: flex; }
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Products','subtitle' => 'Manage your product catalogue','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Products'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Products','subtitle' => 'Manage your product catalogue','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Products'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('products.stock')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 010 4M5 8v10a2 2 0
                         002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            Stock
        </a>
        <a href="<?php echo e(route('products.create')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                  text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Product
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
<div class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20
            border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">

    
    <div onclick="ProductIndex.filterByStock('')"
         class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 flex items-center gap-3 cursor-pointer
                hover:border-indigo-300 dark:hover:border-indigo-700
                hover:bg-indigo-50 dark:hover:bg-indigo-900/10 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/40
                    flex items-center justify-center flex-shrink-0
                    group-hover:bg-indigo-200 dark:group-hover:bg-indigo-900/60 transition-colors">
            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</p>
            <p class="text-2xl font-black text-gray-900 dark:text-white"><?php echo e($stats['total']); ?></p>
        </div>
    </div>

    
    <div onclick="ProductIndex.filterByStock('in')"
         class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                rounded-2xl p-4 flex items-center gap-3 cursor-pointer
                hover:border-emerald-300 dark:hover:border-emerald-700
                hover:bg-emerald-50 dark:hover:bg-emerald-900/10 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/40
                    flex items-center justify-center flex-shrink-0
                    group-hover:bg-emerald-200 transition-colors">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">In Stock</p>
            <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400"><?php echo e($stats['in_stock']); ?></p>
        </div>
    </div>

    
    <div onclick="ProductIndex.filterByStock('low')"
         class="bg-white dark:bg-gray-900 border border-amber-200 dark:border-amber-800
                rounded-2xl p-4 flex items-center gap-3 cursor-pointer
                hover:bg-amber-50 dark:hover:bg-amber-900/10 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-900/40
                    flex items-center justify-center flex-shrink-0
                    group-hover:bg-amber-200 transition-colors">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667
                         1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34
                         16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Low Stock</p>
            <p class="text-2xl font-black text-amber-600 dark:text-amber-400"><?php echo e($stats['low']); ?></p>
        </div>
    </div>

    
    <div onclick="ProductIndex.filterByStock('out')"
         class="bg-white dark:bg-gray-900 border border-red-200 dark:border-red-800
                rounded-2xl p-4 flex items-center gap-3 cursor-pointer
                hover:bg-red-50 dark:hover:bg-red-900/10 transition-all group">
        <div class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-900/40
                    flex items-center justify-center flex-shrink-0
                    group-hover:bg-red-200 transition-colors">
            <svg class="w-5 h-5 text-red-500 dark:text-red-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Out of Stock</p>
            <p class="text-2xl font-black text-red-500 dark:text-red-400"><?php echo e($stats['out']); ?></p>
        </div>
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text"
                   id="filter-search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search name or SKU..."
                   class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 transition-all">
        </div>

        
        <select id="filter-category"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>"
                        <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                    <?php echo e($cat->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select id="filter-brand"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700
                       rounded-xl text-sm outline-none
                       bg-gray-50 dark:bg-gray-800
                       text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Brands</option>
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($brand->id); ?>"
                        <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                    <?php echo e($brand->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <button id="filter-clear"
                style="display:none;"
                onclick="ProductIndex.clearFilters()"
                class="px-4 py-2.5 rounded-xl text-sm font-semibold
                       border border-gray-200 dark:border-gray-700
                       text-gray-600 dark:text-gray-400
                       hover:bg-gray-50 transition-all">
            Clear
        </button>

        
        <span id="stock-filter-badge" style="display:none;"
              class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                     text-xs font-bold bg-indigo-100 dark:bg-indigo-900/40
                     text-indigo-700 dark:text-indigo-300">
            <span id="stock-filter-label"></span>
            <button onclick="ProductIndex.filterByStock('')"
                    class="hover:text-indigo-900 font-black text-sm leading-none
                           bg-transparent border-none cursor-pointer p-0">×</button>
        </span>

    </div>

    
    <input type="hidden" id="filter-stock" value="<?php echo e(request('stock_filter', '')); ?>">
</div>


<div class="flex items-center justify-between mb-3 px-1">
    <p id="results-info" class="text-sm text-gray-500 dark:text-gray-400">
        Showing <?php echo e($products->firstItem() ?? 0); ?>–<?php echo e($products->lastItem() ?? 0); ?>

        of <?php echo e($products->total()); ?> products
    </p>
</div>


<div class="relative">

    
    <div id="products-loading">
        <svg class="w-6 h-6 animate-spin text-indigo-500"
             fill="none" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor"
                    stroke-width="4" opacity="0.25"/>
            <path fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
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
                                    uppercase tracking-wider">Product</th>
                        <th class="text-left px-4 py-3 text-xs font-bold
                                    text-gray-500 dark:text-gray-400
                                    uppercase tracking-wider hidden sm:table-cell">
                            Category / Brand</th>
                        <th class="text-left px-4 py-3 text-xs font-bold
                                    text-gray-500 dark:text-gray-400
                                    uppercase tracking-wider hidden md:table-cell">
                            Stock</th>
                        <th class="text-left px-4 py-3 text-xs font-bold
                                    text-gray-500 dark:text-gray-400
                                    uppercase tracking-wider">Price</th>
                        <th class="text-left px-4 py-3 text-xs font-bold
                                    text-gray-500 dark:text-gray-400
                                    uppercase tracking-wider hidden md:table-cell">
                            Status</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody id="products-tbody"
                       class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php echo $__env->make('products.partials.rows', ['products' => $products], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </tbody>
            </table>
        </div>

        <div id="products-pagination" class="<?php echo e($products->hasPages() ? '' : 'hidden'); ?>

                                              px-5 py-4 border-t
                                              border-gray-200 dark:border-gray-700">
            <?php echo e($products->links()); ?>

        </div>
    </div>
</div>


<div id="topupModal" onclick="if(event.target===this) ProductIndex.closeTopup()">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:400px;
                box-shadow:0 24px 60px rgba(0,0,0,0.2);overflow:hidden;
                font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;"
         class="dark:bg-gray-900">

        
        <div style="background:linear-gradient(135deg,#6366f1,#4f46e5);
                    padding:20px 24px;display:flex;align-items:center;
                    justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);
                            border-radius:10px;display:flex;align-items:center;
                            justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p style="color:#fff;font-weight:800;font-size:0.95rem;margin:0;">
                        Top Up Stock
                    </p>
                    <p id="topup-product-name"
                       style="color:rgba(255,255,255,0.75);font-size:0.75rem;margin:0;">
                    </p>
                </div>
            </div>
            <button onclick="ProductIndex.closeTopup()"
                    style="background:rgba(255,255,255,0.2);border:none;color:#fff;
                           width:32px;height:32px;border-radius:8px;cursor:pointer;
                           font-size:1rem;display:flex;align-items:center;
                           justify-content:center;">✕</button>
        </div>

        
        <div style="padding:24px;display:flex;flex-direction:column;gap:16px;">

            
            <div style="background:#f8fafc;border-radius:12px;padding:12px 16px;
                        display:flex;justify-content:space-between;align-items:center;"
                 class="dark:bg-gray-800">
                <span style="font-size:0.8rem;font-weight:600;color:#64748b;">
                    Current Stock
                </span>
                <span id="topup-current-stock"
                      style="font-size:1.2rem;font-weight:900;color:#1e293b;"
                      class="dark:text-white">
                    —
                </span>
            </div>

            
            <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;
                              color:#374151;margin-bottom:6px;text-transform:uppercase;
                              letter-spacing:0.05em;" class="dark:text-gray-300">
                    Quantity to Add <span style="color:#ef4444;">*</span>
                </label>
                <input id="topup-qty" type="number" min="1" max="9999"
                       placeholder="Enter quantity..."
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                              border-radius:10px;font-size:1.1rem;font-weight:700;
                              outline:none;box-sizing:border-box;
                              transition:border-color 0.15s;"
                       class="dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                       onfocus="this.style.borderColor='#6366f1'"
                       onblur="this.style.borderColor=''">
                <p id="topup-qty-err"
                   style="display:none;color:#ef4444;font-size:0.72rem;
                          margin:4px 0 0;font-weight:600;">
                    Please enter a quantity of at least 1.
                </p>
            </div>

            
            <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;
                              color:#374151;margin-bottom:6px;text-transform:uppercase;
                              letter-spacing:0.05em;" class="dark:text-gray-300">
                    Note <span style="color:#94a3b8;font-weight:400;text-transform:none;">
                        (optional)</span>
                </label>
                <input id="topup-note" type="text"
                       placeholder="e.g. New stock delivery..."
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                              border-radius:10px;font-size:0.875rem;outline:none;
                              box-sizing:border-box;transition:border-color 0.15s;"
                       class="dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                       onfocus="this.style.borderColor='#6366f1'"
                       onblur="this.style.borderColor=''">
            </div>

            
            <div id="topup-error"
                 style="display:none;background:#fef2f2;border:1.5px solid #fecaca;
                        border-radius:10px;padding:10px 14px;
                        color:#dc2626;font-size:0.8rem;font-weight:600;"></div>

        </div>

        
        <div style="padding:0 24px 24px;display:flex;gap:10px;">
            <button onclick="ProductIndex.closeTopup()"
                    style="flex:1;padding:11px;border-radius:10px;
                           border:1.5px solid #e5e7eb;background:#fff;
                           color:#6b7280;font-weight:700;font-size:0.875rem;
                           cursor:pointer;transition:all 0.15s;"
                    class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                Cancel
            </button>
            <button id="topup-submit"
                    onclick="ProductIndex.submitTopup()"
                    style="flex:2;padding:11px;border-radius:10px;border:none;
                           background:#6366f1;color:#fff;font-weight:800;
                           font-size:0.875rem;cursor:pointer;
                           transition:background 0.15s;display:flex;
                           align-items:center;justify-content:center;gap:7px;">
                <svg width="15" height="15" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                Add Stock
            </button>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
const ProductIndex = (() => {

    // ── State ──────────────────────────────────────
    const state = {
        searchTimer : null,
        currentPage : 1,
        topupId     : null,
        isLoading   : false,
        csrf        : '<?php echo e(csrf_token()); ?>',
        indexUrl    : '<?php echo e(route("products.index")); ?>',
        topupBase   : '/products/{id}/topup',
    };

    // ── Init ───────────────────────────────────────
    function init() {
        // Search with debounce
        document.getElementById('filter-search')
            ?.addEventListener('input', () => {
                clearTimeout(state.searchTimer);
                state.searchTimer = setTimeout(() => {
                    state.currentPage = 1;
                    _fetch();
                }, 350);
            });

        // Category — immediate
        document.getElementById('filter-category')
            ?.addEventListener('change', () => {
                state.currentPage = 1;
                _fetch();
            });

        // Brand — immediate
        document.getElementById('filter-brand')
            ?.addEventListener('change', () => {
                state.currentPage = 1;
                _fetch();
            });

        // Show clear button if filters active
        _updateClearBtn();

        // Pagination clicks (delegated)
        document.addEventListener('click', (e) => {
            const pageLink = e.target.closest('[data-page]');
            if (pageLink) {
                e.preventDefault();
                state.currentPage = parseInt(pageLink.dataset.page);
                _fetch();
            }
        });
    }

    // ── Fetch products via AJAX ────────────────────
    async function _fetch() {
        if (state.isLoading) return;
        state.isLoading = true;

        const loading = document.getElementById('products-loading');
        if (loading) loading.classList.add('show');

        _updateClearBtn();

        const params = _buildParams();
        window.history.replaceState({}, '', `${state.indexUrl}?${params}`);

        try {
            const res  = await fetch(`${state.indexUrl}?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                    'X-CSRF-TOKEN'    : state.csrf,
                },
            });
            const data = await res.json();
            _render(data);
        } catch (e) {
            console.error('Products fetch error:', e);
        } finally {
            state.isLoading = false;
            if (loading) loading.classList.remove('show');
        }
    }

    // ── Build query params ─────────────────────────
    function _buildParams() {
        const params = new URLSearchParams();
        const search   = document.getElementById('filter-search')?.value?.trim();
        const category = document.getElementById('filter-category')?.value;
        const brand    = document.getElementById('filter-brand')?.value;
        const stock    = document.getElementById('filter-stock')?.value;

        if (search)   params.set('search',       search);
        if (category) params.set('category_id',  category);
        if (brand)    params.set('brand_id',     brand);
        if (stock)    params.set('stock_filter', stock);
        params.set('page', state.currentPage);
        return params;
    }

    // ── Render response ────────────────────────────
    function _render(data) {
        const tbody = document.getElementById('products-tbody');
        const info  = document.getElementById('results-info');
        const pager = document.getElementById('products-pagination');

        if (tbody) tbody.innerHTML = data.rows;

        if (info) {
            const from = data.from ?? 0;
            const to   = data.to   ?? 0;
            const total= data.total ?? 0;
            info.textContent = total > 0
                ? `Showing ${from}–${to} of ${total} products`
                : '0 products found';
        }

        if (pager) {
            pager.innerHTML   = data.pagination_html ?? '';
            pager.className   = (data.has_pages ? '' : 'hidden') +
                                ' px-5 py-4 border-t border-gray-200 dark:border-gray-700';
        }
    }

    // ── Clear button visibility ────────────────────
    function _updateClearBtn() {
        const search   = document.getElementById('filter-search')?.value?.trim();
        const category = document.getElementById('filter-category')?.value;
        const brand    = document.getElementById('filter-brand')?.value;
        const stock    = document.getElementById('filter-stock')?.value;
        const btn      = document.getElementById('filter-clear');
        const badge    = document.getElementById('stock-filter-badge');
        const label    = document.getElementById('stock-filter-label');

        if (btn) btn.style.display = (search || category || brand || stock) ? '' : 'none';

        if (badge && label) {
            if (stock) {
                const labels = { in: 'In Stock', low: 'Low Stock', out: 'Out of Stock' };
                label.textContent   = labels[stock] ?? stock;
                badge.style.display = 'inline-flex';
            } else {
                badge.style.display = 'none';
            }
        }
    }

    // ── Filter by stock status (from stat cards) ───
    function filterByStock(value) {
        const input = document.getElementById('filter-stock');
        if (input) input.value = value;
        state.currentPage = 1;
        _updateClearBtn();
        _fetch();
    }

    // ── Clear all filters ──────────────────────────
    function clearFilters() {
        const s = document.getElementById('filter-search');
        const c = document.getElementById('filter-category');
        const b = document.getElementById('filter-brand');
        const k = document.getElementById('filter-stock');
        if (s) s.value = '';
        if (c) c.value = '';
        if (b) b.value = '';
        if (k) k.value = '';
        state.currentPage = 1;
        _fetch();
    }

    // ── Open topup modal ───────────────────────────
    function openTopup(productId, productName, currentStock) {
        state.topupId = productId;

        document.getElementById('topup-product-name').textContent = productName;
        document.getElementById('topup-current-stock').textContent = currentStock;
        document.getElementById('topup-qty').value   = '';
        document.getElementById('topup-note').value  = '';
        document.getElementById('topup-qty-err').style.display  = 'none';
        document.getElementById('topup-error').style.display    = 'none';

        document.getElementById('topupModal').classList.add('open');
        setTimeout(() => document.getElementById('topup-qty').focus(), 100);
    }

    function closeTopup() {
        document.getElementById('topupModal').classList.remove('open');
        state.topupId = null;
    }

    // ── Submit topup ───────────────────────────────
    async function submitTopup() {
        const qtyInput = document.getElementById('topup-qty');
        const noteInput= document.getElementById('topup-note');
        const submitBtn= document.getElementById('topup-submit');
        const errDiv   = document.getElementById('topup-error');

        document.getElementById('topup-qty-err').style.display = 'none';
        errDiv.style.display = 'none';

        const qty = parseInt(qtyInput.value);
        if (!qty || qty < 1) {
            document.getElementById('topup-qty-err').style.display = 'block';
            qtyInput.style.borderColor = '#ef4444';
            return;
        }

        submitBtn.disabled   = true;
        submitBtn.innerHTML  = `
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                 style="animation:spin 1s linear infinite;">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="4" opacity="0.25"/>
                <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg> Adding...`;

        try {
            const url = state.topupBase.replace('{id}', state.topupId);
            const res = await fetch(url, {
                method : 'POST',
                headers: {
                    'Content-Type'    : 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN'    : state.csrf,
                    'Accept'          : 'application/json',
                },
                body: JSON.stringify({
                    quantity: qty,
                    note    : noteInput.value.trim() || null,
                }),
            });

            const data = await res.json();

            if (data.success) {
                closeTopup();
                _showToast(`✓ ${data.message}`, '#10b981');
                // Update stock in the table row without a page reload
                const stockEl = document.querySelector(
                    `[data-product-stock="${state.topupId}"]`
                );
                if (stockEl) {
                    stockEl.textContent = data.new_stock;
                    stockEl.className   = 'text-sm font-bold ' + (
                        data.is_out ? 'text-red-500' :
                        data.is_low ? 'text-amber-500' :
                        'text-gray-900 dark:text-white'
                    );
                }
            } else {
                errDiv.textContent   = data.message || 'Failed to top up.';
                errDiv.style.display = 'block';
            }

        } catch (e) {
            errDiv.textContent   = 'Network error. Please try again.';
            errDiv.style.display = 'block';
        } finally {
            submitBtn.disabled  = false;
            submitBtn.innerHTML = `
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg> Add Stock`;
        }
    }

    // ── Toast ──────────────────────────────────────
    function _showToast(msg, bg = '#10b981') {
        const t = document.createElement('div');
        t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:99999;
            padding:10px 18px;border-radius:12px;color:#fff;font-size:0.85rem;
            font-weight:700;background:${bg};box-shadow:0 8px 24px rgba(0,0,0,0.15);
            transform:translateY(10px);opacity:0;transition:all 0.25s ease;`;
        t.textContent = msg;
        document.body.appendChild(t);
        requestAnimationFrame(() => requestAnimationFrame(() => {
            t.style.transform = 'translateY(0)';
            t.style.opacity   = '1';
        }));
        setTimeout(() => {
            t.style.opacity = '0';
            t.style.transform = 'translateY(10px)';
            setTimeout(() => t.remove(), 250);
        }, 3000);
    }

    // ── Enter key on qty input ─────────────────────
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' &&
            document.getElementById('topupModal')?.classList.contains('open')) {
            submitTopup();
        }
        if (e.key === 'Escape' &&
            document.getElementById('topupModal')?.classList.contains('open')) {
            closeTopup();
        }
    });

    return { init, clearFilters, filterByStock, openTopup, closeTopup, submitTopup };

})();

document.addEventListener('DOMContentLoaded', () => ProductIndex.init());
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/products/index.blade.php ENDPATH**/ ?>