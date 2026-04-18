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
 <?php $__env->slot('title', null, []); ?> Buy & Sell <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stat-card.active{border-color:#6366f1!important;box-shadow:0 0 0 2px rgba(99,102,241,.2);}
    #device-table-wrap{position:relative;transition:opacity .15s;}
    #device-table-wrap.loading{opacity:.4;pointer-events:none;}
    #dt-bar{display:none;position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#6366f1 0%,#a5b4fc 50%,#6366f1 100%);
        background-size:200% 100%;animation:dtSlide 1s linear infinite;z-index:10;}
    @keyframes dtSlide{0%{background-position:200% 0}100%{background-position:-200% 0}}
    .loading #dt-bar{display:block;}
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Buy & Sell','subtitle' => 'Manage device purchases and sales','breadcrumbs' => [['label'=>'Dashboard','route'=>'dashboard'],['label'=>'Buy & Sell']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Buy & Sell','subtitle' => 'Manage device purchases and sales','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label'=>'Dashboard','route'=>'dashboard'],['label'=>'Buy & Sell']])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('buy-sell.create')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buy Device
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
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>


<?php $sf = request('status',''); ?>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">

    <a href="<?php echo e(route('buy-sell.index', array_merge(request()->except(['status','page']),[]))); ?>"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all <?php echo e($sf==='' ? 'active':''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total</p>
        <p class="text-2xl font-black text-gray-900 dark:text-white"><?php echo e($stats['total']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">all devices</p>
    </a>

    <a href="<?php echo e(route('buy-sell.index', array_merge(request()->except(['status','page']),['status'=>'in_stock']))); ?>"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-emerald-400 hover:shadow-md transition-all <?php echo e($sf==='in_stock' ? 'active':''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">In Stock</p>
        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400"><?php echo e($stats['in_stock']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">available</p>
    </a>

    <a href="<?php echo e(route('buy-sell.index', array_merge(request()->except(['status','page']),['status'=>'sold']))); ?>"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all <?php echo e($sf==='sold' ? 'active':''); ?>">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sold</p>
        <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400"><?php echo e($stats['sold']); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">completed</p>
    </a>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stock Value</p>
        <p class="text-2xl font-black text-amber-600 dark:text-amber-400">£<?php echo e(number_format($stats['total_value'],2)); ?></p>
        <p class="text-xs text-gray-400 mt-0.5">purchase cost</p>
    </div>
</div>


<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 mb-4">
    <div class="flex flex-wrap gap-3 items-center">
        <div class="relative flex-1 min-w-48">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" id="filter-search" value="<?php echo e(request('search')); ?>"
                   placeholder="Search model, IMEI, serial..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                          text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900 transition-all">
        </div>
        <select id="filter-status"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       cursor-pointer focus:border-indigo-500 transition-all">
            <option value="">All Status</option>
            <option value="in_stock"     <?php echo e(request('status')==='in_stock'     ? 'selected':''); ?>>✅ In Stock</option>
            <option value="sold"         <?php echo e(request('status')==='sold'         ? 'selected':''); ?>>💰 Sold</option>
            <option value="reserved"     <?php echo e(request('status')==='reserved'     ? 'selected':''); ?>>🔒 Reserved</option>
            <option value="under_repair" <?php echo e(request('status')==='under_repair' ? 'selected':''); ?>>🔧 Under Repair</option>
        </select>
        <select id="filter-condition"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       cursor-pointer focus:border-indigo-500 transition-all">
            <option value="">All Conditions</option>
            <option value="new"         <?php echo e(request('condition')==='new'         ? 'selected':''); ?>>🌟 A — New</option>
            <option value="used"        <?php echo e(request('condition')==='used'        ? 'selected':''); ?>>✅ B — Good</option>
            <option value="refurbished" <?php echo e(request('condition')==='refurbished' ? 'selected':''); ?>>🔧 C — Average</option>
            <option value="faulty"      <?php echo e(request('condition')==='faulty'      ? 'selected':''); ?>>⚠️ D — Faulty</option>
        </select>
        <?php if(request()->hasAny(['search','status','condition'])): ?>
        <a href="<?php echo e(route('buy-sell.index')); ?>" onclick="showTableLoading()"
           class="px-3 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                  text-gray-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
            Clear ✕
        </a>
        <?php endif; ?>
    </div>
</div>


<div id="device-table-wrap"
     class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden"
     style="position:relative;">
    <div id="dt-bar"></div>
    <div id="device-list-body">
        <?php echo $__env->make('buy-sell.partials.device-list', compact('devices'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showTableLoading() {
    document.getElementById('device-table-wrap')?.classList.add('loading');
}

// Auto-filter on change
(function() {
    const base = '<?php echo e(route("buy-sell.index")); ?>';
    let st;

    function go() {
        showTableLoading();
        const p = new URLSearchParams();
        const s = document.getElementById('filter-search')?.value;
        const st= document.getElementById('filter-status')?.value;
        const c = document.getElementById('filter-condition')?.value;
        if(s)  p.set('search',s);
        if(st) p.set('status',st);
        if(c)  p.set('condition',c);
        window.location = base + (p.toString() ? '?'+p : '');
    }

    document.getElementById('filter-search')?.addEventListener('input', ()=>{ clearTimeout(st); st=setTimeout(go,350); });
    document.getElementById('filter-status')?.addEventListener('change', go);
    document.getElementById('filter-condition')?.addEventListener('change', go);
    window.addEventListener('pageshow', ()=>document.getElementById('device-table-wrap')?.classList.remove('loading'));
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/buy-sell/index.blade.php ENDPATH**/ ?>