<x-app-layout>
<x-slot name="title">Point of Sale</x-slot>

<style>
/* ── Layout ─────────────────────────────── */
main { padding: 0 !important; }

#pos-wrapper {
    height: calc(100vh - 4rem);
    display: flex;
    overflow: hidden;
    background: #f8fafc;
}
.dark #pos-wrapper { background: #0f172a; }

#pos-left {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #e2e8f0;
    background: #f8fafc;
}
.dark #pos-left {
    border-color: #1e293b;
    background: #0f172a;
}

#pos-right {
    width: 320px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    background: #fff;
}
.dark #pos-right { background: #111827; }

@media (max-width: 768px) {
    #pos-wrapper  { flex-direction: column; height: auto; }
    #pos-right    { width: 100%; height: 460px;
                    border-top: 1px solid #e2e8f0; }
}

/* ── Cards ───────────────────────────────── */
.pos-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.15s ease;
    aspect-ratio: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
}
.dark .pos-card {
    background: #1e293b;
    border-color: #334155;
}
.pos-card:hover {
    border-color: #6366f1;
    box-shadow: 0 4px 16px rgba(99,102,241,0.15);
    transform: translateY(-2px);
}
.pos-card.out-of-stock {
    opacity: 0.5;
    cursor: default;
}
.pos-card.out-of-stock:hover {
    transform: none;
    border-color: #e2e8f0;
    box-shadow: none;
}
.pos-card.in-cart {
    border-color: #6366f1;
    background: #eef2ff;
}
.dark .pos-card.in-cart {
    background: #1e1b4b;
    border-color: #818cf8;
}

