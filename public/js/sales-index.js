/**
 * Sales Index — Filters + Expandable Rows
 * Namespace: SalesIndex
 */
const SalesIndex = (() => {

    // ─────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────
    const state = {
        fetchUrl    : '',
        csrf        : '',
        searchTimer : null,
        currentPage : 1,
        isLoading   : false,
    };

    // ─────────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────────
   function init(config) {
    state.fetchUrl = config.fetchUrl;
    state.csrf     = config.csrf;

    // Search — debounced
    document.getElementById('filter-search')
        ?.addEventListener('input', () => {
            clearTimeout(state.searchTimer);
            state.searchTimer = setTimeout(() => {
                state.currentPage = 1;
                _renderFilterTags();
                _fetchSales();
            }, 350);
        });

    // Payment status — immediate
    document.getElementById('filter-payment-status')
        ?.addEventListener('change', () => {
            state.currentPage = 1;
            _renderFilterTags();
            _fetchSales();
        });

    // Payment method — immediate
    document.getElementById('filter-payment-method')
        ?.addEventListener('change', () => {
            state.currentPage = 1;
            _renderFilterTags();
            _fetchSales();
        });

    // Date from
    document.getElementById('filter-date-from')
        ?.addEventListener('change', () => {
            state.currentPage = 1;
            _renderFilterTags();
            _fetchSales();
        });

    // Date to
    document.getElementById('filter-date-to')
        ?.addEventListener('change', () => {
            state.currentPage = 1;
            _renderFilterTags();
            _fetchSales();
        });

    // Render tags for any pre-filled values (from URL params)
    // but do NOT auto-fetch on load
    _renderFilterTags();

    
}
    // ─────────────────────────────────────────────────────────────
    // FETCH SALES (AJAX)
    // ─────────────────────────────────────────────────────────────
    async function _fetchSales() {
        if (state.isLoading) return;
        state.isLoading = true;
        _showLoading(true);

        const params = _buildParams();

        // Update URL
        window.history.replaceState(
            {},
            '',
            `${window.location.pathname}?${params}`
        );

        try {
            const res  = await fetch(`${state.fetchUrl}?${params}`, {
                headers: {
                    'X-Requested-With' : 'XMLHttpRequest',
                    'Accept'           : 'application/json',
                    'X-CSRF-TOKEN'     : state.csrf,
                },
            });

            const data = await res.json();
            _renderTable(data);

        } catch (e) {
            console.error('Failed to fetch sales:', e);
        } finally {
            state.isLoading = false;
            _showLoading(false);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // BUILD PARAMS
    // ─────────────────────────────────────────────────────────────
    function _buildParams() {
        const params = new URLSearchParams();

        const search = document.getElementById('filter-search')?.value?.trim();
        if (search) params.set('search', search);

        const status = document.getElementById('filter-payment-status')?.value;
        if (status) params.set('payment_status', status);

        const method = document.getElementById('filter-payment-method')?.value;
        if (method) params.set('payment_method', method);

        const dateFrom = document.getElementById('filter-date-from')?.value;
        const dateTo   = document.getElementById('filter-date-to')?.value;
        if (dateFrom) params.set('date_from', dateFrom);
        if (dateTo)   params.set('date_to',   dateTo);

        params.set('page', state.currentPage);

        return params;
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER TABLE
    // ─────────────────────────────────────────────────────────────
   function _renderTable(data) {
    const tbody = document.getElementById('sales-tbody');
    if (!tbody) return;

    // Always clear existing rows
    tbody.innerHTML = '';

    if (!data.sales || data.sales.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="8">
                    <div class="flex flex-col items-center justify-center
                                py-16 text-gray-400 dark:text-gray-600">
                        <svg class="w-16 h-16 mb-4 opacity-40" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.5"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7
                                     13L5.4 5M7 13l-2.293 2.293c-.63.63
                                     -.184 1.707.707 1.707H17m0 0a2 2 0
                                     100 4 2 2 0 000-4zm-8 2a2 2 0 11-4
                                     0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-sm font-semibold
                                   text-gray-500 dark:text-gray-400">
                            No sales found
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Try adjusting your filters
                        </p>
                    </div>
                </td>
            </tr>`;
        _updateResultsInfo(0, 0, 0);
        _renderPagination(null);
        return;
    }

    data.sales.forEach(sale => {
        tbody.appendChild(_buildMainRow(sale));
        tbody.appendChild(_buildExpandRow(sale));
    });

    _updateResultsInfo(
        data.pagination.from,
        data.pagination.to,
        data.pagination.total
    );

    _renderPagination(data.pagination);
}

    // ─────────────────────────────────────────────────────────────
    // BUILD MAIN ROW
    // ─────────────────────────────────────────────────────────────
    function _buildMainRow(sale) {
        const tr     = document.createElement('tr');
        tr.className = 'sale-row group hover:bg-indigo-50/40 dark:hover:bg-indigo-900/10 transition-colors';
        tr.onclick   = () => toggleRow(sale.id, tr);

        const statusClass  = _statusBadgeClass(sale.payment_status);
        const methodClass  = _methodBadgeClass(sale.payment_method);
        const methodIcon   = _methodIcon(sale.payment_method);
        const outstanding  = sale.outstanding;

        const itemsSummary = sale.items.slice(0, 2)
            .map(i => _esc(i.name))
            .join(', ');

        const moreItems = sale.items.length > 2
            ? ` +${sale.items.length - 2} more`
            : '';

        tr.innerHTML = `
            <td class="px-4 py-4 w-8">
                <div id="chevron-${sale.id}"
                     class="w-6 h-6 rounded-full flex items-center
                            justify-center bg-gray-100 dark:bg-gray-800
                            text-gray-400 transition-all
                            group-hover:bg-indigo-100
                            dark:group-hover:bg-indigo-900/40
                            group-hover:text-indigo-500">
                    <svg class="w-3.5 h-3.5 transition-transform duration-200"
                         fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </td>

            <td class="px-4 py-4">
                <p class="text-sm font-bold text-indigo-600
                           dark:text-indigo-400">
                    ${_esc(sale.reference)}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    ${_esc(sale.created_at)}
                </p>
            </td>

            <td class="px-4 py-4">
                ${sale.customer
                    ? `<p class="text-sm font-semibold text-gray-900
                                  dark:text-white">
                           ${_esc(sale.customer.name)}
                       </p>
                       ${sale.customer.phone
                           ? `<p class="text-xs text-gray-500
                                        dark:text-gray-400">
                                  ${_esc(sale.customer.phone)}
                              </p>`
                           : ''}`
                    : `<span class="text-xs italic text-gray-400
                                    dark:text-gray-600">Walk-in</span>`
                }
            </td>

            <td class="px-4 py-4 hidden sm:table-cell">
                <p class="text-sm font-semibold text-gray-900
                           dark:text-white">
                    ${sale.items_count}
                    ${sale.items_count === 1 ? 'item' : 'items'}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400
                           truncate max-w-32">
                    ${_esc(itemsSummary)}${_esc(moreItems)}
                </p>
            </td>

            <td class="px-4 py-4 hidden md:table-cell">
                <span class="inline-flex items-center gap-1.5 px-2.5
                             py-1 rounded-full text-xs font-semibold
                             ${methodClass}">
                    ${methodIcon} ${_capitalize(sale.payment_method || 'N/A')}
                </span>
            </td>

            <td class="px-4 py-4 hidden md:table-cell">
                <span class="inline-flex items-center gap-1.5 px-2.5
                             py-1 rounded-full text-xs font-semibold
                             ${statusClass}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current
                                 opacity-70"></span>
                    ${_capitalize(sale.payment_status)}
                </span>
                ${outstanding > 0
                    ? `<p class="text-xs text-red-500 font-medium mt-0.5">
                           £${outstanding.toFixed(2)} owed
                       </p>`
                    : ''}
            </td>

            <td class="px-4 py-4 hidden lg:table-cell">
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                    £${parseFloat(sale.final_amount).toFixed(2)}
                </p>
                ${sale.discount > 0
                    ? `<p class="text-xs text-red-500">
                           -£${parseFloat(sale.discount).toFixed(2)} disc
                       </p>`
                    : ''}
            </td>

            <td class="px-4 py-4" onclick="event.stopPropagation()">
                <div class="flex items-center gap-1.5 opacity-0
                            group-hover:opacity-100 transition-opacity">
                    <a href="${sale.receipt_url}"
                       target="_blank"
                       class="w-7 h-7 rounded-lg flex items-center
                              justify-center bg-emerald-50
                              dark:bg-emerald-900/30 text-emerald-600
                              dark:text-emerald-400 hover:bg-emerald-100
                              transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2
                                     2 0 012-2h5.586a1 1 0 01.707.293l5.414
                                     5.414a1 1 0 01.293.707V19a2 2 0
                                     01-2 2z"/>
                        </svg>
                    </a>
                </div>
            </td>`;

        return tr;
    }

    // ─────────────────────────────────────────────────────────────
    // BUILD EXPAND ROW
    // ─────────────────────────────────────────────────────────────
    function _buildExpandRow(sale) {
        const tr     = document.createElement('tr');
        tr.id        = `expand-${sale.id}`;
        tr.className = 'sale-expand';

        const outstanding = sale.outstanding;
        const statusClass = _statusBadgeClass(sale.payment_status);
        const methodClass = _methodBadgeClass(sale.payment_method);
        const methodIcon  = _methodIcon(sale.payment_method);

        // Items HTML
        const itemsHtml = sale.items.map(item => `
            <div style="display:flex;justify-content:space-between;
                        align-items:center;gap:8px;margin-bottom:8px;">
                <div style="min-width:0;flex:1;">
                    <p style="font-size:0.8rem;font-weight:700;
                              color:#1e293b;margin:0;white-space:nowrap;
                              overflow:hidden;text-overflow:ellipsis;">
                        ${_esc(item.name)}
                    </p>
                    <p style="font-size:0.7rem;color:#94a3b8;margin:0;">
                        ${item.quantity} × £${parseFloat(item.price).toFixed(2)}
                    </p>
                </div>
                <span style="font-size:0.82rem;font-weight:800;
                             color:#6366f1;white-space:nowrap;">
                    £${parseFloat(item.line_total).toFixed(2)}
                </span>
            </div>`).join('');

        // Payments HTML
        const paymentsHtml = sale.payments.length > 0
            ? `<div style="margin-top:10px;padding-top:10px;
                           border-top:1px solid #f1f5f9;">
                   <p style="font-size:0.65rem;font-weight:700;
                             color:#94a3b8;text-transform:uppercase;
                             letter-spacing:0.05em;margin-bottom:6px;">
                       Payments
                   </p>
                   ${sale.payments.map(p => `
                       <div style="display:flex;justify-content:space-between;
                                   font-size:0.78rem;margin-bottom:4px;">
                           <span style="color:#6b7280;text-transform:capitalize;">
                               ${p.method === 'split' && p.split_part
                                   ? `${_capitalize(p.split_part)} (split)`
                                   : _capitalize(p.method)}
                               ${p.note
                                   ? `<span style="color:#cbd5e1;font-size:0.7rem;">
                                          — ${_esc(p.note)}
                                      </span>`
                                   : ''}
                           </span>
                           <span style="font-weight:700;color:#1e293b;">
                               £${parseFloat(p.amount).toFixed(2)}
                           </span>
                       </div>`).join('')}
               </div>`
            : '';

        tr.innerHTML = `
            <td colspan="8" class="px-0 py-0"
                style="background:linear-gradient(to bottom,
                       #f0f4ff 0%,#f8faff 100%);">
                <div style="border-top:3px solid #6366f1;
                            border-bottom:3px solid #e0e7ff;
                            padding:20px 24px;">

                    <div style="display:flex;align-items:center;
                                gap:8px;margin-bottom:16px;flex-wrap:wrap;">
                        <span style="background:#6366f1;color:#fff;
                                     padding:3px 12px;border-radius:999px;
                                     font-size:0.72rem;font-weight:800;">
                            ${_esc(sale.reference)}
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5
                                     py-1 rounded-full text-xs font-semibold
                                     ${statusClass}">
                            ${_capitalize(sale.payment_status)}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5
                                     py-1 rounded-full text-xs font-semibold
                                     ${methodClass}">
                            ${methodIcon} ${_capitalize(sale.payment_method || '')}
                        </span>
                        <div style="margin-left:auto;">
                            <a href="${sale.receipt_url}"
                               target="_blank"
                               onclick="event.stopPropagation()"
                               style="display:inline-flex;align-items:center;
                                      gap:4px;padding:6px 14px;
                                      border-radius:8px;font-size:0.75rem;
                                      font-weight:700;background:#6366f1;
                                      color:#fff;text-decoration:none;">
                                🖨 Receipt
                            </a>
                        </div>
                    </div>

                
                    <div style="display:grid;
                                grid-template-columns:repeat(auto-fit, minmax(260px,1fr));
                                gap:16px;">


                        <div style="background:#fff;border-radius:14px;
                                    padding:16px;border:1px solid #e0e7ff;
                                    box-shadow:0 1px 4px rgba(99,102,241,0.06);">
                            <p style="font-size:0.65rem;font-weight:700;
                                      color:#94a3b8;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:10px;">
                                Items (${sale.items_count})
                            </p>
                            ${itemsHtml}
                        </div>

                       
                        <div style="background:#fff;border-radius:14px;
                                    padding:16px;border:1px solid #e0e7ff;
                                    box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                            <p style="font-size:0.65rem;font-weight:700;
                                      color:#94a3b8;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:10px;">
                                Summary
                            </p>

                            <div style="display:flex;justify-content:space-between;
                                        font-size:0.78rem;margin-bottom:4px;">
                                <span style="color:#6b7280;">Subtotal</span>
                                <span style="font-weight:600;color:#1e293b;">
                                    £${parseFloat(sale.total_amount).toFixed(2)}
                                </span>
                            </div>

                            ${sale.discount > 0
                                ? `<div style="display:flex;justify-content:space-between;
                                              font-size:0.78rem;margin-bottom:4px;">
                                       <span style="color:#6b7280;">Discount</span>
                                       <span style="font-weight:700;color:#ef4444;">
                                           -£${parseFloat(sale.discount).toFixed(2)}
                                       </span>
                                   </div>`
                                : ''}

                            <div style="display:flex;justify-content:space-between;
                                        font-size:0.9rem;font-weight:800;
                                        padding:8px 0;margin:6px 0;
                                        border-top:2px solid #e0e7ff;
                                        border-bottom:2px solid #e0e7ff;">
                                <span style="color:#1e293b;">Total</span>
                                <span style="color:#6366f1;">
                                    £${parseFloat(sale.final_amount).toFixed(2)}
                                </span>
                            </div>

                            ${paymentsHtml}

                            ${outstanding > 0
                                ? `<div style="margin-top:8px;background:#fee2e2;
                                               border-radius:8px;padding:8px 10px;
                                               display:flex;justify-content:space-between;">
                                       <span style="color:#ef4444;font-weight:700;
                                                    font-size:0.78rem;">
                                           Outstanding
                                       </span>
                                       <span style="color:#ef4444;font-weight:800;
                                                    font-size:0.82rem;">
                                           £${outstanding.toFixed(2)}
                                       </span>
                                   </div>`
                                : `<div style="margin-top:8px;background:#dcfce7;
                                               border-radius:8px;padding:6px 10px;
                                               text-align:center;">
                                       <span style="color:#166534;font-weight:700;
                                                    font-size:0.75rem;">
                                           ✓ Fully Paid
                                       </span>
                                   </div>`
                            }

                            <div style="margin-top:10px;padding-top:8px;
                                        border-top:1px solid #f1f5f9;
                                        font-size:0.72rem;color:#94a3b8;">
                                Served by:
                                <strong style="color:#374151;">
                                    ${_esc(sale.created_by || 'Staff')}
                                </strong>
                            </div>

                        </div>

                    </div>
                </div>
            </td>`;

        return tr;
    }

    // ─────────────────────────────────────────────────────────────
    // TOGGLE ROW
    // ─────────────────────────────────────────────────────────────
    function toggleRow(saleId, rowEl) {
        const expandRow = document.getElementById(`expand-${saleId}`);
        const chevron   = document.getElementById(`chevron-${saleId}`);
        if (!expandRow) return;

        const isOpen = expandRow.classList.contains('open');

        if (isOpen) {
            expandRow.classList.remove('open');
            if (chevron) chevron.querySelector('svg').style.transform = '';
        } else {
            expandRow.classList.add('open');
            if (chevron) {
                chevron.querySelector('svg').style.transform = 'rotate(90deg)';
            }
        }
    }

    // ─────────────────────────────────────────────────────────────
    // FILTER TAGS
    // ─────────────────────────────────────────────────────────────
    function _renderFilterTags() {
        const wrapper   = document.getElementById('active-filters-wrapper');
        const container = document.getElementById('active-filters');
        if (!container || !wrapper) return;

        const tags = [];

        const search = document.getElementById('filter-search')?.value?.trim();
        if (search) {
            tags.push(`
                <span class="filter-tag">
                    🔍 "${_esc(search)}"
                    <button onclick="SalesIndex.clearSearch()"
                            style="border:none;background:transparent;
                                   cursor:pointer;padding:0;line-height:1;
                                   color:inherit;opacity:0.6;">✕</button>
                </span>`);
        }

        const status = document.getElementById('filter-payment-status')?.value;
        if (status) {
            const icons = {
                paid:'✅',partial:'🔵',pending:'🟡',refunded:'🔴'
            };
            tags.push(`
                <span class="filter-tag">
                    ${icons[status] || ''} ${_capitalize(status)}
                    <button onclick="SalesIndex.clearStatus()"
                            style="border:none;background:transparent;
                                   cursor:pointer;padding:0;line-height:1;
                                   color:inherit;opacity:0.6;">✕</button>
                </span>`);
        }

        const method = document.getElementById('filter-payment-method')?.value;
        if (method) {
            const icons = {
                cash:'💵',card:'💳',split:'✂️',trade:'🔄'
            };
            tags.push(`
                <span class="filter-tag">
                    ${icons[method] || ''} ${_capitalize(method)}
                    <button onclick="SalesIndex.clearMethod()"
                            style="border:none;background:transparent;
                                   cursor:pointer;padding:0;line-height:1;
                                   color:inherit;opacity:0.6;">✕</button>
                </span>`);
        }

        const dateFrom = document.getElementById('filter-date-from')?.value;
        const dateTo   = document.getElementById('filter-date-to')?.value;

        if (dateFrom) {
            tags.push(`
                <span class="filter-tag">
                    📅 From ${_formatDate(dateFrom)}
                    <button onclick="SalesIndex.clearDateFrom()"
                            style="border:none;background:transparent;
                                   cursor:pointer;padding:0;line-height:1;
                                   color:inherit;opacity:0.6;">✕</button>
                </span>`);
        }

        if (dateTo) {
            tags.push(`
                <span class="filter-tag">
                    📅 To ${_formatDate(dateTo)}
                    <button onclick="SalesIndex.clearDateTo()"
                            style="border:none;background:transparent;
                                   cursor:pointer;padding:0;line-height:1;
                                   color:inherit;opacity:0.6;">✕</button>
                </span>`);
        }

        if (tags.length > 0) {
            container.innerHTML = tags.join('') + `
                <button onclick="SalesIndex.clearAll()"
                        style="display:inline-flex;align-items:center;
                               gap:4px;padding:3px 10px;border-radius:999px;
                               font-size:0.72rem;font-weight:700;
                               background:#fee2e2;color:#ef4444;
                               border:1px solid #fecaca;cursor:pointer;">
                    ✕ Clear all
                </button>`;
            wrapper.style.display = 'flex';
        } else {
            container.innerHTML   = '';
            wrapper.style.display = 'none';
        }
    }

    // ─────────────────────────────────────────────────────────────
    // CLEAR FILTERS
    // ─────────────────────────────────────────────────────────────
    function clearSearch() {
        const el = document.getElementById('filter-search');
        if (el) el.value = '';
        _afterClear();
    }

    function clearStatus() {
        const el = document.getElementById('filter-payment-status');
        if (el) el.value = '';
        _afterClear();
    }

    function clearMethod() {
        const el = document.getElementById('filter-payment-method');
        if (el) el.value = '';
        _afterClear();
    }

    function clearDateFrom() {
        const el = document.getElementById('filter-date-from');
        if (el) el.value = '';
        _afterClear();
    }

    function clearDateTo() {
        const el = document.getElementById('filter-date-to');
        if (el) el.value = '';
        _afterClear();
    }

    function clearAll() {
        ['filter-search',
         'filter-payment-status',
         'filter-payment-method',
         'filter-date-from',
         'filter-date-to'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.value = '';
        });
        _afterClear();
    }

    function _afterClear() {
        state.currentPage = 1;
        _renderFilterTags();
        _fetchSales();
    }

    // ─────────────────────────────────────────────────────────────
    // PAGINATION
    // ─────────────────────────────────────────────────────────────
    function _renderPagination(pagination) {
        const wrapper = document.getElementById('pagination-wrapper');
        if (!wrapper) return;

        if (!pagination || pagination.last_page <= 1) {
            wrapper.style.display = 'none';
            return;
        }

        wrapper.style.display = 'block';

        let html = `
            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Page ${pagination.current_page} of ${pagination.last_page}
                </p>
                <div class="flex gap-2">`;

        if (pagination.current_page > 1) {
            html += `
                <button onclick="SalesIndex.goToPage(${pagination.current_page - 1})"
                        class="px-3 py-1.5 rounded-lg text-sm font-semibold
                               border border-gray-200 dark:border-gray-700
                               text-gray-600 dark:text-gray-400
                               hover:bg-gray-50 transition-all">
                    ← Prev
                </button>`;
        }

        for (let i = 1; i <= pagination.last_page; i++) {
            if (
                i === 1 ||
                i === pagination.last_page ||
                Math.abs(i - pagination.current_page) <= 1
            ) {
                html += `
                    <button onclick="SalesIndex.goToPage(${i})"
                            class="px-3 py-1.5 rounded-lg text-sm font-semibold
                                   transition-all
                                   ${i === pagination.current_page
                                       ? 'bg-indigo-600 text-white'
                                       : 'border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50'}">
                        ${i}
                    </button>`;
            } else if (Math.abs(i - pagination.current_page) === 2) {
                html += `<span class="px-2 py-1.5 text-gray-400">…</span>`;
            }
        }

        if (pagination.current_page < pagination.last_page) {
            html += `
                <button onclick="SalesIndex.goToPage(${pagination.current_page + 1})"
                        class="px-3 py-1.5 rounded-lg text-sm font-semibold
                               border border-gray-200 dark:border-gray-700
                               text-gray-600 dark:text-gray-400
                               hover:bg-gray-50 transition-all">
                    Next →
                </button>`;
        }

        html += `</div></div>`;
        wrapper.innerHTML = html;
    }

    function goToPage(page) {
        state.currentPage = page;
        _fetchSales();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // ─────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────
    function _showLoading(show) {
        const el = document.getElementById('loading-indicator');
        if (el) el.style.display = show ? 'flex' : 'none';
    }

    function _updateResultsInfo(from, to, total) {
        const el = document.getElementById('results-info');
        if (el) {
            el.textContent = total > 0
                ? `Showing ${from}–${to} of ${total} sales`
                : 'No sales found';
        }
    }

    function _statusBadgeClass(status) {
        const map = {
            paid     : 'badge-paid',
            partial  : 'badge-partial',
            pending  : 'badge-pending',
            refunded : 'badge-refunded',
        };
        return map[status] ?? 'badge-pending';
    }

    function _methodBadgeClass(method) {
        const map = {
            cash  : 'method-cash',
            card  : 'method-card',
            split : 'method-split',
            trade : 'method-trade',
            other : 'method-other',
        };
        return map[method] ?? 'method-other';
    }

    function _methodIcon(method) {
        const map = {
            cash  : '💵',
            card  : '💳',
            split : '✂️',
            trade : '🔄',
            other : '💰',
        };
        return map[method] ?? '💰';
    }

    function _formatDate(dateStr) {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-GB', {
            day  : '2-digit',
            month: 'short',
            year : 'numeric',
        });
    }

    function _capitalize(str) {
        if (!str) return '';
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function _esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    // ─────────────────────────────────────────────────────────────
    // PUBLIC API
    // ─────────────────────────────────────────────────────────────
    return {
        init,
        toggleRow,
        goToPage,
        clearSearch,
        clearStatus,
        clearMethod,
        clearDateFrom,
        clearDateTo,
        clearAll,
    };

})();