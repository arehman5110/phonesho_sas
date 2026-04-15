/**
 * Product Search / Autocomplete
 * Handles: typing, fetch, dropdown, selection, keyboard nav
 */

export function ProductSearch({
    inputEl,
    dropdownEl,
    onSelect,
    searchUrl,
    minChars = 1,
    debounceMs = 300,
}) {

    // ── State ─────────────────────────────────
    let results         = [];
    let highlightedIndex = -1;
    let searchTimer     = null;
    let isOpen          = false;

    // ── Init ──────────────────────────────────
    function init() {
        inputEl.addEventListener('input',   _onInput);
        inputEl.addEventListener('keydown', _onKeydown);
        inputEl.addEventListener('focus',   _onFocus);

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!inputEl.contains(e.target) &&
                !dropdownEl.contains(e.target)) {
                close();
            }
        });
    }

    // ── Input handler ─────────────────────────
    function _onInput() {
        const val = inputEl.value.trim();

        clearTimeout(searchTimer);

        if (val.length < minChars) {
            close();
            return;
        }

        searchTimer = setTimeout(() => _fetch(val), debounceMs);
    }

    // ── Focus handler ─────────────────────────
    function _onFocus() {
        const val = inputEl.value.trim();
        if (val.length >= minChars && results.length > 0) {
            open();
        }
    }

    // ── Keyboard navigation ───────────────────
    function _onKeydown(e) {
        if (!isOpen) return;

        switch (e.key) {
            case 'ArrowDown':
                e.preventDefault();
                highlightedIndex = Math.min(
                    highlightedIndex + 1,
                    results.length - 1
                );
                _renderDropdown();
                _scrollToHighlighted();
                break;

            case 'ArrowUp':
                e.preventDefault();
                highlightedIndex = Math.max(highlightedIndex - 1, -1);
                _renderDropdown();
                _scrollToHighlighted();
                break;

            case 'Enter':
                e.preventDefault();
                if (highlightedIndex >= 0 && results[highlightedIndex]) {
                    _select(results[highlightedIndex]);
                } else {
                    // No selection — keep typed value as new product
                    close();
                }
                break;

            case 'Escape':
                close();
                inputEl.blur();
                break;
        }
    }

    // ── Fetch results ─────────────────────────
    async function _fetch(term) {
        _showLoading();

        try {
            const params = new URLSearchParams({ q: term });
            const res    = await fetch(`${searchUrl}?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept'          : 'application/json',
                },
            });

            results          = await res.json();
            highlightedIndex = -1;
            _renderDropdown();
            open();

        } catch (e) {
            console.error('Product search error:', e);
            close();
        }
    }

    // ── Render dropdown ───────────────────────
    function _renderDropdown() {
        dropdownEl.innerHTML = '';

        if (results.length === 0) {
            dropdownEl.innerHTML = `
                <div class="px-4 py-3 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400
                               font-medium">
                        No products found
                    </p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        Press Enter to create "<strong>${_esc(inputEl.value)}</strong>"
                    </p>
                </div>`;
            return;
        }

        results.forEach((product, index) => {
            const item       = document.createElement('div');
            const isActive   = index === highlightedIndex;

            item.className = `flex items-center justify-between
                              px-4 py-3 cursor-pointer transition-colors
                              border-b border-gray-100 dark:border-gray-700
                              last:border-0
                              ${isActive
                                  ? 'bg-indigo-50 dark:bg-indigo-900/30'
                                  : 'hover:bg-gray-50 dark:hover:bg-gray-700/50'}`;

            item.innerHTML = `
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg flex-shrink-0
                                flex items-center justify-center
                                ${isActive
                                    ? 'bg-indigo-100 dark:bg-indigo-900/60'
                                    : 'bg-gray-100 dark:bg-gray-800'}">
                        <svg class="w-4 h-4
                                    ${isActive
                                        ? 'text-indigo-500'
                                        : 'text-gray-400'}"
                             fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4
                                     m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold truncate
                                   ${isActive
                                       ? 'text-indigo-700 dark:text-indigo-300'
                                       : 'text-gray-900 dark:text-white'}"
                           data-name>
                            ${_highlight(product.name, inputEl.value)}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500
                                   mt-0.5 truncate">
                            ${[product.category, product.brand]
                                .filter(Boolean).join(' · ')}
                            ${product.sku
                                ? `<span class="font-mono ml-1">#${_esc(product.sku)}</span>`
                                : ''}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-end flex-shrink-0 ml-3 gap-0.5">
                    <span class="text-sm font-bold
                                  ${isActive
                                      ? 'text-indigo-600 dark:text-indigo-400'
                                      : 'text-gray-700 dark:text-gray-300'}">
                        ${_esc(product.formatted_price)}
                    </span>
                    <span class="text-xs font-medium
                                  ${product.stock <= 0
                                      ? 'text-red-500'
                                      : product.stock <= 5
                                          ? 'text-amber-500'
                                          : 'text-emerald-500'}">
                        ${product.stock <= 0
                            ? 'Out of stock'
                            : product.stock + ' in stock'}
                    </span>
                </div>`;

            // Click to select
            item.addEventListener('mousedown', (e) => {
                e.preventDefault();
                _select(product);
            });

            dropdownEl.appendChild(item);
        });
    }

    // ── Show loading state ────────────────────
    function _showLoading() {
        dropdownEl.innerHTML = `
            <div class="flex items-center gap-2 px-4 py-3
                        text-sm text-gray-400 dark:text-gray-500">
                <svg class="w-4 h-4 animate-spin text-indigo-400"
                     fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
                Searching...
            </div>`;
        open();
    }

    // ── Select product ────────────────────────
    function _select(product) {
        inputEl.value = product.name;
        close();
        if (typeof onSelect === 'function') {
            onSelect(product);
        }
    }

    // ── Open / Close ──────────────────────────
    function open() {
        isOpen = true;
        dropdownEl.classList.remove('hidden');
        dropdownEl.style.display = 'block';
    }

    function close() {
        isOpen           = false;
        highlightedIndex = -1;
        dropdownEl.classList.add('hidden');
        dropdownEl.style.display = 'none';
    }

    // ── Scroll highlighted into view ──────────
    function _scrollToHighlighted() {
        const items = dropdownEl.querySelectorAll('[class*="px-4 py-3"]');
        if (items[highlightedIndex]) {
            items[highlightedIndex].scrollIntoView({
                block: 'nearest',
            });
        }
    }

    // ── Highlight matched text ────────────────
    function _highlight(text, term) {
        if (!term.trim()) return _esc(text);
        const escaped = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex   = new RegExp(`(${escaped})`, 'gi');
        return _esc(text).replace(
            regex,
            '<mark class="bg-indigo-100 dark:bg-indigo-900/60 text-indigo-700 dark:text-indigo-300 rounded px-0.5 font-bold not-italic">$1</mark>'
        );
    }

    // ── Escape HTML ───────────────────────────
    function _esc(str) {
        if (!str) return '';
        const d = document.createElement('div');
        d.textContent = String(str);
        return d.innerHTML;
    }

    // ── Public API ────────────────────────────
    return { init, close, open };
}