/* ── Customer Search ─────────────────────── */
.customer-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0; right: 0;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    z-index: 100;
    max-height: 200px;
    overflow-y: auto;
}
.dark .customer-dropdown {
    background: #1e293b;
    border-color: #334155;
}
.customer-option {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: background 0.1s;
}
.customer-option:hover { background: #f1f5f9; }
.dark .customer-option:hover { background: #334155; }

/* ── Payment Modal ───────────────────────── */
.method-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    padding: 12px 8px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.15s;
    background: #fff;
    color: #64748b;
    font-size: 0.75rem;
    font-weight: 700;
}
.dark .method-btn {
    background: #1e293b;
    border-color: #334155;
    color: #94a3b8;
}
.method-btn.active {
    border-color: #10b981;
    background: #ecfdf5;
    color: #10b981;
}
.dark .method-btn.active {
    background: #064e3b;
    border-color: #34d399;
    color: #34d399;
}
.method-btn svg { width: 22px; height: 22px; }
</style>

<div id="pos-wrapper">

    {{-- ================================================ --}}
    {{-- LEFT                                            --}}
    {{-- ================================================ --}}
    <div id="pos-left">

        {{-- Top Bar --}}
        <div style="background:#fff;border-bottom:1px solid #e2e8f0;
                    padding:10px 16px;display:flex;align-items:center;
                    gap:10px;flex-shrink:0;">

            <button id="btnBack" onclick="goBack()"
                    style="display:none;width:32px;height:32px;border-radius:8px;
                           background:#f1f5f9;border:none;cursor:pointer;
                           align-items:center;justify-content:center;flex-shrink:0;">
                <svg width="16" height="16" fill="none" stroke="#475569"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <div id="breadcrumb"
                 style="flex:1;display:flex;align-items:center;gap:6px;
                        font-size:0.8rem;overflow:hidden;">
                <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                      onclick="goHome()">All</span>
            </div>

            <div style="position:relative;flex-shrink:0;">
                <input type="text" id="searchProduct"
                       placeholder="Search products..."
                       oninput="handleSearch(this.value)"
                       style="width:200px;padding:7px 32px 7px 30px;
                              border:1.5px solid #e2e8f0;border-radius:10px;
                              font-size:0.8rem;outline:none;background:#f8fafc;
                              color:#1e293b;transition:border 0.15s;">
                <svg style="position:absolute;left:8px;top:50%;transform:translateY(-50%);
                            pointer-events:none;"
                     width="14" height="14" fill="none" stroke="#94a3b8"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <button onclick="clearSearch()"
                        id="clearSearchBtn"
                        style="display:none;position:absolute;right:7px;top:50%;
                               transform:translateY(-50%);background:none;border:none;
                               cursor:pointer;color:#94a3b8;padding:0;line-height:1;">
                    <svg width="14" height="14" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Grid --}}
        <div style="flex:1;overflow-y:auto;padding:12px;">

            <div id="gridLoading" style="display:none;">
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:8px;">
                    @for($i=0;$i<12;$i++)
                    <div style="aspect-ratio:1;background:#fff;border-radius:14px;
                                border:1.5px solid #e2e8f0;padding:12px;
                                animation:pulse 1.5s infinite;">
                    </div>
                    @endfor
                </div>
            </div>

            <div id="gridEmpty"
                 style="display:none;flex-direction:column;align-items:center;
                        justify-content:center;height:200px;color:#94a3b8;">
                <svg width="48" height="48" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" style="opacity:0.4;margin-bottom:8px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.5"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p style="font-size:0.85rem;font-weight:500;">Nothing found</p>
            </div>

            <div id="mainGrid"
                 style="display:grid;grid-template-columns:repeat(auto-fill,minmax(100px,1fr));gap:8px;">
            </div>
        </div>
    </div>

    {{-- ================================================ --}}
    {{-- RIGHT — Cart                                     --}}
    {{-- ================================================ --}}
    <div id="pos-right">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;
                    padding:12px 16px;border-bottom:1px solid #f1f5f9;flex-shrink:0;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-weight:800;font-size:0.9rem;color:#1e293b;">
                    Your Order
                </span>
                <span id="cartBadge"
                      style="display:none;width:20px;height:20px;border-radius:50%;
                             background:#6366f1;color:#fff;font-size:0.7rem;
                             font-weight:800;align-items:center;justify-content:center;">
                    0
                </span>
            </div>
            <div style="display:flex;gap:6px;">
                <button onclick="openCustomModal()"
                        style="font-size:0.7rem;padding:4px 10px;border-radius:8px;
                               border:1.5px solid #e2e8f0;background:#fff;
                               color:#475569;cursor:pointer;font-weight:600;
                               transition:all 0.15s;">
                    + Custom
                </button>
                <button onclick="clearCart()"
                        style="font-size:0.7rem;padding:4px 10px;border-radius:8px;
                               border:1.5px solid #fee2e2;background:#fff;
                               color:#ef4444;cursor:pointer;font-weight:600;
                               transition:all 0.15s;">
                    Clear
                </button>
            </div>
        </div>

        {{-- Customer Searchable --}}
        <div style="padding:10px 16px;border-bottom:1px solid #f1f5f9;
                    flex-shrink:0;position:relative;">
            <div style="position:relative;">
                <input type="text" id="customerSearch"
                       placeholder="Search customer..."
                       autocomplete="off"
                       oninput="filterCustomers(this.value)"
                       onfocus="showCustomerDropdown()"
                       style="width:100%;padding:8px 32px 8px 10px;
                              border:1.5px solid #e2e8f0;border-radius:10px;
                              font-size:0.8rem;outline:none;background:#f8fafc;
                              color:#1e293b;box-sizing:border-box;transition:border 0.15s;">
                <button onclick="clearCustomer()"
                        id="clearCustomerBtn"
                        style="display:none;position:absolute;right:8px;top:50%;
                               transform:translateY(-50%);background:none;border:none;
                               cursor:pointer;color:#94a3b8;padding:0;">
                    <svg width="14" height="14" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div id="customerDropdown" class="customer-dropdown" style="display:none;">
            </div>
        </div>

        {{-- Cart Items --}}
        <div id="cartItems"
             style="flex:1;overflow-y:auto;padding:8px 16px;min-height:0;">
            <div id="cartEmpty"
                 style="display:flex;flex-direction:column;align-items:center;
                        justify-content:center;height:100%;color:#cbd5e1;padding:20px 0;">
                <svg width="40" height="40" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24" style="margin-bottom:8px;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.5"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7
                             13l-2.293 2.293c-.63.63-.184 1.707.707
                             1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8
                             2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p style="font-size:0.8rem;font-weight:500;">Cart is empty</p>
            </div>
        </div>

        {{-- Totals --}}
        <div style="border-top:1px solid #f1f5f9;padding:12px 16px;
                    flex-shrink:0;background:#fff;">

            <div style="display:flex;justify-content:space-between;
                        font-size:0.78rem;margin-bottom:4px;">
                <span style="color:#94a3b8;">Subtotal</span>
                <span id="cartSubtotal" style="color:#475569;font-weight:600;">£0.00</span>
            </div>

            <div id="discountRow"
                 style="display:none;justify-content:space-between;
                        font-size:0.78rem;margin-bottom:4px;">
                <span style="color:#94a3b8;">Discount</span>
                <span id="cartDiscountDisplay"
                      style="color:#ef4444;font-weight:600;">-£0.00</span>
            </div>

            <div style="display:flex;justify-content:space-between;
                        padding-top:8px;border-top:1px solid #f1f5f9;margin-bottom:10px;">
                <span style="font-weight:800;font-size:1rem;color:#1e293b;">Total</span>
                <span id="cartTotal"
                      style="font-weight:800;font-size:1.1rem;color:#10b981;">£0.00</span>
            </div>

            <div style="display:flex;gap:8px;">
                <button onclick="openDiscountModal()"
                        title="Discount"
                        style="width:40px;height:40px;border-radius:10px;
                               border:2px solid #e2e8f0;background:#fff;
                               cursor:pointer;display:flex;align-items:center;
                               justify-content:center;flex-shrink:0;transition:all 0.15s;"
                        onmouseover="this.style.borderColor='#f59e0b';this.style.color='#f59e0b'"
                        onmouseout="this.style.borderColor='#e2e8f0';this.style.color='#94a3b8'">
                    <svg width="16" height="16" fill="none" stroke="#94a3b8"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M7 7h.01M17 17h.01M5 19L19 5"/>
                    </svg>
                </button>

                <button onclick="openPaymentModal()" id="chargeBtn" disabled
                        style="flex:1;height:40px;border-radius:10px;border:none;
                               background:#10b981;color:#fff;font-weight:800;
                               font-size:0.85rem;cursor:pointer;transition:all 0.15s;
                               display:flex;align-items:center;justify-content:center;gap:6px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0
                                 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8
                                 a3 3 0 003 3z"/>
                    </svg>
                    Charge <span id="chargeBtnTotal">£0.00</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================================================ --}}
{{-- CUSTOM MODAL                                    --}}
{{-- ================================================ --}}
<div id="customModal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.7);align-items:center;justify-content:center;
            padding:16px;">
    <div id="customModalBox"
         style="background:#fff;border-radius:20px;padding:24px;width:100%;
                max-width:380px;box-shadow:0 24px 48px rgba(0,0,0,0.2);
                transition:all 0.2s;transform:scale(0.95);opacity:0;">

        <div style="display:flex;justify-content:space-between;
                    align-items:center;margin-bottom:20px;">
            <h3 style="font-weight:800;font-size:1rem;color:#1e293b;">Custom Item</h3>
            <button onclick="closeCustomModal()"
                    style="width:28px;height:28px;border-radius:8px;border:none;
                           background:#f1f5f9;cursor:pointer;display:flex;
                           align-items:center;justify-content:center;">
                <svg width="14" height="14" fill="none" stroke="#475569" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px;">
            <div>
                <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.05em;
                               display:block;margin-bottom:6px;">
                    Item Name *
                </label>
                <input type="text" id="customName" placeholder="e.g. Screen Repair"
                       style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;
                              border-radius:10px;font-size:0.85rem;outline:none;
                              box-sizing:border-box;background:#f8fafc;color:#1e293b;">
            </div>
            <div>
                <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.05em;
                               display:block;margin-bottom:6px;">
                    Price *
                </label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;
                                 transform:translateY(-50%);color:#94a3b8;
                                 font-weight:700;">£</span>
                    <input type="number" id="customPrice" min="0" step="0.01"
                           placeholder="0.00"
                           style="width:100%;padding:10px 12px 10px 24px;
                                  border:1.5px solid #e2e8f0;border-radius:10px;
                                  font-size:0.85rem;outline:none;box-sizing:border-box;
                                  background:#f8fafc;color:#1e293b;">
                </div>
            </div>
            <div>
                <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.05em;
                               display:block;margin-bottom:6px;">
                    Quantity
                </label>
                <input type="number" id="customQty" min="1" value="1"
                       style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;
                              border-radius:10px;font-size:0.85rem;outline:none;
                              box-sizing:border-box;background:#f8fafc;color:#1e293b;">
            </div>
        </div>

        <div style="display:flex;gap:10px;margin-top:20px;">
            <button onclick="closeCustomModal()"
                    style="flex:1;padding:11px;border-radius:10px;
                           border:1.5px solid #e2e8f0;background:#fff;
                           color:#475569;font-weight:700;cursor:pointer;font-size:0.85rem;">
                Cancel
            </button>
            <button onclick="addCustomItem()"
                    style="flex:1;padding:11px;border-radius:10px;border:none;
                           background:#6366f1;color:#fff;font-weight:700;
                           cursor:pointer;font-size:0.85rem;">
                Add to Cart
            </button>
        </div>
    </div>
</div>

