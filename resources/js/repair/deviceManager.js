/**
 * Device Manager
 * Handles add/remove device cards dynamically
 */

// ── State ─────────────────────────────────────────
const state = {
    deviceIndex : 0,
    deviceCount : 0,
};

// ── Helpers ───────────────────────────────────────
function _el(id) {
    return document.getElementById(id);
}

function _fmt(amount) {
    return '£' + parseFloat(amount || 0).toFixed(2);
}

// ── Add Device ────────────────────────────────────
export function addDevice(deviceTemplate) {
    const container = _el('devicesContainer');
    const empty     = _el('devicesEmpty');

    state.deviceIndex++;
    state.deviceCount++;

    let html = deviceTemplate
        .replace(/__INDEX__/g,  state.deviceIndex)
        .replace(/__NUMBER__/g, state.deviceCount);

    const wrapper     = document.createElement('div');
    wrapper.innerHTML = html.trim();
    const card        = wrapper.firstElementChild;

    card.style.opacity   = '0';
    card.style.transform = 'translateY(10px)';
    container.appendChild(card);

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            card.style.transition = 'all 0.2s ease';
            card.style.opacity    = '1';
            card.style.transform  = 'translateY(0)';
        });
    });

    if (empty) empty.style.display = 'none';

    _updateDeviceCount();
    updateTotals();

    setTimeout(() => {
        card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        if (window.Alpine) Alpine.initTree(card);
    }, 250);
}

// ── Remove Device ─────────────────────────────────
export function removeDevice(btn) {
    const card = btn.closest('.device-card');
    if (!card) return;

    card.style.transition = 'all 0.2s ease';
    card.style.opacity    = '0';
    card.style.transform  = 'translateY(-10px)';

    setTimeout(() => {
        card.remove();
        state.deviceCount--;
        _updateDeviceCount();
        updateTotals();

        if (!document.querySelectorAll('.device-card').length) {
            const empty = _el('devicesEmpty');
            if (empty) empty.style.display = 'flex';
        }
    }, 200);
}

// ── Update Totals ─────────────────────────────────
export function updateTotals() {
    let subtotal = 0;
    document.querySelectorAll('input[name$="[price]"]').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });

    const discount = parseFloat(
        document.querySelector('input[name="discount"]')?.value
    ) || 0;

    const total = Math.max(0, subtotal - discount);

    // Update right panel via RepairPayments if available
    if (window.RepairPayments) {
        window.RepairPayments.updateTotals();
    }
}

// ── Update Count Display ──────────────────────────
function _updateDeviceCount() {
    const count = document.querySelectorAll('.device-card').length;
    const badge = _el('deviceCount');
    const info  = _el('infoDeviceCount');
    if (badge) badge.textContent = `${count} device${count !== 1 ? 's' : ''}`;
    if (info)  info.textContent  = count;
}