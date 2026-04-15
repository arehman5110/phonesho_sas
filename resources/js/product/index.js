/**
 * Product Form — Entry Point
 * Handles create/edit with autocomplete
 */

import { ProductSearch } from './productSearch.js';

document.addEventListener('DOMContentLoaded', () => {

    const nameInput  = document.getElementById('product-name-input');
    const dropdown   = document.getElementById('product-name-dropdown');
    const productId  = document.getElementById('product-id-input');
    const formTitle  = document.getElementById('product-form-title');
    const formBadge  = document.getElementById('product-form-badge');
    const submitBtn  = document.getElementById('product-submit-btn');

    if (!nameInput || !dropdown) return;

    // ── Field refs ────────────────────────────
    const fields = {
        sku            : document.getElementById('field-sku'),
        category       : document.getElementById('field-category'),
        brand          : document.getElementById('field-brand'),
        price          : document.getElementById('field-price'),
        cost_price     : document.getElementById('field-cost-price'),
        stock          : document.getElementById('field-stock'),
        low_stock_alert: document.getElementById('field-low-stock-alert'),
        is_active      : document.getElementById('field-is-active'),
        description    : document.getElementById('field-description'),
    };

    // ── Init autocomplete ─────────────────────
    const search = ProductSearch({
        inputEl    : nameInput,
        dropdownEl : dropdown,
        searchUrl  : window.PRODUCT_CONFIG?.routes?.autocomplete ?? '/api/products/autocomplete',
        minChars   : 1,
        debounceMs : 300,
        onSelect   : _onProductSelected,
    });

    search.init();

    // ── On product selected from dropdown ─────
    function _onProductSelected(product) {

        // Set hidden product ID — switches to edit mode
        if (productId) productId.value = product.id;

        // Fill all form fields
        if (fields.sku)             fields.sku.value             = product.sku             ?? '';
        if (fields.category)        fields.category.value        = product.category_id     ?? '';
        if (fields.brand)           fields.brand.value           = product.brand_id        ?? '';
        if (fields.price)           fields.price.value           = product.price           ?? '';
        if (fields.cost_price)      fields.cost_price.value      = product.cost_price      ?? '';
        if (fields.stock)           fields.stock.value           = product.stock           ?? 0;
        if (fields.low_stock_alert) fields.low_stock_alert.value = product.low_stock_alert ?? 5;
        if (fields.is_active)       fields.is_active.checked     = product.is_active       ?? true;
        if (fields.description)     fields.description.value     = product.description     ?? '';

        // Update form UI to edit mode
        _setEditMode(product);
    }

    // ── Switch form to edit mode ──────────────
    function _setEditMode(product) {
        if (formTitle) {
            formTitle.textContent = 'Edit Product';
        }

        if (formBadge) {
            formBadge.textContent  = 'Editing existing';
            formBadge.className    = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400';
            formBadge.style.display = 'inline-flex';
        }

        if (submitBtn) {
            submitBtn.textContent = 'Update Product';
        }

        // Update form action to PUT
        const form = document.getElementById('product-form');
        if (form && product.id) {
            const methodInput = document.getElementById('form-method-input');
            if (methodInput) methodInput.value = 'PUT';

            const actionBase = window.PRODUCT_CONFIG?.routes?.update ?? '/products/{id}';
            form.action      = actionBase.replace('{id}', product.id);
        }

        // Show edit indicator
        _showToast(`Editing: ${product.name}`, 'info');
    }

    // ── Reset to create mode ──────────────────
    window.resetToCreate = function() {
        if (productId)  productId.value  = '';
        if (nameInput)  nameInput.value  = '';
        if (formTitle)  formTitle.textContent = 'New Product';
        if (formBadge)  formBadge.style.display = 'none';
        if (submitBtn)  submitBtn.textContent   = 'Create Product';

        Object.values(fields).forEach(el => {
            if (!el) return;
            if (el.type === 'checkbox') {
                el.checked = true;
            } else {
                el.value = '';
            }
        });

        // Reset form action
        const form = document.getElementById('product-form');
        if (form) {
            const methodInput = document.getElementById('form-method-input');
            if (methodInput) methodInput.value = '';
            form.action = window.PRODUCT_CONFIG?.routes?.store ?? '/products';
        }
    };

    // ── Toast ─────────────────────────────────
    function _showToast(message, type = 'success') {
        const existing = document.getElementById('product-toast');
        if (existing) existing.remove();

        const colors = {
            success : '#10b981',
            error   : '#ef4444',
            warning : '#f59e0b',
            info    : '#6366f1',
        };

        const el = document.createElement('div');
        el.id    = 'product-toast';
        el.style.cssText = `
            position:fixed;bottom:24px;right:24px;z-index:9999;
            padding:10px 18px;border-radius:12px;color:#fff;
            font-size:0.85rem;font-weight:700;max-width:300px;
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
        }, 3000);
    }
});