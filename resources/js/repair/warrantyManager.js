export function updateWarrantyExpiry(input) {
    const days = parseInt(input.value);
    const card = input.closest('.device-card');
    if (!card) return;

    // Update hidden warranty_status field
    const statusInput = card.querySelector('input[name$="[warranty_status]"]');
    if (statusInput) {
        if (days === -1) {
            statusInput.value = 'under_warranty';
        } else if (days > 0) {
            statusInput.value = 'active';
        } else {
            statusInput.value = 'none';
        }
    }
}