/**
 * PartsInput
 * Unified Alpine.js component for:
 *   - Issues field (suggestions only, no qty)
 *   - Parts Used field (product search + custom + qty)
 * Registered globally as window.PartsInput
 */

export function PartsInput(inputName, options = {}) {
    return {
        // ── Config ────────────────────────────────
        inputName,
        searchUrl   : options.searchUrl   ?? null,
        suggestions : options.suggestions ?? [],
        placeholder : options.placeholder ?? 'Type and press Enter...',
        showQty     : options.showQty     ?? false,
        maxTags     : options.maxTags     ?? null,

        // ── State ─────────────────────────────────
        parts            : [],
        inputVal         : '',
        products         : [],
        isOpen           : false,
        isLoading        : false,
        highlightedIndex : -1,
        searchTimer      : null,

        // ── Computed ──────────────────────────────
        get filteredSuggestions() {
            if (!this.inputVal.trim()) {
                return this.suggestions.slice(0, 8);
            }
            const term = this.inputVal.toLowerCase();
            return this.suggestions
                .filter(s => (s.label ?? s).toLowerCase().includes(term))
                .slice(0, 8);
        },

        // ── Prefill (used by edit form) ────────────
        prefill(items) {
            this.parts = items.map(item => ({
                name      : item.name      ?? item.label ?? String(item),
                product_id: item.product_id ?? null,
                quantity  : item.quantity  ?? 1,
                price     : item.price     ?? 0,
                isCustom  : item.isCustom  ?? !item.product_id,
            }));
        },

        // ── Input events ──────────────────────────
        onInput() {
            this.isOpen           = true;
            this.highlightedIndex = -1;

            if (this.searchUrl && this.inputVal.trim().length > 0) {
                clearTimeout(this.searchTimer);
                this.searchTimer = setTimeout(
                    () => this._searchProducts(this.inputVal),
                    300
                );
            } else {
                this.products = [];
            }
        },

        onFocus() {
            this.isOpen = true;
            if (this.searchUrl && this.inputVal.trim()) {
                this._searchProducts(this.inputVal);
            }
        },

        onBlur() {
            setTimeout(() => { this.isOpen = false; }, 200);
        },

        onBackspace() {
            if (this.inputVal === '' && this.parts.length > 0) {
                this.parts.pop();
            }
        },

        closeDropdown() {
            this.isOpen           = false;
            this.highlightedIndex = -1;
        },

        // ── Add custom (Enter) ────────────────────
        addCustomPart() {
    const name = this.inputVal.trim();
    if (!name) return;

    // Respect maxTags limit
    if (this.maxTags && this.parts.length >= this.maxTags) {
        this.inputVal = '';
        this.isOpen   = false;
        return;
    }

            const match = this.suggestions.find(
                s => (s.label ?? s).toLowerCase() === name.toLowerCase()
            );
            if (match) { this.selectSuggestion(match); return; }

            const exists = this.parts.some(
                p => p.name.toLowerCase() === name.toLowerCase()
            );

            if (exists && this.showQty) {
                const part = this.parts.find(
                    p => p.name.toLowerCase() === name.toLowerCase()
                );
                if (part) part.quantity++;
            } else if (!exists) {
                this.parts.push({
                    product_id : null,
                    name,
                    quantity   : 1,
                    isCustom   : true,
                });
            }

            this.inputVal  = '';
            this.isOpen    = false;
            this.products  = [];
            this.$nextTick(() => this.$refs.theInput?.focus());
        },

        // ── Select suggestion ─────────────────────
        selectSuggestion(s) {
    const name = s.label ?? s;

    // Respect maxTags limit
    if (this.maxTags && this.parts.length >= this.maxTags) {
        this.inputVal = '';
        this.isOpen   = false;
        return;
    }

    if (!this.parts.some(p => p.name.toLowerCase() === name.toLowerCase())) {
        this.parts.push({
                    product_id : null,
                    name,
                    quantity   : 1,
                    isCustom   : false,
                });
            }
            this.inputVal         = '';
            this.isOpen           = false;
            this.highlightedIndex = -1;
            this.$nextTick(() => this.$refs.theInput?.focus());
        },

        // ── Select product from search ────────────
        selectProduct(product) {
            const exists = this.parts.some(
                p => p.product_id && p.product_id === product.id
            );

            if (exists) {
                const part = this.parts.find(p => p.product_id === product.id);
                if (part) part.quantity++;
            } else {
                this.parts.push({
                    product_id : product.id,
                    name       : product.name,
                    quantity   : 1,
                    price      : parseFloat(product.price || 0),
                    stock      : product.stock,
                    isCustom   : false,
                });
            }

            this.inputVal  = '';
            this.isOpen    = false;
            this.products  = [];
            this.$nextTick(() => this.$refs.theInput?.focus());
        },

        // ── Update qty ────────────────────────────
        updateQty(index, value) {
            const qty = parseInt(value) || 1;
            if (this.parts[index]) {
                this.parts[index].quantity = Math.max(1, qty);
            }
        },

        // ── Remove ────────────────────────────────
        removePart(index) {
            this.parts.splice(index, 1);
        },

        // ── Product search ────────────────────────
        async _searchProducts(term) {
            if (!term.trim() || !this.searchUrl) return;
            this.isLoading = true;
            try {
                const params = new URLSearchParams({ search: term });
                const res    = await fetch(
                    `${this.searchUrl}?${params}`,
                    { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                );
                this.products = await res.json();
            } catch (e) {
                console.error('Product search error:', e);
                this.products = [];
            } finally {
                this.isLoading = false;
            }
        },
    };
}