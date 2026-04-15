{{-- ============================================================ --}}
{{-- POS RIGHT PANEL — Cart                                      --}}
{{-- Customer selection, items, totals, action buttons           --}}
{{-- ============================================================ --}}
<div id="pos-right">

    {{-- ── Header ─────────────────────────────────────────────── --}}
    <div style="display:flex;align-items:center;justify-content:space-between;
                padding:12px 16px;border-bottom:1px solid #f1f5f9;flex-shrink:0;"
         class="dark:border-gray-800">

        <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-weight:800;font-size:0.9rem;color:#1e293b;"
                  class="dark:text-white">
                Your Order
            </span>
            <span id="cartBadge"
                  style="display:none;width:20px;height:20px;border-radius:50%;
                         background:#6366f1;color:#fff;font-size:0.7rem;
                         font-weight:800;align-items:center;justify-content:center;">
                0
            </span>
        </div>

        <div style="display:flex;gap:6px;align-items:center;">
            <button onclick="POS.openCustomModal()"
                    style="font-size:0.72rem;padding:5px 10px;border-radius:8px;
                           border:1.5px solid #e2e8f0;background:#fff;
                           color:#475569;cursor:pointer;font-weight:600;
                           transition:all 0.15s;"
                    class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                    onmouseover="this.style.borderColor='#6366f1';this.style.color='#6366f1'"
                    onmouseout="this.style.borderColor='';this.style.color=''">
                + Custom
            </button>
            <button onclick="POS.clearCart()"
                    style="font-size:0.72rem;padding:5px 10px;border-radius:8px;
                           border:1.5px solid #fee2e2;background:#fff;
                           color:#ef4444;cursor:pointer;font-weight:600;
                           transition:all 0.15s;"
                    class="dark:bg-gray-900 dark:border-red-900"
                    onmouseover="this.style.background='#fee2e2'"
                    onmouseout="this.style.background='#fff'">
                Clear
            </button>
        </div>
    </div>

    {{-- ── Customer Search ──────────────────────────────────────── --}}
    <div style="padding:10px 16px;border-bottom:1px solid #f1f5f9;
                flex-shrink:0;position:relative;"
         id="cartCustomerWrap"
         class="dark:border-gray-800">

        <div style="position:relative;">
            <svg style="position:absolute;left:9px;top:50%;
                        transform:translateY(-50%);pointer-events:none;"
                 width="14" height="14" fill="none" stroke="#94a3b8"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <input type="text"
                   id="customerSearch"
                   placeholder="Search customer..."
                   autocomplete="off"
                   oninput="POS.filterCustomers(this.value)"
                   onfocus="POS.showCustomerDropdown()"
                   style="width:100%;padding:8px 30px 8px 30px;
                          border:1.5px solid #e2e8f0;border-radius:10px;
                          font-size:0.8rem;outline:none;background:#f8fafc;
                          color:#1e293b;box-sizing:border-box;transition:border 0.15s;"
                   class="dark:bg-gray-800 dark:border-gray-700
                          dark:text-gray-200 dark:placeholder-gray-500">
            <button id="clearCustomerBtn"
                    onclick="POS.clearCustomer()"
                    style="display:none;position:absolute;right:8px;top:50%;
                           transform:translateY(-50%);background:none;
                           border:none;cursor:pointer;color:#94a3b8;padding:0;"
                    onmouseover="this.style.color='#ef4444'"
                    onmouseout="this.style.color='#94a3b8'">
                <svg width="14" height="14" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Customer Dropdown --}}
        <div id="customerDropdown"
             class="customer-dropdown"
             style="display:none;">
        </div>

    </div>

    {{-- ── Cart Items ────────────────────────────────────────────── --}}
    <div id="cartItems"
         style="flex:1;overflow-y:auto;padding:8px 16px;min-height:0;
                scrollbar-width:thin;scrollbar-color:#e2e8f0 transparent;">

        {{-- Empty State --}}
        <div id="cartEmpty"
             style="display:flex;flex-direction:column;align-items:center;
                    justify-content:center;height:100%;
                    color:#cbd5e1;padding:24px 0;">
            <svg width="40" height="40" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24"
                 style="margin-bottom:8px;opacity:0.5;">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7
                         13l-2.293 2.293c-.63.63-.184 1.707.707
                         1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8
                         2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <p style="font-size:0.8rem;font-weight:600;margin:0;color:#94a3b8;">
                Cart is empty
            </p>
            <p style="font-size:0.72rem;margin:4px 0 0;color:#cbd5e1;">
                Click a product to add it
            </p>
        </div>

    </div>

    {{-- ── Totals & Actions ─────────────────────────────────────── --}}
    <div style="border-top:1px solid #f1f5f9;padding:12px 16px;
                flex-shrink:0;background:#fff;"
         class="dark:bg-gray-900 dark:border-gray-800">

        {{-- Subtotal --}}
        <div style="display:flex;justify-content:space-between;
                    font-size:0.78rem;margin-bottom:4px;">
            <span style="color:#94a3b8;">Subtotal</span>
            <span id="cartSubtotal"
                  style="color:#475569;font-weight:600;"
                  class="dark:text-gray-400">
                £0.00
            </span>
        </div>

        {{-- Discount Row (hidden until discount applied) --}}
        <div id="discountRow"
             style="display:none;justify-content:space-between;
                    font-size:0.78rem;margin-bottom:4px;align-items:center;">
            <span style="color:#94a3b8;">Discount</span>
            <div style="display:flex;align-items:center;gap:6px;">
                <span id="cartDiscountDisplay"
                      style="color:#ef4444;font-weight:700;">
                    -£0.00
                </span>
                <button onclick="POS.removeDiscount()"
                        title="Remove discount"
                        style="width:16px;height:16px;border-radius:50%;border:none;
                               background:#fee2e2;color:#ef4444;cursor:pointer;
                               display:flex;align-items:center;justify-content:center;
                               font-size:0.7rem;padding:0;line-height:1;">
                    ✕
                </button>
            </div>
        </div>

        {{-- Total --}}
        <div style="display:flex;justify-content:space-between;
                    padding-top:8px;border-top:1px solid #f1f5f9;
                    margin-bottom:10px;"
             class="dark:border-gray-800">
            <span style="font-weight:800;font-size:1rem;color:#1e293b;"
                  class="dark:text-white">
                Total
            </span>
            <span id="cartTotal"
                  style="font-weight:800;font-size:1.1rem;color:#10b981;">
                £0.00
            </span>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;gap:8px;">

            {{-- Discount Button --}}
            <button onclick="POS.openDiscountModal()"
                    id="discountBtn"
                    title="Add Discount"
                    style="width:40px;height:40px;border-radius:10px;
                           border:2px solid #e2e8f0;background:#fff;
                           cursor:pointer;display:flex;align-items:center;
                           justify-content:center;flex-shrink:0;
                           transition:all 0.15s;"
                    class="dark:bg-gray-800 dark:border-gray-700"
                    onmouseover="this.style.borderColor='#f59e0b';this.style.color='#f59e0b'"
                    onmouseout="this.style.borderColor='';this.style.color=''">
                <svg width="16" height="16" fill="none" stroke="#94a3b8"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M7 7h.01M17 17h.01M5 19L19 5"/>
                </svg>
            </button>

            {{-- Charge Button --}}
            <button onclick="POS.openPaymentModal()"
                    id="chargeBtn"
                    disabled
                    style="flex:1;height:40px;border-radius:10px;border:none;
                           background:#10b981;color:#fff;font-weight:800;
                           font-size:0.85rem;cursor:pointer;
                           transition:all 0.15s;display:flex;
                           align-items:center;justify-content:center;gap:6px;
                           disabled:background:#e2e8f0;">
                <svg width="16" height="16" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0
                             003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8
                             a3 3 0 003 3z"/>
                </svg>
                Charge
                <span id="chargeBtnTotal">£0.00</span>
            </button>

        </div>
    </div>
</div>