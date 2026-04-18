<?php
    $isEdit = !is_null($voucher);
?>

<form method="POST" action="<?php echo e($action); ?>" class="space-y-4">
<?php echo csrf_field(); ?>
<?php if($method === 'PUT'): ?>
    <?php echo method_field('PUT'); ?>
<?php endif; ?>


<?php if($errors->any()): ?>
<div class="flex items-start gap-3 px-4 py-3 rounded-xl
            bg-red-50 dark:bg-red-900/20
            border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <ul class="text-sm text-red-700 dark:text-red-400 space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">

    <div class="flex items-center gap-3 px-5 py-3.5
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700
                rounded-t-2xl">
        <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40
                    flex items-center justify-center">
            <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0
                         110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0
                         110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
        </div>
        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
            Voucher Details
        </span>
    </div>

    <div class="p-5 space-y-4">

        
        <div>
            <label class="block text-xs font-bold text-gray-500
                           dark:text-gray-400 uppercase tracking-wider mb-1.5">
                Voucher Code
                <span class="text-red-500 ml-0.5">*</span>
            </label>
            <div class="flex gap-2">
                <input type="text"
                       name="code"
                       id="voucher-code"
                       value="<?php echo e(old('code', $suggestedCode)); ?>"
                       placeholder="e.g. SAVE20"
                       maxlength="50"
                       required
                       style="text-transform:uppercase;"
                       oninput="this.value = this.value.toUpperCase()"
                       class="flex-1 px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm font-mono font-bold
                              outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              focus:border-indigo-500
                              focus:ring-2 focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900
                              transition-all tracking-wider">
                <button type="button"
                        onclick="generateCode()"
                        class="px-3.5 py-2.5 rounded-xl text-sm font-semibold
                               border border-gray-200 dark:border-gray-700
                               text-gray-600 dark:text-gray-400
                               hover:bg-gray-50 dark:hover:bg-gray-800
                               transition-all whitespace-nowrap">
                    🎲 Generate
                </button>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                Letters and numbers only, uppercase
            </p>
        </div>

        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Discount Type
                    <span class="text-red-500 ml-0.5">*</span>
                </label>
                <select name="type"
                        id="voucher-type"
                        onchange="updateValueLabel()"
                        class="w-full px-3.5 py-2.5
                               border border-gray-200 dark:border-gray-700
                               rounded-xl text-sm outline-none
                               bg-gray-50 dark:bg-gray-800
                               text-gray-900 dark:text-white
                               focus:border-indigo-500 transition-all
                               cursor-pointer">
                    <option value="fixed"
                            <?php echo e(old('type', $voucher?->type) === 'fixed'
                                ? 'selected' : ''); ?>>
                        💷 Fixed Amount (£)
                    </option>
                    <option value="percentage"
                            <?php echo e(old('type', $voucher?->type) === 'percentage'
                                ? 'selected' : ''); ?>>
                        % Percentage
                    </option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    <span id="value-label">Amount (£)</span>
                    <span class="text-red-500 ml-0.5">*</span>
                </label>
                <div class="relative">
                    <span id="value-symbol"
                          class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">
                        £
                    </span>
                    <input type="number"
                           name="value"
                           id="voucher-value"
                           value="<?php echo e(old('value', $voucher?->value)); ?>"
                           min="0.01"
                           step="0.01"
                           placeholder="0.00"
                           required
                           class="w-full pl-8 pr-4 py-2.5
                                  border border-gray-200 dark:border-gray-700
                                  rounded-xl text-sm font-bold outline-none
                                  bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500
                                  focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900
                                  transition-all">
                </div>
            </div>
        </div>

    </div>
