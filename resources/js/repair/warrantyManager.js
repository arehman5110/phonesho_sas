export function updateWarrantyExpiry(input) {
    const days = parseInt(input.value) || 0;

    const card = input.closest('.device-card');
    if (!card) return;

    // Update hidden warranty_status based on days
    const statusInput = card.querySelector('input[name$="[warranty_status]"]');
    if (statusInput) {
        statusInput.value = days > 0 ? 'active' : 'none';
    }
}