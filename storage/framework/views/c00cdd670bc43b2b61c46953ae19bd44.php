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
 <?php $__env->slot('title', null, []); ?> Buy Device(s) <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .ferr { color:#ef4444; font-size:.7rem; font-weight:600; margin-top:2px; display:none; }
    .ferr.show { display:block; }
    input.err, select.err { border-color:#ef4444 !important; }
    .device-card { animation: cardIn .18s ease; }
    @keyframes cardIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }
    @keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
    .shake { animation:shake .3s ease; }
    .ac-item.hi { background:#eef2ff; }
    .dark .ac-item.hi { background:#1e1b4b; }
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Buy Device(s)','subtitle' => 'Record one or multiple device purchases at once','breadcrumbs' => [
        ['label'=>'Dashboard',  'route'=>'dashboard'],
        ['label'=>'Buy & Sell', 'route'=>'buy-sell.index'],
        ['label'=>'Buy Device(s)'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Buy Device(s)','subtitle' => 'Record one or multiple device purchases at once','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label'=>'Dashboard',  'route'=>'dashboard'],
        ['label'=>'Buy & Sell', 'route'=>'buy-sell.index'],
        ['label'=>'Buy Device(s)'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('buy-sell.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200
                  dark:border-gray-700 text-gray-600 dark:text-gray-400
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

<div x-data="BuyDevices()" x-init="init()" class="grid grid-cols-1 xl:grid-cols-3 gap-5">

    
    <div class="xl:col-span-2 space-y-4">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Buying From</span>
                <span class="text-xs text-gray-400">(optional)</span>
            </div>
            <div class="p-5">
                <?php if (isset($component)) { $__componentOriginal202d1a7a1f92404385370f1ad38842a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal202d1a7a1f92404385370f1ad38842a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer-search','data' => ['fieldName' => 'customer_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['field-name' => 'customer_id']); ?>
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
            </div>
        </div>

        
        <template x-for="(dev, idx) in devices" :key="dev.id">
            <div class="device-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">

                
                <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-gray-700 dark:text-gray-200">
                        Device <span x-text="idx + 1"></span>
                        <span x-show="dev.model_name" class="font-normal text-gray-400 ml-1" x-text="'— ' + dev.model_name"></span>
                    </p>
                    <div class="ml-auto flex items-center gap-2">
                        <button type="button" @click="duplicate(idx)"
                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold
                                       border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400
                                       hover:border-indigo-300 hover:text-indigo-600
                                       transition-all cursor-pointer bg-transparent">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Duplicate
                        </button>
                        <button type="button" x-show="devices.length > 1" @click="remove(idx)"
                                class="w-7 h-7 rounded-lg flex items-center justify-center
                                       bg-red-50 dark:bg-red-900/20 text-red-400 hover:bg-red-100
                                       hover:text-red-600 transition-all cursor-pointer border-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    
                    <div class="sm:col-span-2 relative">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Model Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   x-model="dev.model_name"
                                   @input.debounce.300ms="acSearch(dev)"
                                   @keydown.arrow-down.prevent="acDown(dev)"
                                   @keydown.arrow-up.prevent="acUp(dev)"
                                   @keydown.enter.prevent="acEnter(dev)"
                                   @keydown.escape="dev.acOpen=false"
                                   @focus="dev.model_name.length > 0 && (dev.acOpen=true)"
                                   @blur="setTimeout(()=>dev.acOpen=false, 160)"
                                   placeholder="e.g. iPhone 15 Pro, Samsung S24..."
                                   autocomplete="off"
                                   :class="dev.err_model ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-gray-700'"
                                   class="w-full pl-3.5 pr-9 py-2.5 border rounded-xl text-sm outline-none
                                          bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                            <div x-show="dev.acLoading" class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg class="w-4 h-4 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                </svg>
                            </div>
                        </div>

                        
                        <div x-show="dev.acOpen"
                             class="absolute left-0 right-0 top-full mt-1 z-50 bg-white dark:bg-gray-800
                                    border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl max-h-52 overflow-y-auto"
                             style="display:none;">
                            <template x-for="(p, pi) in dev.acResults" :key="p.id">
                                <div @mousedown.prevent="acPick(dev, p)"
                                     :class="{ 'hi': dev.acHi === pi }"
                                     class="ac-item flex items-center justify-between px-4 py-2.5 cursor-pointer text-sm
                                            border-b border-gray-100 dark:border-gray-700/50 last:border-0
                                            hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white" x-text="p.name"></p>
                                        <p class="text-xs text-gray-400" x-text="[p.category,p.brand].filter(Boolean).join(' · ')"></p>
                                    </div>
                                    <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 ml-3 flex-shrink-0" x-text="p.formatted_price"></span>
                                </div>
                            </template>
                            <div x-show="!dev.acLoading && dev.acResults.length===0 && dev.model_name.trim().length>1" class="px-4 py-4">
                                <p class="text-xs text-center text-gray-400 mb-2.5">No products found</p>
                                <button type="button" @mousedown.prevent="dev.acOpen=false"
                                        class="w-full py-2 rounded-xl border-2 border-dashed border-indigo-300
                                               dark:border-indigo-700 text-xs font-semibold text-indigo-600
                                               hover:bg-indigo-50 transition-colors">
                                    Use "<span x-text="dev.model_name"></span>"
                                </button>
                            </div>
                        </div>

                        <p x-show="dev.err_model" x-text="dev.err_model" class="ferr show mt-1"></p>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Brand</label>
                        <input type="text" x-model="dev.brand_name" placeholder="Apple, Samsung..."
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Condition <span class="text-red-500">*</span>
                        </label>
                        <select x-model="dev.condition"
                                :class="dev.err_condition ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-gray-700'"
                                class="w-full px-3.5 py-2.5 border rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                                       text-gray-900 dark:text-white cursor-pointer focus:border-indigo-500 transition-all">
                            <option value="">Select condition...</option>
                            <option value="new">🌟 A — New</option>
                            <option value="used">✅ B — Good</option>
                            <option value="refurbished">🔧 C — Average</option>
                            <option value="faulty">⚠️ D — Faulty</option>
                        </select>
                        <p x-show="dev.err_condition" x-text="dev.err_condition" class="ferr show mt-1"></p>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">IMEI</label>
                        <input type="text" x-model="dev.imei" maxlength="20" placeholder="15-digit IMEI..."
                               :class="dev.err_imei ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-gray-700'"
                               class="w-full px-3.5 py-2.5 border rounded-xl text-sm font-mono outline-none
                                      bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                        <p x-show="dev.err_imei" x-text="dev.err_imei" class="ferr show mt-1"></p>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Serial Number</label>
                        <input type="text" x-model="dev.serial_number" placeholder="S/N..."
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      font-mono outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Storage</label>
                        <input type="text" x-model="dev.storage" placeholder="128GB, 256GB..."
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Color</label>
                        <input type="text" x-model="dev.color" placeholder="Black, Gold..."
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Buy Price <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 pointer-events-none">£</span>
                            <input type="number" x-model="dev.purchase_price" @input="calcTotals()"
                                   min="0" step="0.01" placeholder="0.00"
                                   :class="dev.err_price ? 'border-red-400 dark:border-red-600' : 'border-gray-200 dark:border-gray-700'"
                                   class="w-full pl-8 pr-3 py-2.5 border rounded-xl text-sm font-semibold outline-none
                                          bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                        <p x-show="dev.err_price" x-text="dev.err_price" class="ferr show mt-1"></p>
                    </div>

                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Target Sell <span class="font-normal normal-case text-gray-400">(optional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 pointer-events-none">£</span>
                            <input type="number" x-model="dev.selling_price" @input="calcTotals()"
                                   min="0" step="0.01" placeholder="0.00"
                                   class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          font-semibold outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                    </div>

                    
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Condition Notes</label>
                        <textarea x-model="dev.notes" rows="2"
                                  placeholder="Damage, scratches, accessories included..."
                                  class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                         outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400
                                         resize-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                         focus:bg-white dark:focus:bg-gray-900 transition-all"></textarea>
                    </div>

                </div>
            </div>
        </template>

        
        <button type="button" @click="addDevice()"
                class="w-full py-3.5 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700
                       text-sm font-semibold text-gray-500 dark:text-gray-400
                       hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50/50
                       dark:hover:border-indigo-700 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/10
                       transition-all flex items-center justify-center gap-2 cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Another Device
        </button>

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Payment</span>
                <span class="text-xs text-gray-400 ml-1">— applies to all devices</span>
            </div>
            <div class="p-5 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Method</label>
                    <select x-model="payment.method"
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
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Status</label>
                    <select x-model="payment.status"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                   outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 transition-all">
                        <option value="paid">✅ Paid</option>
                        <option value="partial">🔵 Partial</option>
                        <option value="unpaid">⏳ Unpaid</option>
                    </select>
                </div>
            </div>
        </div>

        
        <div x-show="globalErr" x-transition
             class="flex items-start gap-3 px-4 py-3.5 rounded-xl bg-red-50 dark:bg-red-900/20
                    border border-red-200 dark:border-red-800"
             style="display:none;">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-semibold text-red-700 dark:text-red-400" x-text="globalErr"></p>
        </div>

    </div>

    
    <div class="space-y-4 sticky top-6">

        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Purchase Summary</p>
            </div>
            <div class="p-5 space-y-3">

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500">Devices</span>
                    <span class="text-sm font-black text-gray-900 dark:text-white" x-text="devices.length"></span>
                </div>

                
                <div class="border-t border-gray-100 dark:border-gray-800 pt-3 space-y-2">
                    <template x-for="(d, i) in devices" :key="d.id">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-500 flex-1 min-w-0 truncate"
                                  x-text="d.model_name || ('Device ' + (i+1))"></span>
                            <span class="text-xs font-bold text-gray-900 dark:text-white flex-shrink-0"
                                  x-text="d.purchase_price ? '£'+parseFloat(d.purchase_price).toFixed(2) : '—'"></span>
                        </div>
                    </template>
                </div>

                
                <div class="flex items-center justify-between border-t-2 border-gray-200 dark:border-gray-700 pt-3">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Total</span>
                    <span class="text-xl font-black text-emerald-600 dark:text-emerald-400"
                          x-text="'£'+totalBuy.toFixed(2)"></span>
                </div>

                
                <div x-show="totalSell > 0" class="border-t border-gray-100 dark:border-gray-800 pt-3 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Target Sell Total</span>
                        <span class="text-xs font-semibold text-gray-700 dark:text-gray-300"
                              x-text="'£'+totalSell.toFixed(2)"></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">Expected Profit</span>
                        <span class="text-sm font-black"
                              :class="(totalSell-totalBuy)>=0?'text-emerald-600 dark:text-emerald-400':'text-red-500'"
                              x-text="((totalSell-totalBuy)>=0?'+':'')+'£'+Math.abs(totalSell-totalBuy).toFixed(2)"></span>
                    </div>
                </div>

            </div>
        </div>

        
        <button type="button" @click="submit()" :disabled="submitting"
                class="w-full py-3.5 rounded-2xl text-sm font-black text-white bg-emerald-600
                       hover:bg-emerald-700 active:scale-[.99] disabled:opacity-60
                       disabled:cursor-not-allowed transition-all flex items-center
                       justify-center gap-2 shadow-lg shadow-emerald-500/20">
            <svg x-show="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span x-text="submitting ? 'Saving...' : 'Record ' + devices.length + (devices.length===1?' Purchase':' Purchases')"></span>
        </button>

        <a href="<?php echo e(route('buy-sell.index')); ?>"
           class="w-full py-2.5 rounded-xl text-sm font-semibold border border-gray-200
                  dark:border-gray-700 text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
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

function BuyDevices() {
    return {
        devices    : [],
        payment    : { method:'cash', status:'paid' },
        customerId : null,
        totalBuy   : 0,
        totalSell  : 0,
        submitting : false,
        globalErr  : '',
        _uid       : 0,

        init() {
            this.addDevice();
            document.addEventListener('customer-selected', e => this.customerId = e.detail.id);
            document.addEventListener('customer-cleared',  () => this.customerId = null);
        },

        // ── Device management ─────────────────────────────────
        _blank() {
            return {
                id:'d'+(++this._uid),
                model_name:'', brand_name:'', condition:'',
                imei:'', serial_number:'', storage:'', color:'',
                purchase_price:'', selling_price:'', notes:'',
                err_model:'', err_condition:'', err_imei:'', err_price:'',
                acResults:[], acLoading:false, acOpen:false, acHi:-1, _acTimer:null,
            };
        },

        addDevice()     { this.devices.push(this._blank()); },
        remove(i)       { this.devices.splice(i,1); this.calcTotals(); },
        duplicate(i) {
            const s = this.devices[i];
            const c = this._blank();
            Object.assign(c, { model_name:s.model_name, brand_name:s.brand_name,
                condition:s.condition, storage:s.storage, color:s.color,
                purchase_price:s.purchase_price, selling_price:s.selling_price, notes:s.notes });
            this.devices.splice(i+1, 0, c);
            this.calcTotals();
        },

        // ── Autocomplete ──────────────────────────────────────
        acSearch(dev) {
            clearTimeout(dev._acTimer);
            const q = dev.model_name.trim();
            if (!q) { dev.acOpen=false; return; }
            dev.acLoading=true; dev.acOpen=true;
            dev._acTimer = setTimeout(async () => {
                try {
                    const r = await fetch(`/products/autocomplete?q=${encodeURIComponent(q)}`,
                        {headers:{'X-Requested-With':'XMLHttpRequest'}});
                    dev.acResults = await r.json(); dev.acHi=-1;
                } catch(e) { dev.acResults=[]; }
                finally { dev.acLoading=false; }
            }, 300);
        },
        acDown(dev)  { dev.acHi = Math.min(dev.acHi+1, dev.acResults.length-1); },
        acUp(dev)    { dev.acHi = Math.max(dev.acHi-1, -1); },
        acEnter(dev) { dev.acHi>=0 && dev.acResults[dev.acHi] ? this.acPick(dev,dev.acResults[dev.acHi]) : (dev.acOpen=false); },
        acPick(dev, p) {
            dev.model_name=p.name; dev.acOpen=false; dev.acHi=-1; dev.err_model='';
            if (!dev.brand_name && p.brand) dev.brand_name=p.brand;
        },

        // ── Totals ────────────────────────────────────────────
        calcTotals() {
            this.totalBuy  = this.devices.reduce((s,d)=>s+(parseFloat(d.purchase_price)||0), 0);
            this.totalSell = this.devices.reduce((s,d)=>s+(parseFloat(d.selling_price)||0),  0);
        },

        // ── Validation ────────────────────────────────────────
        validate() {
            let ok = true;
            this.globalErr = '';
            this.devices.forEach(d => {
                d.err_model=''; d.err_condition=''; d.err_imei=''; d.err_price='';
                if (!d.model_name.trim()) { d.err_model='Model name is required.'; ok=false; }
                if (!d.condition)         { d.err_condition='Condition is required.'; ok=false; }
                const p=parseFloat(d.purchase_price);
                if (d.purchase_price===''||isNaN(p)||p<0) { d.err_price='Enter a valid price.'; ok=false; }
                if (d.imei && !/^\d{15}$/.test(d.imei))  { d.err_imei='IMEI must be 15 digits.'; ok=false; }
            });
            if (!ok) this.globalErr='Please fix the errors highlighted below.';
            return ok;
        },

        // ── Submit ────────────────────────────────────────────
        async submit() {
            if (!this.validate()) return;
            this.submitting=true; this.globalErr='';
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            const body = {
                customer_id    : this.customerId || null,
                payment_method : this.payment.method,
                payment_status : this.payment.status,
                devices        : this.devices.map(d => ({
                    model_name    : d.model_name.trim(),
                    brand_name    : d.brand_name.trim()    || null,
                    condition     : d.condition,
                    imei          : d.imei.trim()           || null,
                    serial_number : d.serial_number.trim()  || null,
                    storage       : d.storage.trim()        || null,
                    color         : d.color.trim()          || null,
                    purchase_price: parseFloat(d.purchase_price)||0,
                    selling_price : parseFloat(d.selling_price)||null,
                    notes         : d.notes.trim()          || null,
                })),
            };
            try {
                const res  = await fetch('<?php echo e(route("buy-sell.buy")); ?>', {
                    method:'POST',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,
                             'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                    body:JSON.stringify(body),
                });
                const data = await res.json();
                if (data.success) {
                    window.location = '<?php echo e(route("buy-sell.index")); ?>';
                } else {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([k,v]) => {
                            const m = k.match(/^devices\.(\d+)\.(.+)$/);
                            if (m && this.devices[+m[1]]) {
                                const field = m[2];
                                const key   = {model_name:'err_model',condition:'err_condition',
                                               imei:'err_imei',purchase_price:'err_price'}[field] || null;
                                if (key) this.devices[+m[1]][key] = Array.isArray(v)?v[0]:v;
                            }
                        });
                        this.globalErr='Please fix the errors highlighted below.';
                    } else {
                        this.globalErr = data.message || 'Failed to save.';
                    }
                }
            } catch(e) {
                this.globalErr = 'Network error. Please try again.';
            } finally { this.submitting=false; }
        },
    };
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/buy-sell/create.blade.php ENDPATH**/ ?>