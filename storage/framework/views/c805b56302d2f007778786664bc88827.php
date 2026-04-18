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
 <?php $__env->slot('title', null, []); ?> Sell Device — <?php echo e($device->model_name); ?> <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .field-err{color:#ef4444;font-size:.72rem;font-weight:600;margin-top:3px;display:none;}
    .field-err.show{display:block;}
    input.err,select.err{border-color:#ef4444!important;}
    @keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
    .shake{animation:shake .3s ease;}
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Sell Device','subtitle' => ''.e($device->model_name).'','breadcrumbs' => [
        ['label'=>'Dashboard',  'route'=>'dashboard'],
        ['label'=>'Buy & Sell', 'route'=>'buy-sell.index'],
        ['label'=>'Sell — '.$device->model_name],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sell Device','subtitle' => ''.e($device->model_name).'','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label'=>'Dashboard',  'route'=>'dashboard'],
        ['label'=>'Buy & Sell', 'route'=>'buy-sell.index'],
        ['label'=>'Sell — '.$device->model_name],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('buy-sell.index')); ?>"
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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    
    <div class="lg:col-span-2 space-y-5">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Device Being Sold</span>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Model</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white"><?php echo e($device->model_name); ?></p>
                </div>
                <?php if($device->brand): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Brand</p>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300"><?php echo e($device->brand->name); ?></p>
                </div>
                <?php endif; ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Condition</p>
                    <?php
                        $condColor = match($device->condition) {
                            'new'         => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                            'used'        => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'refurbished' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            'faulty'      => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            default       => 'bg-gray-100 text-gray-600',
                        };
                    ?>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full <?php echo e($condColor); ?>">
                        <?php echo e($device->condition_label); ?>

                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Buy Price</p>
                    <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">£<?php echo e(number_format($device->purchase_price,2)); ?></p>
                </div>
                <?php if($device->imei): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">IMEI</p>
                    <p class="text-xs font-mono text-gray-600 dark:text-gray-400"><?php echo e($device->imei); ?></p>
                </div>
                <?php endif; ?>
                <?php if($device->storage || $device->color): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Specs</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <?php echo e(implode(' · ', array_filter([$device->storage, $device->color]))); ?>

                    </p>
                </div>
                <?php endif; ?>
                <?php if($device->buyTransaction?->customer): ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Bought From</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($device->buyTransaction->customer->name); ?></p>
                </div>
                <?php endif; ?>
                <?php if($device->notes): ?>
                <div class="col-span-2 sm:col-span-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 bg-amber-50 dark:bg-amber-900/20
                               rounded-lg px-3 py-2 border border-amber-100 dark:border-amber-800">
                        <?php echo e($device->notes); ?>

                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Buyer','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Buyer','color' => 'blue']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <p class="text-xs text-gray-400 mb-3">Who are you selling to? (optional)</p>
            <?php if (isset($component)) { $__componentOriginal202d1a7a1f92404385370f1ad38842a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal202d1a7a1f92404385370f1ad38842a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer-search','data' => ['fieldName' => 'sell_customer_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field-name' => 'sell_customer_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal202d1a7a1f92404385370f1ad38842a8)): ?>
