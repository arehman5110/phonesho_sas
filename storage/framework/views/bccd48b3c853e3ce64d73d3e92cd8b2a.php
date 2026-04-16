



<div id="paymentModal" class="pos-modal-overlay" onclick="POS.handleOverlayClick(event, 'paymentModal')">

    <div id="paymentModalBox" class="pos-modal-box" style="max-width:420px;max-height:90vh;overflow-y:auto;">

        
        <div class="pos-modal-header" style="position:sticky;top:0;z-index:10;background:#fff;" class="dark:bg-gray-900">
            <h3 class="pos-modal-title">Payment</h3>
            <button class="pos-modal-close" onclick="POS.closePaymentModal()" title="Close">
                ✕
            </button>
        </div>

        <div class="pos-modal-body">

            
            <div
                style="background:linear-gradient(135deg,#ecfdf5,#d1fae5);
                        border-radius:16px;padding:18px;text-align:center;">
                <p
                    style="font-size:0.62rem;font-weight:700;color:#059669;
                           text-transform:uppercase;letter-spacing:0.12em;
                           margin:0 0 6px;">
                    Total Due
                </p>
                <p id="modalTotalDisplay"
                    style="font-size:2.5rem;font-weight:900;color:#059669;
                          margin:0;letter-spacing:-0.02em;
                          font-family:'Georgia',serif;">
                    £0.00
                </p>
            </div>

            
            <div>
                <label class="pos-label" style="margin-bottom:8px;">
                    Payment Method
                </label>
                <div style="display:flex;gap:8px;">

                    
                    <button class="method-btn active" id="method-cash" onclick="POS.selectMethod('cash')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0
                                     002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2
                                     2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2
                                     2 0 014 0z" />
                        </svg>
                        Cash
                    </button>

                    
                    <button class="method-btn" id="method-card" onclick="POS.selectMethod('card')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3
                                     3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Card
                    </button>

                    
                    <button class="method-btn" id="method-trade" onclick="POS.selectMethod('trade')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h.582m15.356 2A8.001 8.001 0
                                     004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003
                                     8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Trade
                    </button>

                    
                    <button class="method-btn" id="method-split" onclick="POS.selectMethod('split')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0
                                     0l4 4m-4-4l4-4" />
                        </svg>
                        Split
                    </button>

                </div>
            </div>

            
            <div id="fields-cash">

                <label class="pos-label">Cash £</label>

                
                <div
                    style="display:grid;grid-template-columns:repeat(5,1fr);
                            gap:6px;margin-bottom:10px;">
                    <?php $__currentLoopData = [5, 10, 20, 50]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $amount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button onclick="POS.setQuickAmount(<?php echo e($amount); ?>)"
                            style="padding:9px 4px;border-radius:8px;
                                   font-size:0.78rem;font-weight:700;
                                   border:1.5px solid #e2e8f0;background:#f8fafc;
                                   color:#475569;cursor:pointer;transition:all 0.15s;"
                            class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                            onmouseover="this.style.background='#ecfdf5';this.style.color='#10b981';this.style.borderColor='#10b981'"
                            onmouseout="this.style.background='';this.style.color='';this.style.borderColor=''">
                            £<?php echo e($amount); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button onclick="POS.setExactAmount()"
                        style="padding:9px 4px;border-radius:8px;
                                   font-size:0.7rem;font-weight:700;
                                   border:1.5px solid #e2e8f0;background:#f8fafc;
                                   color:#475569;cursor:pointer;transition:all 0.15s;"
                        class="dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300"
                        onmouseover="this.style.background='#ecfdf5';this.style.color='#10b981';this.style.borderColor='#10b981'"
                        onmouseout="this.style.background='';this.style.color='';this.style.borderColor=''">
                        Exact
                    </button>
                </div>

                
                <div style="position:relative;">
                    <span
                        style="position:absolute;left:12px;top:50%;
                                 transform:translateY(-50%);color:#94a3b8;
                                 font-weight:700;font-size:1rem;
                                 pointer-events:none;">
                        £
                    </span>
                    <input type="number" id="cashInput" class="pos-input" min="0" step="0.01" placeholder="0"
                        style="padding-left:28px;font-size:1.5rem;font-weight:800;" oninput="POS.updateChange()">
                </div>

                
                <div id="changeDisplay"
                    style="display:none;margin-top:10px;padding:10px 14px;
                            border-radius:10px;background:#ecfdf5;
                            border:1.5px solid #a7f3d0;
                            flex-direction:row;
                            justify-content:space-between;align-items:center;">
                    <span style="font-size:0.85rem;font-weight:700;color:#059669;">
                        Change Due
                    </span>
                    <span id="changeAmount" style="font-size:1.1rem;font-weight:900;color:#059669;">
                        £0.00
                    </span>
                </div>

            </div>

            
            <div id="fields-card"
                style="display:none;flex-direction:column;
                        align-items:center;padding:16px 0;gap:14px;">

                <div
                    style="width:64px;height:64px;border-radius:18px;
                            background:linear-gradient(135deg,#fbbf24,#f59e0b);
                            display:flex;align-items:center;justify-content:center;
                            box-shadow:0 4px 16px rgba(245,158,11,0.35);">
                    <svg width="32" height="32" fill="none" stroke="#fff" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3
                                 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <p style="font-size:0.9rem;font-weight:600;color:#64748b;margin:0;" class="dark:text-gray-400">
                    Present card to terminal
                </p>

            </div>

            
            <div id="fields-trade" style="display:none;">

                
                <div
                    style="background:#fef3c7;border-radius:12px;padding:12px 14px;
                border:1.5px solid #fde68a;margin-bottom:14px;
                display:flex;align-items:center;gap:10px;">
                    <span style="font-size:1.2rem;">🔄</span>
                    <p
                        style="font-size:0.78rem;font-weight:600;
                   color:#92400e;margin:0;line-height:1.4;">
                        Customer is trading a device as full or partial payment.
                    </p>
                </div>

                
                <div>
                    <label class="pos-label" for="tradeValue">
                        Trade-in Value
                    </label>
                    <div style="position:relative;">
                        <span
                            style="position:absolute;left:12px;top:50%;
                         transform:translateY(-50%);color:#94a3b8;
                         font-weight:700;pointer-events:none;">
                            £
                        </span>
                        <input type="number" id="tradeValue" class="pos-input" min="0" step="0.01"
                            placeholder="0.00" style="padding-left:28px;font-size:1.4rem;font-weight:800;">
                    </div>
                </div>

            </div>


            
            <div id="fields-split" style="display:none;">

                
                <div class="split-card split-card-1" style="margin-bottom:10px;">
                    <p
                        style="font-size:0.72rem;font-weight:800;color:#6366f1;
                   text-transform:uppercase;letter-spacing:0.08em;
                   margin:0 0 12px;">
                        1st Payment
                    </p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">

                        
                        <div>
                            <label class="pos-label">Method</label>
                            <select id="split1Method"
                                style="width:100%;padding:9px 10px;
                               border:1.5px solid #e2e8f0;
                               border-radius:9px;font-size:0.82rem;
                               font-weight:700;outline:none;
                               background:#fff;color:#1e293b;
                               cursor:pointer;box-sizing:border-box;
                               appearance:auto;"
                                class="dark:bg-gray-800 dark:border-gray-700
                               dark:text-gray-200">
                                <option value="cash">💵 Cash</option>
                                <option value="card">💳 Card</option>
                                <option value="trade">🔄 Trade</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>

                        
                        <div>
                            <label class="pos-label">Amount £</label>
                            <div style="position:relative;">
                                <span
                                    style="position:absolute;left:9px;top:50%;
                                 transform:translateY(-50%);color:#94a3b8;
                                 font-weight:700;font-size:0.9rem;
                                 pointer-events:none;">£</span>
                                <input type="number" id="split1Amount" min="0" step="0.01"
                                    placeholder="0.00" oninput="POS.updateSplit2()"
                                    style="width:100%;padding:9px 8px 9px 22px;
                                  border:1.5px solid #e2e8f0;
                                  border-radius:9px;font-size:0.9rem;
                                  font-weight:700;outline:none;
                                  background:#fff;color:#1e293b;
                                  box-sizing:border-box;"
                                    class="dark:bg-gray-800 dark:border-gray-700
                                  dark:text-gray-200">
                            </div>
                        </div>

                    </div>
                </div>

                
                <div class="split-card split-card-2">
                    <p
                        style="font-size:0.72rem;font-weight:800;color:#10b981;
                   text-transform:uppercase;letter-spacing:0.08em;
                   margin:0 0 12px;">
                        2nd Payment
                    </p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">

                        
                        <div>
                            <label class="pos-label">Method</label>
                            <select id="split2Method"
                                style="width:100%;padding:9px 10px;
                               border:1.5px solid #e2e8f0;
                               border-radius:9px;font-size:0.82rem;
                               font-weight:700;outline:none;
                               background:#fff;color:#1e293b;
                               cursor:pointer;box-sizing:border-box;
                               appearance:auto;"
                                class="dark:bg-gray-800 dark:border-gray-700
                               dark:text-gray-200">
                                <option value="card">💳 Card</option>
                                <option value="cash">💵 Cash</option>
                                <option value="trade">🔄 Trade</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>

                        
                        <div>
                            <label class="pos-label">Amount £</label>
                            <div style="position:relative;">
                                <span
                                    style="position:absolute;left:9px;top:50%;
                                 transform:translateY(-50%);color:#94a3b8;
                                 font-weight:700;font-size:0.9rem;
                                 pointer-events:none;">£</span>
                                <input type="number" id="split2Amount" min="0" step="0.01"
                                    placeholder="0.00" readonly
                                    style="width:100%;padding:9px 8px 9px 22px;
                                  border:1.5px solid #e2e8f0;
                                  border-radius:9px;font-size:0.9rem;
                                  font-weight:700;outline:none;
                                  background:#f8fafc;color:#475569;
                                  box-sizing:border-box;">
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            
            <div>
                <label class="pos-label" for="paymentNotes">
                    Notes (Optional)
                </label>
                <input type="text" id="paymentNotes" class="pos-input" placeholder="e.g. customer ref...">
            </div>

        </div>

        
        <div class="pos-modal-footer">
            <button onclick="POS.completeSale()" id="completeSaleBtn"
                style="width:100%;padding:14px;border-radius:12px;
                           border:none;background:#10b981;color:#fff;
                           font-weight:800;font-size:0.95rem;cursor:pointer;
                           transition:all 0.15s;display:flex;
                           align-items:center;justify-content:center;gap:8px;"
                onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">
                <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                </svg>
                Complete Sale
            </button>
        </div>

    </div>
</div>
<?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/pos/partials/modals/payment.blade.php ENDPATH**/ ?>