{{-- ================================================ --}}
{{-- DISCOUNT MODAL                                  --}}
{{-- ================================================ --}}
<div id="discountModal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.7);align-items:center;justify-content:center;
            padding:16px;">
    <div id="discountModalBox"
         style="background:#fff;border-radius:20px;padding:24px;width:100%;
                max-width:360px;box-shadow:0 24px 48px rgba(0,0,0,0.2);
                transition:all 0.2s;transform:scale(0.95);opacity:0;">

        <div style="display:flex;justify-content:space-between;
                    align-items:center;margin-bottom:20px;">
            <h3 style="font-weight:800;font-size:1rem;color:#1e293b;">Add Discount</h3>
            <button onclick="closeDiscountModal()"
                    style="width:28px;height:28px;border-radius:8px;border:none;
                           background:#f1f5f9;cursor:pointer;display:flex;
                           align-items:center;justify-content:center;">
                <svg width="14" height="14" fill="none" stroke="#475569" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;border-radius:10px;
                    overflow:hidden;border:1.5px solid #e2e8f0;margin-bottom:16px;">
            <button id="discTypFixed" onclick="setDiscountType('fixed')"
                    style="padding:10px;font-size:0.85rem;font-weight:700;border:none;
                           background:#6366f1;color:#fff;cursor:pointer;transition:all 0.15s;">
                £ Fixed
            </button>
            <button id="discTypPercent" onclick="setDiscountType('percent')"
                    style="padding:10px;font-size:0.85rem;font-weight:700;border:none;
                           background:#fff;color:#94a3b8;cursor:pointer;transition:all 0.15s;">
                % Percent
            </button>
        </div>

        <div style="position:relative;margin-bottom:16px;">
            <span id="discountSymbol"
                  style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                         color:#94a3b8;font-weight:700;font-size:1.1rem;">£</span>
            <input type="number" id="discountInput" min="0" step="0.01" placeholder="0.00"
                   style="width:100%;padding:12px 12px 12px 28px;border:1.5px solid #e2e8f0;
                          border-radius:10px;font-size:1.3rem;font-weight:800;outline:none;
                          box-sizing:border-box;background:#f8fafc;color:#1e293b;">
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:20px;">
            @foreach([5,10,15,20] as $pct)
            <button onclick="setQuickDiscount({{ $pct }})"
                    style="padding:10px;border-radius:10px;border:1.5px solid #e2e8f0;
                           background:#f8fafc;color:#475569;font-weight:700;
                           font-size:0.85rem;cursor:pointer;transition:all 0.15s;"
                    onmouseover="this.style.background='#eef2ff';this.style.color='#6366f1';this.style.borderColor='#6366f1'"
                    onmouseout="this.style.background='#f8fafc';this.style.color='#475569';this.style.borderColor='#e2e8f0'">
                {{ $pct }}%
            </button>
            @endforeach
        </div>

        <div style="display:flex;gap:10px;">
            <button onclick="closeDiscountModal()"
                    style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;
                           background:#fff;color:#475569;font-weight:700;cursor:pointer;">
                Cancel
            </button>
            <button onclick="applyDiscount()"
                    style="flex:1;padding:11px;border-radius:10px;border:none;
                           background:#6366f1;color:#fff;font-weight:700;cursor:pointer;">
                Apply
            </button>
        </div>
    </div>
</div>

