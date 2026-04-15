/**
 * Repair Index — Filters + Expandable Rows
 * Namespace: RepairIndex
 */
const RepairIndex = (() => {

    // ─────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────
    const state = {
        fetchUrl       : '',
        csrf           : '',
        selectedStatuses: new Set(),
        searchTimer    : null,
        expandedRows   : new Set(),
        currentPage    : 1,
        isLoading      : false,
    };

    // ─────────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────────
    function init(config) {
    state.fetchUrl = config.fetchUrl;
    state.csrf     = config.csrf;

    // Init all statuses as selected
    document.querySelectorAll('.status-option')
        .forEach(opt => {
            const id = parseInt(opt.dataset.statusId);
            if (id) state.selectedStatuses.add(id);
        });

    // Search debounce
    document.getElementById('filter-search')
        ?.addEventListener('input', () => {
            clearTimeout(state.searchTimer);
            state.searchTimer = setTimeout(() => {
                state.currentPage = 1;
                _fetchRepairs();
            }, 350);
        });

   

    // Dates
    document.getElementById('filter-date-from')
    ?.addEventListener('change', () => {
        state.currentPage = 1;
        _renderActiveFilterTags();
        _fetchRepairs();
    });

document.getElementById('filter-date-to')
    ?.addEventListener('change', () => {
        state.currentPage = 1;
        _renderActiveFilterTags();
        _fetchRepairs();
    });

    // Close dropdown on outside click
    document.addEventListener('click', (e) => {
        const wrap = document.getElementById('status-dropdown-wrap');
        if (wrap && !wrap.contains(e.target)) {
            _closeStatusDropdown();
        }
    });
}

    // ─────────────────────────────────────────────────────────────
    // STATUS CHIPS
    // ─────────────────────────────────────────────────────────────
    function toggleStatus(statusId, chipEl) {
        if (state.selectedStatuses.has(statusId)) {
            state.selectedStatuses.delete(statusId);
            chipEl.classList.remove('active');
        } else {
            state.selectedStatuses.add(statusId);
            chipEl.classList.add('active');
        }

        state.currentPage = 1;
        _fetchRepairs();
        _updateClearBtn();
    }

    // ─────────────────────────────────────────────────────────────
    // CLEAR FILTERS
    // ─────────────────────────────────────────────────────────────
    function clearFilters() {
    const searchInput = document.getElementById('filter-search');
    const dateFrom    = document.getElementById('filter-date-from');
    const dateTo      = document.getElementById('filter-date-to');
    if (searchInput) searchInput.value = '';
    if (dateFrom)    dateFrom.value    = '';
    if (dateTo)      dateTo.value      = '';

    selectAllStatuses();
}

    function _updateClearBtn() {
        const btn         = document.getElementById('clear-filters');
        const searchInput = document.getElementById('filter-search');
        const dateFrom    = document.getElementById('filter-date-from');
        const dateTo      = document.getElementById('filter-date-to');

        const hasSearch    = searchInput?.value?.trim().length > 0;
        const hasDate      = dateFrom?.value || dateTo?.value;
        const allActive    = document.querySelectorAll('.status-chip').length
                          === state.selectedStatuses.size;

        const hasFilters = hasSearch || hasDate || !allActive;

        if (btn) btn.style.display = hasFilters ? 'block' : 'none';
    }

    // ─────────────────────────────────────────────────────────────
    // FETCH REPAIRS (AJAX)
    // ─────────────────────────────────────────────────────────────
    async function _fetchRepairs() {
        if (state.isLoading) return;
        state.isLoading = true;

        _showLoading(true);

        // Build params
        const params = new URLSearchParams();

        const search = document.getElementById('filter-search')?.value?.trim();
        if (search) params.set('search', search);

        const dateFrom = document.getElementById('filter-date-from')?.value;
        const dateTo   = document.getElementById('filter-date-to')?.value;
        if (dateFrom) params.set('date_from', dateFrom);
        if (dateTo)   params.set('date_to',   dateTo);

        // Statuses
        if (state.selectedStatuses.size > 0) {
            params.set('statuses', [...state.selectedStatuses].join(','));
        }

        params.set('page', state.currentPage);

        // Update URL without reload
        const newUrl = `${window.location.pathname}?${params.toString()}`;
        window.history.replaceState({}, '', newUrl);

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
            console.error('Failed to fetch repairs:', e);
        } finally {
            state.isLoading = false;
            _showLoading(false);
            _updateClearBtn();
        }
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER TABLE FROM JSON
    // ─────────────────────────────────────────────────────────────
    function _renderTable(data) {
        const tbody = document.getElementById('repairs-tbody');
        if (!tbody) return;

        // Clear existing
        tbody.innerHTML = '';

        if (!data.repairs || data.repairs.length === 0) {
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
                                      d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002
                                         2h11a2 2 0 002-2v-5m-1.414-9.414a2
                                         2 0 112.828 2.828L11.828 15H9v-2.828
                                         l8.586-8.586z"/>
                            </svg>
                            <p class="text-sm font-semibold
                                       text-gray-500 dark:text-gray-400">
                                No repairs found
                            </p>
                            <p class="text-xs text-gray-400
                                       dark:text-gray-600 mt-1">
                                Try adjusting your filters
                            </p>
                        </div>
                    </td>
                </tr>`;

            _updateResultsInfo(0, 0, 0);
            _renderPagination(null);
            return;
        }

        // Render rows
        data.repairs.forEach(repair => {
            tbody.appendChild(_buildMainRow(repair));
            tbody.appendChild(_buildExpandRow(repair));
        });

        // Update info
        _updateResultsInfo(
            data.pagination.from,
            data.pagination.to,
            data.pagination.total
        );

        // Re-render pagination
        _renderPagination(data.pagination);
    }

    // ─────────────────────────────────────────────────────────────
// BUILD MAIN ROW
// ─────────────────────────────────────────────────────────────
function _buildMainRow(repair) {
    const tr     = document.createElement('tr');
    tr.className = 'repair-row group hover:bg-indigo-50/40 dark:hover:bg-indigo-900/10 transition-colors';
    tr.onclick   = () => toggleRow(repair.id, tr);

    const badgeClass  = _badgeClass(repair.status?.color ?? 'gray');
    const totalPaid   = repair.payments.reduce((s, p) => s + parseFloat(p.amount), 0);
    const outstanding = Math.max(0, parseFloat(repair.final_price) - totalPaid);

    const devicesSummary = repair.devices.slice(0, 2)
        .map(d => `
            <p class="text-xs font-medium text-gray-700
                       dark:text-gray-300 truncate max-w-36">
                📱 ${_esc(d.device_name || d.device_type || 'Device')}
            </p>`)
        .join('');

    const moreDevices = repair.devices.length > 2
        ? `<p class="text-xs text-gray-400 mt-0.5">
               +${repair.devices.length - 2} more
           </p>`
        : '';

    tr.innerHTML = `
        <td class="px-4 py-4 w-8">
            <div id="chevron-${repair.id}"
                 class="w-6 h-6 rounded-full flex items-center
                        justify-center bg-gray-100 dark:bg-gray-800
                        text-gray-400 transition-all
                        group-hover:bg-indigo-100
                        dark:group-hover:bg-indigo-900/40
                        group-hover:text-indigo-500">
                <svg class="w-3.5 h-3.5 transition-transform duration-200"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </td>

<td class="px-4 py-4">
    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
        ${_esc(repair.reference)}
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
        ${_esc(repair.created_at)}
    </p>
    ${repair.is_warranty_return
        ? `<div class="flex items-center gap-1.5 mt-1.5">
               <span class="inline-flex items-center gap-1 px-2 py-0.5
                            rounded-full text-xs font-bold
                            bg-amber-100 dark:bg-amber-900/40
                            text-amber-700 dark:text-amber-400">
                   🛡 Warranty
               </span>
               ${repair.parent_reference
                   ? `<a href="${repair.parent_url}"
                         onclick="event.stopPropagation()"
                         class="text-xs text-amber-600 hover:text-amber-800
                                font-semibold underline underline-offset-2">
                          ← ${_esc(repair.parent_reference)}
                      </a>`
                   : ''}
           </div>`
        : ''}
</td>

        <td class="px-4 py-4">
            ${repair.customer
                ? `<p class="text-sm font-semibold text-gray-900 dark:text-white">
                       ${_esc(repair.customer.name)}
                   </p>
                   ${repair.customer.phone
                       ? `<p class="text-xs text-gray-500 dark:text-gray-400">
                              ${_esc(repair.customer.phone)}
                          </p>`
                       : ''}`
                : `<span class="text-xs italic text-gray-400 dark:text-gray-600">
                       Walk-in
                   </span>`
            }
        </td>

        <td class="px-4 py-4 hidden sm:table-cell">
            ${devicesSummary}
            ${moreDevices}
            ${repair.devices.length === 0
                ? '<span class="text-xs text-gray-400">—</span>'
                : ''}
        </td>

        <td class="px-4 py-4 hidden md:table-cell">
            ${repair.status
                ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1
                               rounded-full text-xs font-semibold ${badgeClass}">
                       <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                       ${_esc(repair.status.name)}
                   </span>`
                : '<span class="text-xs text-gray-400">—</span>'
            }
        </td>

        <td class="px-4 py-4 hidden lg:table-cell">
            <p class="text-sm font-bold text-gray-900 dark:text-white">
                £${parseFloat(repair.final_price).toFixed(2)}
            </p>
            ${outstanding > 0
                ? `<p class="text-xs text-red-500 font-medium">
                       £${outstanding.toFixed(2)} owed
                   </p>`
                : `<p class="text-xs text-emerald-500 font-medium">Paid</p>`
            }
        </td>

        <td class="px-4 py-4 hidden xl:table-cell">
            ${repair.assigned_to
                ? `<div class="flex items-center gap-2">
                       <div class="w-6 h-6 rounded-full bg-indigo-500
                                   flex items-center justify-center
                                   text-white text-xs font-bold">
                           ${_esc(repair.assigned_to.charAt(0).toUpperCase())}
                       </div>
                       <span class="text-xs font-medium text-gray-700
                                    dark:text-gray-300 truncate max-w-24">
                           ${_esc(repair.assigned_to)}
                       </span>
                   </div>`
                : `<span class="text-xs italic text-gray-400">Unassigned</span>`
            }
        </td>

        <td class="px-4 py-4" onclick="event.stopPropagation()">
    <div class="flex items-center gap-1.5 opacity-0
                group-hover:opacity-100 transition-opacity">

        <a href="${repair.show_url}"
           title="View"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-indigo-50 dark:bg-indigo-900/30
                  text-indigo-600 dark:text-indigo-400
                  hover:bg-indigo-100 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458
                         12C3.732 7.943 7.523 5 12 5c4.478 0
                         8.268 2.943 9.542 7-1.274 4.057-5.064
                         7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>

        <a href="${repair.receipt_url}"
           target="_blank"
           title="Print Receipt"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-emerald-50 dark:bg-emerald-900/30
                  text-emerald-600 dark:text-emerald-400
                  hover:bg-emerald-100 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2
                         2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0
                         002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2
                         2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0
                         00-2 2v4h10z"/>
            </svg>
        </a>

    </div>
</td>`;

    return tr;
}

// ─────────────────────────────────────────────────────────────
// BUILD EXPAND ROW
// ─────────────────────────────────────────────────────────────
function _buildExpandRow(repair) {
    const tr     = document.createElement('tr');
    tr.id        = `expand-${repair.id}`;
    tr.className = 'repair-expand';

    const totalPaid   = repair.payments.reduce((s, p) => s + parseFloat(p.amount), 0);
    const outstanding = Math.max(0, parseFloat(repair.final_price) - totalPaid);
    const badgeClass  = _badgeClass(repair.status?.color ?? 'gray');

    // ── Devices HTML ──────────────────────────────
    const devicesHtml = repair.devices.map(device => {
        const partsHtml = device.parts.length > 0
            ? `<div style="grid-column:1/-1;">
                   <p style="color:#94a3b8;font-weight:700;font-size:0.65rem;
                             text-transform:uppercase;letter-spacing:0.05em;
                             margin-bottom:4px;">
                       Parts Used
                   </p>
                   <div style="display:flex;flex-wrap:wrap;gap:4px;">
                       ${device.parts.map(p => `
                           <span style="background:#eef2ff;color:#4338ca;
                                        font-size:0.7rem;font-weight:700;
                                        padding:2px 8px;border-radius:6px;">
                               ${_esc(p.name)}
                               ${p.quantity > 1
                                   ? `<span style="opacity:0.6;">×${p.quantity}</span>`
                                   : ''}
                           </span>`).join('')}
                   </div>
               </div>`
            : '';

        const warrantyStyle = device.warranty === 'Under Warranty'
            ? 'background:#dcfce7;color:#166534;'
            : device.warranty === 'Warranty Expired'
                ? 'background:#fee2e2;color:#991b1b;'
                : 'background:#f1f5f9;color:#475569;';

        const meta = [
            device.device_type,
            device.color,
            device.imei ? `IMEI: ${device.imei}` : null
        ].filter(Boolean).join(' · ');

        return `
            <div style="background:#fff;border-radius:14px;padding:16px;
                        border:1px solid #e0e7ff;
                        box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                <div style="display:flex;align-items:center;gap:8px;
                            margin-bottom:12px;padding-bottom:10px;
                            border-bottom:1px solid #f1f5f9;">
                    <span style="font-size:1.2rem;">📱</span>
                    <div style="min-width:0;flex:1;">
                        <p style="font-size:0.82rem;font-weight:800;
                                  color:#1e293b;margin:0;white-space:nowrap;
                                  overflow:hidden;text-overflow:ellipsis;">
                            ${_esc(device.device_name || 'Device')}
                        </p>
                        <p style="font-size:0.7rem;color:#94a3b8;margin:0;">
                            ${_esc(meta || '—')}
                        </p>
                    </div>
                    <span style="font-size:0.8rem;font-weight:800;
                                 color:#6366f1;white-space:nowrap;
                                 flex-shrink:0;">
                        £${parseFloat(device.price || 0).toFixed(2)}
                    </span>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;
                            gap:8px;font-size:0.75rem;">

                    ${device.issue ? `
                        <div style="grid-column:1/-1;">
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Issues
                            </p>
                            <p style="color:#374151;font-weight:600;margin:0;">
                                ${_esc(device.issue)}
                            </p>
                        </div>` : ''}

                    ${device.repair_type ? `
                        <div>
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Repair Type
                            </p>
                            <p style="color:#374151;font-weight:600;margin:0;">
                                ${_esc(device.repair_type)}
                            </p>
                        </div>` : ''}

                    <div>
                        <p style="color:#94a3b8;font-weight:700;
                                  font-size:0.65rem;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:2px;">
                            Warranty
                        </p>
                        <span style="font-size:0.7rem;font-weight:700;
                                     padding:2px 8px;border-radius:999px;
                                     ${warrantyStyle}">
                            ${_esc(device.warranty || 'No Warranty')}
                        </span>
                    </div>

                    ${partsHtml}

                </div>
            </div>`;
    }).join('');

    // ── Payments HTML ─────────────────────────────
    const paymentsHtml = repair.payments.length > 0
        ? `<div style="margin-bottom:12px;padding-bottom:12px;
                       border-bottom:1px solid #f1f5f9;">
               <p style="font-size:0.65rem;font-weight:700;color:#94a3b8;
                         text-transform:uppercase;letter-spacing:0.05em;
                         margin-bottom:8px;">
                   Payments
               </p>
               ${repair.payments.map(p => `
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

    // ── Status badge for header ───────────────────
    const statusBadge = repair.status
        ? `<span class="inline-flex items-center gap-1 px-2.5 py-1
                        rounded-full text-xs font-semibold ${badgeClass}">
               ${_esc(repair.status.name)}
           </span>`
        : '';

    tr.innerHTML = `
        <td colspan="8" class="px-0 py-0"
            style="background:linear-gradient(to bottom,
                   #f0f4ff 0%, #f8faff 100%);">
            <div style="border-top:3px solid #6366f1;
                        border-bottom:3px solid #e0e7ff;
                        padding:20px 24px;">

                  
                <div style="display:flex;align-items:center;
                            gap:8px;margin-bottom:16px;
                            flex-wrap:wrap;">
                    <span style="background:#6366f1;color:#fff;
                                 padding:3px 12px;border-radius:999px;
                                 font-size:0.72rem;font-weight:800;
                                 letter-spacing:0.05em;">
                        ${_esc(repair.reference)}
                    </span>
                    ${statusBadge}
                    ${repair.delivery_type
                        ? `<span style="font-size:0.72rem;font-weight:700;
                                        padding:3px 10px;border-radius:999px;
                                        background:#f1f5f9;color:#475569;">
                               ${_esc(repair.delivery_type)}
                           </span>`
                        : ''}
                    <div style="margin-left:auto;display:flex;
                                align-items:center;gap:8px;">
                        ${repair.assigned_to
                            ? `<span style="font-size:0.75rem;color:#94a3b8;">
                                   Assigned to
                                   <strong style="color:#374151;">
                                       ${_esc(repair.assigned_to)}
                                   </strong>
                               </span>`
                            : ''}
                        <a href="${repair.show_url}"
                           onclick="event.stopPropagation()"
                           style="display:inline-flex;align-items:center;
                                  gap:4px;padding:6px 14px;
                                  border-radius:8px;font-size:0.75rem;
                                  font-weight:700;background:#6366f1;
                                  color:#fff;text-decoration:none;
                                  transition:background 0.15s;"
                           onmouseover="this.style.background='#4f46e5'"
                           onmouseout="this.style.background='#6366f1'">
                            View Full →
                        </a>
                    </div>
                </div>

                
                <div style="display:grid;
                            grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
                            gap:16px;">

                    ${devicesHtml}

                    <div style="background:#fff;border-radius:14px;
                                padding:16px;border:1px solid #e0e7ff;
                                box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                      
                        <div style="padding-bottom:12px;margin-bottom:12px;
                                    border-bottom:1px solid #f1f5f9;">
                            <p style="font-size:0.65rem;font-weight:700;
                                      color:#94a3b8;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:8px;">
                                Pricing
                            </p>
                            <div style="display:flex;justify-content:space-between;
                                        font-size:0.78rem;margin-bottom:4px;">
                                <span style="color:#6b7280;">Total</span>
                                <span style="font-weight:800;color:#1e293b;">
                                    £${parseFloat(repair.final_price).toFixed(2)}
                                </span>
                            </div>
                            ${totalPaid > 0
                                ? `<div style="display:flex;justify-content:space-between;
                                              font-size:0.78rem;margin-bottom:4px;">
                                       <span style="color:#6b7280;">Paid</span>
                                       <span style="font-weight:700;color:#10b981;">
                                           £${totalPaid.toFixed(2)}
                                       </span>
                                   </div>`
                                : ''}
                            ${outstanding > 0
                                ? `<div style="display:flex;justify-content:space-between;
                                              font-size:0.78rem;padding:6px 8px;
                                              background:#fee2e2;border-radius:8px;
                                              margin-top:4px;">
                                       <span style="color:#ef4444;font-weight:700;">
                                           Outstanding
                                       </span>
                                       <span style="font-weight:800;color:#ef4444;">
                                           £${outstanding.toFixed(2)}
                                       </span>
                                   </div>`
                                : `<div style="display:flex;justify-content:space-between;
                                              font-size:0.78rem;padding:6px 8px;
                                              background:#dcfce7;border-radius:8px;
                                              margin-top:4px;">
                                       <span style="color:#166534;font-weight:700;">
                                           Fully Paid
                                       </span>
                                       <span style="font-weight:800;color:#166534;">✓</span>
                                   </div>`
                            }
                        </div>

                        ${paymentsHtml}

                        <div>
                            <p style="font-size:0.65rem;font-weight:700;
                                      color:#94a3b8;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:8px;">
                                Info
                            </p>
                            <div style="display:grid;grid-template-columns:1fr 1fr;
                                        gap:6px;font-size:0.75rem;">
                                <div>
                                    <p style="color:#94a3b8;font-size:0.65rem;
                                              font-weight:700;margin-bottom:1px;">
                                        Book-in
                                    </p>
                                    <p style="color:#374151;font-weight:600;margin:0;">
                                        ${_esc(repair.book_in_date || '—')}
                                    </p>
                                </div>
                                ${repair.completion_date
                                    ? `<div>
                                           <p style="color:#94a3b8;font-size:0.65rem;
                                                     font-weight:700;margin-bottom:1px;">
                                               Due
                                           </p>
                                           <p style="color:#374151;font-weight:600;margin:0;">
                                               ${_esc(repair.completion_date)}
                                           </p>
                                       </div>`
                                    : ''}
                                <div>
                                    <p style="color:#94a3b8;font-size:0.65rem;
                                              font-weight:700;margin-bottom:1px;">
                                        Created by
                                    </p>
                                    <p style="color:#374151;font-weight:600;margin:0;">
                                        ${_esc(repair.created_by || '—')}
                                    </p>
                                </div>
                            </div>
                        </div>

                        ${repair.notes
                            ? `<div style="margin-top:10px;background:#fffbeb;
                                           border-radius:8px;padding:8px 10px;
                                           border:1px solid #fde68a;">
                                   <p style="font-size:0.65rem;font-weight:700;
                                             color:#92400e;text-transform:uppercase;
                                             letter-spacing:0.05em;margin-bottom:2px;">
                                       Notes
                                   </p>
                                   <p style="font-size:0.75rem;color:#78350f;margin:0;">
                                       ${_esc(repair.notes)}
                                   </p>
                               </div>`
                            : ''}

                    </div>

                </div>
            </div>
        </td>`;

    return tr;
}

    // ─────────────────────────────────────────────────────────────
    // TOGGLE ROW EXPAND
    // ─────────────────────────────────────────────────────────────
    function toggleRow(repairId, rowEl) {
        const expandRow = document.getElementById(`expand-${repairId}`);
        const chevron   = document.getElementById(`chevron-${repairId}`);

        if (!expandRow) return;

        const isOpen = expandRow.classList.contains('open');

        if (isOpen) {
            expandRow.classList.remove('open');
            if (chevron) chevron.querySelector('svg').style.transform = '';
            state.expandedRows.delete(repairId);
        } else {
            expandRow.classList.add('open');
            if (chevron) {
                chevron.querySelector('svg').style.transform = 'rotate(90deg)';
            }
            state.expandedRows.add(repairId);
        }
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

        let html = `<div class="flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Page ${pagination.current_page} of ${pagination.last_page}
            </p>
            <div class="flex gap-2">`;

        // Prev
        if (pagination.current_page > 1) {
            html += `<button onclick="RepairIndex.goToPage(${pagination.current_page - 1})"
                             class="px-3 py-1.5 rounded-lg text-sm font-semibold
                                    border border-gray-200 dark:border-gray-700
                                    text-gray-600 dark:text-gray-400
                                    hover:bg-gray-50 dark:hover:bg-gray-800
                                    transition-all">
                         ← Prev
                     </button>`;
        }

        // Pages
        for (let i = 1; i <= pagination.last_page; i++) {
            if (
                i === 1 ||
                i === pagination.last_page ||
                Math.abs(i - pagination.current_page) <= 1
            ) {
                html += `<button onclick="RepairIndex.goToPage(${i})"
                                 class="px-3 py-1.5 rounded-lg text-sm
                                        font-semibold transition-all
                                        ${i === pagination.current_page
                                            ? 'bg-indigo-600 text-white'
                                            : 'border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800'
                                        }">
                             ${i}
                         </button>`;
            } else if (Math.abs(i - pagination.current_page) === 2) {
                html += `<span class="px-2 py-1.5 text-gray-400">…</span>`;
            }
        }

        // Next
        if (pagination.current_page < pagination.last_page) {
            html += `<button onclick="RepairIndex.goToPage(${pagination.current_page + 1})"
                             class="px-3 py-1.5 rounded-lg text-sm font-semibold
                                    border border-gray-200 dark:border-gray-700
                                    text-gray-600 dark:text-gray-400
                                    hover:bg-gray-50 dark:hover:bg-gray-800
                                    transition-all">
                         Next →
                     </button>`;
        }

        html += `</div></div>`;
        wrapper.innerHTML = html;
    }

    function goToPage(page) {
        state.currentPage = page;
        _fetchRepairs();
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
                ? `Showing ${from}–${to} of ${total} repairs`
                : 'No repairs found';
        }
    }

    function _badgeClass(color) {
        const map = {
            green  : 'badge-green',
            blue   : 'badge-blue',
            yellow : 'badge-yellow',
            orange : 'badge-orange',
            red    : 'badge-red',
            purple : 'badge-purple',
            gray   : 'badge-gray',
        };
        return map[color] ?? map.gray;
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
// STATUS DROPDOWN
// ─────────────────────────────────────────────────────────────
function toggleStatusDropdown() {
    const panel   = document.getElementById('status-dropdown-panel');
    const chevron = document.getElementById('status-chevron');
    const isOpen  = panel.style.display !== 'none';

    if (isOpen) {
        _closeStatusDropdown();
    } else {
        panel.style.display = 'block';
        if (chevron) chevron.style.transform = 'rotate(180deg)';
    }
}

function _closeStatusDropdown() {
    const panel   = document.getElementById('status-dropdown-panel');
    const chevron = document.getElementById('status-chevron');
    if (panel)   panel.style.display   = 'none';
    if (chevron) chevron.style.transform = '';
}

function toggleStatus(statusId, optionEl) {
    const checkEl = document.getElementById(`status-check-${statusId}`);

    if (state.selectedStatuses.has(statusId)) {
        state.selectedStatuses.delete(statusId);
        optionEl.classList.remove('selected');
        // Uncheck
        if (checkEl) {
            checkEl.style.background    = 'transparent';
            checkEl.querySelector('svg').style.display = 'none';
        }
    } else {
        state.selectedStatuses.add(statusId);
        optionEl.classList.add('selected');
        // Check
        const color = _getStatusColor(statusId);
        if (checkEl) {
            checkEl.style.background    = color;
            const svg = checkEl.querySelector('svg');
            if (svg) svg.style.display  = 'block';
        }
    }

    _updateStatusBtnLabel();
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function selectAllStatuses() {
    document.querySelectorAll('.status-option').forEach(opt => {
        const id = parseInt(opt.dataset.statusId);
        if (id) {
            state.selectedStatuses.add(id);
            opt.classList.add('selected');
            const checkEl = document.getElementById(`status-check-${id}`);
            const color   = _getStatusColor(id);
            if (checkEl) {
                checkEl.style.background = color;
                const svg = checkEl.querySelector('svg');
                if (svg) svg.style.display = 'block';
            }
        }
    });
    _updateStatusBtnLabel();
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function clearAllStatuses() {
    document.querySelectorAll('.status-option').forEach(opt => {
        const id = parseInt(opt.dataset.statusId);
        if (id) {
            state.selectedStatuses.delete(id);
            opt.classList.remove('selected');
            const checkEl = document.getElementById(`status-check-${id}`);
            if (checkEl) {
                checkEl.style.background = 'transparent';
                const svg = checkEl.querySelector('svg');
                if (svg) svg.style.display = 'none';
            }
        }
    });
    _updateStatusBtnLabel();
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function _updateStatusBtnLabel() {
    const label    = document.getElementById('status-btn-label');
    const total    = document.querySelectorAll('.status-option').length;
    const selected = state.selectedStatuses.size;

    if (!label) return;

    if (selected === 0) {
        label.textContent = 'No Status';
    } else if (selected === total) {
        label.textContent = 'All Statuses';
    } else {
        label.textContent = `${selected} Selected`;
    }
}

function _getStatusColor(statusId) {
    const opt = document.querySelector(
        `.status-option[data-status-id="${statusId}"]`
    );
    if (!opt) return '#6366f1';

    const colorMap = {
        green  : '#10b981',
        blue   : '#3b82f6',
        yellow : '#f59e0b',
        orange : '#f97316',
        red    : '#ef4444',
        purple : '#8b5cf6',
        gray   : '#6b7280',
    };

    return colorMap[opt.dataset.statusColor] || '#6b7280';
}

// ─────────────────────────────────────────────────────────────
// ACTIVE FILTER TAGS
// ─────────────────────────────────────────────────────────────
function _renderActiveFilterTags() {
    const wrapper    = document.getElementById('active-filters-wrapper');
    const container  = document.getElementById('active-filters');
    if (!container || !wrapper) return;

    const tags = [];

    // Search tag
    const search = document.getElementById('filter-search')?.value?.trim();
    if (search) {
        tags.push(`
            <span class="filter-tag">
                🔍 "${_esc(search)}"
                <button onclick="RepairIndex.clearSearch()"
                        style="border:none;background:transparent;
                               cursor:pointer;padding:0;line-height:1;
                               color:inherit;opacity:0.6;margin-left:2px;"
                        onmouseover="this.style.opacity=1"
                        onmouseout="this.style.opacity=0.6">✕</button>
            </span>`);
    }

    // Date tags
    const dateFrom = document.getElementById('filter-date-from')?.value;
    const dateTo   = document.getElementById('filter-date-to')?.value;

    if (dateFrom) {
        const formatted = _formatDate(dateFrom);
        tags.push(`
            <span class="filter-tag">
                📅 From ${formatted}
                <button onclick="RepairIndex.clearDateFrom()"
                        style="border:none;background:transparent;
                               cursor:pointer;padding:0;line-height:1;
                               color:inherit;opacity:0.6;margin-left:2px;"
                        onmouseover="this.style.opacity=1"
                        onmouseout="this.style.opacity=0.6">✕</button>
            </span>`);
    }

    if (dateTo) {
        const formatted = _formatDate(dateTo);
        tags.push(`
            <span class="filter-tag">
                📅 To ${formatted}
                <button onclick="RepairIndex.clearDateTo()"
                        style="border:none;background:transparent;
                               cursor:pointer;padding:0;line-height:1;
                               color:inherit;opacity:0.6;margin-left:2px;"
                        onmouseover="this.style.opacity=1"
                        onmouseout="this.style.opacity=0.6">✕</button>
            </span>`);
    }

    // Status tags — only show if NOT all selected
    const totalStatuses = document.querySelectorAll('.status-option').length;
    if (state.selectedStatuses.size > 0 &&
        state.selectedStatuses.size < totalStatuses) {
        state.selectedStatuses.forEach(id => {
            const opt = document.querySelector(
                `.status-option[data-status-id="${id}"]`
            );
            if (opt) {
                const color = _getStatusColor(id);
                tags.push(`
                    <span style="display:inline-flex;align-items:center;
                                 gap:5px;padding:3px 10px;border-radius:999px;
                                 font-size:0.72rem;font-weight:700;
                                 background:${color}18;color:${color};
                                 border:1px solid ${color}40;
                                 white-space:nowrap;">
                        <span style="width:6px;height:6px;border-radius:50%;
                                     background:${color};display:inline-block;
                                     flex-shrink:0;">
                        </span>
                        ${_esc(opt.dataset.statusName)}
                        <button onclick="RepairIndex.removeStatusTag(${id})"
                                style="border:none;background:transparent;
                                       cursor:pointer;padding:0;line-height:1;
                                       color:${color};opacity:0.6;margin-left:2px;"
                                onmouseover="this.style.opacity=1"
                                onmouseout="this.style.opacity=0.6">✕</button>
                    </span>`);
            }
        });
    }

    if (tags.length > 0) {
        container.innerHTML = tags.join('');

        // Add clear all button at end
        container.innerHTML += `
            <button onclick="RepairIndex.clearFilters()"
                    style="display:inline-flex;align-items:center;gap:4px;
                           padding:3px 10px;border-radius:999px;
                           font-size:0.72rem;font-weight:700;
                           background:#fee2e2;color:#ef4444;
                           border:1px solid #fecaca;cursor:pointer;
                           white-space:nowrap;transition:all 0.15s;"
                    onmouseover="this.style.background='#fecaca'"
                    onmouseout="this.style.background='#fee2e2'">
                ✕ Clear all
            </button>`;

        wrapper.style.display = 'flex';
    } else {
        container.innerHTML    = '';
        wrapper.style.display  = 'none';
    }
}
function clearSearch() {
    const input = document.getElementById('filter-search');
    if (input) input.value = '';
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function clearDateFrom() {
    const input = document.getElementById('filter-date-from');
    if (input) input.value = '';
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function clearDateTo() {
    const input = document.getElementById('filter-date-to');
    if (input) input.value = '';
    _renderActiveFilterTags();
    state.currentPage = 1;
    _fetchRepairs();
}

function removeStatusTag(statusId) {
    const opt = document.querySelector(
        `.status-option[data-status-id="${statusId}"]`
    );
    if (opt) toggleStatus(statusId, opt);
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
    // ─────────────────────────────────────────────────────────────
    // PUBLIC API
    // ─────────────────────────────────────────────────────────────
   return {
    init,
    toggleStatus,
    toggleStatusDropdown,
    selectAllStatuses,
    clearAllStatuses,
    removeStatusTag,
    toggleRow,
    clearFilters,
    clearSearch,
    clearDateFrom,
    clearDateTo,
    goToPage,
};

})();