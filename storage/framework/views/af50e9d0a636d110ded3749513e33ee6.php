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
 <?php $__env->slot('title', null, []); ?> Stock Movements — <?php echo e($product->name); ?> <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Stock Movements','subtitle' => $product->name,'breadcrumbs' => [
        ['label' => 'Dashboard',  'route' => 'dashboard'],
        ['label' => 'Products',   'route' => 'products.index'],
        ['label' => $product->name],
        ['label' => 'Movements'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Stock Movements','subtitle' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->name),'breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard',  'route' => 'dashboard'],
        ['label' => 'Products',   'route' => 'products.index'],
        ['label' => $product->name],
        ['label' => 'Movements'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <button onclick="document.getElementById('topupModal').classList.add('open')"
                class="flex items-center gap-2 px-4 py-2.5 rounded-xl
                       text-sm font-bold bg-emerald-600 hover:bg-emerald-700
                       active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Top Up Stock
        </button>
        <a href="<?php echo e(route('products.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
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


<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-5">

    <div class="bg-white dark:bg-gray-900 border border-gray-200
                dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
            Current Stock
        </p>
        <p id="current-stock-display"
           class="text-2xl font-black
                  <?php echo e($product->stock <= 0 ? 'text-red-500' :
                    ($product->stock <= ($product->low_stock_alert ?? 5) ? 'text-amber-500' :
                    'text-gray-900 dark:text-white')); ?>">
            <?php echo e($product->stock); ?>

        </p>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200
                dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
            Low Stock Alert
        </p>
        <p class="text-2xl font-black text-gray-900 dark:text-white">
            <?php echo e($product->low_stock_alert ?? 5); ?>

        </p>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200
                dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
            Sell Price
        </p>
        <p class="text-2xl font-black text-gray-900 dark:text-white">
            £<?php echo e(number_format($product->sell_price, 2)); ?>

        </p>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200
                dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
            Total Movements
        </p>
        <p class="text-2xl font-black text-gray-900 dark:text-white">
            <?php echo e($movements->total()); ?>

        </p>
    </div>

</div>


<div class="bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-700 rounded-2xl overflow-hidden">

    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800
                flex items-center justify-between">
        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
            Movement History
        </h3>
        <span class="text-xs text-gray-400">Most recent first</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">Date</th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">Type</th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider">Qty</th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden sm:table-cell">
                        Note</th>
                    <th class="text-left px-4 py-3 text-xs font-bold
                                text-gray-500 dark:text-gray-400
                                uppercase tracking-wider hidden md:table-cell">
                        By</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $move): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isPositive = $move->quantity > 0;
                    $typeColors = [
                        'topup'  => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                        'sale'   => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                        'repair' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                        'manual' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                        'return' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                    ];
                    $typeColor = $typeColors[$move->type] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-600';
                ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                    <td class="px-4 py-3.5">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            <?php echo e($move->created_at->format('d/m/Y')); ?>

                        </p>
                        <p class="text-xs text-gray-400">
                            <?php echo e($move->created_at->format('H:i')); ?>

                        </p>
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full <?php echo e($typeColor); ?>">
                            <?php echo e(ucfirst($move->type)); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3.5">
                        <span class="text-sm font-black
                                     <?php echo e($isPositive ? 'text-emerald-600' : 'text-red-500'); ?>">
                            <?php echo e($isPositive ? '+' : ''); ?><?php echo e($move->quantity); ?>

                        </span>
                    </td>
                    <td class="px-4 py-3.5 hidden sm:table-cell">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo e($move->note ?? '—'); ?>

                        </p>
                    </td>
                    <td class="px-4 py-3.5 hidden md:table-cell">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <?php echo e($move->user?->name ?? 'System'); ?>

                        </p>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5">
                        <div class="flex flex-col items-center justify-center
                                    py-16 text-gray-400 dark:text-gray-600">
                            <svg class="w-16 h-16 mb-4 opacity-40" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.5"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2
                                         2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2
                                         2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0
                                         0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2
                                         2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                No movements yet
                            </p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($movements->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-200 dark:border-gray-700">
        <?php echo e($movements->links()); ?>

    </div>
    <?php endif; ?>

</div>


<div id="topupModal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(0,0,0,0.5);align-items:center;
            justify-content:center;padding:16px;"
     onclick="if(event.target===this) closeTopupModal()">
    <div style="background:#fff;border-radius:20px;width:100%;max-width:400px;
                box-shadow:0 24px 60px rgba(0,0,0,0.2);overflow:hidden;"
         class="dark:bg-gray-900">

        <div style="background:linear-gradient(135deg,#6366f1,#4f46e5);
                    padding:20px 24px;display:flex;align-items:center;
                    justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);
                            border-radius:10px;display:flex;align-items:center;
                            justify-content:center;">
                    <svg width="18" height="18" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p style="color:#fff;font-weight:800;font-size:0.95rem;margin:0;">
                        Top Up Stock
                    </p>
                    <p style="color:rgba(255,255,255,0.75);font-size:0.75rem;margin:0;">
                        <?php echo e($product->name); ?>

                    </p>
                </div>
            </div>
            <button onclick="closeTopupModal()"
                    style="background:rgba(255,255,255,0.2);border:none;color:#fff;
                           width:32px;height:32px;border-radius:8px;cursor:pointer;
                           font-size:1rem;display:flex;align-items:center;
                           justify-content:center;">✕</button>
        </div>

        <div style="padding:24px;display:flex;flex-direction:column;gap:16px;">
            <div style="background:#f8fafc;border-radius:12px;padding:12px 16px;
                        display:flex;justify-content:space-between;align-items:center;"
                 class="dark:bg-gray-800">
                <span style="font-size:0.8rem;font-weight:600;color:#64748b;">Current Stock</span>
                <span id="mv-current-stock"
                      style="font-size:1.2rem;font-weight:900;color:#1e293b;"
                      class="dark:text-white"><?php echo e($product->stock); ?></span>
            </div>

            <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;
                              color:#374151;margin-bottom:6px;text-transform:uppercase;
                              letter-spacing:0.05em;" class="dark:text-gray-300">
                    Quantity to Add <span style="color:#ef4444;">*</span>
                </label>
                <input id="mv-topup-qty" type="number" min="1" max="9999"
                       placeholder="Enter quantity..."
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                              border-radius:10px;font-size:1.1rem;font-weight:700;
                              outline:none;box-sizing:border-box;"
                       class="dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

            <div>
                <label style="display:block;font-size:0.75rem;font-weight:700;
                              color:#374151;margin-bottom:6px;text-transform:uppercase;
                              letter-spacing:0.05em;" class="dark:text-gray-300">
                    Note <span style="color:#94a3b8;font-weight:400;text-transform:none;">(optional)</span>
                </label>
                <input id="mv-topup-note" type="text"
                       placeholder="e.g. New stock delivery..."
                       style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                              border-radius:10px;font-size:0.875rem;outline:none;
                              box-sizing:border-box;"
                       class="dark:bg-gray-800 dark:border-gray-700 dark:text-white">
            </div>

            <div id="mv-topup-error"
                 style="display:none;background:#fef2f2;border:1.5px solid #fecaca;
                        border-radius:10px;padding:10px 14px;color:#dc2626;
                        font-size:0.8rem;font-weight:600;"></div>
        </div>

        <div style="padding:0 24px 24px;display:flex;gap:10px;">
            <button onclick="closeTopupModal()"
                    style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e5e7eb;
                           background:#fff;color:#6b7280;font-weight:700;cursor:pointer;"
                    class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                Cancel
            </button>
            <button id="mv-topup-submit"
                    onclick="submitMovementTopup()"
                    style="flex:2;padding:11px;border-radius:10px;border:none;
                           background:#6366f1;color:#fff;font-weight:800;cursor:pointer;
                           display:flex;align-items:center;justify-content:center;gap:7px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
const _TOPUP_URL  = '<?php echo e(route("products.topup", $product)); ?>';
const _CSRF       = '<?php echo e(csrf_token()); ?>';
const _MOVE_URL   = '<?php echo e(route("products.movements", $product)); ?>';

function closeTopupModal() {
    const m = document.getElementById('topupModal');
    m.style.display = 'none';
    document.getElementById('mv-topup-qty').value   = '';
    document.getElementById('mv-topup-note').value  = '';
    document.getElementById('mv-topup-error').style.display = 'none';
}

document.getElementById('topupModal').addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeTopupModal();
    if (e.key === 'Enter')  submitMovementTopup();
});

