<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
 <?php $__env->slot('title', null, []); ?> Point of Sale <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ── Layout ─────────────────────────────────────────── */
main { padding: 0 !important; }

#pos-wrapper {
    height: calc(100vh - 4rem);
    display: flex;
    overflow: hidden;
    background: #f8fafc;
}
.dark #pos-wrapper { background: #0f172a; }

/* ── Left Panel ──────────────────────────────────────── */
#pos-left {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #e2e8f0;
    background: #f8fafc;
}
.dark #pos-left {
    border-color: #1e293b;
    background: #0f172a;
}

/* ── Right Panel ─────────────────────────────────────── */
#pos-right {
    width: 320px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    background: #fff;
    border-left: 1px solid #e2e8f0;
}
.dark #pos-right {
    background: #111827;
    border-color: #1e293b;
}

/* ── Product Cards ───────────────────────────────────── */
.pos-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    cursor: pointer;
    transition: all 0.15s ease;
    aspect-ratio: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    position: relative;
}
.dark .pos-card {
    background: #1e293b;
    border-color: #334155;
}
.pos-card:hover {
    border-color: #6366f1;
    box-shadow: 0 4px 16px rgba(99,102,241,0.15);
    transform: translateY(-2px);
}
.pos-card.in-cart {
    border-color: #6366f1;
    background: #eef2ff;
}
.dark .pos-card.in-cart {
    background: #1e1b4b;
    border-color: #818cf8;
}

/* ── Customer Dropdown ───────────────────────────────── */
.customer-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    z-index: 100;
    max-height: 220px;
    overflow-y: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.customer-dropdown::-webkit-scrollbar { display: none; }
.dark .customer-dropdown {
    background: #1e293b;
    border-color: #334155;
}
.customer-option {
    padding: 9px 12px;
    cursor: pointer;
    font-size: 0.8rem;
    transition: background 0.1s;
    color: #1e293b;
}
.dark .customer-option { color: #e2e8f0; }
.customer-option:hover { background: #f1f5f9; }
.dark .customer-option:hover { background: #334155; }

/* ── Payment Method Buttons ──────────────────────────── */
.method-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding: 11px 6px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.15s;
    background: #fff;
    color: #64748b;
    font-size: 0.72rem;
    font-weight: 700;
}
.dark .method-btn {
    background: #1e293b;
    border-color: #334155;
    color: #94a3b8;
}
.method-btn svg { width: 20px; height: 20px; }
.method-btn.active {
    border-color: #10b981;
    background: #ecfdf5;
    color: #10b981;
}
.dark .method-btn.active {
    background: #064e3b;
    border-color: #34d399;
    color: #34d399;
}

/* ── Modal Overlay ───────────────────────────────────── */
.pos-modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 50;
    background: rgba(15,23,42,0.75);
    align-items: center;
    justify-content: center;
    padding: 16px;
}
.pos-modal-box {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    box-shadow: 0 24px 48px rgba(0,0,0,0.2);
    transition: all 0.2s;
    transform: scale(0.95);
    opacity: 0;
    overflow: hidden;
    scrollbar-width: none;
    -ms-overflow-style: none;
}
.pos-modal-box::-webkit-scrollbar { display: none; }
.dark .pos-modal-box {
    background: #1e293b;
    color: #e2e8f0;
}
.pos-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
}
.dark .pos-modal-header { border-color: #334155; }
.pos-modal-title {
    font-weight: 800;
    font-size: 1rem;
    color: #1e293b;
    margin: 0;
}
.dark .pos-modal-title { color: #f1f5f9; }
.pos-modal-close {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: none;
    background: #f1f5f9;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: #64748b;
    flex-shrink: 0;
    transition: all 0.15s;
}
.dark .pos-modal-close { background: #334155; color: #94a3b8; }
.pos-modal-close:hover { background: #fee2e2; color: #ef4444; }
.pos-modal-body {
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.pos-modal-footer {
    padding: 0 22px 22px;
}

/* ── Form Inputs ─────────────────────────────────────── */
.pos-input {
    width: 100%;
    padding: 10px 12px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.85rem;
    outline: none;
    box-sizing: border-box;
    background: #f8fafc;
    color: #1e293b;
    transition: border 0.15s;
    font-weight: 500;
}
.dark .pos-input {
    background: #0f172a;
    border-color: #334155;
    color: #e2e8f0;
}
.pos-input:focus { border-color: #6366f1; }
.pos-label {
    font-size: 0.62rem;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    display: block;
    margin-bottom: 5px;
}

/* ── Split Payment Cards ─────────────────────────────── */
.split-card {
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 10px;
}
.split-card-1 { background: #f0f4ff; }
.split-card-2 { background: #f0fdf4; }
.dark .split-card-1 { background: #1e1b4b; }
.dark .split-card-2 { background: #064e3b33; }

/* ── Discount Toggle ─────────────────────────────────── */
.disc-type-btn {
    flex: 1;
    padding: 10px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s;
    border: 2px solid #e2e8f0;
    background: #fff;
    color: #94a3b8;
}
.dark .disc-type-btn { background: #0f172a; color: #64748b; border-color: #334155; }
.disc-type-btn.active {
    border-color: #6366f1;
    background: #6366f1;
    color: #fff;
}

/* ── Cart Items ──────────────────────────────────────── */
.cart-item-row {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
}
.dark .cart-item-row { border-color: #1e293b; }
.cart-item-row:last-child { border-bottom: none; }

.qty-btn {
    width: 24px;
    height: 24px;
    border-radius: 8px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    cursor: pointer;
    font-weight: 800;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    transition: all 0.1s;
    flex-shrink: 0;
}
.dark .qty-btn { background: #1e293b; border-color: #334155; color: #94a3b8; }
.qty-btn:hover.minus { background: #fee2e2; border-color: #fca5a5; color: #ef4444; }
.qty-btn:hover.plus  { background: #dcfce7; border-color: #86efac; color: #16a34a; }

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 768px) {
    #pos-wrapper { flex-direction: column; height: auto; }
    #pos-right   { width: 100%; height: 460px;
                   border-top: 1px solid #e2e8f0; border-left: none; }
}

/* ── Loading Pulse ───────────────────────────────────── */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.5; }
}
</style>
<?php $__env->stopPush(); ?>

<div id="pos-wrapper">
    <?php echo $__env->make('pos.partials.left-panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('pos.partials.cart', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>


<?php echo $__env->make('pos.partials.modals.custom-item', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pos.partials.modals.discount', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pos.partials.modals.payment', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/pos.js')); ?>"></script>
<script>
    // Boot POS with server-side config
   window.POS_CONFIG = {
    routes: {
        categories : '<?php echo e(route("categories.search")); ?>',
        brands     : '<?php echo e(route("brands.filter")); ?>',
        products   : '<?php echo e(route("products.search")); ?>',
        store      : '<?php echo e(route("pos.store")); ?>',
        customers  : '<?php echo e(route("customers.search")); ?>',
        addPayment : '/pos/{id}/pay',
        summary    : '/pos/{id}/summary',
    },
    csrf    : '<?php echo e(csrf_token()); ?>',
    currency: '£',
};
 document.addEventListener('DOMContentLoaded', () => POS.init(window.POS_CONFIG));
</script>
<?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/pos/index.blade.php ENDPATH**/ ?>