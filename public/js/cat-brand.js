/**
 * Categories & Brands Manager
 * Handles all AJAX CRUD operations
 * Namespace: CatBrand
 */
function CatBrand() {
    return {

        // ── State ─────────────────────────────────
        tab             : 'categories',
        search          : '',
        categories      : [],
        brands          : [],
        categoriesTotal : 0,
        brandsTotal     : 0,
        isLoading       : false,
        showForm        : false,
        editMode        : false,
        selectedId      : null,
        isSaving        : false,
        formError       : '',
        formErrors      : {},

        form: {
            name       : '',
            type       : 'accessories',
            sort_order : 0,
            is_active  : true,
        },

        // ── Config (set from Blade) ────────────────
        routes : {},
        csrf   : '',

        // ── Init ──────────────────────────────────
  init() {
    this.csrf   = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    this.routes = window.CAT_BRAND_ROUTES ?? this.routes;

    this.$nextTick(() => {
        this.fetchCategories();
        this.fetchBrands();
    });
},

        // ── Switch Tab ────────────────────────────
        switchTab(tab) {
            this.tab        = tab;
            this.search     = '';
            this.showForm   = false;
            this.selectedId = null;
            this.formError  = '';
            this.formErrors = {};
            this.fetchList();
        },

        // ── Fetch (current tab) ───────────────────
        fetchList() {
            if (this.tab === 'categories') {
                this.fetchCategories();
            } else {
                this.fetchBrands();
            }
        },

        // ── Fetch Categories ──────────────────────
        async fetchCategories() {
            this.isLoading = true;
            try {
                const params = new URLSearchParams({ _ajax: '1' });
                if (this.search.trim()) params.set('search', this.search);

                const res  = await fetch(
                    `${this.routes.categories.list}?${params}`,
                    { headers: this._headers() }
                );
                const data = await res.json();
                this.categories      = data.categories ?? [];
                this.categoriesTotal = data.total      ?? 0;
            } catch (e) {
                console.error('Fetch categories error:', e);
            } finally {
                this.isLoading = false;
            }
        },

        // ── Fetch Brands ──────────────────────────
        async fetchBrands() {
            this.isLoading = true;
            try {
                const params = new URLSearchParams({ _ajax: '1' });
                if (this.search.trim()) params.set('search', this.search);

                const res  = await fetch(
                    `${this.routes.brands.list}?${params}`,
                    { headers: this._headers() }
                );
                const data = await res.json();
                this.brands      = data.brands ?? [];
                this.brandsTotal = data.total   ?? 0;
            } catch (e) {
                console.error('Fetch brands error:', e);
            } finally {
                this.isLoading = false;
            }
        },

        // ── Open Create ───────────────────────────
        openCreate() {
            this.editMode   = false;
            this.selectedId = null;
            this.formError  = '';
            this.formErrors = {};
            this.form = {
                name      : '',
                type      : 'accessories',
                sort_order: 0,
                is_active : true,
            };
            this.showForm = true;
            this.$nextTick(() => this.$refs.nameInput?.focus());
        },

        // ── Edit Item ─────────────────────────────
        editItem(item) {
            this.editMode   = true;
            this.selectedId = item.id;
            this.formError  = '';
            this.formErrors = {};
            this.form = {
                name      : item.name,
                type      : item.type       ?? 'accessories',
                sort_order: item.sort_order ?? 0,
                is_active : item.is_active,
            };
            this.showForm = true;
            this.$nextTick(() => this.$refs.nameInput?.focus());
        },

        // ── Save ──────────────────────────────────
        async saveItem() {
            this.formError  = '';
            this.formErrors = {};

            if (!this.form.name.trim()) {
                this.formErrors.name = 'Name is required.';
                this.$refs.nameInput?.focus();
                return;
            }

            this.isSaving = true;

            const isCategories = this.tab === 'categories';
            const r            = isCategories
                ? this.routes.categories
                : this.routes.brands;

            const url    = this.editMode
                ? r.update.replace('{id}', this.selectedId)
                : r.store;

            const method = this.editMode ? 'PUT' : 'POST';

            const body = isCategories
                ? {
                    name      : this.form.name.trim(),
                    type      : this.form.type,
                    sort_order: parseInt(this.form.sort_order) || 0,
                    is_active : this.form.is_active,
                }
                : {
                    name      : this.form.name.trim(),
                    sort_order: parseInt(this.form.sort_order) || 0,
                    is_active : this.form.is_active,
                };

            try {
                const res  = await fetch(url, {
                    method,
                    headers: {
                        ...this._headers(),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                const data = await res.json();

                if (data.success) {
                    this._toast(data.message, 'success');
                    this.closeForm();
                    this.fetchCategories();
                    this.fetchBrands();
                } else if (data.errors) {
                    this.formErrors = Object.fromEntries(
                        Object.entries(data.errors)
                            .map(([k, v]) => [k, Array.isArray(v) ? v[0] : v])
                    );
                    this.$refs.nameInput?.focus();
                } else {
                    this.formError = data.message || 'Failed to save.';
                }

            } catch (e) {
                this.formError = 'Network error. Please try again.';
            } finally {
                this.isSaving = false;
            }
        },

        // ── Delete ────────────────────────────────
        async deleteItem(id, name) {
            if (!confirm(`Delete "${name}"?`)) return;

            const r = this.tab === 'categories'
                ? this.routes.categories
                : this.routes.brands;

            const url = r.destroy.replace('{id}', id);

            try {
                const res  = await fetch(url, {
                    method  : 'DELETE',
                    headers : {
                        ...this._headers(),
                        'Content-Type': 'application/json',
                    },
                });

                const data = await res.json();

                if (data.success) {
                    this._toast(data.message, 'success');
                    if (this.selectedId === id) this.closeForm();
                    this.fetchCategories();
                    this.fetchBrands();
                } else {
                    this._toast(data.message || 'Cannot delete.', 'error');
                }

            } catch (e) {
                this._toast('Network error.', 'error');
            }
        },

        // ── Close Form ────────────────────────────
        closeForm() {
            this.showForm   = false;
            this.editMode   = false;
            this.selectedId = null;
            this.formError  = '';
            this.formErrors = {};
        },

        // ── Helpers ───────────────────────────────
        _headers() {
            return {
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
                'X-CSRF-TOKEN'     : this.csrf,
            };
        },

        _toast(message, type = 'success') {
            const existing = document.getElementById('cb-toast');
            if (existing) existing.remove();

            const el = document.createElement('div');
            el.id    = 'cb-toast';
            el.style.cssText = `
                position:fixed;bottom:24px;right:24px;z-index:9999;
                padding:10px 18px;border-radius:12px;color:#fff;
                font-size:0.85rem;font-weight:700;max-width:300px;
                box-shadow:0 8px 24px rgba(0,0,0,0.15);
                background:${type === 'success' ? '#10b981' : '#ef4444'};
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
        },
    };
}

// Auto-init when Alpine loads
document.addEventListener('alpine:init', () => {
    Alpine.data('CatBrand', CatBrand);
});