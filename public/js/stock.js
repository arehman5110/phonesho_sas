/**
 * Stock Manager
 * Handles: top-up modal, stock update, movement history
 * Namespace: StockManager
 */
const StockManager = (() => {

    // ─────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────
    const state = {
        csrf          : '',
        routes        : {},
        selectedId    : null,
        selectedName  : '',
        currentStock  : 0,
        loadedMovements: new Set(),
    };

    // ─────────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────────
    function init(config) {
        state.csrf   = config.csrf;
        state.routes = config.routes;

        // Close modal on overlay click
        document.getElementById('topup-modal')
            ?.addEventListener('click', (e) => {
                if (e.target === e.currentTarget) closeModal();
            });

        // Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeModal();
        });

        // Live qty preview
        document.getElementById('topup-quantity')
            ?.addEventListener('input', _updatePreview);
    }

    // ─────────────────────────────────────────────────────────────
    // FILTER BY STOCK LEVEL
    // ─────────────────────────────────────────────────────────────
    function filterBy(level) {
        const select = document.getElementById('filter-stock');
        if (select) {
            select.value = level;
            document.getElementById('filter-form')?.submit();
        }
    }

    // ─────────────────────────────────────────────────────────────
    // OPEN MODAL
    // ─────────────────────────────────────────────────────────────
    function openModal(productId, productName, currentStock) {
        state.selectedId   = productId;
        state.selectedName = productName;
        state.currentStock = parseInt(currentStock) || 0;

        // Set display values
        _setText('topup-product-name',   productName);
        _setText('topup-current-stock',  state.currentStock);

        // Reset fields
        const qtyInput = document.getElementById('topup-quantity');
        const noteInput = document.getElementById('topup-note');
        if (qtyInput)  qtyInput.value  = '1';
        if (noteInput) noteInput.value = '';

        // Update preview
        _updatePreview();

        // Show modal
        const modal = document.getElementById('topup-modal');
        const box   = document.getElementById('topup-modal-box');
        if (!modal || !box) return;

        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                box.style.transform = 'scale(1)';
                box.style.opacity   = '1';
            });
        });

        // Focus quantity input
        setTimeout(() => {
            document.getElementById('topup-quantity')?.select();
        }, 200);
    }

    // ─────────────────────────────────────────────────────────────
    // CLOSE MODAL
    // ─────────────────────────────────────────────────────────────
    function closeModal() {
        const modal = document.getElementById('topup-modal');
        const box   = document.getElementById('topup-modal-box');
        if (!modal || !box) return;

        box.style.transform = 'scale(0.95)';
        box.style.opacity   = '0';
        setTimeout(() => {
            modal.style.display  = 'none';
            state.selectedId     = null;
        }, 180);
    }

    // ─────────────────────────────────────────────────────────────
    // QUANTITY CONTROLS
    // ─────────────────────────────────────────────────────────────
    function setQty(amount) {
        const input = document.getElementById('topup-quantity');
        if (input) {
            input.value = amount;
            _updatePreview();
        }
    }

    function adjustQty(delta) {
        const input = document.getElementById('topup-quantity');
        if (!input) return;
        const current = parseInt(input.value) || 0;
        input.value   = Math.max(1, current + delta);
        _updatePreview();
    }

    function _updatePreview() {
        const qty      = parseInt(
            document.getElementById('topup-quantity')?.value
        ) || 0;
        const newStock = state.currentStock + qty;
        _setText('topup-new-stock', newStock);
    }

    // ─────────────────────────────────────────────────────────────
    // SUBMIT TOP-UP
    // ─────────────────────────────────────────────────────────────
    async function submitTopup() {
        const qty  = parseInt(
            document.getElementById('topup-quantity')?.value
        ) || 0;
        const note = document.getElementById('topup-note')?.value || '';

        if (qty <= 0) {
            _toast('Please enter a quantity greater than 0', 'error');
            return;
        }

        if (qty > 9999) {
            _toast('Maximum quantity is 9,999', 'error');
            return;
        }

        // Set loading state
        const btn     = document.getElementById('topup-submit-btn');
        btn.disabled  = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="white" stroke-width="4"/>
                <path class="opacity-75" fill="white"
                      d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            Adding...`;

        const url = state.routes.topup.replace('{id}', state.selectedId);

        try {
            const res  = await fetch(url, {
                method  : 'POST',
                headers : {
                    'Content-Type'     : 'application/json',
                    'X-CSRF-TOKEN'     : state.csrf,
                    'X-Requested-With' : 'XMLHttpRequest',
                    'Accept'           : 'application/json',
                },
                body: JSON.stringify({ quantity: qty, note }),
            });

            const data = await res.json();

            if (data.success) {
                // Update stock display in table
                _updateStockDisplay(
                    data.product_id,
                    data.new_stock,
                    data.is_low,
                    data.is_out
                );

                // Reset movement cache so it reloads
                state.loadedMovements.delete(state.selectedId);

                // If row is expanded — reload movements
                const expandRow = document.getElementById(
                    `stock-expand-${state.selectedId}`
                );
                if (expandRow?.classList.contains('open')) {
                    _loadMovements(state.selectedId);
                }

                closeModal();
                _toast(data.message, 'success');

            } else {
                _toast(data.message || 'Failed to update stock', 'error');
            }

        } catch (e) {
            console.error('Topup error:', e);
            _toast('Network error. Please try again.', 'error');
        } finally {
            btn.disabled  = false;
            btn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Stock`;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // UPDATE STOCK DISPLAY IN TABLE
    // ─────────────────────────────────────────────────────────────
    function _updateStockDisplay(productId, newStock, isLow, isOut) {
        const qtyEl = document.getElementById(`stock-qty-${productId}`);
        if (!qtyEl) return;

        // Update number
        qtyEl.textContent = newStock;

        // Update color class
        qtyEl.className = `text-lg ${
            isOut ? 'stock-out' : isLow ? 'stock-low' : 'stock-ok'
        }`;

        // Update badge — find sibling span
        const cell     = qtyEl.closest('td');
        const badge    = cell?.querySelector('span:not([id])');

        if (badge) badge.remove();

        if (isOut) {
            const b       = document.createElement('span');
            b.className   = 'text-xs font-bold px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400';
            b.textContent = 'Out';
            qtyEl.after(b);
        } else if (isLow) {
            const b       = document.createElement('span');
            b.className   = 'text-xs font-bold px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400';
            b.textContent = 'Low';
            qtyEl.after(b);
        }

        // Update row icon color
        const row  = document.getElementById(`stock-chevron-${productId}`)
            ?.closest('tr');
        if (row) {
            row.className = `stock-row group transition-colors ${
                isOut
                    ? 'hover:bg-red-50/40 dark:hover:bg-red-900/10'
                    : isLow
                        ? 'hover:bg-amber-50/40 dark:hover:bg-amber-900/10'
                        : 'hover:bg-indigo-50/40 dark:hover:bg-indigo-900/10'
            }`;
        }

        // Flash animation
        if (qtyEl) {
            qtyEl.style.transform  = 'scale(1.3)';
            qtyEl.style.transition = 'transform 0.2s ease';
            setTimeout(() => {
                qtyEl.style.transform = 'scale(1)';
            }, 200);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // TOGGLE ROW — load movement history
    // ─────────────────────────────────────────────────────────────
    function toggleRow(productId, rowEl) {
        const expandRow = document.getElementById(`stock-expand-${productId}`);
        const chevron   = document.getElementById(`stock-chevron-${productId}`);
        if (!expandRow) return;

        const isOpen = expandRow.classList.contains('open');

        if (isOpen) {
            expandRow.classList.remove('open');
            if (chevron) {
                chevron.querySelector('svg').style.transform = '';
            }
        } else {
            expandRow.classList.add('open');
            if (chevron) {
                chevron.querySelector('svg').style.transform = 'rotate(90deg)';
            }

            // Load movements if not already loaded
            if (!state.loadedMovements.has(productId)) {
                _loadMovements(productId);
            }
        }
    }

    // ─────────────────────────────────────────────────────────────
    // LOAD MOVEMENT HISTORY
    // ─────────────────────────────────────────────────────────────
    async function _loadMovements(productId) {
        const loadingEl = document.getElementById(
            `movements-loading-${productId}`
        );
        const contentEl = document.getElementById(
            `movements-content-${productId}`
        );

        if (!loadingEl || !contentEl) return;

        loadingEl.style.display = 'flex';
        contentEl.style.display = 'none';

        const url = state.routes.movements.replace('{id}', productId);

        try {
            const res  = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            const data = await res.json();

            contentEl.innerHTML = _renderMovements(data);
            loadingEl.style.display = 'none';
            contentEl.style.display = 'block';

            state.loadedMovements.add(productId);

        } catch (e) {
            loadingEl.style.display = 'none';
            contentEl.style.display = 'block';
            contentEl.innerHTML = `
                <p class="text-sm text-red-500 py-2">
                    Failed to load movement history.
                </p>`;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER MOVEMENTS
    // ─────────────────────────────────────────────────────────────
    function _renderMovements(data) {
        if (!data.movements || data.movements.length === 0) {
            return `
                <div class="py-6 text-center">
                    <p class="text-sm font-semibold text-gray-500
                               dark:text-gray-400">
                        No movement history yet
                    </p>
                </div>`;
        }

        const rows = data.movements.map(m => {
            const isPositive = m.quantity > 0;
            const typeClass  = _movementTypeClass(m.type);
            const qtyColor   = isPositive ? '#16a34a' : '#dc2626';
            const qtyPrefix  = isPositive ? '+' : '';

            return `
                <div style="display:flex;align-items:center;gap:12px;
                            padding:8px 0;border-bottom:1px solid #f1f5f9;">

                    {{-- Type badge --}}
                    <span class="${typeClass}"
                          style="font-size:0.7rem;font-weight:700;
                                 padding:2px 8px;border-radius:999px;
                                 white-space:nowrap;flex-shrink:0;
                                 text-transform:capitalize;">
                        ${_esc(m.type)}
                    </span>

                    {{-- Note --}}
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:0.78rem;color:#374151;
                                  margin:0;white-space:nowrap;
                                  overflow:hidden;text-overflow:ellipsis;">
                            ${_esc(m.note || '—')}
                        </p>
                        <p style="font-size:0.7rem;color:#94a3b8;margin:0;">
                            ${_esc(m.user)} · ${_esc(m.created_at)}
                        </p>
                    </div>

                    {{-- Quantity --}}
                    <span style="font-size:0.9rem;font-weight:800;
                                 color:${qtyColor};white-space:nowrap;
                                 flex-shrink:0;">
                        ${qtyPrefix}${m.quantity}
                    </span>

                </div>`;
        }).join('');

        return `
            <div style="margin-bottom:12px;">
                <div style="display:flex;align-items:center;
                            justify-content:space-between;margin-bottom:10px;">
                    <p style="font-size:0.65rem;font-weight:700;
                              color:#94a3b8;text-transform:uppercase;
                              letter-spacing:0.05em;margin:0;">
                        Movement History (last 20)
                    </p>
                    <span style="font-size:0.75rem;font-weight:700;
                                 color:#6366f1;">
                        Current: ${data.stock} units
                    </span>
                </div>
                <div style="background:#fff;border-radius:12px;
                            padding:4px 16px;border:1px solid #e0e7ff;">
                    ${rows}
                </div>
            </div>`;
    }

    // ─────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────
    function _movementTypeClass(type) {
        const map = {
            topup  : 'move-topup',
            manual : 'move-manual',
            sale   : 'move-sale',
            repair : 'move-repair',
            return : 'move-return',
        };
        return map[type] ?? 'move-default';
    }

    function _setText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = String(text);
    }

    function _esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    function _toast(message, type = 'success') {
        const existing = document.getElementById('stock-toast');
        if (existing) existing.remove();

        const colors = {
            success : '#10b981',
            error   : '#ef4444',
            warning : '#f59e0b',
        };

        const el        = document.createElement('div');
        el.id           = 'stock-toast';
        el.style.cssText = `
            position:fixed;bottom:24px;right:24px;z-index:9999;
            padding:10px 18px;border-radius:12px;color:#fff;
            font-size:0.85rem;font-weight:700;max-width:320px;
            box-shadow:0 8px 24px rgba(0,0,0,0.15);
            background:${colors[type] || colors.success};
            transform:translateY(10px);opacity:0;
            transition:all 0.25s ease;`;
        el.textContent = message;
        document.body.appendChild(el);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                el.style.transform = 'translateY(0)';
                el.style.opacity   = '1';
            });
        });

        setTimeout(() => {
            el.style.opacity   = '0';
            el.style.transform = 'translateY(10px)';
            setTimeout(() => el.remove(), 250);
        }, 3500);
    }

    // ─────────────────────────────────────────────────────────────
    // PUBLIC API
    // ─────────────────────────────────────────────────────────────
    return {
        init,
        filterBy,
        openModal,
        closeModal,
        setQty,
        adjustQty,
        submitTopup,
        toggleRow,
    };

})();