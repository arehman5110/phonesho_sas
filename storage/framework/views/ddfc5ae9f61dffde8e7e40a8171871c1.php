<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($title); ?> — <?php echo e($shopName); ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #f8fafc;
            padding: 20px;
        }

        .report-wrap {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* ── Header ── */
        .report-header {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            padding: 24px 28px;
        }
        .report-header h1 { font-size: 20px; font-weight: 800; }
        .report-header .meta {
            margin-top: 6px;
            font-size: 11px;
            opacity: 0.85;
            display: flex;
            gap: 16px;
        }

        /* ── Stats bar ── */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border-bottom: 1px solid #e5e7eb;
        }
        .stat {
            padding: 14px 20px;
            border-right: 1px solid #e5e7eb;
            text-align: center;
        }
        .stat:last-child { border-right: none; }
        .stat-val { font-size: 20px; font-weight: 900; color: #4f46e5; }
        .stat-lbl { font-size: 10px; font-weight: 600; text-transform: uppercase;
                    letter-spacing: .05em; color: #9ca3af; margin-top: 2px; }
        .stat-val.red   { color: #ef4444; }
        .stat-val.green { color: #10b981; }
        .stat-val.amber { color: #f59e0b; }

        /* ── Table ── */
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }
        .report-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: #6b7280;
            white-space: nowrap;
        }
        .report-table tbody tr {
            border-bottom: 1px solid #f3f4f6;
        }
        .report-table tbody tr:last-child { border-bottom: none; }
        .report-table tbody tr:hover { background: #fafafa; }
        .report-table td {
            padding: 9px 14px;
            font-size: 12px;
            color: #374151;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }
        .badge-ok      { background:#dcfce7; color:#166534; }
        .badge-low     { background:#fef9c3; color:#854d0e; }
        .badge-out     { background:#fee2e2; color:#991b1b; }

        .sku { font-family: monospace; font-size: 11px; color: #9ca3af; }
        .right { text-align: right; }
        .bold { font-weight: 700; }

        /* ── Footer ── */
        .report-footer {
            padding: 14px 20px;
            border-top: 1px solid #e5e7eb;
            background: #f8fafc;
            font-size: 10px;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
        }

        /* ── Empty ── */
        .empty {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
        }
        .empty svg { width: 48px; height: 48px; margin: 0 auto 12px; display: block; opacity: .4; }

        /* ── Print ── */
        .print-btn {
            position: fixed;
            top: 16px;
            right: 16px;
            display: flex;
            gap: 8px;
            z-index: 100;
        }
        .btn {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }
        .btn-primary { background: #4f46e5; color: #fff; }
        .btn-primary:hover { background: #4338ca; }
        .btn-back { background: #f3f4f6; color: #374151; text-decoration: none; }
        .btn-back:hover { background: #e5e7eb; }

        @media print {
            body { background: #fff; padding: 0; }
            .print-btn { display: none; }
            .report-wrap { box-shadow: none; border-radius: 0; max-width: 100%; }
        }
    </style>
</head>
<body>


<div class="print-btn">
    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-back">← Back</a>
    <button class="btn btn-primary" onclick="window.print()">🖨 Print</button>
</div>

<div class="report-wrap">

    
    <div class="report-header">
        <h1><?php echo e($title); ?></h1>
        <div class="meta">
            <span>🏪 <?php echo e($shopName); ?></span>
            <span>📅 <?php echo e($date); ?></span>
            <span>📦 <?php echo e($products->count()); ?> products</span>
        </div>
    </div>

    
    <?php
        $lowCount = $products->filter(fn($p) => $p->stock > 0 && $p->stock <= ($p->low_stock_alert ?: 5))->count();
        $outCount = $products->filter(fn($p) => $p->stock <= 0)->count();
        $okCount  = $products->count() - $lowCount - $outCount;
    ?>
    <div class="stats-bar">
        <div class="stat">
            <div class="stat-val"><?php echo e($products->count()); ?></div>
            <div class="stat-lbl">Total Products</div>
        </div>
        <div class="stat">
            <div class="stat-val green"><?php echo e($okCount); ?></div>
            <div class="stat-lbl">In Stock</div>
        </div>
        <div class="stat">
            <div class="stat-val amber"><?php echo e($lowCount); ?></div>
            <div class="stat-lbl">Low Stock</div>
        </div>
        <div class="stat">
            <div class="stat-val red"><?php echo e($outCount); ?></div>
            <div class="stat-lbl">Out of Stock</div>
        </div>
    </div>

    
    <?php if($products->isEmpty()): ?>
    <div class="empty">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <p style="font-weight:700;font-size:14px;color:#6b7280;">No products found for this report</p>
    </div>
    <?php else: ?>
    <table class="report-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Brand</th>
                <th class="right">Cost</th>
                <th class="right">Price</th>
                <th class="right">Stock</th>
                <th class="right">Stock Value</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $stockVal  = $product->stock * ($product->cost_price ?? 0);
                $isOut     = $product->stock <= 0;
                $isLow     = !$isOut && $product->stock <= ($product->low_stock_alert ?: 5);
                $badgeClass = $isOut ? 'badge-out' : ($isLow ? 'badge-low' : 'badge-ok');
                $badgeText  = $isOut ? 'Out' : ($isLow ? 'Low' : 'OK');
            ?>
            <tr>
                <td style="color:#9ca3af;"><?php echo e($i + 1); ?></td>
                <td class="bold"><?php echo e($product->name); ?></td>
                <td class="sku"><?php echo e($product->sku ?: '—'); ?></td>
                <td><?php echo e($product->category?->name ?: '—'); ?></td>
                <td><?php echo e($product->brand?->name ?: '—'); ?></td>
                <td class="right"><?php echo e($product->cost_price ? $currency . number_format($product->cost_price, 2) : '—'); ?></td>
                <td class="right"><?php echo e($currency); ?><?php echo e(number_format($product->sell_price, 2)); ?></td>
                <td class="right bold" style="<?php echo e($isOut ? 'color:#ef4444' : ($isLow ? 'color:#f59e0b' : '')); ?>">
                    <?php echo e($product->stock); ?>

                </td>
                <td class="right"><?php echo e($currency); ?><?php echo e(number_format($stockVal, 2)); ?></td>
                <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e($badgeText); ?></span></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr style="background:#f8fafc;border-top:2px solid #e5e7eb;">
                <td colspan="5" class="bold" style="padding:10px 14px;">Totals</td>
                <td class="right bold" style="padding:10px 14px;">—</td>
                <td class="right bold" style="padding:10px 14px;">—</td>
                <td class="right bold" style="padding:10px 14px;">
                    <?php echo e($products->sum('stock')); ?>

                </td>
                <td class="right bold" style="padding:10px 14px;">
                    <?php echo e($currency); ?><?php echo e(number_format($totalValue, 2)); ?>

                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <?php endif; ?>

    
    <div class="report-footer">
        <span><?php echo e($shopName); ?> · <?php echo e($title); ?></span>
        <span>Generated: <?php echo e($date); ?></span>
    </div>

</div>

</body>
</html><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/products/report.blade.php ENDPATH**/ ?>