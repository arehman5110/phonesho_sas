


<div class="lg:col-span-1">
    <div class="lg:sticky lg:top-5 space-y-4">
        
        <span id="infoCustomer" style="display:none;"></span>
        <span id="infoDeviceCount" style="display:none;">0</span>

        
        <div class="bg-white dark:bg-gray-900
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl overflow-hidden">

            
            <div class="flex items-center gap-3 px-5 py-3.5
                        bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700
                        rounded-t-2xl">
                <div class="w-7 h-7 rounded-lg
                            bg-emerald-100 dark:bg-emerald-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2
                                 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402
                                 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11
                                 0-2.08-.402-2.599-1M21 12a9 9 0 11-18
                                 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold
                             text-gray-800 dark:text-gray-200">
                    Price Summary
                </span>
            </div>

            
            <div class="p-5 space-y-3">

                
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-500 dark:text-gray-400">
                        Subtotal
                    </span>
                    <span id="rp-subtotal"
                          class="font-semibold text-gray-900
                                 dark:text-white">
                        £0.00
                    </span>
                </div>

                
                <div class="flex justify-between items-center text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-500 dark:text-gray-400">
                            Discount
                        </span>
                        
                        <button type="button"
                                id="rp-discount-btn"
                                onclick="RepairPayments.openDiscountModal()"
                                title="Add Discount"
                                class="w-6 h-6 rounded-lg flex items-center
                                       justify-center transition-all
                                       border border-gray-200 dark:border-gray-700
                                       text-gray-400 dark:text-gray-500
                                       hover:border-orange-400
                                       hover:text-orange-500
                                       hover:bg-orange-50
                                       dark:hover:bg-orange-900/20
                                       dark:hover:border-orange-600
                                       dark:hover:text-orange-400">
                            <svg class="w-3.5 h-3.5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M7 7h.01M17 17h.01M5 19L19 5"/>
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span id="rp-discount"
                              class="font-semibold text-red-500
                                     dark:text-red-400">
                            -£0.00
                        </span>
                        
                        <button type="button"
                                id="rp-remove-discount"
                                onclick="RepairPayments.removeDiscount()"
                                style="display:none;"
                                class="w-4 h-4 rounded-full flex items-center
                                       justify-center bg-red-100
                                       dark:bg-red-900/40 text-red-500
                                       hover:bg-red-200 transition-all
                                       border-none cursor-pointer">
                            <svg class="w-2.5 h-2.5" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="3"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                
                <div class="border-t border-gray-200 dark:border-gray-700
                            pt-3">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900
                                     dark:text-white">
                            Total
                        </span>
                        <span id="rp-total"
                              class="text-xl font-black
                                     text-emerald-600 dark:text-emerald-400">
                            £0.00
                        </span>
                    </div>
                </div>

            </div>
        </div>

        
        <div id="rp-payments-section"
             style="display:none;"
             class="bg-white dark:bg-gray-900
                    border border-gray-200 dark:border-gray-700
                    rounded-2xl overflow-hidden">

            <div class="flex items-center gap-3 px-5 py-3.5
                        bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700
                        rounded-t-2xl">
                <div class="w-7 h-7 rounded-lg
                            bg-blue-100 dark:bg-blue-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0
                                 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8
                                 a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold
                             text-gray-800 dark:text-gray-200">
                    Payments
                </span>
                <button type="button"
                        onclick="RepairPayments.clearPayments()"
                        class="ml-auto text-xs font-semibold
                               text-red-500 hover:text-red-700
                               dark:text-red-400 transition-colors
                               bg-transparent border-none cursor-pointer">
                    Clear
                </button>
            </div>

            <div id="rp-payments-list" class="p-4 space-y-2">
            </div>

            
            <div class="px-4 pb-4 space-y-1.5">
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 dark:text-gray-400">
                        Paid
                    </span>
                    <span id="rp-paid"
                          class="font-bold text-emerald-600
                                 dark:text-emerald-400">
                        £0.00
                    </span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-gray-500 dark:text-gray-400">
                        Outstanding
                    </span>
                    <span id="rp-outstanding"
                          class="font-bold text-red-500
                                 dark:text-red-400">
                        £0.00
                    </span>
                </div>
            </div>

        </div>

        
        <div class="space-y-2">

            
            <button type="button"
                    id="rp-charge-btn"
                    onclick="RepairPayments.openPaymentModal()"
                    disabled
                    class="w-full py-3 rounded-xl text-sm font-bold
                           bg-emerald-600 hover:bg-emerald-700
                           active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2
                           disabled:bg-gray-200 dark:disabled:bg-gray-800
                           disabled:text-gray-400 dark:disabled:text-gray-600
                           disabled:cursor-not-allowed">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0
                             003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8
                             a3 3 0 003 3z"/>
                </svg>
                Charge
                <span id="rp-charge-total">£0.00</span>
            </button>

            
            <button type="submit"
                    id="submitBtn"
                    class="w-full py-3 rounded-xl text-sm font-bold
                           bg-indigo-600 hover:bg-indigo-700
                           active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Save Repair
            </button>

        </div>

    </div>
</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/partials/right-panel.blade.php ENDPATH**/ ?>