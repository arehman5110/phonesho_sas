{{-- ============================================================ --}}
{{-- CUSTOM ITEM MODAL                                           --}}
{{-- Allows adding a non-inventory item to the cart              --}}
{{-- ============================================================ --}}
<div id="customModal"
     class="pos-modal-overlay"
     onclick="POS.handleOverlayClick(event, 'customModal')">

    <div id="customModalBox"
         class="pos-modal-box"
         style="max-width:380px;">

        {{-- Header --}}
        <div class="pos-modal-header">
            <h3 class="pos-modal-title">Custom Item</h3>
            <button class="pos-modal-close"
                    onclick="POS.closeCustomModal()"
                    title="Close">
                ✕
            </button>
        </div>

        {{-- Body --}}
        <div class="pos-modal-body">

            {{-- Item Name --}}
            <div>
                <label class="pos-label" for="customName">
                    Item Name <span style="color:#ef4444;">*</span>
                </label>
                <input type="text"
                       id="customName"
                       class="pos-input"
                       placeholder="e.g. Screen Repair Labour"
                       autocomplete="off"
                       onkeydown="if(event.key==='Enter') document.getElementById('customPrice').focus()">
            </div>

            {{-- Price --}}
            <div>
                <label class="pos-label" for="customPrice">
                    Price <span style="color:#ef4444;">*</span>
                </label>
                <div style="position:relative;">
                    <span style="position:absolute;left:12px;top:50%;
                                 transform:translateY(-50%);color:#94a3b8;
                                 font-weight:700;font-size:0.9rem;
                                 pointer-events:none;">
                        £
                    </span>
                    <input type="number"
                           id="customPrice"
                           class="pos-input"
                           min="0"
                           step="0.01"
                           placeholder="0.00"
                           style="padding-left:28px;"
                           onkeydown="if(event.key==='Enter') document.getElementById('customQty').focus()">
                </div>
            </div>

            {{-- Quantity --}}
            <div>
                <label class="pos-label" for="customQty">
                    Quantity
                </label>
                <div style="display:flex;align-items:center;gap:10px;">
                    <button onclick="POS.adjustCustomQty(-1)"
                            style="width:36px;height:36px;border-radius:10px;
                                   border:2px solid #e2e8f0;background:#fff;
                                   cursor:pointer;font-size:1.1rem;font-weight:800;
                                   display:flex;align-items:center;
                                   justify-content:center;color:#475569;
                                   flex-shrink:0;transition:all 0.15s;"
                            class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            onmouseover="this.style.background='#fee2e2';this.style.borderColor='#fca5a5';this.style.color='#ef4444'"
                            onmouseout="this.style.background='';this.style.borderColor='';this.style.color=''">
                        −
                    </button>
                    <input type="number"
                           id="customQty"
                           class="pos-input"
                           min="1"
                           value="1"
                           style="text-align:center;font-weight:800;font-size:1rem;">
                    <button onclick="POS.adjustCustomQty(1)"
                            style="width:36px;height:36px;border-radius:10px;
                                   border:2px solid #e2e8f0;background:#fff;
                                   cursor:pointer;font-size:1.1rem;font-weight:800;
                                   display:flex;align-items:center;
                                   justify-content:center;color:#475569;
                                   flex-shrink:0;transition:all 0.15s;"
                            class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            onmouseover="this.style.background='#dcfce7';this.style.borderColor='#86efac';this.style.color='#16a34a'"
                            onmouseout="this.style.background='';this.style.borderColor='';this.style.color=''">
                        +
                    </button>
                </div>
            </div>

            {{-- Note --}}
            <div>
                <label class="pos-label" for="customNote">
                    Note (Optional)
                </label>
                <input type="text"
                       id="customNote"
                       class="pos-input"
                       placeholder="e.g. includes parts and labour"
                       onkeydown="if(event.key==='Enter') POS.addCustomItem()">
            </div>

        </div>

        {{-- Footer --}}
        <div class="pos-modal-footer">
            <div style="display:flex;gap:10px;">
                <button onclick="POS.closeCustomModal()"
                        style="flex:1;padding:11px;border-radius:10px;
                               border:2px solid #e2e8f0;background:#fff;
                               color:#475569;font-weight:700;cursor:pointer;
                               font-size:0.85rem;transition:all 0.15s;"
                        class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300">
                    Cancel
                </button>
                <button onclick="POS.addCustomItem()"
                        style="flex:1;padding:11px;border-radius:10px;
                               border:none;background:#6366f1;color:#fff;
                               font-weight:700;cursor:pointer;
                               font-size:0.85rem;transition:all 0.15s;"
                        onmouseover="this.style.background='#4f46e5'"
                        onmouseout="this.style.background='#6366f1'">
                    Add to Cart
                </button>
            </div>
        </div>

    </div>
</div>