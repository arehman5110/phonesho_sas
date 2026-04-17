<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repair Receipt — <?php echo e($repair->reference); ?></title>

    <style>
        /* ── Reset ───────────────────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ── Base ────────────────────────────────────── */
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #1a1a1a;
            background: #f5f5f5;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 16px;
        }

        /* ── Receipt Container ───────────────────────── */
        .receipt {
            width: 300px;
            background: #fff;
            padding: 24px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }

        /* ── Header ──────────────────────────────────── */
        .receipt-header {
            text-align: center;
            margin-bottom: 16px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #ccc;
        }

        .shop-name {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .shop-meta {
            font-size: 10px;
            color: #555;
            line-height: 1.6;
        }

        /* ── Section Divider ─────────────────────────── */
        .section-divider {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 12px 0;
        }

        /* ── Info Row ────────────────────────────────── */
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .info-row .label {
            color: #666;
        }

        .info-row .value {
            font-weight: 600;
            text-align: right;
            color: #1a1a1a;
        }

        /* ── Section Title ───────────────────────────── */
        .section-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 8px;
        }

        /* ── Device Card ─────────────────────────────── */
        .device-card {
            background: #f9f9f9;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 8px;
        }

        .device-name {
            font-size: 12px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
            padding-bottom: 6px;
            border-bottom: 1px solid #eee;
        }

        .device-field {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            margin-bottom: 3px;
            gap: 8px;
        }

        .device-field .field-label {
            color: #888;
            flex-shrink: 0;
        }

        .device-field .field-value {
            color: #333;
            font-weight: 600;
            text-align: right;
        }

        .parts-list {
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px dotted #ddd;
        }

        .parts-title {
            font-size: 9px;
            text-transform: uppercase;
            color: #999;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }

        .part-item {
            font-size: 10px;
            color: #555;
            padding: 1px 0;
        }

        .part-item::before {
            content: '• ';
            color: #999;
        }

        .device-price {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            font-weight: 700;
            margin-top: 6px;
            padding-top: 6px;
            border-top: 1px solid #eee;
        }

        /* ── Totals ──────────────────────────────────── */
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .total-row .label { color: #555; }
        .total-row .amount { font-weight: 600; }
        .total-row.discount .amount { color: #e53e3e; }

        .grand-total {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: 700;
            padding-top: 8px;
            margin-top: 6px;
            border-top: 2px solid #1a1a1a;
        }

        /* ── Payment ─────────────────────────────────── */
        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .payment-method { color: #555; text-transform: capitalize; }
        .payment-amount { font-weight: 600; }

        /* ── Status Badge ────────────────────────────── */
        .status-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ── Outstanding ─────────────────────────────── */
        .outstanding-box {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 6px;
            padding: 8px 12px;
            margin: 8px 0;
            text-align: center;
        }

        .outstanding-box .label {
            font-size: 10px;
            color: #c53030;
            text-transform: uppercase;
            font-weight: 700;
        }

        .outstanding-box .amount {
            font-size: 14px;
            font-weight: 700;
            color: #c53030;
        }

        /* ── Footer ──────────────────────────────────── */
        .receipt-footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            line-height: 1.6;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px dashed #ccc;
        }

        .receipt-footer .thank-you {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .barcode {
            font-family: 'Courier New', monospace;
            font-size: 9px;
            letter-spacing: 2px;
            color: #aaa;
            margin-top: 10px;
        }

        /* ── Action Buttons ──────────────────────────── */
        .receipt-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
            font-family: sans-serif;
        }

        .btn-print {
            background: #1a1a1a;
            color: #fff;
        }

        .btn-print:hover { background: #333; }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-back:hover { background: #e2e8f0; }

        .btn-email {
            background: #6366f1;
            color: #fff;
        }

        .btn-email:hover { background: #4f46e5; }

        /* ── Print Styles ────────────────────────────── */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                border-radius: 0;
                width: 100%;
                max-width: 80mm;
                padding: 8px;
            }

            .receipt-actions {
                display: none !important;
            }

            @page {
                margin: 0;
                size: 80mm auto;
            }
        }
    </style>
</head>
<body>

<div class="receipt" id="receipt">

    
    <div class="receipt-header">
        <div class="shop-name">
            <?php echo e($settings['receipt_header'] ?? $repair->shop->name); ?>

        </div>
        <div class="shop-meta">
            <?php if($repair->shop->address): ?>
                <?php echo e($repair->shop->address); ?><br>
            <?php endif; ?>
            <?php if($repair->shop->city): ?>
                <?php echo e($repair->shop->city); ?><br>
            <?php endif; ?>
            <?php if($repair->shop->phone): ?>
                Tel: <?php echo e($repair->shop->phone); ?><br>
            <?php endif; ?>
            <?php if($repair->shop->email): ?>
                <?php echo e($repair->shop->email); ?><br>
            <?php endif; ?>
            <?php if(!empty($settings['tax_number'])): ?>
                VAT: <?php echo e($settings['tax_number']); ?><br>
            <?php endif; ?>
            <?php if(!empty($settings['website'])): ?>
                <?php echo e($settings['website']); ?>

            <?php endif; ?>
        </div>
    </div>

    
    <div style="margin-bottom:12px;">
        <div class="info-row">
            <span class="label">Repair #</span>
            <span class="value"><?php echo e($repair->reference); ?></span>
        </div>
        <div class="info-row">
            <span class="label">Date</span>
            <span class="value">
                <?php echo e($repair->created_at->format('d/m/Y H:i')); ?>

            </span>
        </div>
        <?php if($repair->book_in_date): ?>
        <div class="info-row">
            <span class="label">Book-in</span>
            <span class="value">
                <?php echo e($repair->book_in_date->format('d/m/Y')); ?>

            </span>
        </div>
        <?php endif; ?>
        <?php if($repair->completion_date): ?>
        <div class="info-row">
            <span class="label">Est. Completion</span>
            <span class="value">
                <?php echo e($repair->completion_date->format('d/m/Y')); ?>

            </span>
        </div>
        <?php endif; ?>
        <?php if($repair->status): ?>
        <div class="info-row">
            <span class="label">Status</span>
            <span class="value"><?php echo e($repair->status->name); ?></span>
        </div>
        <?php endif; ?>
        <div class="info-row">
            <span class="label">Served by</span>
            <span class="value">
                <?php echo e($repair->createdBy?->name ?? 'Staff'); ?>

            </span>
        </div>
        <?php if($repair->assignedTo): ?>
        <div class="info-row">
            <span class="label">Assigned to</span>
            <span class="value"><?php echo e($repair->assignedTo->name); ?></span>
        </div>
        <?php endif; ?>
        <div class="info-row">
            <span class="label">Delivery</span>
            <span class="value"><?php echo e($repair->delivery_type_label); ?></span>
        </div>
    </div>

    
    <?php if($repair->customer): ?>
    <hr class="section-divider">
    <div style="margin-bottom:12px;">
        <div class="section-title">Customer</div>
        <div class="info-row">
            <span class="label">Name</span>
            <span class="value"><?php echo e($repair->customer->name); ?></span>
        </div>
        <?php if($repair->customer->phone): ?>
        <div class="info-row">
            <span class="label">Phone</span>
            <span class="value"><?php echo e($repair->customer->phone); ?></span>
        </div>
        <?php endif; ?>
        <?php if($repair->customer->email): ?>
        <div class="info-row">
            <span class="label">Email</span>
            <span class="value"><?php echo e($repair->customer->email); ?></span>
        </div>
        <?php endif; ?>
        <?php if($repair->customer->address): ?>
        <div class="info-row">
            <span class="label">Address</span>
            <span class="value"
                  style="max-width:160px;word-break:break-word;">
                <?php echo e($repair->customer->address); ?>

            </span>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    
    <hr class="section-divider">
    <div style="margin-bottom:12px;">
        <div class="section-title">
            Devices (<?php echo e($repair->devices->count()); ?>)
        </div>

        <?php $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="device-card">

            
            <div class="device-name">
                <?php echo e($device->device_name ?? $device->deviceType?->name ?? 'Device'); ?>

                <?php if($device->color): ?>
                    <span style="color:#888;font-weight:400;
                                 font-size:10px;">
                        — <?php echo e($device->color); ?>

                    </span>
                <?php endif; ?>
            </div>

            
            <?php if($device->deviceType): ?>
            <div class="device-field">
                <span class="field-label">Type</span>
                <span class="field-value">
                    <?php echo e($device->deviceType->name); ?>

                </span>
            </div>
            <?php endif; ?>

            <?php if($device->imei): ?>
            <div class="device-field">
                <span class="field-label">IMEI</span>
                <span class="field-value"
                      style="font-family:'Courier New',monospace;
                             font-size:9px;">
                    <?php echo e($device->imei); ?>

                </span>
            </div>
            <?php endif; ?>

            <?php if($device->issue): ?>
            <div class="device-field">
                <span class="field-label">Issues</span>
                <span class="field-value"
                      style="max-width:160px;text-align:right;">
                    <?php echo e($device->issue); ?>

                </span>
            </div>
            <?php endif; ?>

            <?php if($device->repair_type): ?>
            <div class="device-field">
                <span class="field-label">Repair</span>
                <span class="field-value"><?php echo e($device->repair_type); ?></span>
            </div>
            <?php endif; ?>

            <?php if($device->warranty_status !== 'none'): ?>
            <div class="device-field">
                <span class="field-label">Warranty</span>
                <span class="field-value">
                    <?php echo e($device->warranty_label); ?>

                </span>
            </div>
            <?php endif; ?>

            
            <?php if($device->parts->isNotEmpty()): ?>
            <div class="parts-list">
                <div class="parts-title">Parts Used</div>
                <?php $__currentLoopData = $device->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="part-item">
                    <?php echo e($part->name); ?>

                    <?php if($part->quantity > 1): ?>
                        × <?php echo e($part->quantity); ?>

                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>

            
            <div class="device-price">
                <span>Price</span>
                <span>£<?php echo e(number_format($device->price, 2)); ?></span>
            </div>

        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <hr class="section-divider">
    <div style="margin-bottom:12px;">

        <div class="total-row">
            <span class="label">Subtotal</span>
            <span class="amount">
                £<?php echo e(number_format($repair->total_price, 2)); ?>

            </span>
        </div>

        <?php if($repair->discount > 0): ?>
        <div class="total-row discount">
            <span class="label">Discount</span>
            <span class="amount">
                -£<?php echo e(number_format($repair->discount, 2)); ?>

            </span>
        </div>
        <?php endif; ?>

        <div class="grand-total">
            <span>TOTAL</span>
            <span>£<?php echo e(number_format($repair->final_price, 2)); ?></span>
        </div>
    </div>

    
    <?php if($repair->payments->isNotEmpty()): ?>
    <hr class="section-divider">
    <div style="margin-bottom:12px;">
        <div class="section-title">Payments</div>

        <?php $__currentLoopData = $repair->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="payment-row">
            <span class="payment-method">
                <?php if($payment->method === 'split' && $payment->split_part): ?>
                    <?php echo e(ucfirst($payment->split_part)); ?> (split)
                <?php else: ?>
                    <?php echo e(ucfirst($payment->method)); ?>

                <?php endif; ?>
                <?php if($payment->note): ?>
                    <span style="color:#aaa;font-size:9px;">
                        — <?php echo e($payment->note); ?>

                    </span>
                <?php endif; ?>
            </span>
            <span class="payment-amount">
                £<?php echo e(number_format($payment->amount, 2)); ?>

            </span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php
            $totalPaid   = $repair->payments->sum('amount');
            $outstanding = max(0, $repair->final_price - $totalPaid);
        ?>

        <?php if($outstanding > 0): ?>
        <div class="outstanding-box">
            <div class="label">Outstanding Balance</div>
            <div class="amount">
                £<?php echo e(number_format($outstanding, 2)); ?>

            </div>
        </div>
        <?php endif; ?>

    </div>
    <?php endif; ?>

    
    <?php if($repair->notes): ?>
    <hr class="section-divider">
    <div style="margin-bottom:12px;">
        <div class="section-title">Notes</div>
        <p style="font-size:10px;color:#555;line-height:1.5;">
            <?php echo e($repair->notes); ?>

        </p>
    </div>
    <?php endif; ?>

    
    <div class="receipt-footer">
        <div class="thank-you">
            <?php echo e($settings['receipt_footer'] ?? 'Thank you for choosing us!'); ?>

        </div>

        <?php if(!empty($settings['repair_warranty'])): ?>
        <p><?php echo e($settings['repair_warranty']); ?></p>
        <?php endif; ?>

        <?php if(!empty($settings['repair_terms'])): ?>
        <p style="margin-top:4px;"><?php echo e($settings['repair_terms']); ?></p>
        <?php endif; ?>

        <div class="barcode">
            <?php echo e($repair->reference); ?>

        </div>

        <div style="margin-top:6px;font-size:9px;color:#bbb;">
            <?php echo e($repair->created_at->format('d/m/Y H:i:s')); ?>

        </div>
    </div>

</div>


<div class="receipt-actions">

    <button class="btn btn-back"
            onclick="window.history.back()">
        ← Back
    </button>

    <?php if($repair->customer?->email): ?>
    <button class="btn btn-email"
            id="emailBtn"
            onclick="sendReceiptEmail(<?php echo e($repair->id); ?>)">
        ✉ Email
    </button>
    <?php endif; ?>

    <button class="btn btn-print"
            onclick="window.print()">
        🖨 Print
    </button>

</div>

<script>
async function sendReceiptEmail(repairId) {
    const btn = document.getElementById('emailBtn');
    if (!btn) return;

    btn.disabled    = true;
    btn.textContent = 'Sending...';

    try {
        const res = await fetch(`/repairs/${repairId}/email`, {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN'     : '<?php echo e(csrf_token()); ?>',
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            btn.textContent      = '✓ Sent!';
            btn.style.background = '#10b981';
            setTimeout(() => {
                btn.disabled         = false;
                btn.textContent      = '✉ Email';
                btn.style.background = '';
            }, 3000);
        } else {
            alert(data.message || 'Failed to send.');
            btn.disabled    = false;
            btn.textContent = '✉ Email';
        }
    } catch (e) {
        alert('Network error.');
        btn.disabled    = false;
        btn.textContent = '✉ Email';
    }
}
</script>

</body>
</html><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/receipt.blade.php ENDPATH**/ ?>