{{-- ================================================ --}}
{{-- PAYMENT MODAL                                   --}}
{{-- ================================================ --}}
<div id="paymentModal"
     style="display:none;position:fixed;inset:0;z-index:50;
            background:rgba(15,23,42,0.7);align-items:center;justify-content:center;
            padding:16px;">
    <div id="paymentModalBox"
         style="background:#fff;border-radius:20px;width:100%;max-width:440px;
                box-shadow:0 24px 48px rgba(0,0,0,0.2);
                transition:all 0.2s;transform:scale(0.95);opacity:0;
                max-height:90vh;overflow-y:auto;">

        {{-- Header --}}
        <div style="display:flex;justify-content:space-between;align-items:center;
                    padding:20px 24px 16px;border-bottom:1px solid #f1f5f9;
                    position:sticky;top:0;background:#fff;z-index:10;">
            <h3 style="font-weight:800;font-size:1.1rem;color:#1e293b;">Payment</h3>
            <button onclick="closePaymentModal()"
                    style="width:32px;height:32px;border-radius:10px;border:none;
                           background:#f1f5f9;cursor:pointer;display:flex;
                           align-items:center;justify-content:center;">
                <svg width="16" height="16" fill="none" stroke="#475569"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div style="padding:20px 24px;display:flex;flex-direction:column;gap:20px;">

            {{-- Total Due --}}
            <div style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);
                        border-radius:16px;padding:20px;text-align:center;">
                <p style="font-size:0.7rem;font-weight:700;color:#059669;
                           text-transform:uppercase;letter-spacing:0.1em;margin-bottom:6px;">
                    Total Due
                </p>
                <p id="modalTotalDisplay"
                   style="font-size:2.8rem;font-weight:900;color:#059669;
                          font-family:'Georgia',serif;letter-spacing:-0.02em;">
                    £0.00
                </p>
            </div>

            {{-- Payment Methods --}}
            <div>
                <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                           text-transform:uppercase;letter-spacing:0.05em;margin-bottom:10px;">
                    Payment Method
                </p>
                <div style="display:flex;gap:8px;">
                    <button class="method-btn active" id="method-cash"
                            onclick="selectMethod('cash')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Cash
                    </button>
                    <button class="method-btn" id="method-card"
                            onclick="selectMethod('card')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Card
                    </button>
                    <button class="method-btn" id="method-split"
                            onclick="selectMethod('split')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Split
                    </button>
                    <button class="method-btn" id="method-trade"
                            onclick="selectMethod('trade')">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Trade
                    </button>
                </div>
            </div>

            {{-- CASH fields --}}
            <div id="fields-cash">
                <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                           text-transform:uppercase;letter-spacing:0.05em;margin-bottom:8px;">
                    Cash £
                </p>
                <div style="display:grid;grid-template-columns:repeat(5,1fr);
                            gap:6px;margin-bottom:8px;">
                    @foreach([5,10,20,50] as $a)
                    <button onclick="setQuickAmount({{ $a }})"
                            style="padding:9px 4px;border-radius:8px;font-size:0.78rem;
                                   font-weight:700;border:1.5px solid #e2e8f0;
                                   background:#f8fafc;color:#475569;cursor:pointer;
                                   transition:all 0.15s;"
                            onmouseover="this.style.background='#ecfdf5';this.style.color='#10b981';this.style.borderColor='#10b981'"
                            onmouseout="this.style.background='#f8fafc';this.style.color='#475569';this.style.borderColor='#e2e8f0'">
                        £{{ $a }}
                    </button>
                    @endforeach
                    <button onclick="setExactAmount()"
                            style="padding:9px 4px;border-radius:8px;font-size:0.7rem;
                                   font-weight:700;border:1.5px solid #e2e8f0;
                                   background:#f8fafc;color:#475569;cursor:pointer;
                                   transition:all 0.15s;"
                            onmouseover="this.style.background='#ecfdf5';this.style.color='#10b981';this.style.borderColor='#10b981'"
                            onmouseout="this.style.background='#f8fafc';this.style.color='#475569';this.style.borderColor='#e2e8f0'">
                        Exact
                    </button>
                </div>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);
                                 color:#94a3b8;font-weight:700;">£</span>
                    <input type="number" id="cashInput" min="0" step="0.01" placeholder="0"
                           oninput="updateChange()"
                           style="width:100%;padding:12px 12px 12px 28px;
                                  border:1.5px solid #e2e8f0;border-radius:10px;
                                  font-size:1.4rem;font-weight:800;outline:none;
                                  box-sizing:border-box;background:#f8fafc;color:#1e293b;">
                </div>
                <div id="changeDisplay"
                     style="display:none;margin-top:10px;padding:10px 14px;
                            border-radius:10px;background:#ecfdf5;
                            border:1.5px solid #a7f3d0;
                            justify-content:space-between;align-items:center;">
                    <span style="font-size:0.85rem;font-weight:700;color:#059669;">Change</span>
                    <span id="changeAmount"
                          style="font-size:1.1rem;font-weight:900;color:#059669;">
                        £0.00
                    </span>
                </div>
            </div>

            {{-- CARD fields --}}
            <div id="fields-card" style="display:none;text-align:center;padding:10px 0;">
                <div style="width:60px;height:60px;border-radius:16px;
                            background:linear-gradient(135deg,#fbbf24,#f59e0b);
                            margin:0 auto 12px;display:flex;align-items:center;
                            justify-content:center;box-shadow:0 4px 12px rgba(245,158,11,0.3);">
                    <svg width="32" height="32" fill="none" stroke="#fff"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <p style="font-size:0.9rem;font-weight:600;color:#64748b;">
                    Present card to terminal
                </p>
            </div>

            {{-- SPLIT fields --}}
            <div id="fields-split" style="display:none;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div>
                        <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                                       text-transform:uppercase;letter-spacing:0.05em;
                                       display:block;margin-bottom:6px;">
                            Cash £
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;
                                         transform:translateY(-50%);color:#94a3b8;
                                         font-weight:700;">£</span>
                            <input type="number" id="splitCash" min="0" step="0.01"
                                   placeholder="0" oninput="updateSplitCard()"
                                   style="width:100%;padding:10px 10px 10px 22px;
                                          border:1.5px solid #e2e8f0;border-radius:10px;
                                          font-size:1rem;font-weight:700;outline:none;
                                          box-sizing:border-box;background:#f8fafc;
                                          color:#1e293b;">
                        </div>
                    </div>
                    <div>
                        <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                                       text-transform:uppercase;letter-spacing:0.05em;
                                       display:block;margin-bottom:6px;">
                            Card £
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute;left:10px;top:50%;
                                         transform:translateY(-50%);color:#94a3b8;
                                         font-weight:700;">£</span>
                            <input type="number" id="splitCard" min="0" step="0.01"
                                   placeholder="0" readonly
                                   style="width:100%;padding:10px 10px 10px 22px;
                                          border:1.5px solid #e2e8f0;border-radius:10px;
                                          font-size:1rem;font-weight:700;outline:none;
                                          box-sizing:border-box;background:#f1f5f9;
                                          color:#475569;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- TRADE fields --}}
            <div id="fields-trade" style="display:none;">
                <div style="background:#fef3c7;border-radius:12px;
                            padding:14px;border:1.5px solid #fde68a;margin-bottom:12px;">
                    <p style="font-size:0.78rem;font-weight:600;color:#92400e;margin:0;">
                        🔄 Customer is trading in a device as full or partial payment.
                    </p>
                </div>
                <div>
                    <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                                   text-transform:uppercase;letter-spacing:0.05em;
                                   display:block;margin-bottom:6px;">
                        Trade-in Value £
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;
                                     transform:translateY(-50%);color:#94a3b8;
                                     font-weight:700;">£</span>
                        <input type="number" id="tradeValue" min="0" step="0.01"
                               placeholder="0.00"
                               style="width:100%;padding:11px 12px 11px 28px;
                                      border:1.5px solid #e2e8f0;border-radius:10px;
                                      font-size:1rem;font-weight:700;outline:none;
                                      box-sizing:border-box;background:#f8fafc;color:#1e293b;">
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                                   text-transform:uppercase;letter-spacing:0.05em;
                                   display:block;margin-bottom:6px;">
                        Device Description
                    </label>
                    <input type="text" id="tradeDevice" placeholder="e.g. iPhone 12 64GB"
                           style="width:100%;padding:11px 12px;border:1.5px solid #e2e8f0;
                                  border-radius:10px;font-size:0.85rem;outline:none;
                                  box-sizing:border-box;background:#f8fafc;color:#1e293b;">
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label style="font-size:0.7rem;font-weight:700;color:#94a3b8;
                               text-transform:uppercase;letter-spacing:0.05em;
                               display:block;margin-bottom:6px;">
                    Notes (optional)
                </label>
                <input type="text" id="paymentNotes"
                       placeholder="e.g. customer ref..."
                       style="width:100%;padding:10px 12px;border:1.5px solid #e2e8f0;
                              border-radius:10px;font-size:0.85rem;outline:none;
                              box-sizing:border-box;background:#f8fafc;color:#1e293b;">
            </div>

        </div>

        {{-- Complete --}}
        <div style="padding:0 24px 24px;">
            <button onclick="completeSale()" id="completeSaleBtn"
                    style="width:100%;padding:14px;border-radius:12px;border:none;
                           background:#10b981;color:#fff;font-weight:800;font-size:0.95rem;
                           cursor:pointer;transition:all 0.15s;display:flex;
                           align-items:center;justify-content:center;gap:8px;">
                <svg width="18" height="18" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                Complete Sale
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ================================================
// STATE
// ================================================
let cart            = [];
let allProducts     = [];
let allCustomers    = [];
let selectedCustomer = null;
let discountAmount  = 0;
let discountType    = 'fixed';
let selectedMethod  = 'cash';
let navState        = null;

const ROUTES = {
    categories : '{{ route("categories.search") }}',
    brands     : '{{ route("brands.filter") }}',
    products   : '{{ route("products.search") }}',
    store      : '{{ route("sales.store") }}',
    customers  : '{{ route("customers.search") }}',
};
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ================================================
// INIT
// ================================================
document.addEventListener('DOMContentLoaded', () => {
    loadCategoriesFromDB();
    loadCustomersFromDB();

    // Close customer dropdown on outside click
    document.addEventListener('click', e => {
        if (!e.target.closest('#cartCustomer-wrap')) {
            document.getElementById('customerDropdown').style.display = 'none';
        }
    });
});

// ================================================
// LOAD CATEGORIES FROM DB
// ================================================
async function loadCategoriesFromDB() {
    showLoading(true);
    try {
        const res  = await fetch(ROUTES.categories, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const cats = await res.json();
        renderCategories(cats);
    } catch(e) {
        console.error('Failed to load categories', e);
    } finally {
        showLoading(false);
    }
}

// ================================================
// NAVIGATION
// ================================================
function goHome() {
    navState = null;
    updateBreadcrumb();
    loadCategoriesFromDB();
    document.getElementById('searchProduct').value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
}

function goBack() {
    if (!navState) return;
    if (navState.type === 'brand') {
        navState = { type:'category', id:navState.categoryId, name:navState.categoryName };
        updateBreadcrumb();
        loadBrandsFromDB(navState.id);
    } else {
        goHome();
    }
}

async function selectCategory(categoryId, categoryName) {
    navState = { type:'category', id:categoryId, name:categoryName };
    updateBreadcrumb();
    await loadBrandsFromDB(categoryId);
}

async function selectBrand(brandId, brandName) {
    navState = {
        type        : 'brand',
        categoryId  : navState.id,
        categoryName: navState.name,
        brandId     : brandId,
        name        : brandName,
    };
    updateBreadcrumb();
    await loadProductsFiltered(navState.categoryId, brandId);
}

function updateBreadcrumb() {
    const bc      = document.getElementById('breadcrumb');
    const backBtn = document.getElementById('btnBack');
    const sep     = `<svg width="12" height="12" fill="none" stroke="#cbd5e1"
                         viewBox="0 0 24 24" style="flex-shrink:0;">
                         <path stroke-linecap="round" stroke-linejoin="round"
                               stroke-width="2" d="M9 5l7 7-7 7"/>
                     </svg>`;

    if (!navState) {
        bc.innerHTML = `<span style="color:#6366f1;font-weight:700;cursor:pointer;"
                              onclick="goHome()">All</span>`;
        backBtn.style.display = 'none';
        return;
    }

    backBtn.style.display = 'flex';

    if (navState.type === 'category') {
        bc.innerHTML = `
            <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                  onclick="goHome()">All</span>
            ${sep}
            <span style="color:#475569;font-weight:700;">${escHtml(navState.name)}</span>`;
    } else {
        bc.innerHTML = `
            <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                  onclick="goHome()">All</span>
            ${sep}
            <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                  onclick="selectCategory(${navState.categoryId},'${navState.categoryName}')">
                ${escHtml(navState.categoryName)}
            </span>
            ${sep}
            <span style="color:#475569;font-weight:700;">${escHtml(navState.name)}</span>`;
    }
}

// ================================================
// RENDER CATEGORIES
// ================================================
const CAT_ICONS = {
    'screen-protectors' : '🛡️',
    'phone-cases'       : '📱',
    'cables-chargers'   : '🔌',
    'repair-parts'      : '🔧',
    'accessories'       : '🎧',
    'second-hand-phones': '♻️',
};

function renderCategories(cats) {
    const grid  = document.getElementById('mainGrid');
    const empty = document.getElementById('gridEmpty');
    grid.innerHTML = '';

    if (!cats || cats.length === 0) {
        empty.style.display = 'flex';
        return;
    }
    empty.style.display = 'none';
    grid.style.display  = 'grid';

    cats.forEach(cat => {
        const icon = CAT_ICONS[cat.slug] || '📦';
        const div  = document.createElement('div');
        div.className = 'pos-card';
        div.onclick   = () => selectCategory(cat.id, cat.name);
        div.innerHTML = `
            <span style="font-size:1.8rem;line-height:1;">${icon}</span>
            <span style="font-size:0.72rem;font-weight:700;color:#475569;
                         text-align:center;line-height:1.3;
                         display:-webkit-box;-webkit-line-clamp:2;
                         -webkit-box-orient:vertical;overflow:hidden;">
                ${escHtml(cat.name)}
            </span>`;
        grid.appendChild(div);
    });
}

// ================================================
// LOAD & RENDER BRANDS
// ================================================
const BRAND_COLORS = {
    'apple'   : { bg:'#f1f5f9', text:'#1e293b' },
    'samsung' : { bg:'#eff6ff', text:'#1d4ed8' },
    'google'  : { bg:'#fef9c3', text:'#713f12' },
    'oneplus' : { bg:'#fff1f2', text:'#be123c' },
    'xiaomi'  : { bg:'#fff7ed', text:'#9a3412' },
    'generic' : { bg:'#f8fafc', text:'#475569' },
};

async function loadBrandsFromDB(categoryId) {
    showLoading(true);
    try {
        const res    = await fetch(
            `${ROUTES.brands}?category_id=${categoryId}`,
            { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
        );
        const brands = await res.json();

        // If no brands — go straight to products
        if (!brands || brands.length === 0) {
            await loadProductsFiltered(categoryId, null);
            return;
        }

        renderBrands(brands);
    } catch(e) {
        console.error(e);
    } finally {
        showLoading(false);
    }
}

function renderBrands(brands) {
    const grid  = document.getElementById('mainGrid');
    const empty = document.getElementById('gridEmpty');
    grid.innerHTML = '';
    empty.style.display = 'none';
    grid.style.display  = 'grid';

    brands.forEach(brand => {
        const colors = BRAND_COLORS[brand.slug] || BRAND_COLORS['generic'];
        const div    = document.createElement('div');
        div.className  = 'pos-card';
        div.style.background = colors.bg;
        div.onclick    = () => selectBrand(brand.id, brand.name);
        div.innerHTML  = `
            <div style="width:40px;height:40px;border-radius:12px;
                        background:#fff;display:flex;align-items:center;
                        justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.08);
                        border:1px solid rgba(0,0,0,0.06);">
                <span style="font-size:0.75rem;font-weight:900;color:${colors.text};">
                    ${escHtml(brand.name.substring(0,2).toUpperCase())}
                </span>
            </div>
            <span style="font-size:0.72rem;font-weight:700;color:${colors.text};
                         text-align:center;">
                ${escHtml(brand.name)}
            </span>`;
        grid.appendChild(div);
    });
}

// ================================================
// LOAD & RENDER PRODUCTS
// ================================================
async function loadProductsFiltered(categoryId, brandId) {
    showLoading(true);
    try {
        const params = new URLSearchParams();
        if (categoryId) params.set('category_id', categoryId);
        if (brandId)    params.set('brand_id',    brandId);

        const res   = await fetch(`${ROUTES.products}?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        allProducts = await res.json();
        renderProducts(allProducts);
    } catch(e) {
        console.error(e);
    } finally {
        showLoading(false);
    }
}

function renderProducts(products) {
    const grid  = document.getElementById('mainGrid');
    const empty = document.getElementById('gridEmpty');
    grid.innerHTML = '';

    if (!products || products.length === 0) {
        empty.style.display = 'flex';
        grid.style.display  = 'none';
        return;
    }
    empty.style.display = 'none';
    grid.style.display  = 'grid';

    products.forEach(p => grid.appendChild(createProductCard(p)));
}

function createProductCard(product) {
    const inCart   = cart.find(i => i.id === product.id && !i.isCustom);
    const cartQty  = inCart ? inCart.quantity : 0;
    const available = product.stock - cartQty;
    const isOOS    = available <= 0;
    const isLow    = !isOOS && available <= (product.low_stock_alert || 5);

    const div     = document.createElement('div');
    div.id        = `product-card-${product.id}`;
    div.className = `pos-card${cartQty > 0 ? ' in-cart' : ''}`;

    // Allow adding even if out of stock
    div.onclick = () => addToCart(product.id);

    div.innerHTML = `
        <div style="position:relative;width:100%;">
            ${cartQty > 0
                ? `<div id="cart-qty-badge-${product.id}"
                        style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;
                               border-radius:50%;background:#6366f1;color:#fff;
                               font-size:0.65rem;font-weight:900;display:flex;
                               align-items:center;justify-content:center;
                               box-shadow:0 2px 6px rgba(99,102,241,0.4);">
                       ${cartQty}
                   </div>`
                : `<div id="cart-qty-badge-${product.id}"
                        style="display:none;position:absolute;top:-6px;right:-6px;
                               width:20px;height:20px;border-radius:50%;
                               background:#6366f1;color:#fff;font-size:0.65rem;
                               font-weight:900;align-items:center;
                               justify-content:center;
                               box-shadow:0 2px 6px rgba(99,102,241,0.4);">
                       0
                   </div>`}
            <div style="width:36px;height:36px;border-radius:10px;
                        background:${cartQty > 0 ? '#c7d2fe' : '#eef2ff'};
                        display:flex;align-items:center;justify-content:center;
                        margin:0 auto;">
                <svg width="18" height="18" fill="none" stroke="#6366f1"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                             00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <p style="font-size:0.68rem;font-weight:700;color:#1e293b;text-align:center;
                  line-height:1.3;display:-webkit-box;-webkit-line-clamp:2;
                  -webkit-box-orient:vertical;overflow:hidden;width:100%;">
            ${escHtml(product.name)}
        </p>
        <p style="font-size:0.8rem;font-weight:900;color:#6366f1;text-align:center;">
            ${escHtml(product.formatted_price)}
        </p>
        <p id="stock-label-${product.id}"
           style="font-size:0.62rem;font-weight:600;text-align:center;
                  color:${isOOS ? '#ef4444' : isLow ? '#f59e0b' : '#94a3b8'};">
            ${isOOS ? '⚠ out of stock' : `${available} in stock`}
        </p>`;

    return div;
}

// ================================================
// SEARCH
// ================================================
let searchTimer;
function handleSearch(value) {
    const clearBtn = document.getElementById('clearSearchBtn');
    clearBtn.style.display = value ? 'block' : 'none';

    clearTimeout(searchTimer);
    searchTimer = setTimeout(async () => {
        if (!value.trim()) {
            if (!navState)                       loadCategoriesFromDB();
            else if (navState.type==='category') loadBrandsFromDB(navState.id);
            else                                 renderProducts(allProducts);
            return;
        }
        showLoading(true);
        try {
            const params = new URLSearchParams({ search: value });
            if (navState?.type === 'category') params.set('category_id', navState.id);
            if (navState?.type === 'brand') {
                params.set('category_id', navState.categoryId);
                params.set('brand_id',    navState.brandId);
            }
            const res   = await fetch(`${ROUTES.products}?${params}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const prods = await res.json();
            allProducts = prods;
            renderProducts(prods);
        } catch(e) { console.error(e); }
        finally    { showLoading(false); }
    }, 350);
}

function clearSearch() {
    const input = document.getElementById('searchProduct');
    input.value = '';
    document.getElementById('clearSearchBtn').style.display = 'none';
    if (!navState)                       loadCategoriesFromDB();
    else if (navState.type==='category') loadBrandsFromDB(navState.id);
    else                                 renderProducts(allProducts);
}

// ================================================
// CUSTOMER SEARCH
// ================================================
async function loadCustomersFromDB() {
    try {
        const res  = await fetch(ROUTES.customers, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        allCustomers = await res.json();
    } catch(e) { console.error(e); }
}

function showCustomerDropdown() {
    filterCustomers(document.getElementById('customerSearch').value);
}

function filterCustomers(value) {
    const dropdown = document.getElementById('customerDropdown');
    const term     = value.toLowerCase().trim();

    const filtered = term
        ? allCustomers.filter(c =>
            c.name.toLowerCase().includes(term) ||
            (c.phone && c.phone.includes(term))  ||
            (c.email && c.email.toLowerCase().includes(term))
          )
        : allCustomers;

    if (filtered.length === 0 && !term) {
        dropdown.style.display = 'none';
        return;
    }

    dropdown.innerHTML = '';

    if (filtered.length === 0) {
        dropdown.innerHTML = `<div class="customer-option" style="color:#94a3b8;">
            No customers found</div>`;
        dropdown.style.display = 'block';
        return;
    }

    // Walk-in option
    const walkIn = document.createElement('div');
    walkIn.className = 'customer-option';
    walkIn.style.cssText = 'border-bottom:1px solid #f1f5f9;color:#94a3b8;';
    walkIn.innerHTML     = '<em>Walk-in Customer</em>';
    walkIn.onclick       = () => {
        selectedCustomer = null;
        document.getElementById('customerSearch').value = '';
        document.getElementById('clearCustomerBtn').style.display = 'none';
        dropdown.style.display = 'none';
    };
    dropdown.appendChild(walkIn);

    filtered.slice(0, 8).forEach(c => {
        const opt = document.createElement('div');
        opt.className = 'customer-option';

        const hasBalance = c.balance && parseFloat(c.balance) > 0;
        opt.innerHTML = `
            <div style="display:flex;justify-content:space-between;align-items:center;">
                <div>
                    <span style="font-weight:700;color:#1e293b;">${escHtml(c.name)}</span>
                    ${c.phone ? `<span style="color:#94a3b8;margin-left:6px;">${escHtml(c.phone)}</span>` : ''}
                </div>
                ${hasBalance
                    ? `<span style="font-size:0.7rem;font-weight:700;color:#ef4444;
                                    background:#fee2e2;padding:2px 6px;border-radius:6px;">
                           £${parseFloat(c.balance).toFixed(2)} owed
                       </span>`
                    : ''}
            </div>`;
        opt.onclick = () => selectCustomer(c);
        dropdown.appendChild(opt);
    });

    dropdown.style.display = 'block';
}

function selectCustomer(customer) {
    selectedCustomer = customer;
    document.getElementById('customerSearch').value = customer.name
        + (customer.phone ? ` — ${customer.phone}` : '');
    document.getElementById('clearCustomerBtn').style.display = 'block';
    document.getElementById('customerDropdown').style.display = 'none';
}

function clearCustomer() {
    selectedCustomer = null;
    document.getElementById('customerSearch').value = '';
    document.getElementById('clearCustomerBtn').style.display = 'none';
}

// ================================================
// CART
// ================================================
function addToCart(productId) {
    const product  = allProducts.find(p => p.id === productId);
    if (!product) return;

    const existing = cart.find(i => i.id === productId && !i.isCustom);
    const cartQty  = existing ? existing.quantity : 0;

    // Allow adding even out of stock — just warn
    if (cartQty >= product.stock && product.stock > 0) {
        showToast(`Only ${product.stock} in stock — added anyway`, 'warning');
    }

    if (existing) {
        existing.quantity++;
    } else {
        cart.push({
            id      : product.id,
            name    : product.name,
            price   : parseFloat(product.price),
            stock   : product.stock,
            quantity: 1,
            isCustom: false,
        });
    }

    renderCart();
    updateProductCardBadge(productId);
    showToast(`${product.name} added`, 'success');
}

function addCustomItem() {
    const name  = document.getElementById('customName').value.trim();
    const price = parseFloat(document.getElementById('customPrice').value);
    const qty   = parseInt(document.getElementById('customQty').value) || 1;

    if (!name)           { showToast('Enter item name', 'error');      return; }
    if (!price || price <= 0) { showToast('Enter valid price', 'error'); return; }

    cart.push({
        id      : 'custom_' + Date.now(),
        name    : name,
        price   : price,
        stock   : 9999,
        quantity: qty,
        isCustom: true,
    });

    renderCart();
    closeCustomModal();
    showToast(`${name} added`, 'success');
}

function updateQuantity(itemId, delta) {
    const item = cart.find(i => String(i.id) === String(itemId));
    if (!item) return;

    const newQty = item.quantity + delta;
    if (newQty <= 0) { removeFromCart(itemId); return; }

    item.quantity = newQty;
    renderCart();
    if (!item.isCustom) updateProductCardBadge(item.id);
}

function removeFromCart(itemId) {
    const item = cart.find(i => String(i.id) === String(itemId));
    cart       = cart.filter(i => String(i.id) !== String(itemId));
    renderCart();
    if (item && !item.isCustom) updateProductCardBadge(item.id);
}

function clearCart() {
    if (!cart.length) return;
    if (!confirm('Clear all items?')) return;
    const ids  = cart.filter(i => !i.isCustom).map(i => i.id);
    cart       = [];
    discountAmount = 0;
    renderCart();
    ids.forEach(id => updateProductCardBadge(id));
}

// ================================================
// RENDER CART
// ================================================
function renderCart() {
    const container = document.getElementById('cartItems');
    const empty     = document.getElementById('cartEmpty');
    const badge     = document.getElementById('cartBadge');
    const chargeBtn = document.getElementById('chargeBtn');

    Array.from(container.children).forEach(c => {
        if (c.id !== 'cartEmpty') c.remove();
    });

    if (!cart.length) {
        empty.style.display    = 'flex';
        chargeBtn.disabled     = true;
        chargeBtn.style.background = '#e2e8f0';
        chargeBtn.style.color      = '#94a3b8';
        chargeBtn.style.cursor     = 'not-allowed';
        badge.style.display    = 'none';
        updateTotals();
        return;
    }

    empty.style.display        = 'none';
    chargeBtn.disabled         = false;
    chargeBtn.style.background = '#10b981';
    chargeBtn.style.color      = '#fff';
    chargeBtn.style.cursor     = 'pointer';

    const totalQty      = cart.reduce((s, i) => s + i.quantity, 0);
    badge.textContent   = totalQty;
    badge.style.display = 'flex';

    cart.forEach(item => {
        const el     = document.createElement('div');
        el.style.cssText = `display:flex;align-items:center;gap:8px;
                            padding:8px 0;border-bottom:1px solid #f1f5f9;`;
        el.innerHTML = `
            <div style="flex:1;min-width:0;">
                <p style="font-size:0.78rem;font-weight:700;color:#1e293b;
                           white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    ${escHtml(item.name)}
                    ${item.isCustom ? '<span style="color:#a78bfa;font-size:0.65rem;font-weight:600;margin-left:4px;">custom</span>' : ''}
                </p>
                <p style="font-size:0.72rem;margin-top:2px;">
                    <span style="font-weight:800;color:#6366f1;">
                        £${(item.price * item.quantity).toFixed(2)}
                    </span>
                    <span style="color:#cbd5e1;margin-left:4px;">
                        @ £${item.price.toFixed(2)}
                    </span>
                </p>
            </div>
            <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                <button onclick="updateQuantity('${item.id}',-1)"
                        style="width:24px;height:24px;border-radius:8px;border:1.5px solid #e2e8f0;
                               background:#fff;cursor:pointer;font-weight:800;font-size:1rem;
                               display:flex;align-items:center;justify-content:center;
                               color:#475569;transition:all 0.1s;"
                        onmouseover="this.style.background='#fee2e2';this.style.borderColor='#fca5a5';this.style.color='#ef4444'"
                        onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#475569'">
                    −
                </button>
                <span style="width:22px;text-align:center;font-size:0.8rem;font-weight:800;color:#1e293b;">
                    ${item.quantity}
                </span>
                <button onclick="updateQuantity('${item.id}',1)"
                        style="width:24px;height:24px;border-radius:8px;border:1.5px solid #e2e8f0;
                               background:#fff;cursor:pointer;font-weight:800;font-size:1rem;
                               display:flex;align-items:center;justify-content:center;
                               color:#475569;transition:all 0.1s;"
                        onmouseover="this.style.background='#dcfce7';this.style.borderColor='#86efac';this.style.color='#16a34a'"
                        onmouseout="this.style.background='#fff';this.style.borderColor='#e2e8f0';this.style.color='#475569'">
                    +
                </button>
                <button onclick="removeFromCart('${item.id}')"
                        style="width:24px;height:24px;border-radius:8px;border:none;
                               background:none;cursor:pointer;color:#cbd5e1;
                               display:flex;align-items:center;justify-content:center;
                               transition:all 0.1s;"
                        onmouseover="this.style.color='#ef4444';this.style.background='#fee2e2'"
                        onmouseout="this.style.color='#cbd5e1';this.style.background='none'">
                    <svg width="12" height="12" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>`;
        container.appendChild(el);
    });

    updateTotals();
}

// ================================================
// UPDATE PRODUCT CARD BADGE
// ================================================
function updateProductCardBadge(productId) {
    const inCart   = cart.find(i => i.id === productId && !i.isCustom);
    const cartQty  = inCart ? inCart.quantity : 0;
    const product  = allProducts.find(p => p.id === productId);
    const available = product ? product.stock - cartQty : 0;

    const badge = document.getElementById(`cart-qty-badge-${productId}`);
    if (badge) {
        badge.textContent    = cartQty;
        badge.style.display  = cartQty > 0 ? 'flex' : 'none';
    }

    const label = document.getElementById(`stock-label-${productId}`);
    if (label && product) {
        const isOOS = available <= 0;
        const isLow = !isOOS && available <= (product.low_stock_alert || 5);
        label.textContent = isOOS
            ? '⚠ out of stock'
            : `${available} in stock`;
        label.style.color = isOOS ? '#ef4444' : isLow ? '#f59e0b' : '#94a3b8';
    }

    const card = document.getElementById(`product-card-${productId}`);
    if (card) {
        if (cartQty > 0) {
            card.classList.add('in-cart');
        } else {
            card.classList.remove('in-cart');
        }
    }
}

// ================================================
// TOTALS
// ================================================
function getSubtotal() {
    return cart.reduce((s, i) => s + i.price * i.quantity, 0);
}
function getTotal() {
    return Math.max(0, getSubtotal() - discountAmount);
}
function updateTotals() {
    const sub   = getSubtotal();
    const total = getTotal();

    document.getElementById('cartSubtotal').textContent   = `£${sub.toFixed(2)}`;
    document.getElementById('cartTotal').textContent      = `£${total.toFixed(2)}`;
    document.getElementById('chargeBtnTotal').textContent = `£${total.toFixed(2)}`;

    const discRow = document.getElementById('discountRow');
    if (discountAmount > 0) {
        discRow.style.display = 'flex';
        document.getElementById('cartDiscountDisplay').textContent
            = `-£${discountAmount.toFixed(2)}`;
    } else {
        discRow.style.display = 'none';
    }

    const modal = document.getElementById('modalTotalDisplay');
    if (modal) modal.textContent = `£${total.toFixed(2)}`;
}

// ================================================
// PAYMENT METHOD
// ================================================
function selectMethod(method) {
    selectedMethod = method;
    ['cash','card','split','trade'].forEach(m => {
        const btn = document.getElementById(`method-${m}`);
        if (btn) btn.className = m === method ? 'method-btn active' : 'method-btn';
        const fields = document.getElementById(`fields-${m}`);
        if (fields) fields.style.display = m === method ? 'block' : 'none';
    });
    if (method === 'card') {
        document.getElementById('fields-card').style.display = 'flex';
        document.getElementById('fields-card').style.flexDirection = 'column';
        document.getElementById('fields-card').style.alignItems = 'center';
    }
    if (method === 'split') {
        document.getElementById('splitCard').value = getTotal().toFixed(2);
    }
}

function updateChange() {
    const tendered = parseFloat(document.getElementById('cashInput').value) || 0;
    const change   = tendered - getTotal();
    const display  = document.getElementById('changeDisplay');
    if (tendered > 0 && change >= 0) {
        display.style.display = 'flex';
        document.getElementById('changeAmount').textContent = `£${change.toFixed(2)}`;
    } else {
        display.style.display = 'none';
    }
}

function updateSplitCard() {
    const cashVal  = parseFloat(document.getElementById('splitCash').value) || 0;
    const remainder = Math.max(0, getTotal() - cashVal);
    document.getElementById('splitCard').value = remainder.toFixed(2);
}

function setQuickAmount(amount) {
    document.getElementById('cashInput').value = amount.toFixed(2);
    updateChange();
}
function setExactAmount() {
    document.getElementById('cashInput').value = getTotal().toFixed(2);
    updateChange();
}

// ================================================
// DISCOUNT MODAL
// ================================================
function openDiscountModal() {
    document.getElementById('discountInput').value = '';
    discountType = 'fixed';
    syncDiscountTypeUI();
    showModal('discountModal');
    setTimeout(() => document.getElementById('discountInput').focus(), 200);
}
function closeDiscountModal() { hideModal('discountModal'); }

function setDiscountType(type) {
    discountType = type;
    syncDiscountTypeUI();
}
function syncDiscountTypeUI() {
    const f = document.getElementById('discTypFixed');
    const p = document.getElementById('discTypPercent');
    if (discountType === 'fixed') {
        f.style.background = '#6366f1'; f.style.color = '#fff';
        p.style.background = '#fff';    p.style.color = '#94a3b8';
        document.getElementById('discountSymbol').textContent = '£';
    } else {
        p.style.background = '#6366f1'; p.style.color = '#fff';
        f.style.background = '#fff';    f.style.color = '#94a3b8';
        document.getElementById('discountSymbol').textContent = '%';
    }
}
function setQuickDiscount(pct) {
    discountType = 'percent';
    syncDiscountTypeUI();
    document.getElementById('discountInput').value = pct;
}
function applyDiscount() {
    const val = parseFloat(document.getElementById('discountInput').value) || 0;
    const sub = getSubtotal();
    discountAmount = discountType === 'percent' ? (sub * val) / 100 : val;
    discountAmount = Math.min(Math.max(0, discountAmount), sub);
    updateTotals();
    closeDiscountModal();
    if (discountAmount > 0)
        showToast(`Discount £${discountAmount.toFixed(2)} applied`, 'success');
}

// ================================================
// CUSTOM MODAL
// ================================================
function openCustomModal() {
    document.getElementById('customName').value  = '';
    document.getElementById('customPrice').value = '';
    document.getElementById('customQty').value   = '1';
    showModal('customModal');
    setTimeout(() => document.getElementById('customName').focus(), 200);
}
function closeCustomModal() { hideModal('customModal'); }

// ================================================
// PAYMENT MODAL
// ================================================
function openPaymentModal() {
    if (!cart.length) return;

    document.getElementById('modalTotalDisplay').textContent
        = `£${getTotal().toFixed(2)}`;
    document.getElementById('cashInput').value   = '';
    document.getElementById('paymentNotes').value = '';
    document.getElementById('changeDisplay').style.display = 'none';

    // Reset to cash
    selectMethod('cash');

    showModal('paymentModal');
    setTimeout(() => document.getElementById('cashInput').focus(), 200);
}
function closePaymentModal() { hideModal('paymentModal'); }

// ================================================
// COMPLETE SALE
// ================================================
async function completeSale() {
    if (!cart.length) { showToast('Cart is empty!', 'error'); return; }

    const btn = document.getElementById('completeSaleBtn');
    btn.disabled  = true;
    btn.innerHTML = `<svg class="animate-spin" width="18" height="18" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"/>
        <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
    </svg> Processing...`;

    const payload = {
        customer_id    : selectedCustomer ? selectedCustomer.id : null,
        payment_method : selectedMethod === 'trade' ? 'other' : selectedMethod,
        payment_status : 'paid',
        discount       : discountAmount,
        notes          : document.getElementById('paymentNotes').value || null,
        items          : cart.filter(i => !i.isCustom).map(i => ({
            product_id : i.id,
            quantity   : i.quantity,
            price      : i.price,
        })),
        custom_items   : cart.filter(i => i.isCustom).map(i => ({
            name     : i.name,
            quantity : i.quantity,
            price    : i.price,
        })),
    };

    // Add method-specific data
    if (selectedMethod === 'split') {
        payload.split_cash = parseFloat(document.getElementById('splitCash').value) || 0;
        payload.split_card = parseFloat(document.getElementById('splitCard').value) || 0;
    }
    if (selectedMethod === 'trade') {
        payload.trade_value  = parseFloat(document.getElementById('tradeValue').value) || 0;
        payload.trade_device = document.getElementById('tradeDevice').value || null;
    }

    try {
        const res  = await fetch(ROUTES.store, {
            method  : 'POST',
            headers : {
                'Content-Type'     : 'application/json',
                'X-CSRF-TOKEN'     : CSRF,
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
            body: JSON.stringify(payload),
        });
        const data = await res.json();

        if (data.success) {
            closePaymentModal();
            showToast(`✓ ${data.message}`, 'success');
            cart           = [];
            discountAmount = 0;
            selectedCustomer = null;
            document.getElementById('customerSearch').value = '';
            document.getElementById('clearCustomerBtn').style.display = 'none';
            renderCart();
            if (navState?.type === 'brand')
                loadProductsFiltered(navState.categoryId, navState.brandId);
        } else {
            const errors = data.errors
                ? Object.values(data.errors).flat().join('\n')
                : data.message;
            showToast(errors, 'error');
        }
    } catch(e) {
        showToast('Network error.', 'error');
        console.error(e);
    } finally {
        btn.disabled  = false;
        btn.innerHTML = `<svg width="18" height="18" fill="none" stroke="white"
                              viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  stroke-width="2.5" d="M5 13l4 4L19 7"/>
        </svg> Complete Sale`;
    }
}

// ================================================
// MODAL HELPERS
// ================================================
function showModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            const box = modal.querySelector('[id$="ModalBox"],[id$="modalBox"]');
            if (box) { box.style.transform = 'scale(1)'; box.style.opacity = '1'; }
        });
    });
}
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    const box   = modal.querySelector('[id$="ModalBox"],[id$="modalBox"]');
    if (box) { box.style.transform = 'scale(0.95)'; box.style.opacity = '0'; }
    setTimeout(() => modal.style.display = 'none', 150);
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closePaymentModal();
        closeDiscountModal();
        closeCustomModal();
    }
});

