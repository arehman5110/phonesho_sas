/**
 * RepairTypeInput
 * Alpine.js component for searchable repair type field
 * Searches existing types + allows custom input
 * Registered globally as window.RepairTypeInput
 */

export function RepairTypeInput(inputName) {
    return {
        // ── State ─────────────────────────────────
        inputName,
        inputVal   : '',
        results    : [],
        isOpen     : false,
        isLoading  : false,
        searchTimer: null,

        // ── Route ─────────────────────────────────
        get searchRoute() {
            return window.REPAIR_CONFIG?.routes?.repairTypes
                ?? '/api/repair-types';
        },

        // ── Input ─────────────────────────────────
        onInput() {
            this.isOpen = true;
            clearTimeout(this.searchTimer);

            if (!this.inputVal.trim()) {
                this.results = [];
                return;
            }

            this.searchTimer = setTimeout(
                () => this._search(this.inputVal),
                300
            );
        },

        onFocus() {
            this.isOpen = true;
            this._search(this.inputVal || '');
        },

        onBlur() {
            setTimeout(() => { this.isOpen = false; }, 200);
        },

        closeDropdown() {
            this.isOpen = false;
        },

        // ── Select ────────────────────────────────
        select(type) {
            this.inputVal = type.name;
            this.isOpen   = false;
            this.$nextTick(() => this.$refs.repairTypeInput?.focus());
        },

        confirmInput() {
            const val = this.inputVal.trim();
            if (!val) return;
            const match = this.results.find(
                r => r.name.toLowerCase() === val.toLowerCase()
            );
            if (match) this.inputVal = match.name;
            this.isOpen = false;
        },

        clear() {
            this.inputVal = '';
            this.results  = [];
            this.isOpen   = false;
            this.$nextTick(() => this.$refs.repairTypeInput?.focus());
        },

        // ── Search ────────────────────────────────
        async _search(term) {
            this.isLoading = true;
            try {
                const params = new URLSearchParams();
                if (term.trim()) params.set('q', term);

                const res = await fetch(
                    `${this.searchRoute}?${params}`,
                    { headers: { 'X-Requested-With': 'XMLHttpRequest' } }
                );
                this.results = await res.json();
            } catch (e) {
                console.error('Repair type search:', e);
                this.results = [];
            } finally {
                this.isLoading = false;
            }
        },
    };
}