// Show modal
document.querySelector('[onclick*="topupModal"]')?.addEventListener('click', () => {
    const m = document.getElementById('topupModal');
    m.style.display = 'flex';
    setTimeout(() => document.getElementById('mv-topup-qty').focus(), 100);
});

async function submitMovementTopup() {
    const qty    = parseInt(document.getElementById('mv-topup-qty').value);
    const note   = document.getElementById('mv-topup-note').value.trim();
    const errDiv = document.getElementById('mv-topup-error');
    const btn    = document.getElementById('mv-topup-submit');

    errDiv.style.display = 'none';

    if (!qty || qty < 1) {
        errDiv.textContent   = 'Please enter a quantity of at least 1.';
        errDiv.style.display = 'block';
        return;
    }

    btn.disabled  = true;
    btn.innerHTML = `<svg width="15" height="15" fill="none" viewBox="0 0 24 24"
        style="animation:spin 1s linear infinite;">
        <circle cx="12" cy="12" r="10" stroke="white" stroke-width="4" opacity="0.25"/>
        <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/></svg> Adding...`;

    try {
        const res  = await fetch(_TOPUP_URL, {
            method : 'POST',
            headers: {
                'Content-Type'    : 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN'    : _CSRF,
                'Accept'          : 'application/json',
            },
            body: JSON.stringify({ quantity: qty, note: note || null }),
        });
        const data = await res.json();

        if (data.success) {
            closeTopupModal();
            // Update stock display
            document.getElementById('mv-current-stock').textContent    = data.new_stock;
            document.getElementById('current-stock-display').textContent = data.new_stock;
            // Reload page to show new movement in list
            setTimeout(() => window.location.reload(), 600);
        } else {
            errDiv.textContent   = data.message || 'Failed.';
            errDiv.style.display = 'block';
        }
    } catch (e) {
        errDiv.textContent   = 'Network error. Please try again.';
        errDiv.style.display = 'block';
    } finally {
        btn.disabled  = false;
        btn.innerHTML = `<svg width="15" height="15" fill="none" stroke="currentColor"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2.5" d="M12 4v16m8-8H4"/></svg> Add Stock`;
    }
}
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/products/movements.blade.php ENDPATH**/ ?>