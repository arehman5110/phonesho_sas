<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt — <?php echo e($sale->reference); ?></title>

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
            justify-content: center;
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

        /* ── Invoice Info ────────────────────────────── */
        .receipt-info {
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #ccc;
        }

        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .receipt-info-row .label {
            color: #666;
        }

        .receipt-info-row .value {
            font-weight: 600;
            color: #1a1a1a;
            text-align: right;
        }

        /* ── Items ───────────────────────────────────── */
        .items-header {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 6px;
            padding-bottom: 6px;
            border-bottom: 1px solid #eee;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 6px;
            font-size: 11px;
            gap: 8px;
        }

        .item-name {
            flex: 1;
            line-height: 1.4;
        }

        .item-name .qty {
            color: #666;
            font-size: 10px;
        }

        .item-price {
            font-weight: 600;
            white-space: nowrap;
            text-align: right;
        }

        .items-divider {
            border: none;
            border-top: 1px dashed #ccc;
            margin: 10px 0;
        }

        /* ── Totals ──────────────────────────────────── */
        .totals {
            margin-bottom: 14px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .total-row .label {
            color: #555;
        }

        .total-row .amount {
            font-weight: 600;
        }

        .total-row.discount .amount {
            color: #e53e3e;
        }

        .total-row.grand-total {
            font-size: 14px;
            font-weight: 700;
            padding-top: 8px;
            margin-top: 6px;
            border-top: 2px solid #1a1a1a;
        }

        /* ── Payments ────────────────────────────────── */
        .payments-section {
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #ccc;
        }

        .payments-title {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 6px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            margin-bottom: 4px;
        }

        .payment-method {
            color: #555;
            text-transform: capitalize;
        }

        .payment-amount {
            font-weight: 600;
        }

        .payment-status {
            display: inline-block;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-paid    { background: #c6f6d5; color: #276749; }
        .status-partial { background: #bee3f8; color: #2c5282; }
        .status-pending { background: #fefcbf; color: #744210; }

        /* ── Outstanding ─────────────────────────────── */
        .outstanding-box {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 6px;
            padding: 8px 12px;
            margin-bottom: 14px;
            text-align: center;
        }

        .outstanding-box .label {
            font-size: 10px;
            color: #c53030;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        .outstanding-box .amount {
            font-size: 14px;
            font-weight: 700;
            color: #c53030;
            margin-top: 2px;
        }

        /* ── Customer ────────────────────────────────── */
        .customer-section {
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px dashed #ccc;
            font-size: 11px;
        }

        .customer-section .label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #666;
            margin-bottom: 3px;
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

        /* ── Action Buttons (screen only) ────────────── */
        .receipt-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            justify-content: center;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
        }

        .btn-print {
            background: #1a1a1a;
            color: #fff;
        }

        .btn-print:hover {
            background: #333;
        }

        .btn-back {
            background: #f1f5f9;
            color: #475569;
        }

        .btn-back:hover {
            background: #e2e8f0;
        }

        .btn-email {
            background: #6366f1;
            color: #fff;
        }

        .btn-email:hover {
            background: #4f46e5;
        }

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

<div>
    
    <div class="receipt" id="receipt">

        
        <div class="receipt-header">
            <div class="shop-name">
                <?php echo e($settings['receipt_header'] ?? $sale->shop->name); ?>

            </div>
            <div class="shop-meta">
                <?php if($sale->shop->address): ?>
                    <?php echo e($sale->shop->address); ?><br>
                <?php endif; ?>
                <?php if($sale->shop->city): ?>
                    <?php echo e($sale->shop->city); ?><br>
                <?php endif; ?>
                <?php if($sale->shop->phone): ?>
                    Tel: <?php echo e($sale->shop->phone); ?><br>
                <?php endif; ?>
                <?php if($sale->shop->email): ?>
                    <?php echo e($sale->shop->email); ?><br>
                <?php endif; ?>
                <?php if(!empty($settings['tax_number'])): ?>
                    VAT: <?php echo e($settings['tax_number']); ?><br>
                <?php endif; ?>
                <?php if(!empty($settings['website'])): ?>
                    <?php echo e($settings['website']); ?>

                <?php endif; ?>
            </div>
        </div>

        
        <div class="receipt-info">
            <div class="receipt-info-row">
                <span class="label">Receipt #</span>
                <span class="value"><?php echo e($sale->reference); ?></span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Date</span>
                <span class="value">
                    <?php echo e($sale->created_at->format('d/m/Y')); ?>

                </span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Time</span>
                <span class="value">
                    <?php echo e($sale->created_at->format('H:i')); ?>

                </span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Served by</span>
                <span class="value">
                    <?php echo e($sale->createdBy?->name ?? 'Staff'); ?>

                </span>
            </div>
            <div class="receipt-info-row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="payment-status
                        <?php echo e(match($sale->payment_status) {
                            'paid'    => 'status-paid',
                            'partial' => 'status-partial',
                            default   => 'status-pending'
                        }); ?>">
                        <?php echo e(ucfirst($sale->payment_status)); ?>

                    </span>
                </span>
            </div>
        </div>

        
        <?php if($sale->customer): ?>
        <div class="customer-section">
            <div class="label">Customer</div>
            <?php echo e($sale->customer->name); ?>

            <?php if($sale->customer->phone): ?>
                <br><?php echo e($sale->customer->phone); ?>

            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <div class="items-header">
            <span>Item</span>
            <span>Total</span>
        </div>

        <?php $__currentLoopData = $sale->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="item-row">
            <div class="item-name">
                <?php echo e($item->product_name); ?>

                <br>
                <span class="qty">
                    <?php echo e($item->quantity); ?> x
                    £<?php echo e(number_format($item->price, 2)); ?>

                </span>
            </div>
            <div class="item-price">
                £<?php echo e(number_format($item->line_total, 2)); ?>

            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <hr class="items-divider">

        
        <div class="totals">
            <div class="total-row">
                <span class="label">Subtotal</span>
                <span class="amount">
                    £<?php echo e(number_format($sale->total_amount, 2)); ?>

                </span>
            </div>

            <?php if($sale->discount > 0): ?>
            <div class="total-row discount">
                <span class="label">Discount</span>
                <span class="amount">
                    -£<?php echo e(number_format($sale->discount, 2)); ?>

                </span>
            </div>
            <?php endif; ?>

            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>£<?php echo e(number_format($sale->final_amount, 2)); ?></span>
            </div>
        </div>

        
        <?php if($sale->payments->count() > 0): ?>
        <div class="payments-section">
            <div class="payments-title">Payment</div>

            <?php $__currentLoopData = $sale->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="payment-row">
                <span class="payment-method">
                    <?php if($payment->method === 'split' && $payment->split_part): ?>
                        <?php echo e(ucfirst($payment->split_part)); ?> (split)
                    <?php else: ?>
                        <?php echo e(ucfirst($payment->method)); ?>

                    <?php endif; ?>
                    <?php if($payment->note): ?>
                        <br>
                        <small style="color:#999;">
                            <?php echo e($payment->note); ?>

                        </small>
                    <?php endif; ?>
                </span>
                <span class="payment-amount">
                    £<?php echo e(number_format($payment->amount, 2)); ?>

                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php
                $totalPaid   = $sale->payments->sum('amount');
                $change      = max(0, $totalPaid - $sale->final_amount);
                $outstanding = max(0, $sale->final_amount - $totalPaid);
            ?>

            <?php if($change > 0): ?>
            <div class="payment-row" style="margin-top:6px;color:#666;">
                <span>Change</span>
                <span>£<?php echo e(number_format($change, 2)); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        
        <?php if($outstanding > 0): ?>
        <div class="outstanding-box">
            <div class="label">Outstanding Balance</div>
            <div class="amount">
                £<?php echo e(number_format($outstanding, 2)); ?>

            </div>
        </div>
        <?php endif; ?>

        
        <div class="receipt-footer">
            <div class="thank-you">
                <?php echo e($settings['receipt_footer'] ?? 'Thank you for your business!'); ?>

            </div>

            <?php if(!empty($settings['receipt_terms'])): ?>
            <p><?php echo e($settings['receipt_terms']); ?></p>
            <?php endif; ?>

            <div class="barcode">
                <?php echo e($sale->reference); ?>

            </div>

            <div style="margin-top:8px;font-size:9px;color:#bbb;">
                <?php echo e($sale->created_at->format('d/m/Y H:i:s')); ?>

            </div>
        </div>

    </div>

    
    <div class="receipt-actions">

        <button class="btn btn-back"
                onclick="window.history.back()">
            ← Back
        </button>

        <?php if($sale->customer?->email): ?>
        <button class="btn btn-email"
                onclick="sendReceiptEmail(<?php echo e($sale->id); ?>)">
            ✉ Email
        </button>
        <?php endif; ?>

        <button class="btn btn-print"
                onclick="window.print()">
            🖨 Print
        </button>

    </div>
</div>

<script>
async function sendReceiptEmail(saleId) {
    const btn = document.querySelector('.btn-email');
    if (!btn) return;

    btn.disabled     = true;
    btn.textContent  = 'Sending...';

    try {
        const res = await fetch(`/sales/${saleId}/email`, {
            method  : 'POST',
            headers : {
                'X-CSRF-TOKEN'     : '<?php echo e(csrf_token()); ?>',
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
        });

        const data = await res.json();

        if (data.success) {
            btn.textContent = '✓ Sent!';
            btn.style.background = '#10b981';
            setTimeout(() => {
                btn.disabled     = false;
                btn.textContent  = '✉ Email';
                btn.style.background = '';
            }, 3000);
        } else {
            alert(data.message || 'Failed to send email.');
            btn.disabled    = false;
            btn.textContent = '✉ Email';
        }

    } catch (e) {
        alert('Network error. Please try again.');
        btn.disabled    = false;
        btn.textContent = '✉ Email';
    }
}
</script>

</body>
</html><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/pos/receipt.blade.php ENDPATH**/ ?>