/**
 * UI Helpers
 * Shared utility functions used across all modules
 */

export function _el(id) {
    return document.getElementById(id);
}

export function _fmt(amount) {
    return '£' + parseFloat(amount || 0).toFixed(2);
}

export function _esc(str) {
    if (!str) return '';
    const d = document.createElement('div');
    d.textContent = String(str);
    return d.innerHTML;
}

export function _capitalize(str) {
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
}

export function _setText(id, text) {
    const el = _el(id);
    if (el) el.textContent = text;
}

export function _toast(message, type = 'success') {
    const existing = document.getElementById('repair-toast');
    if (existing) existing.remove();

    const colors = {
        success : '#10b981',
        error   : '#ef4444',
        warning : '#f59e0b',
    };

    const el        = document.createElement('div');
    el.id           = 'repair-toast';
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
    }, 3500);
}

export function showModal(modalId, boxId) {
    const modal = _el(modalId);
    const box   = _el(boxId);
    if (!modal || !box) return;
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            box.style.transform = 'scale(1)';
            box.style.opacity   = '1';
        });
    });
}

export function hideModal(modalId, boxId) {
    const modal = _el(modalId);
    const box   = _el(boxId);
    if (!modal || !box) return;
    box.style.transform = 'scale(0.95)';
    box.style.opacity   = '0';
    setTimeout(() => modal.style.display = 'none', 180);
}