</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">

    <div class="flex items-center gap-3 px-5 py-3.5
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700
                rounded-t-2xl">
        <div class="w-7 h-7 rounded-lg bg-purple-100 dark:bg-purple-900/40
                    flex items-center justify-center">
            <svg class="w-4 h-4 text-purple-600 dark:text-purple-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2
                         2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
            Restrictions
        </span>
    </div>

    <div class="p-5 space-y-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Usage Limit
                </label>
                <input type="number"
                       name="usage_limit"
                       value="<?php echo e(old('usage_limit', $voucher?->usage_limit)); ?>"
                       min="1"
                       placeholder="Unlimited"
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              focus:border-indigo-500 transition-all">
                <p class="text-xs text-gray-400 mt-1">
                    Leave empty for unlimited uses
                </p>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Min Order Amount
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">
                        £
                    </span>
                    <input type="number"
                           name="min_order_amount"
                           value="<?php echo e(old('min_order_amount', $voucher?->min_order_amount)); ?>"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           class="w-full pl-8 pr-4 py-2.5
                                  border border-gray-200 dark:border-gray-700
                                  rounded-xl text-sm outline-none
                                  bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 transition-all">
                </div>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Expiry Date
                </label>
                <input type="date"
                       name="expiry_date"
                       value="<?php echo e(old('expiry_date', $voucher?->expiry_date?->format('Y-m-d'))); ?>"
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              focus:border-indigo-500 transition-all">
                <p class="text-xs text-gray-400 mt-1">
                    Leave empty for no expiry
                </p>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Assign to Customer
                </label>
                <select name="assigned_to"
                        class="w-full px-3.5 py-2.5
                               border border-gray-200 dark:border-gray-700
                               rounded-xl text-sm outline-none
                               bg-gray-50 dark:bg-gray-800
                               text-gray-900 dark:text-white
                               focus:border-indigo-500 transition-all
                               cursor-pointer">
                    <option value="">Anyone can use</option>
                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($customer->id); ?>"
                                <?php echo e(old('assigned_to', $voucher?->assigned_to)
                                    == $customer->id ? 'selected' : ''); ?>>
                            <?php echo e($customer->name); ?>

                            <?php if($customer->phone): ?>
                                — <?php echo e($customer->phone); ?>

                            <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </div>

    </div>
</div>


<div class="bg-white dark:bg-gray-900
            border border-gray-200 dark:border-gray-700
            rounded-2xl overflow-hidden">

    <div class="flex items-center gap-3 px-5 py-3.5
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700
                rounded-t-2xl">
        <div class="w-7 h-7 rounded-lg bg-amber-100 dark:bg-amber-900/40
                    flex items-center justify-center">
            <svg class="w-4 h-4 text-amber-600 dark:text-amber-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724
                         1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37
                         2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756
                         2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94
                         1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572
                         1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724
                         0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724
                         1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0
                         -3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826
                         -3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z
                         M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
            Settings
        </span>
    </div>

    <div class="p-5 space-y-4">

        
        <div>
            <label class="block text-xs font-bold text-gray-500
                           dark:text-gray-400 uppercase tracking-wider mb-1.5">
                Internal Notes
            </label>
            <textarea name="notes"
                      rows="2"
                      placeholder="Internal notes about this voucher..."
                      class="w-full px-3.5 py-2.5 resize-none
                             border border-gray-200 dark:border-gray-700
                             rounded-xl text-sm outline-none
                             bg-gray-50 dark:bg-gray-800
                             text-gray-900 dark:text-white
                             focus:border-indigo-500 transition-all"><?php echo e(old('notes', $voucher?->notes)); ?></textarea>
        </div>

        
        <div class="flex items-center justify-between py-2">
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-white">
                    Active
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    Inactive vouchers cannot be used
                </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       class="sr-only peer"
                       <?php echo e(old('is_active', $voucher?->is_active ?? true)
                           ? 'checked' : ''); ?>>
                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700
                            rounded-full peer
                            peer-checked:bg-indigo-500
                            transition-all after:content-['']
                            after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:rounded-full
                            after:h-5 after:w-5 after:transition-all
                            peer-checked:after:translate-x-5">
                </div>
            </label>
        </div>

    </div>
</div>


<div class="flex gap-3">
    <a href="<?php echo e(route('vouchers.index')); ?>"
       class="flex-1 py-3 rounded-xl text-sm font-semibold text-center
              border border-gray-200 dark:border-gray-700
              text-gray-600 dark:text-gray-400
              hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
        Cancel
    </a>
    <button type="submit"
            class="flex-1 py-3 rounded-xl text-sm font-bold
                   bg-indigo-600 hover:bg-indigo-700 active:scale-95
                   text-white transition-all
                   flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <?php echo e($isEdit ? 'Update Voucher' : 'Create Voucher'); ?>

    </button>
</div>

</form>

<script>
function generateCode() {
    const chars  = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    let code     = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('voucher-code').value = code;
}

function updateValueLabel() {
    const type   = document.getElementById('voucher-type').value;
    const label  = document.getElementById('value-label');
    const symbol = document.getElementById('value-symbol');
    const input  = document.getElementById('voucher-value');

    if (type === 'percentage') {
        label.textContent  = 'Percentage (%)';
        symbol.textContent = '%';
        input.max          = '100';
        input.placeholder  = '10';
    } else {
        label.textContent  = 'Amount (£)';
        symbol.textContent = '£';
        input.max          = '';
        input.placeholder  = '0.00';
    }
}

// Init on load
document.addEventListener('DOMContentLoaded', updateValueLabel);
</script><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/vouchers/partials/form.blade.php ENDPATH**/ ?>