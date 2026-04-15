{{-- ============================================================ --}}
{{-- REPAIR PAYMENT MODAL                                        --}}
{{-- ============================================================ --}}
<div id="repair-payment-modal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.75);align-items:center;
            justify-content:center;padding:16px;">

    <div id="repair-payment-modal-box"
         style="transform:scale(0.95);opacity:0;transition:all 0.2s;
                max-height:90vh;overflow-y:auto;scrollbar-width:none;"
         class="relative w-full max-w-md
                bg-white dark:bg-gray-900
                rounded-2xl shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800
                    sticky top-0 bg-white dark:bg-gray-900 z-10">
            <h3 class="text-base font-bold
                        text-gray-900 dark:text-white">
                Add Payment
            </h3>
            <button type="button"
                    onclick="RepairPayments.closePaymentModal()"
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

        <div class="px-6 py-5 space-y-5">

            {{-- Total Due --}}
            <div class="text-center py-4 rounded-2xl
                        bg-gradient-to-br from-emerald-50 to-teal-50
                        dark:from-emerald-900/20 dark:to-teal-900/20
                        border border-emerald-100 dark:border-emerald-800">
                <p class="text-xs font-bold text-emerald-600
                           dark:text-emerald-400 uppercase
                           tracking-widest mb-1">
                    Total Due
                </p>
                <p id="repair-payment-total"
                   class="text-4xl font-black text-emerald-700
                          dark:text-emerald-300"
                   style="font-family:'Georgia',serif;">
                    £0.00
                </p>
                <div id="repair-payment-outstanding-row"
                     style="display:none;"
                     class="mt-2 text-xs font-semibold
                            text-amber-600 dark:text-amber-400">
                    Outstanding:
                    <span id="repair-payment-outstanding">£0.00</span>
                </div>
            </div>

            {{-- Payments Added So Far --}}
            <div id="repair-existing-payments"
                 style="display:none;">
                <p class="text-xs font-bold text-gray-500
                           dark:text-gray-400 uppercase
                           tracking-wider mb-2">
                    Payments Added
                </p>
                <div id="repair-existing-payments-list"
                     class="space-y-1.5 mb-3">
                </div>
            </div>

            {{-- Payment Method --}}
<div>
    <p class="text-xs font-bold text-gray-500
               dark:text-gray-400 uppercase
               tracking-wider mb-2">
        Payment Method
    </p>
    <div class="grid grid-cols-4 gap-2">
        @foreach([
            'cash' => [
                'label' => 'Cash',
                'icon'  => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
            ],
            'card' => [
                'label' => 'Card',
                'icon'  => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
            ],
            'split' => [
                'label' => 'Split',
                'icon'  => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4',
            ],
            'trade' => [
                'label' => 'Trade',
                'icon'  => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
            ],
        ] as $value => $method)
        <label class="cursor-pointer">
            <input type="radio"
                   name="repair_payment_method"
                   value="{{ $value }}"
                   class="sr-only peer"
                   onchange="RepairPayments.onMethodChange('{{ $value }}')"
                   {{ $value === 'cash' ? 'checked' : '' }}>
            <div class="flex flex-col items-center gap-1.5
                        py-3 rounded-xl border-2 transition-all
                        cursor-pointer
                        border-gray-200 dark:border-gray-700
                        text-gray-500 dark:text-gray-400
                        peer-checked:border-emerald-500
                        peer-checked:bg-emerald-50
                        dark:peer-checked:bg-emerald-900/20
                        peer-checked:text-emerald-600
                        dark:peer-checked:text-emerald-400
                        hover:border-emerald-300">
                <svg class="w-5 h-5" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="{{ $method['icon'] }}"/>
                </svg>
                <span class="text-xs font-bold">
                    {{ $method['label'] }}
                </span>
            </div>
        </label>
        @endforeach
    </div>