<?php $attributes = $__attributesOriginal202d1a7a1f92404385370f1ad38842a8; ?>
<?php unset($__attributesOriginal202d1a7a1f92404385370f1ad38842a8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal202d1a7a1f92404385370f1ad38842a8)): ?>
<?php $component = $__componentOriginal202d1a7a1f92404385370f1ad38842a8; ?>
<?php unset($__componentOriginal202d1a7a1f92404385370f1ad38842a8); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $attributes = $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $component = $__componentOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Sale Details','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sale Details','color' => 'indigo']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Sell Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold pointer-events-none">£</span>
                        <input type="number" id="inp-sell-price" min="0.01" step="0.01" placeholder="0.00"
                               oninput="updateProfit()"
                               class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      font-semibold outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>
                    <p class="field-err" id="err-sell-price"></p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Discount <span class="text-gray-400 font-normal normal-case">(optional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold pointer-events-none">£</span>
                        <input type="number" id="inp-discount" min="0" step="0.01" value="0"
                               oninput="updateProfit()"
                               class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      font-semibold outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Payment Method</label>
                    <select id="inp-pay-method"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                   outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 transition-all">
                        <option value="cash">💵 Cash</option>
                        <option value="card">💳 Card</option>
                        <option value="bank_transfer">🏦 Bank Transfer</option>
                        <option value="trade">🔄 Trade</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Payment Status</label>
                    <select id="inp-pay-status"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                   outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 transition-all">
                        <option value="paid">✅ Paid</option>
                        <option value="partial">🔵 Partial</option>
                        <option value="unpaid">⏳ Unpaid</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Notes</label>
                    <input type="text" id="inp-notes" placeholder="Sale notes, accessories handed over..."
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                  outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>

            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $attributes = $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $component = $__componentOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>

    </div>

    
    <div class="space-y-4 sticky top-6">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Financials</p>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Buy Price</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                        £<?php echo e(number_format($device->purchase_price,2)); ?>

                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Sell Price</span>
                    <span id="sum-sell" class="text-sm font-bold text-gray-900 dark:text-white">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Discount</span>
                    <span id="sum-discount" class="text-sm font-semibold text-red-500">—</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-800 pt-3">
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Final Amount</span>
                    <span id="sum-final" class="text-base font-black text-indigo-600 dark:text-indigo-400">—</span>
                </div>
            </div>
        </div>

        
        <div id="profit-box" style="display:none"
             class="rounded-2xl border-2 p-5 text-center transition-all">
            <p id="profit-label" class="text-xs font-bold uppercase tracking-widest mb-2"></p>
            <p id="profit-val" class="text-4xl font-black"></p>
            <p id="profit-margin" class="text-xs text-gray-400 mt-2"></p>
        </div>

        
        <div id="global-err" style="display:none"
             class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold
                    bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span id="global-err-text"></span>
        </div>

        
        <button type="button" id="submit-btn" onclick="submitSell()"
                class="w-full py-3.5 rounded-2xl text-sm font-black text-white bg-indigo-600
                       hover:bg-indigo-700 active:scale-[.99] transition-all
                       flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span id="submit-text">Complete Sale</span>
        </button>

        <a href="<?php echo e(route('buy-sell.index')); ?>"
           class="w-full py-2.5 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                  flex items-center justify-center">
            Cancel
        </a>

    </div>
</div>

<?php echo $__env->make('customers.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
window.REPAIR_CONFIG = {
    routes: {
        customers     : '<?php echo e(route("customers.search")); ?>',
        customerStore : '<?php echo e(route("customers.store")); ?>',
        customerUpdate: '/api/customers/{id}',
        customerStats : '<?php echo e(route("customers.stats", "__ID__")); ?>'.replace('__ID__','{id}'),
    },
    csrf: '<?php echo e(csrf_token()); ?>',
};

const BUY_PRICE = <?php echo e((float)$device->purchase_price); ?>;
let _customerId = null;
document.addEventListener('customer-selected', e => _customerId = e.detail.id);
document.addEventListener('customer-cleared',  () => _customerId = null);

function updateProfit() {
    const sell     = parseFloat(document.getElementById('inp-sell-price')?.value) || 0;
    const discount = parseFloat(document.getElementById('inp-discount')?.value)   || 0;
    const final    = Math.max(0, sell - discount);
    const profit   = final - BUY_PRICE;
    const margin   = final > 0 ? (profit/final*100) : 0;

    document.getElementById('sum-sell').textContent     = sell     ? '£'+sell.toFixed(2)     : '—';
    document.getElementById('sum-discount').textContent = discount ? '-£'+discount.toFixed(2) : '—';
    document.getElementById('sum-final').textContent    = final    ? '£'+final.toFixed(2)    : '—';

    const box = document.getElementById('profit-box');
    if (sell > 0) {
        box.style.display='block';
        const lbl=document.getElementById('profit-label');
        const val=document.getElementById('profit-val');
        const mrg=document.getElementById('profit-margin');
        if (profit>0) {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-emerald-600 dark:text-emerald-400';
            lbl.textContent='📈 Profit';
            val.className='text-4xl font-black text-emerald-600 dark:text-emerald-400';
        } else if (profit<0) {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-red-500';
            lbl.textContent='📉 Loss';
            val.className='text-4xl font-black text-red-500';
        } else {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-gray-400';
            lbl.textContent='Break Even';
            val.className='text-4xl font-black text-gray-500';
        }
        val.textContent=(profit>=0?'+':'')+'£'+Math.abs(profit).toFixed(2);
        mrg.textContent=Math.abs(margin).toFixed(1)+'% margin';
    } else { box.style.display='none'; }
}

async function submitSell() {
    const btn = document.getElementById('submit-btn');
    const txt = document.getElementById('submit-text');
    const errBox = document.getElementById('global-err');
    const errTxt = document.getElementById('global-err-text');
    document.querySelectorAll('.field-err').forEach(e=>e.classList.remove('show'));
    document.querySelectorAll('.err').forEach(e=>e.classList.remove('err'));
    errBox.style.display='none';

    const sell = parseFloat(document.getElementById('inp-sell-price')?.value);
    if (!sell||sell<=0) {
        const el=document.getElementById('err-sell-price');
        if(el){el.textContent='Enter a valid sell price.';el.classList.add('show');}
        document.getElementById('inp-sell-price')?.classList.add('err');
        btn.classList.add('shake'); setTimeout(()=>btn.classList.remove('shake'),400);
        return;
    }

    btn.disabled=true; txt.textContent='Processing...';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const body = {
        selling_price : sell,
        discount      : parseFloat(document.getElementById('inp-discount')?.value)||0,
        customer_id   : _customerId||null,
        payment_method: document.getElementById('inp-pay-method')?.value,
        payment_status: document.getElementById('inp-pay-status')?.value,
        notes         : document.getElementById('inp-notes')?.value?.trim()||null,
    };

    try {
        const res  = await fetch('<?php echo e(route("buy-sell.sell", $device)); ?>', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
            body:JSON.stringify(body),
        });
        const data = await res.json();
        if (data.success) {
            window.location='<?php echo e(route("buy-sell.index")); ?>';
        } else {
            errTxt.textContent = data.message||'Failed to process sale.';
            errBox.style.display='flex';
            btn.disabled=false; txt.textContent='Complete Sale';
        }
    } catch(e) {
        errTxt.textContent='Network error. Please try again.';
        errBox.style.display='flex';
        btn.disabled=false; txt.textContent='Complete Sale';
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/buy-sell/sell.blade.php ENDPATH**/ ?>