// ================================================
// LOADING
// ================================================
function showLoading(show) {
    document.getElementById('gridLoading').style.display = show ? 'block' : 'none';
    document.getElementById('mainGrid').style.display    = show ? 'none'  : 'grid';
    document.getElementById('gridEmpty').style.display   = 'none';
}

// ================================================
// TOAST
// ================================================
function showToast(msg, type = 'success') {
    const ex = document.getElementById('posToast');
    if (ex) ex.remove();

    const bg = { success:'#10b981', error:'#ef4444', warning:'#f59e0b' };
    const t  = document.createElement('div');
    t.id     = 'posToast';
    t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:9999;
                       padding:10px 16px;border-radius:12px;color:#fff;
                       font-size:0.85rem;font-weight:700;
                       box-shadow:0 8px 24px rgba(0,0,0,0.15);
                       background:${bg[type]||bg.success};
                       transform:translateY(8px);opacity:0;
                       transition:all 0.25s;max-width:280px;`;
    t.textContent = msg;
    document.body.appendChild(t);

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            t.style.transform = 'translateY(0)';
            t.style.opacity   = '1';
        });
    });
    setTimeout(() => {
        t.style.transform = 'translateY(8px)';
        t.style.opacity   = '0';
        setTimeout(() => t.remove(), 250);
    }, 3000);
}

// ================================================
// ESCAPE HTML
// ================================================
function escHtml(str) {
    if (!str) return '';
    const d = document.createElement('div');
    d.textContent = String(str);
    return d.innerHTML;
}
</script>
@endpush

</x-app-layout>