</div>

            {{-- CASH Fields --}}
            <div id="repair-fields-cash">
                <p class="text-xs font-bold text-gray-500
                           dark:text-gray-400 uppercase
                           tracking-wider mb-2">
                    Amount £
                </p>

                {{-- Quick Amounts --}}
                <div class="grid grid-cols-5 gap-1.5 mb-2">
                    @foreach([5, 10, 20, 50] as $amt)
                    <button type="button"
                            onclick="RepairPayments.setQuickAmount({{ $amt }})"
                            class="py-2 rounded-lg text-xs font-bold
                                   border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800
                                   text-gray-600 dark:text-gray-400
                                   hover:bg-emerald-50 hover:text-emerald-600
                                   hover:border-emerald-400
                                   dark:hover:bg-emerald-900/20
                                   dark:hover:text-emerald-400
                                   transition-all">
                        £{{ $amt }}
                    </button>
                    @endforeach
                    <button type="button"
                            onclick="RepairPayments.setExactAmount()"
                            class="py-2 rounded-lg text-xs font-bold
                                   border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800
                                   text-gray-600 dark:text-gray-400
                                   hover:bg-emerald-50 hover:text-emerald-600
                                   hover:border-emerald-400
                                   dark:hover:bg-emerald-900/20
                                   dark:hover:text-emerald-400
                                   transition-all">
                        Exact
                    </button>
                </div>

                {{-- Amount Input --}}
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">
                        £
                    </span>
                    <input type="number"
                           id="repair-payment-amount"
                           min="0"
                           step="0.01"
                           placeholder="0"
                           oninput="RepairPayments.updateChange()"
                           class="w-full pl-8 pr-4 py-3
                                  border border-gray-200 dark:border-gray-700
                                  rounded-xl text-xl font-black outline-none
                                  bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-emerald-500
                                  focus:ring-2 focus:ring-emerald-500/10
                                  focus:bg-white dark:focus:bg-gray-900
                                  transition-all">
                </div>

                {{-- Change Display --}}
                <div id="repair-change-display"
                     style="display:none;"
                     class="mt-2 flex items-center justify-between
                            px-4 py-2.5 rounded-xl
                            bg-emerald-50 dark:bg-emerald-900/20
                            border border-emerald-200 dark:border-emerald-800">
                    <span class="text-sm font-semibold
                                 text-emerald-700 dark:text-emerald-400">
                        Change Due
                    </span>
                    <span id="repair-change-amount"
                          class="text-base font-black
                                 text-emerald-600 dark:text-emerald-400">
                        £0.00
                    </span>
                </div>
            </div>

            {{-- CARD Fields --}}
            <div id="repair-fields-card"
                 style="display:none;"
                 class="flex flex-col items-center py-4 gap-3">
                <div class="w-16 h-16 rounded-2xl
                            bg-gradient-to-br from-amber-400 to-amber-500
                            flex items-center justify-center
                            shadow-lg shadow-amber-200 dark:shadow-amber-900/30">
                    <svg class="w-8 h-8 text-white" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0
                                 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8
                                 a3 3 0 003 3z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold
                           text-gray-600 dark:text-gray-400">
                    Present card to terminal
                </p>
            </div>

            {{-- SPLIT Fields --}}
            <div id="repair-fields-split" style="display:none;">

                {{-- 1st Payment --}}
                <div class="bg-indigo-50 dark:bg-indigo-900/20
                            rounded-xl p-4 mb-3">
                    <p class="text-xs font-bold text-indigo-600
                               dark:text-indigo-400 uppercase
                               tracking-wider mb-3">
                        1st Payment
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Method
                            </label>
                            <select id="repair-split1-method"
                                    class="w-full px-3 py-2
                                           border border-gray-200
                                           dark:border-gray-700
                                           rounded-lg text-sm font-semibold
                                           outline-none bg-white
                                           dark:bg-gray-800
                                           text-gray-900 dark:text-white
                                           cursor-pointer">
                                <option value="cash">💵 Cash</option>
                                <option value="card">💳 Card</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Amount £
                            </label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2
                                             -translate-y-1/2 text-gray-400
                                             font-bold text-sm
                                             pointer-events-none">
                                    £
                                </span>
                                <input type="number"
                                       id="repair-split1-amount"
                                       min="0" step="0.01"
                                       placeholder="0.00"
                                       oninput="RepairPayments.updateSplit2()"
                                       class="w-full pl-7 pr-2 py-2
                                              border border-gray-200
                                              dark:border-gray-700
                                              rounded-lg text-sm font-bold
                                              outline-none bg-white
                                              dark:bg-gray-800
                                              text-gray-900 dark:text-white
                                              focus:border-indigo-400
                                              transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2nd Payment --}}
                <div class="bg-emerald-50 dark:bg-emerald-900/20
                            rounded-xl p-4">
                    <p class="text-xs font-bold text-emerald-600
                               dark:text-emerald-400 uppercase
                               tracking-wider mb-3">
                        2nd Payment
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Method
                            </label>
                            <select id="repair-split2-method"
                                    class="w-full px-3 py-2
                                           border border-gray-200
                                           dark:border-gray-700
                                           rounded-lg text-sm font-semibold
                                           outline-none bg-white
                                           dark:bg-gray-800
                                           text-gray-900 dark:text-white
                                           cursor-pointer">
                                <option value="card">💳 Card</option>
                                <option value="cash">💵 Cash</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold
                                           text-gray-500 dark:text-gray-400
                                           uppercase tracking-wider mb-1.5">
                                Amount £
                            </label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2
                                             -translate-y-1/2 text-gray-400
                                             font-bold text-sm
                                             pointer-events-none">
                                    £
                                </span>
                                <input type="number"
                                       id="repair-split2-amount"
                                       min="0" step="0.01"
                                       placeholder="0.00"
                                       readonly
                                       class="w-full pl-7 pr-2 py-2
                                              border border-gray-200
                                              dark:border-gray-700
                                              rounded-lg text-sm font-bold
                                              outline-none
                                              bg-gray-50 dark:bg-gray-700
                                              text-gray-500 dark:text-gray-400">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- TRADE Fields --}}
