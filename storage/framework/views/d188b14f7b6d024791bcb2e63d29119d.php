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
     <?php $__env->slot('title', null, []); ?> Create Repair <?php $__env->endSlot(); ?>

    <?php $__env->startPush('styles'); ?>
        <style>
            .repair-input {
                width: 100%;
                padding: 4px 7px;
                border: 1.5px solid #e2e8f0;
                border-radius: 5px;
                font-size: 0.85rem;
                outline: none;
                /* background: #f8fafc; */
                color: #1e293b;
                transition: border 0.15s, box-shadow 0.15s;
                box-sizing: border-box;
            }

            .repair-input:focus {
                border-color: #6366f1;
                box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
                background: #fff;
            }

            .dark .repair-input {
                background: #1e293b;
                border-color: #334155;
                color: #e2e8f0;
            }

            .dark .repair-input:focus {
                border-color: #818cf8;
                background: #0f172a;
            }

            select.repair-input {
                cursor: pointer;
            }

            textarea.repair-input {
                resize: none;
            }
        </style>
    <?php $__env->stopPush(); ?>

    <form id="repairForm" method="POST" action="<?php echo e(route('repairs.store')); ?>" onsubmit="RepairForm.submit(event)">
        <?php echo csrf_field(); ?>

        
        <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'New Repair Job','subtitle' => 'Fill in the details below to create a new repair','breadcrumbs' => [
                ['label' => 'Dashboard', 'route' => 'dashboard'],
                ['label' => 'Repairs', 'route' => 'repairs.index'],
                ['label' => 'Create'],
            ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'New Repair Job','subtitle' => 'Fill in the details below to create a new repair','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                ['label' => 'Dashboard', 'route' => 'dashboard'],
                ['label' => 'Repairs', 'route' => 'repairs.index'],
                ['label' => 'Create'],
            ])]); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a href="<?php echo e(route('repairs.index')); ?>"
                    class="px-4 py-2 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
                    Cancel
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

            
            
            
            <div class="lg:col-span-2 space-y-4">

                
                <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Customer','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Customer','color' => 'blue']); ?>
                     <?php $__env->slot('icon', null, []); ?> 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12
                             14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                     <?php $__env->endSlot(); ?>
                    <?php if (isset($component)) { $__componentOriginal202d1a7a1f92404385370f1ad38842a8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal202d1a7a1f92404385370f1ad38842a8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer-search','data' => ['inputName' => 'customer_id']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['input-name' => 'customer_id']); ?>
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


                
                <div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden mb-0"
                    id="warranty-toggle-card">

                    <div class="flex items-center justify-between px-5 py-4">

                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-lg
                        bg-amber-100 dark:bg-amber-900/40
                        flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955
                             0 0112 2.944a11.955 11.955 0 01-8.618
                             3.04A12.02 12.02 0 003 9c0 5.591 3.824
                             10.29 9 11.622 5.176-1.332 9-6.03
                             9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    Warranty Return
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Is this repair a warranty return from a previous job?
                                </p>
                            </div>
                        </div>

                        
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="warranty-toggle" name="is_warranty_return" value="1"
                                class="sr-only peer" onchange="WarrantyReturn.toggle(this.checked)">
                            <div
                                class="w-11 h-6 bg-gray-200 dark:bg-gray-700
                        peer-focus:ring-2 peer-focus:ring-amber-400
                        rounded-full peer
                        peer-checked:bg-amber-500
                        transition-all after:content-['']
                        after:absolute after:top-[2px] after:left-[2px]
                        after:bg-white after:rounded-full
                        after:h-5 after:w-5 after:transition-all
                        peer-checked:after:translate-x-5">
                            </div>
                        </label>

                    </div>

                    
                    <div id="warranty-search-panel" style="display:none;"
                        class="border-t border-gray-200 dark:border-gray-700
                px-5 py-4 bg-amber-50/50 dark:bg-amber-900/10">

                        
                        <input type="hidden" id="parent-repair-id" name="parent_repair_id">

                        
                        <div class="relative mb-3">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2
                        w-4 h-4 text-gray-400 pointer-events-none"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0" />
                            </svg>
                            <input type="text" id="warranty-search-input"
                                placeholder="Search by IMEI, Repair ID or customer name..." autocomplete="off"
                                oninput="WarrantyReturn.search(this.value)"
                                class="w-full pl-9 pr-4 py-2.5
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-sm outline-none
                          bg-white dark:bg-gray-800
                          text-gray-900 dark:text-white
                          placeholder-gray-400
                          focus:border-amber-400
                          focus:ring-2 focus:ring-amber-400/10
                          transition-all">

                            
                            <div id="warranty-search-loading" style="display:none;"
                                class="absolute right-3 top-1/2 -translate-y-1/2">
                                <svg class="w-4 h-4 animate-spin text-amber-500" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                                </svg>
                            </div>
                        </div>

                        
                        <div id="warranty-search-results" style="display:none;"
                            class="bg-white dark:bg-gray-800
                    border border-gray-200 dark:border-gray-700
                    rounded-xl overflow-hidden mb-3
                    shadow-lg">
                        </div>

                        
                        <div id="warranty-selected-repair" style="display:none;">
                        </div>

                    </div>
                </div>

                
                <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Repair Details','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Repair Details','color' => 'purple']); ?>
                     <?php $__env->slot('icon', null, []); ?> 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2
                             2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0
                             002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2
                             2 0 012 2" />
                        </svg>
                     <?php $__env->endSlot(); ?>

                    <div class="grid grid-cols-1 sm:grid-cols-2
                        lg:grid-cols-3 gap-4">

                        
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Book-in Date
                            </label>
                            <input type="date" name="book_in_date" value="<?php echo e(date('Y-m-d')); ?>"
                                class="repair-input">
                        </div>

                        
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Est. Completion
                            </label>
                            <input type="date" name="completion_date" class="repair-input">
                        </div>

                        
                        <div>
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Delivery Type
                            </label>
                            <select name="delivery_type" class="repair-input">
                                <option value="collection">🏪 Collection</option>
                                <option value="delivery">🚚 Delivery</option>
                            </select>
                        </div>

                        
                        <input type="hidden" name="discount" id="repair-discount-hidden" value="0">

                        
                        <div class="sm:col-span-2 lg:col-span-3">
                            <label
                                class="block text-xs font-semibold
                                   text-gray-500 dark:text-gray-400
                                   uppercase tracking-wider mb-1.5">
                                Internal Notes
                            </label>
                            <textarea name="notes" rows="3" placeholder="Internal notes..." class="repair-input">
                    </textarea>
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

                
                <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Devices','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Devices','color' => 'green']); ?>
                     <?php $__env->slot('icon', null, []); ?> 
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                             00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                     <?php $__env->endSlot(); ?>
                     <?php $__env->slot('badgeSlot', null, []); ?> 
                        <span id="deviceCount"
                            class="text-xs font-bold px-2 py-0.5
                             rounded-full bg-green-100
                             dark:bg-green-900/40
                             text-green-700 dark:text-green-400">
                            0 devices
                        </span>
                     <?php $__env->endSlot(); ?>

                    
                    <div id="devicesContainer" class="space-y-4 mb-4">
                        <div id="devicesEmpty"
                            class="flex flex-col items-center
                            justify-center py-10
                            text-gray-400 dark:text-gray-600">
                            <svg class="w-12 h-12 mb-3 opacity-40" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2
                                 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0
                                 002 2z" />
                            </svg>
                            <p class="text-sm font-semibold">No devices added</p>
                            <p class="text-xs mt-1">Click "Add Device" to start</p>
                        </div>
                    </div>

                    
                    <button type="button" onclick="RepairForm.addDevice()"
                        class="w-full py-3 rounded-xl text-sm font-bold
                           border-2 border-dashed
                           border-green-300 dark:border-green-800
                           text-green-600 dark:text-green-500
                           hover:bg-green-50 dark:hover:bg-green-900/20
                           transition-all flex items-center
                           justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Add Device
                    </button>

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

            
            
            
            <?php echo $__env->make('repairs.partials.right-panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        </div>
    </form>

    
    <?php echo $__env->make('customers.modals.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('repairs.partials.modals.discount', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('repairs.partials.modals.payment', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php $__env->startPush('scripts'); ?>
        
        <script>
           window.REPAIR_CONFIG = {
    routes: {
        repairTypes   : '<?php echo e(route("repair-types.search")); ?>',
        products      : '<?php echo e(route("products.search")); ?>',
        customers     : '<?php echo e(route("customers.search")); ?>',
        customerStats : '/api/customers/{id}/stats',
        customerStore : '<?php echo e(route("customers.store")); ?>',
        customerUpdate: '/api/customers/{id}',
    },
    csrf: '<?php echo e(csrf_token()); ?>',
};

            // Device card template for JS cloning
            window.__DEVICE_TEMPLATE__ = <?php echo json_encode($deviceCardTemplate, 15, 512) ?>;
        </script>

        
        <script src="<?php echo e(asset('js/repair-form.js')); ?>"></script>

        
        <?php echo app('Illuminate\Foundation\Vite')('resources/js/repair/index.js'); ?>
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/create.blade.php ENDPATH**/ ?>