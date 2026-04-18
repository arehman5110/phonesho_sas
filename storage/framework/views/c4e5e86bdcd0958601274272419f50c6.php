<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Voucher <?php echo e($voucher->code); ?></title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body {
    font-family: 'Courier New', monospace;
    font-size: 12px;
    background: #f5f5f5;
    display: flex;
    justify-content: center;
    padding: 20px;
}
.receipt {
    width: 300px;
    background: #fff;
    padding: 20px 16px;
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
}
.shop-name { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 2px; }
.shop-sub  { font-size: 11px; text-align: center; color: #666; margin-bottom: 12px; }
.divider   { border: none; border-top: 1px dashed #ccc; margin: 10px 0; }
.title     { font-size: 13px; font-weight: bold; text-align: center; margin: 8px 0 12px; letter-spacing: 1px; }
.code-box  {
    text-align: center; font-size: 22px; font-weight: 900; letter-spacing: 3px;
    border: 2px dashed #333; padding: 10px; margin: 10px 0; border-radius: 4px;
}
.value     { text-align: center; font-size: 18px; font-weight: bold; margin: 6px 0; }
.row       { display: flex; justify-content: space-between; margin: 3px 0; font-size: 11px; }
.row .lbl  { color: #666; }
.footer    { text-align: center; font-size: 10px; color: #999; margin-top: 12px; }
.no-print  {
    text-align: center; margin-top: 16px;
    display: flex; gap: 8px; justify-content: center;
}
.btn {
    padding: 7px 18px; border-radius: 6px; font-size: 12px;
    font-weight: 700; border: none; cursor: pointer;
}
.btn-print { background: #4f46e5; color: #fff; }
.btn-close { background: #f3f4f6; color: #374151; text-decoration: none; display: inline-flex; align-items: center; }
@media print {
    body { background:#fff; padding:0; }
    .no-print { display:none; }
    .receipt { box-shadow:none; }
}
</style>
</head>
<body>
<div>
    <div class="receipt">
        <p class="shop-name"><?php echo e($shop?->name ?? config('app.name')); ?></p>
        <?php if($shop?->address): ?><p class="shop-sub"><?php echo e($shop->address); ?></p><?php endif; ?>
        <?php if($shop?->phone): ?><p class="shop-sub"><?php echo e($shop->phone); ?></p><?php endif; ?>

        <hr class="divider">
        <p class="title">🎟 DISCOUNT VOUCHER</p>
        <div class="code-box"><?php echo e($voucher->code); ?></div>
        <p class="value"><?php echo e($voucher->formatted_value); ?> OFF</p>
        <hr class="divider">

        <?php if($voucher->min_order_amount > 0): ?>
        <div class="row"><span class="lbl">Min Order:</span><span>£<?php echo e(number_format($voucher->min_order_amount,2)); ?></span></div>
        <?php endif; ?>
        <?php if($voucher->usage_limit): ?>
        <div class="row"><span class="lbl">Uses:</span><span><?php echo e($voucher->used_count); ?> / <?php echo e($voucher->usage_limit); ?></span></div>
        <?php endif; ?>
        <?php if($voucher->expiry_date): ?>
        <div class="row"><span class="lbl">Expires:</span><span><?php echo e(\Carbon\Carbon::parse($voucher->expiry_date)->format('d/m/Y')); ?></span></div>
        <?php endif; ?>
        <?php if($voucher->assignedCustomer): ?>
        <div class="row"><span class="lbl">For:</span><span><?php echo e($voucher->assignedCustomer->name); ?></span></div>
        <?php endif; ?>

        <hr class="divider">
        <p class="footer"><?php echo e(now()->format('d/m/Y H:i')); ?> · <?php echo e($shop?->name); ?></p>
        <p class="footer" style="margin-top:4px;">Present this voucher at checkout</p>
    </div>

    <div class="no-print">
        <a href="<?php echo e(route('vouchers.index')); ?>" class="btn btn-close">← Back</a>
        <button class="btn btn-print" onclick="window.print()">🖨 Print</button>
    </div>
</div>
<script>window.onload = () => window.print();</script>
</body>
</html><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/vouchers/print.blade.php ENDPATH**/ ?>