



<div class="device-card bg-white dark:bg-gray-900
            border-2 border-gray-200 dark:border-gray-700
            rounded-2xl transition-all duration-200
            hover:border-indigo-400 dark:hover:border-indigo-600
            hover:shadow-lg"
     data-device-index="__INDEX__">

    
    <div class="flex items-center justify-between px-5 py-3
                bg-gray-50 dark:bg-gray-800
                border-b border-gray-200 dark:border-gray-700
                rounded-t-2xl">
        <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-lg
                        bg-indigo-100 dark:bg-indigo-900/40
                        flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                             00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <span class="text-sm font-bold
                         text-gray-700 dark:text-gray-300">
                Device #<span class="device-number">__NUMBER__</span>
            </span>
        </div>
        <button type="button"
                onclick="RepairForm.removeDevice(this)"
                class="flex items-center gap-1.5 text-xs font-semibold
                       text-red-500 hover:text-red-700
                       dark:text-red-400 dark:hover:text-red-300
                       transition-colors px-2 py-1 rounded-lg
                       hover:bg-red-50 dark:hover:bg-red-900/20
                       border-none bg-transparent cursor-pointer">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Remove
        </button>
    </div>

    
    <div class="p-5 space-y-4">

        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Device Name
                    <span class="text-red-500 ml-0.5">*</span>
                </label>
                <input type="text"
                       name="devices[__INDEX__][device_name]"
                       placeholder="e.g. iPhone 13 Pro..."
                       required
                       class="repair-input">
            </div>

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Device Type
                </label>
                <select name="devices[__INDEX__][device_type_id]"
                        class="repair-input">
                    <option value="">Select type...</option>
                    <?php $__currentLoopData = $deviceTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->id); ?>"
                                <?php echo e($type->name === 'Mobile Phone' ? 'selected' : ''); ?>>
                            <?php echo e($type->icon_emoji); ?> <?php echo e($type->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Device Status
                </label>
                <select name="devices[__INDEX__][status_id]"
                        class="repair-input">
                    <option value="">Same as repair</option>
                    <?php $__currentLoopData = $deviceStatuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($status->id); ?>"
                                <?php echo e($status->is_default ? 'selected' : ''); ?>>
                            <?php echo e($status->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    IMEI / Serial
                </label>
                <input type="text"
                       name="devices[__INDEX__][imei]"
                       placeholder="Enter IMEI..."
                       class="repair-input">
            </div>

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Color
                </label>
                <input type="text"
                       name="devices[__INDEX__][color]"
                       placeholder="e.g. Space Grey..."
                       class="repair-input">
            </div>

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Warranty
                </label>
                <select name="devices[__INDEX__][warranty_days]"
                        class="repair-input"
                        onchange="RepairPayments.updateWarrantyExpiry(this)">
                    <option value="0">No Warranty</option>
                    <option value="-1">🛡️ Under Warranty</option>
                    <option value="30">1 Month</option>
                    <option value="90">3 Months</option>
                    <option value="180" selected>6 Months</option>
                    <option value="365">1 Year</option>
                </select>
                
                <input type="hidden"
                       name="devices[__INDEX__][warranty_status]"
                       value="active">
            </div>

        </div>

        
        <div>
            <label class="block text-xs font-semibold
                           text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-1.5">
                Issues
                <span class="text-red-500 ml-0.5">*</span>
            </label>

            <div x-data="PartsInput('devices[__INDEX__][issues]', {
                             searchUrl    : null,
                             suggestions  : <?php echo e(json_encode($issueSuggestions ?? [])); ?>,
                             placeholder  : 'Type issue and press Enter...',
                             tagColor     : 'red',
                             showQty      : false,
                         })"
                 class="relative">

                <div @click="$refs.theInput.focus()"
                     class="min-h-[42px] w-full px-2 py-1.5
                            border border-gray-200 dark:border-gray-700
                            rounded-xl bg-gray-50 dark:bg-gray-800
                            flex flex-wrap gap-1.5 items-center
                            cursor-text transition-all
                            focus-within:border-indigo-500
                            focus-within:ring-2
                            focus-within:ring-indigo-500/10
                            focus-within:bg-white
                            dark:focus-within:bg-gray-900">

                    <template x-for="(tag, i) in parts" :key="i">
                        <span class="inline-flex items-center gap-1
                                     px-2.5 py-1 rounded-lg text-xs
                                     font-semibold bg-red-50
                                     dark:bg-red-900/30
                                     text-red-700 dark:text-red-300">
                            <span x-text="tag.name"></span>
                            <button type="button"
                                    @click.stop="removePart(i)"
                                    class="hover:opacity-70 transition-opacity
                                           bg-transparent border-none
                                           cursor-pointer p-0 leading-none
                                           text-red-400 flex items-center">
                                <svg class="w-3 h-3" fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.5"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    </template>

                    <input type="text"
                           x-ref="theInput"
                           x-model="inputVal"
                           @input="onInput()"
                           @keydown.enter.prevent="addCustomPart()"
                           @keydown.backspace="onBackspace()"
                           @keydown.escape="closeDropdown()"
                           @focus="onFocus()"
                           @blur="onBlur()"
                           :placeholder="parts.length === 0 ? placeholder : ''"
                           class="flex-1 min-w-24 bg-transparent
                                  outline-none text-sm
                                  text-gray-900 dark:text-white
                                  placeholder-gray-400
                                  dark:placeholder-gray-500
                                  py-0.5  border-0 px-1">
                </div>

                <template x-for="(tag, i) in parts"
                          :key="'issue-hidden-' + i">
                    <input type="hidden"
                           :name="`devices[__INDEX__][issues][${i}][label]`"
                           :value="tag.name">
                </template>

                <div x-show="isOpen && filteredSuggestions.length > 0"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 right-0 mt-1.5
                            bg-white dark:bg-gray-800
                            border border-gray-200 dark:border-gray-700
                            rounded-xl shadow-xl z-[999]
                            max-h-48 overflow-y-auto"
                     style="display:none;">

                    <div x-show="inputVal.trim().length > 0 &&
                                 !filteredSuggestions.some(s =>
                                     (s.label ?? s).toLowerCase() ===
                                     inputVal.toLowerCase())"
                         @mousedown.prevent="addCustomPart()"
                         class="flex items-center gap-2 px-4 py-2.5
                                cursor-pointer text-sm font-semibold
                                text-red-600 dark:text-red-400
                                hover:bg-red-50 dark:hover:bg-red-900/20
                                border-b border-gray-100
                                dark:border-gray-700 transition-colors">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Add "<span x-text="inputVal" class="ml-0.5"></span>"
                    </div>

                    <template x-for="(s, i) in filteredSuggestions"
                              :key="i">
                        <div @mousedown.prevent="selectSuggestion(s)"
                             :class="highlightedIndex === i
                                 ? 'bg-indigo-50 dark:bg-indigo-900/20'
                                 : 'hover:bg-gray-50 dark:hover:bg-gray-700'"
                             class="px-4 py-2.5 cursor-pointer
                                    transition-colors text-sm
                                    text-gray-800 dark:text-gray-200
                                    border-b border-gray-100
                                    dark:border-gray-700 last:border-0">
                            <span x-text="s.label ?? s"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        
        <div>
            <label class="block text-xs font-semibold
                           text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-1.5">
                Repair Type
            </label>

            <div x-data="PartsInput('devices[__INDEX__][repair_type_tags]', {
                             searchUrl    : null,
                             suggestions  : <?php echo e(json_encode($repairTypes->pluck('name')->toArray() ?? [])); ?>,
                             placeholder  : 'Select or type repair type...',
                             tagColor     : 'indigo',
                             showQty      : false,
                         })"
                 class="relative">

                <div @click="$refs.theInput.focus()"
                     class="min-h-[42px] w-full px-2 py-1.5
                            border border-gray-200 dark:border-gray-700
                            rounded-xl bg-gray-50 dark:bg-gray-800
                            flex flex-wrap gap-1.5 items-center
                            cursor-text transition-all
                            focus-within:border-indigo-500
                            focus-within:ring-2
                            focus-within:ring-indigo-500/10
                            focus-within:bg-white
                            dark:focus-within:bg-gray-900">

                    <template x-for="(tag, i) in parts" :key="i">
                        <span class="inline-flex items-center gap-1
                                     px-2.5 py-1 rounded-lg text-xs
                                     font-semibold bg-indigo-50
                                     dark:bg-indigo-900/30
                                     text-indigo-700 dark:text-indigo-300">
                            <span x-text="tag.name"></span>
                            <button type="button"
                                    @click.stop="removePart(i)"
                                    class="hover:opacity-70 transition-opacity
                                           bg-transparent border-none
                                           cursor-pointer p-0 leading-none
                                           text-indigo-400 flex items-center">
                                <svg class="w-3 h-3" fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2.5"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </span>
                    </template>

                    <input type="text"
                           x-ref="theInput"
                           x-model="inputVal"
                           @input="onInput()"
                           @keydown.enter.prevent="addCustomPart()"
                           @keydown.backspace="onBackspace()"
                           @keydown.escape="closeDropdown()"
                           @focus="onFocus()"
                           @blur="onBlur()"
                           :placeholder="parts.length === 0 ? placeholder : ''"
                           class="flex-1 min-w-24 bg-transparent
                                  outline-none text-sm
                                  text-gray-900 dark:text-white
                                  placeholder-gray-400
                                  dark:placeholder-gray-500
                                  py-0.5 px-1  border-0">
                </div>

                
                <template x-for="(tag, i) in parts"
                          :key="'rt-hidden-' + i">
                    <input type="hidden"
                           :name="`devices[__INDEX__][repair_types][${i}]`"
                           :value="tag.name">
                </template>

                <div x-show="isOpen && (filteredSuggestions.length > 0
                             || inputVal.trim().length > 0)"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 right-0 mt-1.5
                            bg-white dark:bg-gray-800
                            border border-gray-200 dark:border-gray-700
                            rounded-xl shadow-xl z-[999]
                            max-h-48 overflow-y-auto"
                     style="display:none;">

                    <div x-show="inputVal.trim().length > 0 &&
                                 !filteredSuggestions.some(s =>
                                     (s.label ?? s).toLowerCase() ===
                                     inputVal.toLowerCase())"
                         @mousedown.prevent="addCustomPart()"
                         class="flex items-center gap-2 px-4 py-2.5
                                cursor-pointer text-sm font-semibold
                                text-indigo-600 dark:text-indigo-400
                                hover:bg-indigo-50
                                dark:hover:bg-indigo-900/20
                                border-b border-gray-100
                                dark:border-gray-700 transition-colors">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add "<span x-text="inputVal" class="ml-0.5 font-black"></span>"
                    </div>

                    <template x-for="(s, i) in filteredSuggestions"
                              :key="i">
                        <div @mousedown.prevent="selectSuggestion(s)"
                             :class="highlightedIndex === i
                                 ? 'bg-indigo-50 dark:bg-indigo-900/20'
                                 : 'hover:bg-gray-50 dark:hover:bg-gray-700'"
                             class="px-4 py-2.5 cursor-pointer
                                    transition-colors text-sm
                                    text-gray-800 dark:text-gray-200
                                    border-b border-gray-100
                                    dark:border-gray-700 last:border-0">
                            <span x-text="s.label ?? s"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Parts Used
                </label>

                <div x-data="PartsInput('devices[__INDEX__][parts]', {
                                 searchUrl   : '<?php echo e(route("products.search")); ?>',
                                 suggestions : [],
                                 placeholder : 'Search parts or type custom...',
                                 tagColor    : 'indigo',
                                 showQty     : true,
                             })"
                     class="relative">

                    <div @click="$refs.theInput.focus()"
                         class="min-h-[42px] w-full px-2 py-1.5
                                border border-gray-200 dark:border-gray-700
                                rounded-xl bg-gray-50 dark:bg-gray-800
                                flex flex-wrap gap-1.5 items-center
                                cursor-text transition-all
                                focus-within:border-indigo-500
                                focus-within:ring-2
                                focus-within:ring-indigo-500/10
                                focus-within:bg-white
                                dark:focus-within:bg-gray-900">

                        <template x-for="(part, i) in parts" :key="i">
                            <span class="inline-flex items-center gap-1.5
                                         px-2.5 py-1 rounded-lg text-xs
                                         font-semibold bg-indigo-50
                                         dark:bg-indigo-900/30
                                         text-indigo-700 dark:text-indigo-300">
                                <span x-text="part.name"></span>
                                <template x-if="showQty && part.price > 0">
                                    <span class="text-indigo-400
                                                 dark:text-indigo-500
                                                 font-normal">
                                        — <span x-text="'£' + parseFloat(part.price).toFixed(2)"></span>
                                    </span>
                                </template>
                                <template x-if="part.isCustom">
                                    <span class="text-indigo-300
                                                 dark:text-indigo-600
                                                 font-normal text-xs">
                                        custom
                                    </span>
                                </template>
                                <button type="button"
                                        @click.stop="removePart(i)"
                                        class="hover:opacity-70 transition-opacity
                                               bg-transparent border-none
                                               cursor-pointer p-0 leading-none
                                               text-indigo-300
                                               dark:text-indigo-600
                                               flex items-center ml-0.5">
                                    <svg class="w-3 h-3" fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2.5"
                                              d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </span>
                        </template>

                        <input type="text"
                               x-ref="theInput"
                               x-model="inputVal"
                               @input="onInput()"
                               @keydown.enter.prevent="addCustomPart()"
                               @keydown.backspace="onBackspace()"
                               @keydown.escape="closeDropdown()"
                               @focus="onFocus()"
                               @blur="onBlur()"
                               :placeholder="parts.length === 0 ? placeholder : ''"
                               class="flex-1 min-w-28 bg-transparent
                                      outline-none text-sm
                                      text-gray-900 dark:text-white
                                      placeholder-gray-400
                                      dark:placeholder-gray-500
                                      py-0.5 px-1 border-0">
                    </div>

                    <template x-for="(part, i) in parts"
                              :key="'part-h-' + i">
                        <span>
                            <input type="hidden"
                                   :name="`${inputName}[${i}][name]`"
                                   :value="part.name">
                            <input type="hidden"
                                   :name="`${inputName}[${i}][product_id]`"
                                   :value="part.product_id ?? ''">
                            <input type="hidden"
                                   :name="`${inputName}[${i}][quantity]`"
                                   :value="part.quantity">
                        </span>
                    </template>

                    <div x-show="isOpen"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 right-0 mt-1.5
                                bg-white dark:bg-gray-800
                                border border-gray-200 dark:border-gray-700
                                rounded-xl shadow-xl z-[999]
                                max-h-56 overflow-y-auto"
                         style="display:none;">

                        <div x-show="isLoading"
                             class="flex items-center gap-2 px-4 py-3
                                    text-sm text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 animate-spin" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12"
                                        r="10" stroke="currentColor"
                                        stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
                            Searching...
                        </div>

                        <div x-show="!isLoading && inputVal.trim().length > 0"
                             @mousedown.prevent="addCustomPart()"
                             class="flex items-center gap-2 px-4 py-2.5
                                    cursor-pointer text-sm font-semibold
                                    text-indigo-600 dark:text-indigo-400
                                    hover:bg-indigo-50
                                    dark:hover:bg-indigo-900/20
                                    border-b border-gray-100
                                    dark:border-gray-700 transition-colors">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            Add "<span x-text="inputVal" class="ml-0.5"></span>"
                            as custom
                        </div>

                        <template x-for="(product, i) in products"
                                  :key="product.id">
                            <div @mousedown.prevent="selectProduct(product)"
                                 class="flex items-center justify-between
                                        px-4 py-2.5 cursor-pointer
                                        hover:bg-gray-50 dark:hover:bg-gray-700
                                        transition-colors border-b
                                        border-gray-100 dark:border-gray-700
                                        last:border-0">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold
                                               text-gray-900 dark:text-white
                                               truncate"
                                       x-text="product.name">
                                    </p>
                                </div>
                                <div class="text-right flex-shrink-0 ml-3">
                                    <p class="text-sm font-bold
                                               text-indigo-600
                                               dark:text-indigo-400"
                                       x-text="product.formatted_price">
                                    </p>
                                    <p class="text-xs"
                                       :class="product.stock <= 0
                                           ? 'text-red-500'
                                           : product.stock <= 5
                                               ? 'text-amber-500'
                                               : 'text-emerald-500'"
                                       x-text="product.stock <= 0
                                           ? 'Out of stock'
                                           : product.stock + ' in stock'">
                                    </p>
                                </div>
                            </div>
                        </template>

                        <div x-show="!isLoading && products.length === 0
                                     && inputVal.trim().length > 1"
                             class="px-4 py-3 text-sm text-center
                                    text-gray-500 dark:text-gray-400">
                            No products — press Enter to add custom
                        </div>
                    </div>
                </div>
            </div>

            
            <div>
                <label class="block text-xs font-semibold
                               text-gray-500 dark:text-gray-400
                               uppercase tracking-wider mb-1.5">
                    Repair Price
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-semibold text-sm
                                 pointer-events-none">
                        £
                    </span>
                    <input type="number"
                           name="devices[__INDEX__][price]"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           oninput="RepairPayments.updateTotals()"
                           class="repair-input pl-10">
                </div>
            </div>

        </div>

        
        <div>
            <label class="block text-xs font-semibold
                           text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-1.5">
                Notes
            </label>
            <textarea name="devices[__INDEX__][notes]"
                      rows="3"
                      placeholder="Internal notes about this device..."
                      class="repair-input resize-none">
            </textarea>
        </div>

    </div>
</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/partials/device-card.blade.php ENDPATH**/ ?>