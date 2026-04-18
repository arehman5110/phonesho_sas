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
    .stat-card.active { border-color: #6366f1 !important; box-shadow: 0 0 0 2px rgba(99,102,241,.2); }
    .dark .stat-card.active { border-color: #818cf8 !important; }
    .filter-tag {
        display:inline-flex;align-items:center;gap:5px;padding:3px 10px;
        border-radius:999px;font-size:.72rem;font-weight:700;
        background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;white-space:nowrap;
    }
    .dark .filter-tag { background:#1e1b4b;color:#a5b4fc;border-color:#3730a3; }

    /* ── Table loading overlay ── */
    #products-table-wrap { position:relative; transition:opacity 0.15s; }
    #products-table-wrap.loading { opacity:0.4; pointer-events:none; }
    #table-loading-bar {
        display:none;
        position:absolute;
        top:0; left:0; right:0;
        height:3px;
        background:linear-gradient(90deg,#6366f1 0%,#a5b4fc 50%,#6366f1 100%);
        background-size:200% 100%;
        animation:tableLoadSlide 1s linear infinite;
        z-index:10;
        border-radius:2px 2px 0 0;
    }
    @keyframes tableLoadSlide {
        0%   { background-position:200% 0; }
        100% { background-position:-200% 0; }
    }
    #table-loading-overlay {
        display:none;
        position:absolute;
        inset:0;
        align-items:center;
        justify-content:center;
        z-index:9;
    }
    .loading #table-loading-bar    { display:block; }
    .loading #table-loading-overlay{ display:flex; }
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
        <a href="<?php echo e(route('products.report', ['type' => 'all'])); ?>"
           target="_blank"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0
                         002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2
                         2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Report
        </a>

        <a href="<?php echo e(route('products.create')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
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


<?php $sf = request('stock_filter', ''); ?>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">

    <a href="<?php echo e(route('products.index', array_merge(request()->except(['stock_filter','page']), []))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all
              <?php echo e($sf === '' ? 'active' : ''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Products</p>
        <p class="text-2xl font-black text-gray-900 dark:text-white"><?php echo e($stats['total']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">all items</p>
    </a>

    <a href="<?php echo e(route('products.index', array_merge(request()->except(['stock_filter','page']), ['stock_filter'=>'in_stock']))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-emerald-400 hover:shadow-md transition-all
              <?php echo e($sf === 'in_stock' ? 'active' : ''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">In Stock</p>
        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400"><?php echo e($stats['in_stock']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">available</p>
    </a>

    <a href="<?php echo e(route('products.index', array_merge(request()->except(['stock_filter','page']), ['stock_filter'=>'low_stock']))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-amber-400 hover:shadow-md transition-all
              <?php echo e($sf === 'low_stock' ? 'active' : ''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">⚠️ Low Stock</p>
        <p class="text-2xl font-black text-amber-600 dark:text-amber-400"><?php echo e($stats['low_stock']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">need restock</p>
    </a>

    <a href="<?php echo e(route('products.index', array_merge(request()->except(['stock_filter','page']), ['stock_filter'=>'out_stock']))); ?>"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-red-400 hover:shadow-md transition-all
              <?php echo e($sf === 'out_stock' ? 'active' : ''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">❌ Out of Stock</p>
        <p class="text-2xl font-black text-red-500"><?php echo e($stats['out_stock']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">unavailable</p>
    </a>

</div>


<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 mb-4">
    <div class="flex flex-wrap gap-3 items-center">

        
        <div class="flex-1 min-w-48 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" id="filter-search"
                   value="<?php echo e(request('search')); ?>"
                   placeholder="Search name or SKU..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white placeholder-gray-400
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900 transition-all">
        </div>

        
        <select id="filter-category"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Categories</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category_id') == $cat->id ? 'selected' : ''); ?>>
                <?php echo e($cat->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select id="filter-brand"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Brands</option>
            <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($brand->id); ?>" <?php echo e(request('brand_id') == $brand->id ? 'selected' : ''); ?>>
                <?php echo e($brand->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select id="filter-stock"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       focus:border-indigo-500 transition-all cursor-pointer">
            <option value="">All Stock</option>
            <option value="in_stock"  <?php echo e(request('stock_filter') === 'in_stock'  ? 'selected' : ''); ?>>✅ In Stock</option>
            <option value="low_stock" <?php echo e(request('stock_filter') === 'low_stock' ? 'selected' : ''); ?>>⚠️ Low Stock</option>
            <option value="out_stock" <?php echo e(request('stock_filter') === 'out_stock' ? 'selected' : ''); ?>>❌ Out of Stock</option>
        </select>

        
        <?php if(request()->hasAny(['search','category_id','brand_id','stock_filter'])): ?>
        <a href="<?php echo e(route('products.index')); ?>"
           id="clear-filters"
           class="px-3 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-500 hover:text-red-500
                  hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
            Clear ✕
        </a>
        <?php endif; ?>

    </div>

    
    <?php
        $tags = [];
        if(request('search'))         $tags[] = ['Search: ' . request('search'),           'search'];
        if(request('category_id'))    $tags[] = ['Category: ' . ($categories->find(request('category_id'))?->name ?? request('category_id')), 'category_id'];
        if(request('brand_id'))       $tags[] = ['Brand: ' . ($brands->find(request('brand_id'))?->name ?? request('brand_id')),    'brand_id'];
        if(request('stock_filter'))   $tags[] = [match(request('stock_filter')) {
            'low_stock' => '⚠️ Low Stock', 'out_stock' => '❌ Out of Stock', 'in_stock' => '✅ In Stock', default => request('stock_filter')
        }, 'stock_filter'];
    ?>
    <?php if(count($tags) > 0): ?>
    <div class="flex items-center gap-2 flex-wrap mt-3 pt-3 border-t border-gray-100 dark:border-gray-800">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Showing:</span>
        <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $param]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('products.index', request()->except([$param, 'page']))); ?>"
           class="filter-tag group">
            <?php echo e($label); ?>

            <span class="opacity-50 group-hover:opacity-100">✕</span>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
</div>


<div class="flex items-center justify-between mb-3 px-1">
    <p class="text-sm text-gray-500 dark:text-gray-400">
        Showing <?php echo e($products->firstItem() ?? 0); ?>–<?php echo e($products->lastItem() ?? 0); ?>

        of <?php echo e($products->total()); ?> products
    </p>
</div>


<div id="products-table-wrap" class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden" style="position:relative;">
    <div id="table-loading-bar"></div>
    <div id="table-loading-overlay">
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
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Product</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Category / Brand</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Stock</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                    <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isOut = $product->stock <= 0;
                    $isLow = !$isOut && $product->stock <= ($product->low_stock_alert ?? 5);
                ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/40
                                        flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($product->name); ?></p>
                                <?php if($product->sku): ?>
                                <p class="text-xs text-gray-400 font-mono"><?php echo e($product->sku); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3.5 hidden sm:table-cell">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($product->category?->name ?? '—'); ?></p>
                        <p class="text-xs text-gray-400 dark:text-gray-500"><?php echo e($product->brand?->name ?? ''); ?></p>
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell">
                        <span class="text-sm font-bold <?php echo e($isOut ? 'text-red-500' : ($isLow ? 'text-amber-500' : 'text-gray-900 dark:text-white')); ?>">
                            <?php echo e($product->stock); ?>

                        </span>
                        <?php if($isOut): ?>
                        <span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full
                                     bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">Out</span>
                        <?php elseif($isLow): ?>
                        <span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full
                                     bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">Low</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3.5">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">£<?php echo e(number_format($product->sell_price, 2)); ?></p>
                        <?php if($product->cost_price): ?>
                        <p class="text-xs text-gray-400">Cost: £<?php echo e(number_format($product->cost_price, 2)); ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full
                                     <?php echo e($product->is_active
                                         ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
                                         : 'bg-gray-100 dark:bg-gray-800 text-gray-500'); ?>">
                            <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="<?php echo e(route('products.edit', $product)); ?>"
                               class="w-7 h-7 rounded-lg flex items-center justify-center
                                      bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    title="Top Up Stock"
                                    onclick="openTopupModal(<?php echo e($product->id); ?>, '<?php echo e(addslashes($product->name)); ?>', <?php echo e($product->stock); ?>)"
                                    class="w-7 h-7 rounded-lg flex items-center justify-center
                                           bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400
                                           hover:bg-emerald-100 transition-colors border-none cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                            <form method="POST" action="<?php echo e(route('products.destroy', $product)); ?>"
                                  onsubmit="return confirm('Deactivate <?php echo e(addslashes($product->name)); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center
                                               bg-red-50 dark:bg-red-900/30 text-red-500
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
                    <td colspan="6">
                        <div class="flex flex-col items-center justify-center py-16 text-gray-400 dark:text-gray-600">
                            <svg class="w-16 h-16 mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No products found</p>
                            <a href="<?php echo e(route('products.create')); ?>"
                               class="mt-2 text-sm text-indigo-500 hover:text-indigo-700 font-semibold">
                                Add your first product
                            </a>
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
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(15,23,42,0.75);align-items:center;
            justify-content:center;padding:16px;"
     onclick="if(event.target===this) closeTopupModal()">
    <div id="topup-modal-box"
         style="transform:scale(0.95);opacity:0;transition:all 0.18s;"
         class="relative w-full max-w-sm bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">

        
        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Top Up Stock</h3>
                    <p id="topup-product-name" class="text-xs text-gray-400 truncate max-w-48"></p>
                </div>
            </div>
            <button type="button" onclick="closeTopupModal()"
                    class="w-8 h-8 rounded-full flex items-center justify-center
                           bg-gray-100 dark:bg-gray-800 text-gray-500
                           hover:bg-gray-200 dark:hover:bg-gray-700 hover:text-red-500
                           transition-all border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 space-y-4">

            
            <div class="flex items-center justify-between px-4 py-3 rounded-xl
                        bg-gray-50 dark:bg-gray-800">
                <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Current Stock</span>
                <span id="topup-current-stock"
                      class="text-lg font-black text-gray-900 dark:text-white"></span>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Add Quantity <span class="text-red-500">*</span>
                </label>
                <input type="number" id="topup-qty" min="1" max="9999" value="1"
                       oninput="updateTopupPreview()"
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white text-center text-lg font-bold
                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
                <p class="text-xs text-center text-gray-400 mt-1">
                    New total: <span id="topup-new-total" class="font-bold text-emerald-600 dark:text-emerald-400"></span>
                </p>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Note <span class="text-gray-400 font-normal normal-case">(optional)</span>
                </label>
                <input type="text" id="topup-note" placeholder="e.g. New delivery"
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white placeholder-gray-400
                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
            </div>

            
            <div id="topup-error" style="display:none;"
                 class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-600 dark:text-red-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="topup-error-text"></span>
            </div>

        </div>

        
        <div class="px-6 pb-6 flex gap-3">
            <button type="button" onclick="closeTopupModal()"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold
                           border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400
                           hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                Cancel
            </button>
            <button type="button" id="topup-save-btn" onclick="saveTopup()"
                    class="flex-1 py-3 rounded-xl text-sm font-bold
                           bg-emerald-600 hover:bg-emerald-700 active:scale-95
                           text-white transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Stock
            </button>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
// ── Topup Modal ──────────────────────────────────────────────
let _topupProductId  = null;
let _topupCurrent    = 0;
const _topupCsrf     = document.querySelector('meta[name="csrf-token"]')?.content;

function openTopupModal(productId, productName, currentStock) {
    _topupProductId = productId;
    _topupCurrent   = parseInt(currentStock) || 0;

    document.getElementById('topup-product-name').textContent  = productName;
    document.getElementById('topup-current-stock').textContent = _topupCurrent;
    document.getElementById('topup-qty').value                 = 1;
    document.getElementById('topup-note').value                = '';
    document.getElementById('topup-error').style.display       = 'none';
    document.getElementById('topup-save-btn').disabled         = false;
    document.getElementById('topup-save-btn').textContent      = 'Add Stock';
    updateTopupPreview();

    const modal = document.getElementById('topup-modal');
    const box   = document.getElementById('topup-modal-box');
    modal.style.display = 'flex';
    requestAnimationFrame(() => requestAnimationFrame(() => {
        box.style.transform = 'scale(1)';
        box.style.opacity   = '1';
    }));
    setTimeout(() => document.getElementById('topup-qty')?.focus(), 150);
}

function closeTopupModal() {
    const modal = document.getElementById('topup-modal');
    const box   = document.getElementById('topup-modal-box');
    box.style.transform = 'scale(0.95)';
    box.style.opacity   = '0';
    setTimeout(() => { modal.style.display = 'none'; }, 180);
}

function updateTopupPreview() {
    const qty  = parseInt(document.getElementById('topup-qty')?.value) || 0;
    const total = document.getElementById('topup-new-total');
    if (total) total.textContent = (_topupCurrent + qty) + ' units';
}

async function saveTopup() {
    const qty  = parseInt(document.getElementById('topup-qty')?.value) || 0;
    const note = document.getElementById('topup-note')?.value.trim();
    const btn  = document.getElementById('topup-save-btn');
    const err  = document.getElementById('topup-error');

    err.style.display = 'none';

    if (!qty || qty < 1) {
        document.getElementById('topup-error-text').textContent = 'Please enter a quantity of at least 1.';
        err.style.display = 'flex';
        return;
    }

    btn.disabled    = true;
    btn.textContent = 'Saving...';

    try {
        const url = `/products/${_topupProductId}/topup`;
        const res = await fetch(url, {
            method : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': _topupCsrf,
                'Accept'      : 'application/json',
            },
            body: JSON.stringify({ quantity: qty, note: note || 'Manual stock top-up' }),
        });
        const data = await res.json();

        if (data.success) {
            // Update the stock cell in the table without full reload
            _updateStockCell(_topupProductId, data.new_stock, data.is_low, data.is_out);
            closeTopupModal();
            _showToast('✓ ' + data.message, 'success');
        } else {
            document.getElementById('topup-error-text').textContent = data.message || 'Failed to update stock.';
            err.style.display = 'flex';
            btn.disabled      = false;
            btn.textContent   = 'Add Stock';
        }
    } catch(e) {
        document.getElementById('topup-error-text').textContent = 'Network error. Please try again.';
        err.style.display = 'flex';
        btn.disabled      = false;
        btn.textContent   = 'Add Stock';
    }
}

function _updateStockCell(productId, newStock, isLow, isOut) {
    // Find the topup button with matching productId and walk up to the row
    const btn = document.querySelector(`button[onclick*="openTopupModal(${productId},"]`);
    if (!btn) return;
    const row  = btn.closest('tr');
    if (!row)  return;
    const cell = row.querySelector('td.hidden.md\:table-cell');
    if (!cell) return;

    const color = isOut ? 'color:#ef4444' : (isLow ? 'color:#f59e0b' : '');
    const badge = isOut
        ? '<span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full bg-red-100 text-red-600">Out</span>'
        : (isLow
            ? '<span class="ml-1 text-xs font-bold px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-600">Low</span>'
            : '');
    cell.innerHTML = `<span class="text-sm font-bold" style="${color}">${newStock}</span>${badge}`;
}

function _showToast(msg, type) {
    const colors = { success: '#10b981', error: '#ef4444' };
    const el = document.createElement('div');
    el.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:9999;
        padding:10px 18px;border-radius:12px;color:#fff;font-size:.85rem;
        font-weight:700;background:${colors[type]||colors.success};
        transform:translateY(10px);opacity:0;transition:all .25s ease;
        box-shadow:0 8px 24px rgba(0,0,0,.15);`;
    el.textContent = msg;
    document.body.appendChild(el);
    requestAnimationFrame(() => requestAnimationFrame(() => {
        el.style.transform = 'translateY(0)'; el.style.opacity = '1';
    }));
    setTimeout(() => {
        el.style.opacity = '0'; el.style.transform = 'translateY(10px)';
        setTimeout(() => el.remove(), 250);
    }, 3000);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeTopupModal(); });

// ── Auto-submit on filter change — no button needed
(function() {
    const base = '<?php echo e(route("products.index")); ?>';

    function getParams() {
        const p = new URLSearchParams(window.location.search);
        return p;
    }

    function go(key, value) {
        const p = getParams();
        // preserve existing params
        const search   = document.getElementById('filter-search')?.value.trim() || '';
        const category = document.getElementById('filter-category')?.value || '';
        const brand    = document.getElementById('filter-brand')?.value || '';
        const stock    = document.getElementById('filter-stock')?.value || '';

        const np = new URLSearchParams();
        if (search)   np.set('search', search);
        if (category) np.set('category_id', category);
        if (brand)    np.set('brand_id', brand);
        if (stock)    np.set('stock_filter', stock);

        // Override with new value
        if (key && value) np.set(key, value);
        else if (key)     np.delete(key);

        // Show loading state on table before navigation
        const wrap = document.getElementById('products-table-wrap');
        if (wrap) wrap.classList.add('loading');

        window.location = base + (np.toString() ? '?' + np.toString() : '');
    }

    let _st;
    document.getElementById('filter-search')?.addEventListener('input', function() {
        clearTimeout(_st);
        _st = setTimeout(() => go(), 350);
    });

    document.getElementById('filter-category')?.addEventListener('change', () => go());
    document.getElementById('filter-brand')?.addEventListener('change', () => go());
    document.getElementById('filter-stock')?.addEventListener('change', () => go());

    // Show loading when navigating via stat cards or filter tags
    document.querySelectorAll('.stat-card, .filter-tag').forEach(el => {
        el.addEventListener('click', () => {
            const wrap = document.getElementById('products-table-wrap');
            if (wrap) wrap.classList.add('loading');
        });
    });

    // Also show on page navigation (back/forward)
    window.addEventListener('pageshow', () => {
        const wrap = document.getElementById('products-table-wrap');
        if (wrap) wrap.classList.remove('loading');
    });
})();
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