/**
 * POS System — Main JavaScript Module
 * All logic is namespaced under window.POS
 * No global variable pollution
 */

// Add slideUp animation
const slideUpStyle = document.createElement('style');
slideUpStyle.textContent = `
    @keyframes slideUp {
        from { transform: translateX(-50%) translateY(20px); opacity: 0; }
        to   { transform: translateX(-50%) translateY(0);    opacity: 1; }
    }
`;
document.head.appendChild(slideUpStyle);

const POS = (() => {

    // ─────────────────────────────────────────────────────────────
    // STATE
    // ─────────────────────────────────────────────────────────────
    const state = {
        cart            : [],
        allProducts     : [],
        allCustomers    : [],
        selectedCustomer: null,
        discountAmount  : 0,
        discountType    : 'percent',
        selectedMethod  : 'cash',
        navState        : null,   // null | {type:'category',...} | {type:'brand',...}
        config          : {},
    };

    // ─────────────────────────────────────────────────────────────
    // CONSTANTS
    // ─────────────────────────────────────────────────────────────
    const CATEGORY_ICONS = {
        'screen-protectors' : '🛡️',
        'phone-cases'       : '📱',
        'cables-chargers'   : '🔌',
        'repair-parts'      : '🔧',
        'accessories'       : '🎧',
        'second-hand-phones': '♻️',
    };

    const BRAND_COLORS = {
        'apple'   : { bg: '#f1f5f9', text: '#1e293b' },
        'samsung' : { bg: '#eff6ff', text: '#1d4ed8' },
        'google'  : { bg: '#fef9c3', text: '#713f12' },
        'oneplus' : { bg: '#fff1f2', text: '#be123c' },
        'xiaomi'  : { bg: '#fff7ed', text: '#9a3412' },
        'generic' : { bg: '#f8fafc', text: '#475569' },
    };

    // ─────────────────────────────────────────────────────────────
    // INIT
    // ─────────────────────────────────────────────────────────────
    function init(config) {
        state.config = config;
        _loadCategories();
        _loadCustomers();

        // Close customer dropdown on outside click
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#cartCustomerWrap')) {
                _el('customerDropdown').style.display = 'none';
            }
        });
    }

    // ─────────────────────────────────────────────────────────────
    // HELPERS
    // ─────────────────────────────────────────────────────────────
    function _el(id) {
        return document.getElementById(id);
    }

    function _escHtml(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    function _fmt(amount) {
        return '£' + parseFloat(amount).toFixed(2);
    }

    function _sep() {
        return `<svg width="12" height="12" fill="none" stroke="#cbd5e1"
                     viewBox="0 0 24 24" style="flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>`;
    }

    // ─────────────────────────────────────────────────────────────
    // API CALLS
    // ─────────────────────────────────────────────────────────────
    async function _fetch(url) {
        const res = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        return res.json();
    }

    async function _post(url, data) {
        const res = await fetch(url, {
            method  : 'POST',
            headers : {
                'Content-Type'     : 'application/json',
                'X-CSRF-TOKEN'     : state.config.csrf,
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
            body: JSON.stringify(data),
        });
        return res.json();
    }

    // ─────────────────────────────────────────────────────────────
    // NAVIGATION
    // ─────────────────────────────────────────────────────────────
    function goHome() {
        state.navState = null;
        _updateBreadcrumb();
        _loadCategories();
        _el('searchProduct').value = '';
        _el('clearSearchBtn').style.display = 'none';
    }

    function goBack() {
        if (!state.navState) return;

        if (state.navState.type === 'brand') {
            state.navState = {
                type : 'category',
                id   : state.navState.categoryId,
                name : state.navState.categoryName,
            };
            _updateBreadcrumb();
            _loadBrands(state.navState.id);
        } else {
            goHome();
        }
    }

    async function selectCategory(id, name) {
        state.navState = { type: 'category', id, name };
        _updateBreadcrumb();
        await _loadBrands(id);
    }

    async function selectBrand(id, name) {
        state.navState = {
            type         : 'brand',
            categoryId   : state.navState.id,
            categoryName : state.navState.name,
            brandId      : id,
            name         : name,
        };
        _updateBreadcrumb();
        await _loadProducts(state.navState.categoryId, id);
    }

    function _updateBreadcrumb() {
        const bc      = _el('breadcrumb');
        const backBtn = _el('btnBack');

        if (!state.navState) {
            bc.innerHTML = `<span style="color:#6366f1;font-weight:700;cursor:pointer;"
                                  onclick="POS.goHome()">All</span>`;
            backBtn.style.display = 'none';
            return;
        }

        backBtn.style.display = 'flex';

        if (state.navState.type === 'category') {
            bc.innerHTML = `
                <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                      onclick="POS.goHome()">All</span>
                ${_sep()}
                <span style="color:#475569;font-weight:700;
                             white-space:nowrap;overflow:hidden;
                             text-overflow:ellipsis;"
                      class="dark:text-gray-300">
                    ${_escHtml(state.navState.name)}
                </span>`;
        } else {
            bc.innerHTML = `
                <span style="color:#6366f1;font-weight:700;cursor:pointer;"
                      onclick="POS.goHome()">All</span>
                ${_sep()}
                <span style="color:#6366f1;font-weight:700;cursor:pointer;
                             white-space:nowrap;"
                      onclick="POS.selectCategory(
                          ${state.navState.categoryId},
                          '${_escHtml(state.navState.categoryName)}'
                      )">
                    ${_escHtml(state.navState.categoryName)}
                </span>
                ${_sep()}
                <span style="color:#475569;font-weight:700;
                             white-space:nowrap;overflow:hidden;
                             text-overflow:ellipsis;"
                      class="dark:text-gray-300">
                    ${_escHtml(state.navState.name)}
                </span>`;
        }
    }

    // ─────────────────────────────────────────────────────────────
    // LOAD DATA
    // ─────────────────────────────────────────────────────────────
    async function _loadCategories() {
        _showLoading(true);
        try {
            const cats = await _fetch(state.config.routes.categories);
            _renderCategories(cats);
        } catch (e) {
            console.error('Failed to load categories:', e);
            _showEmpty(true);
        } finally {
            _showLoading(false);
        }
    }

    async function _loadBrands(categoryId) {
        _showLoading(true);
        try {
            const brands = await _fetch(
                `${state.config.routes.brands}?category_id=${categoryId}`
            );

            if (!brands || brands.length === 0) {
                await _loadProducts(categoryId, null);
                return;
            }

            _renderBrands(brands);
        } catch (e) {
            console.error('Failed to load brands:', e);
        } finally {
            _showLoading(false);
        }
    }

    async function _loadProducts(categoryId, brandId, search) {
        _showLoading(true);
        try {
            const params = new URLSearchParams();
            if (categoryId) params.set('category_id', categoryId);
            if (brandId)    params.set('brand_id',    brandId);
            if (search)     params.set('search',      search);

            state.allProducts = await _fetch(
                `${state.config.routes.products}?${params}`
            );
            _renderProducts(state.allProducts);
        } catch (e) {
            console.error('Failed to load products:', e);
        } finally {
            _showLoading(false);
        }
    }

    async function _loadCustomers() {
        try {
            state.allCustomers = await _fetch(state.config.routes.customers);
        } catch (e) {
            console.error('Failed to load customers:', e);
        }
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER — CATEGORIES
    // ─────────────────────────────────────────────────────────────
    function _renderCategories(cats) {
        const grid = _el('mainGrid');
        grid.innerHTML = '';

        if (!cats || cats.length === 0) {
            _showEmpty(true);
            return;
        }

        _showEmpty(false);
        grid.style.display = 'grid';

        cats.forEach(cat => {
            const icon = CATEGORY_ICONS[cat.slug] || '📦';
            const div  = document.createElement('div');
            div.className = 'pos-card';
            div.onclick   = () => selectCategory(cat.id, cat.name);
            div.innerHTML = `
                <span style="font-size:1.8rem;line-height:1;">${icon}</span>
                <span style="font-size:0.72rem;font-weight:700;color:#475569;
                             text-align:center;line-height:1.3;
                             display:-webkit-box;-webkit-line-clamp:2;
                             -webkit-box-orient:vertical;overflow:hidden;"
                      class="dark:text-gray-400">
                    ${_escHtml(cat.name)}
                </span>`;
            grid.appendChild(div);
        });
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER — BRANDS
    // ─────────────────────────────────────────────────────────────
    function _renderBrands(brands) {
        const grid = _el('mainGrid');
        grid.innerHTML = '';
        _showEmpty(false);
        grid.style.display = 'grid';

        brands.forEach(brand => {
            const colors = BRAND_COLORS[brand.slug] || BRAND_COLORS['generic'];
            const div    = document.createElement('div');
            div.className  = 'pos-card';
            div.style.background = colors.bg;
            div.onclick    = () => selectBrand(brand.id, brand.name);
            div.innerHTML  = `
                <div style="width:40px;height:40px;border-radius:12px;
                            background:#fff;display:flex;align-items:center;
                            justify-content:center;
                            box-shadow:0 2px 8px rgba(0,0,0,0.08);
                            border:1px solid rgba(0,0,0,0.06);">
                    <span style="font-size:0.75rem;font-weight:900;
                                 color:${colors.text};">
                        ${_escHtml(brand.name.substring(0, 2).toUpperCase())}
                    </span>
                </div>
                <span style="font-size:0.72rem;font-weight:700;
                             color:${colors.text};text-align:center;">
                    ${_escHtml(brand.name)}
                </span>`;
            grid.appendChild(div);
        });
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER — PRODUCTS
    // ─────────────────────────────────────────────────────────────
    function _renderProducts(products) {
        const grid = _el('mainGrid');
        grid.innerHTML = '';

        if (!products || products.length === 0) {
            _showEmpty(true);
            grid.style.display = 'none';
            return;
        }

        _showEmpty(false);
        grid.style.display = 'grid';
        products.forEach(p => grid.appendChild(_createProductCard(p)));
    }

    function _createProductCard(product) {
        const inCart    = state.cart.find(i => i.id === product.id && !i.isCustom);
        const cartQty   = inCart ? inCart.quantity : 0;
        const available = product.stock - cartQty;
        const isOOS     = product.stock <= 0;
        const isLow     = !isOOS && available <= (product.low_stock_alert || 5);
        console.log(product);
        
        const div       = document.createElement('div');
        div.id          = `product-card-${product.id}`;
        div.className   = `pos-card${cartQty > 0 ? ' in-cart' : ''}`;
        div.onclick     = () => addToCart(product.id);
        // console.log(product)
        div.innerHTML = `
            ${cartQty > 0
                ? `<div id="cart-qty-badge-${product.id}"
                        style="position:absolute;top:-6px;right:-6px;
                               width:20px;height:20px;border-radius:50%;
                               background:#6366f1;color:#fff;font-size:0.65rem;
                               font-weight:900;display:flex;align-items:center;
                               justify-content:center;
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
                        display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" stroke="#6366f1"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                             00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="font-size:0.68rem;font-weight:700;color:#1e293b;
                      text-align:center;line-height:1.3;width:100%;
                      display:-webkit-box;-webkit-line-clamp:2;
                      -webkit-box-orient:vertical;overflow:hidden;"
               class="dark:text-gray-200">
                ${_escHtml(product.name)}
            </p>
            <p style="font-size:0.82rem;font-weight:900;color:#6366f1;
                      text-align:center;margin:0;">
                ${_escHtml(product.formatted_price)}
            </p>
            <p id="stock-label-${product.id}"
               style="font-size:0.62rem;font-weight:600;text-align:center;margin:0;
                      color:${isOOS ? '#ef4444' : isLow ? '#f59e0b' : '#94a3b8'};">
                ${isOOS ? '⚠ out of stock' : `${available} in stock`}
            </p>`;

        return div;
    }

    // ─────────────────────────────────────────────────────────────
    // SEARCH
    // ─────────────────────────────────────────────────────────────
    let _searchTimer;

    function handleSearch(value) {
        _el('clearSearchBtn').style.display = value ? 'block' : 'none';

        clearTimeout(_searchTimer);
        _searchTimer = setTimeout(async () => {
            if (!value.trim()) {
                clearSearch();
                return;
            }

            _showLoading(true);
            try {
                const params = new URLSearchParams({ search: value });
                const ns     = state.navState;
                if (ns?.type === 'category') params.set('category_id', ns.id);
                if (ns?.type === 'brand') {
                    params.set('category_id', ns.categoryId);
                    params.set('brand_id',    ns.brandId);
                }

                state.allProducts = await _fetch(
                    `${state.config.routes.products}?${params}`
                );
                _renderProducts(state.allProducts);
            } catch (e) {
                console.error(e);
            } finally {
                _showLoading(false);
            }
        }, 350);
    }

    function clearSearch() {
        _el('searchProduct').value          = '';
        _el('clearSearchBtn').style.display = 'none';

        const ns = state.navState;
        if (!ns)                      _loadCategories();
        else if (ns.type==='category') _loadBrands(ns.id);
        else                           _renderProducts(state.allProducts);
    }

    // ─────────────────────────────────────────────────────────────
    // CUSTOMER
    // ─────────────────────────────────────────────────────────────
    function showCustomerDropdown() {
        filterCustomers(_el('customerSearch').value);
    }

    function filterCustomers(value) {
        const dropdown = _el('customerDropdown');
        const term     = value.toLowerCase().trim();

        const filtered = term
            ? state.allCustomers.filter(c =>
                c.name.toLowerCase().includes(term) ||
                (c.phone && c.phone.includes(term))  ||
                (c.email && c.email.toLowerCase().includes(term))
              )
            : state.allCustomers;

        dropdown.innerHTML = '';

        // Walk-in option
        const walkIn = document.createElement('div');
        walkIn.className   = 'customer-option';
        walkIn.style.cssText = 'border-bottom:1px solid #f1f5f9;color:#94a3b8;';
        walkIn.innerHTML   = '<em>Walk-in Customer</em>';
        walkIn.onclick     = () => clearCustomer();
        dropdown.appendChild(walkIn);

        if (filtered.length === 0) {
            const none = document.createElement('div');
            none.className   = 'customer-option';
            none.style.color = '#94a3b8';
            none.textContent = 'No customers found';
            dropdown.appendChild(none);
        } else {
            filtered.slice(0, 8).forEach(c => {
                const opt     = document.createElement('div');
                opt.className = 'customer-option';
                const balance = parseFloat(c.balance || 0);

                opt.innerHTML = `
                    <div style="display:flex;justify-content:space-between;
                                align-items:center;">
                        <div>
                            <span style="font-weight:700;color:#1e293b;"
                                  class="dark:text-white">
                                ${_escHtml(c.name)}
                            </span>
                            ${c.phone
                                ? `<span style="color:#94a3b8;margin-left:6px;
                                               font-size:0.75rem;">
                                       ${_escHtml(c.phone)}
                                   </span>`
                                : ''}
                        </div>
                        ${balance > 0
                            ? `<span style="font-size:0.7rem;font-weight:700;
                                           color:#ef4444;background:#fee2e2;
                                           padding:2px 7px;border-radius:6px;">
                                   ${_fmt(balance)} owed
                               </span>`
                            : ''}
                    </div>`;
                opt.onclick = () => _selectCustomer(c);
                dropdown.appendChild(opt);
            });
        }

        dropdown.style.display = 'block';
    }

    function _selectCustomer(customer) {
        state.selectedCustomer = customer;
        _el('customerSearch').value = customer.name
            + (customer.phone ? ` — ${customer.phone}` : '');
        _el('clearCustomerBtn').style.display = 'block';
        _el('customerDropdown').style.display = 'none';
    }

    function clearCustomer() {
        state.selectedCustomer = null;
        _el('customerSearch').value           = '';
        _el('clearCustomerBtn').style.display = 'none';
        _el('customerDropdown').style.display = 'none';
    }

    // ─────────────────────────────────────────────────────────────
    // CART — ADD
    // ─────────────────────────────────────────────────────────────
    function addToCart(productId) {
        const product  = state.allProducts.find(p => p.id === productId);
        if (!product) return;

        const existing = state.cart.find(i => i.id === productId && !i.isCustom);
        const cartQty  = existing ? existing.quantity : 0;

        // Warn if over stock but still allow
        if (product.stock > 0 && cartQty >= product.stock) {
            _toast(`Only ${product.stock} in stock — added anyway`, 'warning');
        }

        if (existing) {
            existing.quantity++;
        } else {
            state.cart.push({
                id      : product.id,
                name    : product.name,
                price   : parseFloat(product.price),
                stock   : product.stock,
                quantity: 1,
                isCustom: false,
            });
        }

        _renderCart();
        _updateProductBadge(productId);
        _toast(`${product.name} added`, 'success');
    }

    function addCustomItem() {
        const name  = _el('customName').value.trim();
        const price = parseFloat(_el('customPrice').value);
        const qty   = parseInt(_el('customQty').value) || 1;

        if (!name)            { _toast('Enter item name', 'error');      return; }
        if (!price || price <= 0) { _toast('Enter valid price', 'error'); return; }

        state.cart.push({
            id      : 'custom_' + Date.now(),
            name    : name,
            price   : price,
            stock   : 9999,
            quantity: qty,
            isCustom: true,
        });

        _renderCart();
        closeCustomModal();
        _toast(`${name} added to cart`, 'success');
    }

    function adjustCustomQty(delta) {
        const input = _el('customQty');
        const val   = Math.max(1, (parseInt(input.value) || 1) + delta);
        input.value = val;
    }

    // ─────────────────────────────────────────────────────────────
    // CART — UPDATE / REMOVE
    // ─────────────────────────────────────────────────────────────
    function updateQuantity(itemId, delta) {
        const item = state.cart.find(i => String(i.id) === String(itemId));
        if (!item) return;

        const newQty = item.quantity + delta;
        if (newQty <= 0) { removeFromCart(itemId); return; }

        item.quantity = newQty;
        _renderCart();
        if (!item.isCustom) _updateProductBadge(item.id);
    }

    function removeFromCart(itemId) {
        const item   = state.cart.find(i => String(i.id) === String(itemId));
        state.cart   = state.cart.filter(i => String(i.id) !== String(itemId));
        _renderCart();
        if (item && !item.isCustom) _updateProductBadge(item.id);
    }

    function clearCart() {
        if (!state.cart.length) return;
        if (!confirm('Clear all items from cart?')) return;
        const ids          = state.cart.filter(i => !i.isCustom).map(i => i.id);
        state.cart         = [];
        state.discountAmount = 0;
        _renderCart();
        ids.forEach(id => _updateProductBadge(id));
    }

    // ─────────────────────────────────────────────────────────────
    // CART — RENDER
    // ─────────────────────────────────────────────────────────────
    function _renderCart() {
        const container = _el('cartItems');
        const empty     = _el('cartEmpty');
        const badge     = _el('cartBadge');
        const chargeBtn = _el('chargeBtn');

        // Remove all except empty state
        Array.from(container.children).forEach(c => {
            if (c.id !== 'cartEmpty') c.remove();
        });

        if (!state.cart.length) {
            empty.style.display         = 'flex';
            chargeBtn.disabled          = true;
            chargeBtn.style.background  = '#e2e8f0';
            chargeBtn.style.cursor      = 'not-allowed';
            badge.style.display         = 'none';
            _updateTotals();
            return;
        }

        empty.style.display         = 'none';
        chargeBtn.disabled          = false;
        chargeBtn.style.background  = '#10b981';
        chargeBtn.style.cursor      = 'pointer';

        const totalQty      = state.cart.reduce((s, i) => s + i.quantity, 0);
        badge.textContent   = totalQty;
        badge.style.display = 'flex';

        state.cart.forEach(item => {
            const row     = document.createElement('div');
            row.className = 'cart-item-row';
            row.innerHTML = `
                <div style="flex:1;min-width:0;">
                    <p style="font-size:0.78rem;font-weight:700;color:#1e293b;
                               white-space:nowrap;overflow:hidden;
                               text-overflow:ellipsis;margin:0;"
                       class="dark:text-white">
                        ${_escHtml(item.name)}
                        ${item.isCustom
                            ? `<span style="color:#a78bfa;font-size:0.65rem;
                                           font-weight:600;margin-left:4px;">
                                   custom
                               </span>`
                            : ''}
                    </p>
                    <p style="font-size:0.72rem;margin:3px 0 0;">
                        <span style="font-weight:800;color:#6366f1;">
                            ${_fmt(item.price * item.quantity)}
                        </span>
                        <span style="color:#cbd5e1;margin-left:4px;">
                            @ ${_fmt(item.price)}
                        </span>
                    </p>
                </div>
                <div style="display:flex;align-items:center;gap:4px;flex-shrink:0;">
                    <button class="qty-btn minus"
                            onclick="POS.updateQuantity('${item.id}', -1)">
                        −
                    </button>
                    <span style="width:22px;text-align:center;font-size:0.8rem;
                                 font-weight:800;color:#1e293b;"
                          class="dark:text-white">
                        ${item.quantity}
                    </span>
                    <button class="qty-btn plus"
                            onclick="POS.updateQuantity('${item.id}', 1)">
                        +
                    </button>
                    <button onclick="POS.removeFromCart('${item.id}')"
                            style="width:24px;height:24px;border-radius:8px;
                                   border:none;background:none;cursor:pointer;
                                   color:#cbd5e1;display:flex;align-items:center;
                                   justify-content:center;transition:all 0.1s;
                                   margin-left:2px;"
                            onmouseover="this.style.color='#ef4444';this.style.background='#fee2e2'"
                            onmouseout="this.style.color='#cbd5e1';this.style.background='none'">
                        <svg width="12" height="12" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>`;
            container.appendChild(row);
        });

        _updateTotals();
    }

    // ─────────────────────────────────────────────────────────────
    // CART — PRODUCT BADGE UPDATE
    // ─────────────────────────────────────────────────────────────
    function _updateProductBadge(productId) {
        const inCart    = state.cart.find(i => i.id === productId && !i.isCustom);
        const cartQty   = inCart ? inCart.quantity : 0;
        const product   = state.allProducts.find(p => p.id === productId);
        const available = product ? product.stock - cartQty : 0;

        // Badge
        const badge = _el(`cart-qty-badge-${productId}`);
        if (badge) {
            badge.textContent   = cartQty;
            badge.style.display = cartQty > 0 ? 'flex' : 'none';
        }

        // Stock label
        const label = _el(`stock-label-${productId}`);
        if (label && product) {
            const isOOS = available <= 0;
            const isLow = !isOOS && available <= (product.low_stock_alert || 5);
            label.textContent = isOOS
                ? '⚠ out of stock'
                : `${available} in stock`;
            label.style.color = isOOS
                ? '#ef4444'
                : isLow ? '#f59e0b' : '#94a3b8';
        }

        // Card highlight
        const card = _el(`product-card-${productId}`);
        if (card) {
            if (cartQty > 0) {
                card.classList.add('in-cart');
            } else {
                card.classList.remove('in-cart');
            }
        }
    }

    // ─────────────────────────────────────────────────────────────
    // TOTALS
    // ─────────────────────────────────────────────────────────────
    function _getSubtotal() {
        return state.cart.reduce((s, i) => s + i.price * i.quantity, 0);
    }

    function _getTotal() {
        return Math.max(0, _getSubtotal() - state.discountAmount);
    }

    function _updateTotals() {
        const sub   = _getSubtotal();
        const total = _getTotal();

        _el('cartSubtotal').textContent   = _fmt(sub);
        _el('cartTotal').textContent      = _fmt(total);
        _el('chargeBtnTotal').textContent = _fmt(total);

        const discRow = _el('discountRow');
        if (state.discountAmount > 0) {
            discRow.style.display = 'flex';
            _el('cartDiscountDisplay').textContent
                = `-${_fmt(state.discountAmount)}`;
        } else {
            discRow.style.display = 'none';
        }

        // Sync modal total if open
        const modalTotal = _el('modalTotalDisplay');
        if (modalTotal) modalTotal.textContent = _fmt(total);
    }

    // ─────────────────────────────────────────────────────────────
    // DISCOUNT
    // ─────────────────────────────────────────────────────────────
    function openDiscountModal() {
        _el('discountInput').value = '';
        state.discountType = 'percent';
        _syncDiscountUI();

        // Show remove button if discount already applied
        const removeBtn = _el('removeDiscountBtn');
        if (removeBtn) {
            removeBtn.style.display = state.discountAmount > 0 ? 'block' : 'none';
        }

        // Hide preview
        _el('discountPreview').style.display = 'none';

        _showModal('discountModal');
        setTimeout(() => _el('discountInput').focus(), 200);
    }

    function closeDiscountModal() {
        _hideModal('discountModal');
    }

    function setDiscountType(type) {
        state.discountType = type;
        _syncDiscountUI();
        _updateDiscountPreview();
    }

    function _syncDiscountUI() {
        const pBtn = _el('discTypPercent');
        const fBtn = _el('discTypFixed');
        const sym  = _el('discountSymbolBox');

        if (state.discountType === 'percent') {
            pBtn.className = 'disc-type-btn active';
            fBtn.className = 'disc-type-btn';
            sym.textContent = '%';
        } else {
            fBtn.className = 'disc-type-btn active';
            pBtn.className = 'disc-type-btn';
            sym.textContent = '£';
        }

        // Hide quick % buttons for fixed
        const quickRow = _el('quickDiscountRow');
        if (quickRow) {
            quickRow.style.display = state.discountType === 'percent'
                ? 'flex' : 'none';
        }
    }

    function setQuickDiscount(pct) {
        state.discountType = 'percent';
        _syncDiscountUI();
        _el('discountInput').value = pct;
        _updateDiscountPreview();
    }

    function _updateDiscountPreview() {
        const val     = parseFloat(_el('discountInput').value) || 0;
        const sub     = _getSubtotal();
        const preview = _el('discountPreview');
        const amount  = _el('discountPreviewAmount');

        if (val <= 0 || sub <= 0) {
            preview.style.display = 'none';
            return;
        }

        const calculated = state.discountType === 'percent'
            ? (sub * val) / 100
            : val;

        preview.style.display      = 'flex';
        amount.textContent         = _fmt(Math.min(calculated, sub));
    }

    function applyDiscount() {
        const val = parseFloat(_el('discountInput').value) || 0;
        const sub = _getSubtotal();

        if (val <= 0) {
            _toast('Enter a discount value', 'error');
            return;
        }

        state.discountAmount = state.discountType === 'percent'
            ? (sub * val) / 100
            : val;

        state.discountAmount = Math.min(
            Math.max(0, state.discountAmount),
            sub
        );

        _updateTotals();
        closeDiscountModal();
        _toast(`Discount ${_fmt(state.discountAmount)} applied`, 'success');
    }

    function removeDiscount() {
        state.discountAmount = 0;
        _updateTotals();
        closeDiscountModal();
        _toast('Discount removed', 'success');
    }

    // ─────────────────────────────────────────────────────────────
    // PAYMENT METHOD
    // ─────────────────────────────────────────────────────────────
    function selectMethod(method) {
        state.selectedMethod = method;

        ['cash', 'card', 'trade', 'split'].forEach(m => {
            const btn    = _el(`method-${m}`);
            const fields = _el(`fields-${m}`);
            if (btn) btn.className = m === method
                ? 'method-btn active'
                : 'method-btn';
            if (fields) fields.style.display = 'none';
        });

        const activeFields = _el(`fields-${method}`);
        if (activeFields) {
            activeFields.style.display = method === 'card' ? 'flex' : 'block';
        }

        // Auto-fill split remainder
        if (method === 'split') {
            _el('split1Amount').value = '';
            _el('split2Amount').value = _getTotal().toFixed(2);
        }
    }

    function updateSplit2() {
        const amount1   = parseFloat(_el('split1Amount').value) || 0;
        const remainder = Math.max(0, _getTotal() - amount1);
        _el('split2Amount').value = remainder.toFixed(2);
    }

    function setQuickAmount(amount) {
        _el('cashInput').value = amount.toFixed(2);
        updateChange();
    }

    function setExactAmount() {
        _el('cashInput').value = _getTotal().toFixed(2);
        updateChange();
    }

    function updateChange() {
        const tendered = parseFloat(_el('cashInput').value) || 0;
        const change   = tendered - _getTotal();
        const display  = _el('changeDisplay');

        if (tendered > 0 && change >= 0) {
            display.style.display              = 'flex';
            _el('changeAmount').textContent    = _fmt(change);
        } else {
            display.style.display = 'none';
        }
    }

    // ─────────────────────────────────────────────────────────────
    // PAYMENT MODAL
    // ─────────────────────────────────────────────────────────────
    function openPaymentModal() {
    if (!state.cart.length) return;

    // Sync total display
    _el('modalTotalDisplay').textContent = _fmt(_getTotal());

    // Reset fields
    if (_el('cashInput'))       _el('cashInput').value       = '';
    if (_el('paymentNotes'))    _el('paymentNotes').value    = '';
    if (_el('tradeValue'))      _el('tradeValue').value      = '';
    if (_el('tradeDevice'))     _el('tradeDevice').value     = '';
    if (_el('split1Amount'))    _el('split1Amount').value    = '';
    if (_el('split1Note'))      _el('split1Note').value      = '';
    if (_el('split2Note'))      _el('split2Note').value      = '';
    if (_el('changeDisplay'))   _el('changeDisplay').style.display = 'none';

    // Default to cash method
    selectMethod('cash');

    _showModal('paymentModal');
    setTimeout(() => _el('cashInput')?.focus(), 200);
}

    function closePaymentModal() {
        _hideModal('paymentModal');
    }

    // ─────────────────────────────────────────────────────────────
    // CUSTOM ITEM MODAL
    // ─────────────────────────────────────────────────────────────
    function openCustomModal() {
        _el('customName').value  = '';
        _el('customPrice').value = '';
        _el('customQty').value   = '1';
        _el('customNote').value  = '';
        _showModal('customModal');
        setTimeout(() => _el('customName').focus(), 200);
    }

    function closeCustomModal() {
        _hideModal('customModal');
    }

    // ─────────────────────────────────────────────────────────────
    // COMPLETE SALE
    // ─────────────────────────────────────────────────────────────
  async function completeSale() {
    if (!state.cart.length) {
        _toast('Cart is empty!', 'error');
        return;
    }

    // ── Validate split amounts ────────────────────
    if (state.selectedMethod === 'split') {
        const cash = parseFloat(_el('split1Amount')?.value) || 0;
        const card = parseFloat(_el('split2Amount')?.value) || 0;
        if (cash <= 0 && card <= 0) {
            _toast('Please enter split payment amounts', 'error');
            return;
        }
    }

    // ── Validate trade value ──────────────────────
    if (state.selectedMethod === 'trade') {
        const trade = parseFloat(_el('tradeValue')?.value) || 0;
        if (trade <= 0) {
            _toast('Please enter a trade-in value', 'error');
            return;
        }
    }

    // ── Set button loading state ──────────────────
    const btn = _el('completeSaleBtn');
    btn.disabled  = true;
    btn.innerHTML = `
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
             style="animation:spin 1s linear infinite;">
            <circle cx="12" cy="12" r="10" stroke="white"
                    stroke-width="4" opacity="0.25"/>
            <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        Processing...`;

    // ── Build payload ─────────────────────────────
    const payload = _buildPayload();

    try {
        const data = await _post(state.config.routes.store, payload);

        if (data.success) {
            _handleSaleSuccess(data);
        } else {
            _handleSaleError(data);
        }

    } catch (e) {
        console.error('Sale error:', e);
        _toast('Network error. Please try again.', 'error');
    } finally {
        btn.disabled  = false;
        btn.innerHTML = `
            <svg width="18" height="18" fill="none" stroke="white"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            Complete Sale`;
    }
}

// ─────────────────────────────────────────────────────────────
// BUILD PAYLOAD
// ─────────────────────────────────────────────────────────────
function _buildPayload() {
    const payload = {
        customer_id    : state.selectedCustomer?.id ?? null,
        payment_method : state.selectedMethod === 'trade' ? 'trade' : state.selectedMethod,
        payment_status : 'paid',
        discount       : state.discountAmount,
        notes          : _el('paymentNotes')?.value || null,

        // Regular items
        items : state.cart
            .filter(i => !i.isCustom)
            .map(i => ({
                product_id : i.id,
                quantity   : i.quantity,
                price      : i.price,
            })),

        // Custom items
        custom_items : state.cart
            .filter(i => i.isCustom)
            .map(i => ({
                name     : i.name,
                quantity : i.quantity,
                price    : i.price,
            })),
    };

    // Split payment
    if (state.selectedMethod === 'split') {
        payload.split_cash    = parseFloat(_el('split1Amount')?.value) || 0;
        payload.split_card    = parseFloat(_el('split2Amount')?.value) || 0;
        payload.split1_method = _el('split1Method')?.value || 'cash';
        payload.split2_method = _el('split2Method')?.value || 'card';
        payload.split1_note   = _el('split1Note')?.value   || null;
        payload.split2_note   = _el('split2Note')?.value   || null;
    }

    // Trade-in payment
    // Trade-in payment
    if (state.selectedMethod === 'trade') {
        payload.trade_value = parseFloat(_el('tradeValue')?.value) || 0;
    }

    return payload;
}

// ─────────────────────────────────────────────────────────────
// HANDLE SALE SUCCESS
// ─────────────────────────────────────────────────────────────
function _handleSaleSuccess(data) {
    closePaymentModal();

    const summary = data.summary;
    let message   = `✓ ${data.message}`;

    if (summary) {
        if (summary.outstanding > 0) {
            message += ` — Outstanding: £${summary.outstanding.toFixed(2)}`;
        } else {
            message += ` — Fully paid`;
        }
    }

    _toast(message, 'success');

    // Show receipt button toast
    if (data.sale_id) {
        setTimeout(() => {
            _showReceiptPrompt(data.sale_id, data.reference, data.customer_email ?? null);
        }, 500);
    }

    // Reset cart state
    state.cart             = [];
    state.discountAmount   = 0;
    state.selectedCustomer = null;

    // Reset customer UI
    const customerSearch = _el('customerSearch');
    const clearCustomBtn = _el('clearCustomerBtn');
    if (customerSearch) customerSearch.value         = '';
    if (clearCustomBtn) clearCustomBtn.style.display = 'none';

    // Reset search bar
    const searchInput = _el('searchProduct');
    const clearSearch = _el('clearSearchBtn');
    if (searchInput) searchInput.value         = '';
    if (clearSearch) clearSearch.style.display = 'none';

    // Re-render empty cart
    _renderCart();

    // Go back to categories
    goHome();
}

// ─────────────────────────────────────────────────────────────
// RECEIPT OPTIONS — shown after successful sale
// ─────────────────────────────────────────────────────────────
function _showReceiptPrompt(saleId, reference, customerEmail) {
    // Remove any existing prompt
    const existing = document.getElementById('receiptPrompt');
    if (existing) existing.remove();

    const prompt = document.createElement('div');
    prompt.id = 'receiptPrompt';
    prompt.style.cssText = `
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 9999;
        background: #1e293b;
        color: #fff;
        padding: 14px 18px;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        animation: slideUp 0.3s ease;
        white-space: nowrap;
    `;

    prompt.innerHTML = `
        <span style="color:#94a3b8;font-size:0.8rem;">Sale ${_escHtml(reference)}</span>

        <button id="receiptPrintBtn"
                style="background:#6366f1;color:#fff;padding:8px 14px;
                       border-radius:9px;border:none;font-weight:700;
                       font-size:0.8rem;cursor:pointer;display:flex;
                       align-items:center;gap:6px;transition:background 0.15s;"
                onmouseover="this.style.background='#4f46e5'"
                onmouseout="this.style.background='#6366f1'">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0
                         002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2
                         2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print Receipt
        </button>

        <button id="receiptEmailBtn"
                style="background:#10b981;color:#fff;padding:8px 14px;
                       border-radius:9px;border:none;font-weight:700;
                       font-size:0.8rem;cursor:pointer;display:flex;
                       align-items:center;gap:6px;transition:background 0.15s;"
                onmouseover="this.style.background='#059669'"
                onmouseout="this.style.background='#10b981'">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2
                         2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Email Receipt
        </button>

        <button onclick="document.getElementById('receiptPrompt').remove()"
                style="background:none;border:none;color:#64748b;
                       cursor:pointer;font-size:1.1rem;padding:0 4px;
                       line-height:1;flex-shrink:0;"
                title="Dismiss">✕</button>
    `;

    document.body.appendChild(prompt);

    // Print — open receipt in new tab and trigger print, no navigation
    document.getElementById('receiptPrintBtn').addEventListener('click', () => {
        const printWin = window.open(`/sales/${saleId}/receipt`, '_blank');
        if (printWin) {
            printWin.addEventListener('load', () => {
                printWin.print();
            });
        }
    });

    // Email — open email modal
    document.getElementById('receiptEmailBtn').addEventListener('click', () => {
        prompt.remove();
        _showEmailModal(saleId, reference, customerEmail);
    });

    // Auto-dismiss after 12 seconds
    setTimeout(() => {
        const el = document.getElementById('receiptPrompt');
        if (el) {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.3s';
            setTimeout(() => el.remove(), 300);
        }
    }, 12000);
}

// ─────────────────────────────────────────────────────────────
// EMAIL RECEIPT MODAL
// ─────────────────────────────────────────────────────────────
function _showEmailModal(saleId, reference, customerEmail) {
    // Remove existing
    const existing = document.getElementById('emailReceiptModal');
    if (existing) existing.remove();

    const defaultSubject = `Your Receipt — ${reference}`;
    const defaultMessage = `Thank you for shopping with us!\n\nWe really appreciate your business. Please find your receipt attached for sale ${reference}.\n\nIf you have any questions, feel free to get in touch.\n\nWarm regards,\nThe Team`;

    const overlay = document.createElement('div');
    overlay.id = 'emailReceiptModal';
    overlay.style.cssText = `
        position: fixed; inset: 0; z-index: 99999;
        background: rgba(0,0,0,0.55);
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
        animation: fadeIn 0.2s ease;
    `;

    overlay.innerHTML = `
        <div style="background:#fff;border-radius:20px;width:100%;max-width:480px;
                    box-shadow:0 24px 60px rgba(0,0,0,0.25);overflow:hidden;
                    font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">

            <!-- Header -->
            <div style="background:linear-gradient(135deg,#10b981,#059669);
                        padding:20px 24px;display:flex;align-items:center;
                        justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);
                                border-radius:10px;display:flex;align-items:center;
                                justify-content:center;">
                        <svg width="18" height="18" fill="none" stroke="#fff" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0
                                     002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p style="color:#fff;font-weight:800;font-size:0.95rem;margin:0;">
                            Email Receipt
                        </p>
                        <p style="color:rgba(255,255,255,0.75);font-size:0.75rem;margin:0;">
                            Sale ${_escHtml(reference)}
                        </p>
                    </div>
                </div>
                <button id="emailModalClose"
                        style="background:rgba(255,255,255,0.2);border:none;color:#fff;
                               width:32px;height:32px;border-radius:8px;cursor:pointer;
                               font-size:1rem;display:flex;align-items:center;
                               justify-content:center;">✕</button>
            </div>

            <!-- Body -->
            <div style="padding:24px;display:flex;flex-direction:column;gap:16px;">

                <!-- Email -->
                <div>
                    <label style="display:block;font-size:0.75rem;font-weight:700;
                                  color:#374151;margin-bottom:6px;text-transform:uppercase;
                                  letter-spacing:0.05em;">
                        Email Address <span style="color:#ef4444;">*</span>
                    </label>
                    <input id="emailModalTo" type="email"
                           value="${_escAttr(customerEmail || '')}"
                           placeholder="customer@example.com"
                           required
                           style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                                  border-radius:10px;font-size:0.875rem;outline:none;
                                  box-sizing:border-box;transition:border-color 0.15s;
                                  font-family:inherit;"
                           onfocus="this.style.borderColor='#10b981'"
                           onblur="this.style.borderColor='#e5e7eb'">
                    <p id="emailModalToErr"
                       style="display:none;color:#ef4444;font-size:0.72rem;
                              margin:4px 0 0;font-weight:600;">
                        Please enter a valid email address.
                    </p>
                </div>

                <!-- Subject -->
                <div>
                    <label style="display:block;font-size:0.75rem;font-weight:700;
                                  color:#374151;margin-bottom:6px;text-transform:uppercase;
                                  letter-spacing:0.05em;">
                        Subject <span style="color:#ef4444;">*</span>
                    </label>
                    <input id="emailModalSubject" type="text"
                           value="${_escAttr(defaultSubject)}"
                           placeholder="Receipt subject..."
                           required
                           style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                                  border-radius:10px;font-size:0.875rem;outline:none;
                                  box-sizing:border-box;transition:border-color 0.15s;
                                  font-family:inherit;"
                           onfocus="this.style.borderColor='#10b981'"
                           onblur="this.style.borderColor='#e5e7eb'">
                    <p id="emailModalSubjectErr"
                       style="display:none;color:#ef4444;font-size:0.72rem;
                              margin:4px 0 0;font-weight:600;">
                        Subject is required.
                    </p>
                </div>

                <!-- Message -->
                <div>
                    <label style="display:block;font-size:0.75rem;font-weight:700;
                                  color:#374151;margin-bottom:6px;text-transform:uppercase;
                                  letter-spacing:0.05em;">
                        Message <span style="color:#94a3b8;font-weight:400;text-transform:none;">(optional)</span>
                    </label>
                    <textarea id="emailModalMessage"
                              rows="5"
                              placeholder="Write a message to the customer..."
                              style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;
                                     border-radius:10px;font-size:0.875rem;outline:none;
                                     box-sizing:border-box;resize:vertical;
                                     transition:border-color 0.15s;font-family:inherit;
                                     line-height:1.5;"
                              onfocus="this.style.borderColor='#10b981'"
                              onblur="this.style.borderColor='#e5e7eb'">${_escHtml(defaultMessage)}</textarea>
                </div>

                <!-- Error banner -->
                <div id="emailModalError"
                     style="display:none;background:#fef2f2;border:1.5px solid #fecaca;
                            border-radius:10px;padding:10px 14px;
                            color:#dc2626;font-size:0.8rem;font-weight:600;"></div>

            </div>

            <!-- Footer -->
            <div style="padding:0 24px 24px;display:flex;gap:10px;">
                <button id="emailModalCancel"
                        style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e5e7eb;
                               background:#fff;color:#6b7280;font-weight:700;font-size:0.875rem;
                               cursor:pointer;transition:all 0.15s;"
                        onmouseover="this.style.background='#f9fafb'"
                        onmouseout="this.style.background='#fff'">
                    Cancel
                </button>
                <button id="emailModalSend"
                        style="flex:2;padding:11px;border-radius:10px;border:none;
                               background:#10b981;color:#fff;font-weight:800;font-size:0.875rem;
                               cursor:pointer;transition:background 0.15s;display:flex;
                               align-items:center;justify-content:center;gap:7px;"
                        onmouseover="this.style.background='#059669'"
                        onmouseout="this.style.background='#10b981'">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Send Receipt
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    // Close handlers
    const closeModal = () => overlay.remove();
    document.getElementById('emailModalClose').addEventListener('click', closeModal);
    document.getElementById('emailModalCancel').addEventListener('click', closeModal);
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });

    // Send handler
    document.getElementById('emailModalSend').addEventListener('click', async () => {
        const emailInput   = document.getElementById('emailModalTo');
        const subjectInput = document.getElementById('emailModalSubject');
        const messageInput = document.getElementById('emailModalMessage');
        const sendBtn      = document.getElementById('emailModalSend');
        const errorBanner  = document.getElementById('emailModalError');

        // Reset errors
        document.getElementById('emailModalToErr').style.display      = 'none';
        document.getElementById('emailModalSubjectErr').style.display = 'none';
        errorBanner.style.display = 'none';

        let valid = true;

        const emailVal = emailInput.value.trim();
        const emailRe  = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailVal || !emailRe.test(emailVal)) {
            document.getElementById('emailModalToErr').style.display = 'block';
            emailInput.style.borderColor = '#ef4444';
            valid = false;
        }

        const subjectVal = subjectInput.value.trim();
        if (!subjectVal) {
            document.getElementById('emailModalSubjectErr').style.display = 'block';
            subjectInput.style.borderColor = '#ef4444';
            valid = false;
        }

        if (!valid) return;

        // Loading state
        sendBtn.disabled  = true;
        sendBtn.innerHTML = `
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                 style="animation:spin 1s linear infinite;">
                <circle cx="12" cy="12" r="10" stroke="white" stroke-width="4" opacity="0.25"/>
                <path fill="white" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            Sending...`;

        try {
            const res = await fetch(`/sales/${saleId}/email`, {
                method : 'POST',
                headers: {
                    'Content-Type'     : 'application/json',
                    'X-Requested-With' : 'XMLHttpRequest',
                    'X-CSRF-TOKEN'     : state.config.csrf,
                    'Accept'           : 'application/json',
                },
                body: JSON.stringify({
                    email  : emailVal,
                    subject: subjectVal,
                    message: messageInput.value.trim() || null,
                }),
            });

            const data = await res.json();

            if (data.success) {
                overlay.remove();
                _toast(`✓ ${data.message}`, 'success');
            } else {
                errorBanner.textContent   = data.message || 'Failed to send email.';
                errorBanner.style.display = 'block';
            }

        } catch (e) {
            errorBanner.textContent   = 'Network error. Please try again.';
            errorBanner.style.display = 'block';
        } finally {
            sendBtn.disabled      = false;
            sendBtn.style.background = '#10b981';
            sendBtn.innerHTML = `
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Send Receipt`;
        }
    });
}

// ─────────────────────────────────────────────────────────────
// HTML ESCAPE HELPERS (for dynamic DOM building)
// ─────────────────────────────────────────────────────────────
function _escHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function _escAttr(str) {
    if (!str) return '';
    return String(str).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}
// ─────────────────────────────────────────────────────────────
// HANDLE SALE ERROR
// ─────────────────────────────────────────────────────────────
function _handleSaleError(data) {
    if (data.errors) {
        // Show first validation error
        const firstError = Object.values(data.errors).flat()[0];
        _toast(firstError, 'error');

        // Log all errors for debugging
        console.warn('Validation errors:', data.errors);
    } else {
        _toast(data.message || 'Failed to complete sale', 'error');
    }
}

    // ─────────────────────────────────────────────────────────────
    // MODAL HELPERS
    // ─────────────────────────────────────────────────────────────
    function _showModal(modalId) {
        const modal = _el(modalId);
        if (!modal) return;
        modal.style.display = 'flex';
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                const box = modal.querySelector('.pos-modal-box');
                if (box) {
                    box.style.transform = 'scale(1)';
                    box.style.opacity   = '1';
                }
            });
        });
    }

    function _hideModal(modalId) {
        const modal = _el(modalId);
        if (!modal) return;
        const box = modal.querySelector('.pos-modal-box');
        if (box) {
            box.style.transform = 'scale(0.95)';
            box.style.opacity   = '0';
        }
        setTimeout(() => modal.style.display = 'none', 180);
    }

    function handleOverlayClick(event, modalId) {
        if (event.target === event.currentTarget) {
            _hideModal(modalId);
        }
    }

    // Escape key closes all modals
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            _hideModal('paymentModal');
            _hideModal('discountModal');
            _hideModal('customModal');
        }
    });

    // ─────────────────────────────────────────────────────────────
    // UI HELPERS
    // ─────────────────────────────────────────────────────────────
    function _showLoading(show) {
        _el('gridLoading').style.display = show ? 'block' : 'none';
        _el('mainGrid').style.display    = show ? 'none'  : 'grid';
        _el('gridEmpty').style.display   = 'none';
    }

    function _showEmpty(show) {
        _el('gridEmpty').style.display = show ? 'flex' : 'none';
    }

    function _toast(message, type = 'success') {
        const existing = document.getElementById('posToast');
        if (existing) existing.remove();

        const colors = {
            success : '#10b981',
            error   : '#ef4444',
            warning : '#f59e0b',
        };

        const toast     = document.createElement('div');
        toast.id        = 'posToast';
        toast.style.cssText = `
            position:fixed;bottom:24px;right:24px;z-index:9999;
            padding:10px 18px;border-radius:12px;color:#fff;
            font-size:0.85rem;font-weight:700;max-width:300px;
            box-shadow:0 8px 24px rgba(0,0,0,0.15);
            background:${colors[type] || colors.success};
            transform:translateY(10px);opacity:0;
            transition:all 0.25s ease;`;
        toast.textContent = message;
        document.body.appendChild(toast);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                toast.style.transform = 'translateY(0)';
                toast.style.opacity   = '1';
            });
        });

        setTimeout(() => {
            toast.style.transform = 'translateY(10px)';
            toast.style.opacity   = '0';
            setTimeout(() => toast.remove(), 250);
        }, 3000);
    }

    // ─────────────────────────────────────────────────────────────
    // DISCOUNT INPUT LIVE PREVIEW
    // ─────────────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('discountInput');
        if (input) {
            input.addEventListener('input', _updateDiscountPreview);
        }
    });

    // ─────────────────────────────────────────────────────────────
    // SPIN KEYFRAME (for loading button)
    // ─────────────────────────────────────────────────────────────
    const spinStyle = document.createElement('style');
    spinStyle.textContent = `@keyframes spin {
        from { transform: rotate(0deg); }
        to   { transform: rotate(360deg); }
    }`;
    document.head.appendChild(spinStyle);

    // ─────────────────────────────────────────────────────────────
    // PUBLIC API
    // ─────────────────────────────────────────────────────────────
    return {
        init,
        // Navigation
        goHome,
        goBack,
        selectCategory,
        selectBrand,
        // Search
        handleSearch,
        clearSearch,
        // Customer
        showCustomerDropdown,
        filterCustomers,
        clearCustomer,
        // Cart
        addToCart,
        addCustomItem,
        adjustCustomQty,
        updateQuantity,
        removeFromCart,
        clearCart,
        // Discount
        openDiscountModal,
        closeDiscountModal,
        setDiscountType,
        setQuickDiscount,
        applyDiscount,
        removeDiscount,
        // Payment
        openPaymentModal,
        closePaymentModal,
        selectMethod,
        updateSplit2,
        setQuickAmount,
        setExactAmount,
        updateChange,
        // Custom
        openCustomModal,
        closeCustomModal,
        // Complete
        completeSale,
        // Modal
        handleOverlayClick,
    };

})();