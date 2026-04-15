<x-mail::message>

{{-- ── Header ─────────────────────────────────────────── --}}
# {{ $settings['receipt_header'] ?? $sale->shop->name }}

@if($sale->shop->address)
{{ $sale->shop->address }}
@endif
@if($sale->shop->phone)
Tel: {{ $sale->shop->phone }}
@endif
@if(!empty($settings['tax_number']))
VAT: {{ $settings['tax_number'] }}
@endif

---

{{-- ── Invoice Info ─────────────────────────────────────── --}}
**Receipt #:** {{ $sale->reference }}
**Date:** {{ $sale->created_at->format('d/m/Y H:i') }}
**Served by:** {{ $sale->createdBy?->name ?? 'Staff' }}
**Status:**
@if($sale->payment_status === 'paid')
✅ Paid
@elseif($sale->payment_status === 'partial')
🔵 Partial Payment
@else
🟡 Pending
@endif

---

{{-- ── Customer ─────────────────────────────────────────── --}}
@if($sale->customer)
**Customer:** {{ $sale->customer->name }}
@if($sale->customer->phone)
**Phone:** {{ $sale->customer->phone }}
@endif

---
@endif

{{-- ── Items ────────────────────────────────────────────── --}}
## Items

<x-mail::table>
| Item | Qty | Price | Total |
|:-----|:---:|------:|------:|
@foreach($sale->items as $item)
| {{ $item->product_name }} | {{ $item->quantity }} | £{{ number_format($item->price, 2) }} | £{{ number_format($item->line_total, 2) }} |
@endforeach
</x-mail::table>

---

{{-- ── Totals ────────────────────────────────────────────── --}}
**Subtotal:** £{{ number_format($sale->total_amount, 2) }}

@if($sale->discount > 0)
**Discount:** -£{{ number_format($sale->discount, 2) }}
@endif

**Total: £{{ number_format($sale->final_amount, 2) }}**

---

{{-- ── Payments ─────────────────────────────────────────── --}}
## Payment

<x-mail::table>
| Method | Amount |
|:-------|-------:|
@foreach($sale->payments as $payment)
| @if($payment->method === 'split' && $payment->split_part)
{{ ucfirst($payment->split_part) }} (split)
@else
{{ ucfirst($payment->method) }}
@endif
@if($payment->note) — {{ $payment->note }}@endif | £{{ number_format($payment->amount, 2) }} |
@endforeach
</x-mail::table>

@if($change > 0)
**Change Due:** £{{ number_format($change, 2) }}
@endif

@if($outstanding > 0)
> ⚠️ **Outstanding Balance: £{{ number_format($outstanding, 2) }}**
@endif

---

{{-- ── Footer ──────────────────────────────────────────── --}}
{{ $settings['receipt_footer'] ?? 'Thank you for your business!' }}

@if(!empty($settings['receipt_terms']))
*{{ $settings['receipt_terms'] }}*
@endif

@if(!empty($settings['website']))
🌐 {{ $settings['website'] }}
@endif

<x-mail::button :url="url('/pos/' . $sale->id . '/receipt')" color="green">
View Receipt Online
</x-mail::button>

{{ $settings['email_footer'] ?? '' }}

Thanks,
**{{ $sale->shop->name }}**

</x-mail::message>