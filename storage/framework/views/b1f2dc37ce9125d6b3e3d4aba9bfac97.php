


<div id="repair-discount-modal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.75);align-items:center;
            justify-content:center;padding:16px;">

    <div id="repair-discount-modal-box"
         style="transform:scale(0.95);opacity:0;transition:all 0.2s;"
         class="relative w-full max-w-sm
                bg-white dark:bg-gray-900
                rounded-2xl shadow-2xl overflow-hidden">

        
        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-bold
                            text-gray-900 dark:text-white">
                    Add Discount
                </h3>
                <p id="repair-discount-subtotal-label"
                   class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Subtotal: £0.00
                </p>
            </div>
            <button type="button"
                    onclick="RepairPayments.closeDiscountModal()"
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

        
        <div class="px-6 py-5 space-y-4">

            
            <div class="grid grid-cols-2 gap-2">
                <button type="button"
                        id="repair-disc-percent-btn"
                        onclick="RepairPayments.setDiscountType('percent')"
                        class="py-2.5 rounded-xl text-sm font-bold
                               transition-all border-2
                               border-indigo-500 bg-indigo-600
                               text-white">
                    % Percent
                </button>
                <button type="button"
                        id="repair-disc-fixed-btn"
                        onclick="RepairPayments.setDiscountType('fixed')"
                        class="py-2.5 rounded-xl text-sm font-bold
                               transition-all border-2
                               border-gray-200 dark:border-gray-700
                               bg-white dark:bg-gray-900
                               text-gray-500 dark:text-gray-400
                               hover:border-indigo-400">
                    £ Fixed
                </button>
            </div>

            
<div style="display:flex;align-items:stretch;
            border:2px solid #e2e8f0;border-radius:12px;
            overflow:hidden;transition:border 0.15s;"
     class="dark:border-gray-700"
     onfocusin="this.style.borderColor='#6366f1'"
     onfocusout="this.style.borderColor=''">

    
    <div id="repair-disc-symbol"
         style="padding:0 16px;background:#f8fafc;
                border-right:2px solid #e2e8f0;
                font-weight:800;font-size:1.1rem;
                color:#6366f1;min-width:48px;
                display:flex;align-items:center;
                justify-content:center;
                user-select:none;flex-shrink:0;"
         class="dark:bg-gray-800 dark:border-gray-700
                dark:text-indigo-400">
        %
    </div>

    
    <input type="number"
           id="repair-disc-input"
           min="0"
           step="0.01"
           placeholder="0"
           oninput="RepairPayments.updateDiscountPreview()"
           style="flex:1;padding:14px 16px;border:none;
                  outline:none;font-size:1.5rem;
                  font-weight:800;width:100%;
                  background:#fff;color:#1e293b;"
           class="dark:bg-gray-900 dark:text-white">

</div>

            
            <div id="repair-disc-quick-btns"
                 class="grid grid-cols-4 gap-2">
                <?php $__currentLoopData = [5, 10, 15, 20]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button"
                        onclick="RepairPayments.setQuickDiscount(<?php echo e($pct); ?>)"
                        class="py-2 rounded-xl text-sm font-bold
                               border border-gray-200 dark:border-gray-700
                               bg-gray-50 dark:bg-gray-800
                               text-gray-600 dark:text-gray-400
                               hover:border-indigo-400
                               hover:text-indigo-600
                               hover:bg-indigo-50
                               dark:hover:bg-indigo-900/20
                               dark:hover:text-indigo-400
                               transition-all">
                    <?php echo e($pct); ?>%
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div id="repair-disc-preview"
                 style="display:none;"
                 class="flex items-center justify-between
                        px-4 py-3 rounded-xl
                        bg-indigo-50 dark:bg-indigo-900/20
                        border border-indigo-200 dark:border-indigo-800">
                <span class="text-sm font-semibold
                             text-indigo-600 dark:text-indigo-400">
                    Discount amount
                </span>
                <span id="repair-disc-preview-amount"
                      class="text-base font-black
                             text-indigo-700 dark:text-indigo-300">
                    £0.00
                </span>
            </div>

        </div>

        
        <div class="px-6 pb-6 flex flex-col gap-2.5">

            <button type="button"
                    onclick="RepairPayments.applyDiscount()"
                    class="w-full py-3 rounded-xl text-sm font-bold
                           bg-indigo-600 hover:bg-indigo-700
                           active:scale-95 text-white transition-all">
                Apply Discount
            </button>

            <button type="button"
                    id="repair-disc-remove-btn"
                    onclick="RepairPayments.removeDiscount()"
                    style="display:none;"
                    class="w-full py-3 rounded-xl text-sm font-bold
                           border-2 border-red-200 dark:border-red-800
                           text-red-500 dark:text-red-400
                           hover:bg-red-50 dark:hover:bg-red-900/20
                           transition-all">
                Remove Discount
            </button>

        </div>

    </div>
</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/partials/modals/discount.blade.php ENDPATH**/ ?>