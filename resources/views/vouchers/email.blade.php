<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f5f5f5;padding:30px;}
.wrap{max-width:480px;margin:0 auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);}
.header{background:#4f46e5;color:#fff;padding:28px 28px 20px;text-align:center;}
.header h1{font-size:22px;margin:0 0 4px;}
.header p{font-size:13px;opacity:.85;margin:0;}
.body{padding:28px;}
.code-box{text-align:center;border:2px dashed #4f46e5;border-radius:8px;padding:16px;margin:16px 0;}
.code{font-family:monospace;font-size:26px;font-weight:900;letter-spacing:4px;color:#1f2937;}
.value{font-size:18px;font-weight:700;color:#4f46e5;margin-top:6px;}
.meta{background:#f9fafb;border-radius:8px;padding:12px 16px;margin:16px 0;font-size:13px;color:#374151;}
.meta-row{display:flex;justify-content:space-between;padding:3px 0;}
.msg{font-size:14px;color:#374151;line-height:1.6;margin-bottom:16px;}
.footer{border-top:1px solid #e5e7eb;padding:16px 28px;font-size:11px;color:#9ca3af;text-align:center;}
</style></head>
<body>
<div class="wrap">
    <div class="header">
        <h1>🎟 Your Voucher</h1>
        <p>{{ $shop?->name ?? config('app.name') }}</p>
    </div>
    <div class="body">
        @if($message)
        <p class="msg">{{ $message }}</p>
        @endif
        <div class="code-box">
            <div class="code">{{ $voucher->code }}</div>
            <div class="value">{{ $voucher->formatted_value }} OFF</div>
        </div>
        <div class="meta">
            @if($voucher->min_order_amount > 0)
            <div class="meta-row"><span>Min order</span><span>£{{ number_format($voucher->min_order_amount,2) }}</span></div>
            @endif
            @if($voucher->usage_limit)
            <div class="meta-row"><span>Uses remaining</span><span>{{ max(0, $voucher->usage_limit - $voucher->used_count) }}</span></div>
            @endif
            @if($voucher->expiry_date)
            <div class="meta-row"><span>Expires</span><span>{{ \Carbon\Carbon::parse($voucher->expiry_date)->format('d/m/Y') }}</span></div>
            @else
            <div class="meta-row"><span>Expires</span><span>Never</span></div>
            @endif
        </div>
    </div>
    <div class="footer">{{ $shop?->name }} · {{ now()->format('d/m/Y') }}</div>
</div>
</body>
</html>