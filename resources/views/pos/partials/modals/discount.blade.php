{{-- ============================================================ --}}
{{-- DISCOUNT MODAL                                              --}}
{{-- Supports fixed £ and percentage % discounts                 --}}
{{-- ============================================================ --}}
<div id="discountModal"
     class="pos-modal-overlay"
     onclick="POS.handleOverlayClick(event, 'discountModal')">

    <div id="discountModalBox"
         class="pos-modal-box"
         style="max-width:340px;">

        {{-- Header --}}
        <div class="pos-modal-header">
            <h3 class="pos-modal-title">Discount</h3>
            <button class="pos-modal-close"
                    onclick="POS.closeDiscountModal()"
                    title="Close">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="pos-modal-body">

            {{-- Type Toggle --}}
            <div style="display:flex;gap:8px;">
                <button id="discTypPercent"
                        onclick="POS.setDiscountType('percent')"
                        class="disc-type-btn active">
                    % Percent
                </button>
                <button id="discTypFixed"
                        onclick="POS.setDiscountType('fixed')"
                        class="disc-type-btn">
                    £ Fixed
                </button>
            </div>

            {{-- Input with symbol prefix --}}
            <div style="display:flex;align-items:stretch;
                        border:2px solid #e2e8f0;border-radius:12px;
                        overflow:hidden;transition:border 0.15s;"
                 id="discountInputWrap"
                 class="dark:border-gray-700">

                {{-- Symbol Box --}}
                <div id="discountSymbolBox"
                     style="padding:0 14px;background:#f8fafc;
                            border-right:2px solid #e2e8f0;
                            font-weight:800;font-size:1rem;color:#6366f1;
                            display:flex;align-items:center;justify-content:center;
                            min-width:46px;flex-shrink:0;"
                     class="dark:bg-gray-800 dark:border-gray-700">
                    %
                </div>

                {{-- Number Input --}}
                <input type="number"
                       id="discountInput"
                       min="0"
                       step="0.01"
                       placeholder="0"
                       style="flex:1;padding:14px 16px;border:none;
                              outline:none;font-size:1.5rem;font-weight:800;
                              color:#1e293b;background:#fff;width:100%;"
                       class="dark:bg-gray-900 dark:text-white"
                       onkeydown="if(event.key==='Enter') POS.applyDiscount()"
                       onfocus="document.getElementById('discountInputWrap').style.borderColor='#6366f1'"
                       onblur="document.getElementById('discountInputWrap').style.borderColor=''">
            </div>

            {{-- Quick % Shortcuts --}}
            <div id="quickDiscountRow" style="display:flex;gap:8px;">
                @foreach([5, 10, 15, 20] as $pct)
                <button onclick="POS.setQuickDiscount({{ $pct }})"
                        style="flex:1;padding:9px 4px;border-radius:10px;
                               border:1.5px solid #e2e8f0;background:#f8fafc;
                               color:#475569;font-weight:700;font-size:0.82rem;
                               cursor:pointer;transition:all 0.15s;"
                        class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                        onmouseover="this.style.background='#eef2ff';this.style.color='#6366f1';this.style.borderColor='#6366f1'"
                        onmouseout="this.style.background='';this.style.color='';this.style.borderColor=''">
                    {{ $pct }}%
                </button>
                @endforeach
            </div>

            {{-- Discount Preview --}}
            <div id="discountPreview"
                 style="display:none;padding:10px 14px;border-radius:10px;
                        background:#eef2ff;border:1.5px solid #c7d2fe;
                        justify-content:space-between;align-items:center;">
                <span style="font-size:0.8rem;font-weight:600;color:#6366f1;">
                    Discount amount
                </span>
                <span id="discountPreviewAmount"
                      style="font-size:1rem;font-weight:900;color:#6366f1;">
                    £0.00
                </span>
            </div>

        </div>

        {{-- Footer --}}
        <div class="pos-modal-footer">
            <div style="display:flex;flex-direction:column;gap:8px;">

                {{-- Apply --}}
                <button onclick="POS.applyDiscount()"
                        style="width:100%;padding:13px;border-radius:12px;
                               border:none;background:#6366f1;color:#fff;
                               font-weight:800;font-size:0.95rem;
                               cursor:pointer;transition:all 0.15s;"
                        onmouseover="this.style.background='#4f46e5'"
                        onmouseout="this.style.background='#6366f1'">
                    Apply Discount
                </button>

                {{-- Remove (only shown if discount active) --}}
                <button id="removeDiscountBtn"
                        onclick="POS.removeDiscount()"
                        style="display:none;width:100%;padding:13px;
                               border-radius:12px;border:2px solid #fee2e2;
                               background:#fff;color:#ef4444;font-weight:700;
                               font-size:0.9rem;cursor:pointer;transition:all 0.15s;"
                        class="dark:bg-gray-900 dark:border-red-900"
                        onmouseover="this.style.background='#fee2e2'"
                        onmouseout="this.style.background=''">
                    Remove Discount
                </button>

            </div>
        </div>

    </div>
</div>