<div id="repair-fields-trade" style="display:none;">

    {{-- Info Banner --}}
    <div class="flex items-start gap-3 px-4 py-3 rounded-xl
                bg-amber-50 dark:bg-amber-900/20
                border border-amber-200 dark:border-amber-800
                mb-4">
        <span class="text-xl flex-shrink-0">🔄</span>
        <p class="text-sm font-semibold text-amber-700
                   dark:text-amber-400 leading-snug">
            Customer is trading a device as full or partial payment.
        </p>
    </div>

    {{-- Trade Value --}}
    <div>
        <label class="block text-xs font-bold text-gray-500
                       dark:text-gray-400 uppercase
                       tracking-wider mb-1.5">
            Trade-in Value
        </label>
        <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2
                         text-gray-400 font-bold pointer-events-none">
                £
            </span>
            <input type="number"
                   id="repair-trade-value"
                   min="0"
                   step="0.01"
                   placeholder="0.00"
                   class="w-full pl-8 pr-4 py-3
                          border border-gray-200 dark:border-gray-700
                          rounded-xl text-xl font-black outline-none
                          bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-emerald-500
                          focus:ring-2 focus:ring-emerald-500/10
                          focus:bg-white dark:focus:bg-gray-900
                          transition-all">
        </div>
    </div>

</div>

            {{-- Note --}}
            <div>
                <label class="block text-xs font-bold text-gray-500
                               dark:text-gray-400 uppercase
                               tracking-wider mb-1.5">
                    Note (Optional)
                </label>
                <input type="text"
                       id="repair-payment-note"
                       placeholder="e.g. deposit, partial payment..."
                       class="w-full px-3.5 py-2.5
                              border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none
                              bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white
                              placeholder-gray-400 dark:placeholder-gray-500
                              focus:border-emerald-500 focus:ring-2
                              focus:ring-emerald-500/10
                              focus:bg-white dark:focus:bg-gray-900
                              transition-all">
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 flex gap-3">
            <button type="button"
                    onclick="RepairPayments.closePaymentModal()"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold
                           border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400
                           hover:bg-gray-50 dark:hover:bg-gray-800
                           transition-all">
                Cancel
            </button>
            <button type="button"
                    onclick="RepairPayments.addPayment()"
                    class="flex-1 py-3 rounded-xl text-sm font-bold
                           bg-emerald-600 hover:bg-emerald-700
                           active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Payment
            </button>
        </div>

    </div>
</div>