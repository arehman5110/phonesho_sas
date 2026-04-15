<x-mail::message>

{{-- ── Header ─────────────────────────────────────────── --}}
# {{ $settings['receipt_header'] ?? $repair->shop->name }}

@if($repair->shop->address)
{{ $repair->shop->address }}
@endif
@if($repair->shop->phone)
Tel: {{ $repair->shop->phone }}
@endif
@if(!empty($settings['tax_number']))
VAT: {{ $settings['tax_number'] }}
@endif

---

{{-- ── Repair Info ──────────────────────────────────────── --}}
**Repair #:** {{ $repair->reference }}
**Date:** {{ $repair->created_at->format('d/m/Y H:i') }}
@if($repair->book_in_date)
**Book-in:** {{ $repair->book_in_date->format('d/m/Y') }}
@endif
@if($repair->completion_date)
**Est. Completion:** {{ $repair->completion_date->format('d/m/Y') }}
@endif
@if($repair->status)
**Status:** {{ $repair->status->name }}
@endif
**Served by:** {{ $repair->createdBy?->name ?? 'Staff' }}
**Delivery:** {{ $repair->delivery_type_label }}

---

{{-- ── Customer ─────────────────────────────────────────── --}}
@if($repair->customer)
## Customer

**{{ $repair->customer->name }}**
@if($repair->customer->phone)
📞 {{ $repair->customer->phone }}
@endif
@if($repair->customer->email)
✉ {{ $repair->customer->email }}
@endif
@if($repair->customer->address)
📍 {{ $repair->customer->address }}
@endif

---
@endif

{{-- ── Devices ───────────────────────────────────────────── --}}
## Devices ({{ $repair->devices->count() }})

@foreach($repair->devices as $device)
### 📱 {{ $device->device_name ?? $device->deviceType?->name ?? 'Device' }}

<x-mail::table>
| Field | Detail |
|:------|:-------|
@if($device->deviceType)
| Type | {{ $device->deviceType->name }} |
@endif
@if($device->color)
| Color | {{ $device->color }} |
@endif
@if($device->imei)
| IMEI | `{{ $device->imei }}` |
@endif
@if($device->issue)
| Issues | {{ $device->issue }} |
@endif
@if($device->repair_type)
| Repair Type | {{ $device->repair_type }} |
@endif
@if($device->warranty_status !== 'none')
| Warranty | {{ $device->warranty_label }} |
@endif
| Price | **£{{ number_format($device->price, 2) }}** |
</x-mail::table>

@if($device->parts->isNotEmpty())
**Parts Used:**
@foreach($device->parts as $part)
- {{ $part->name }}@if($part->quantity > 1) × {{ $part->quantity }}@endif
@endforeach
@endif

@if(!$loop->last)
---
@endif

@endforeach

---

{{-- ── Totals ────────────────────────────────────────────── --}}
## Summary

<x-mail::table>
| | |
|:--|--:|
| Subtotal | £{{ number_format($repair->total_price, 2) }} |
@if($repair->discount > 0)
| Discount | -£{{ number_format($repair->discount, 2) }} |
@endif
| **Total** | **£{{ number_format($repair->final_price, 2) }}** |
</x-mail::table>

---

{{-- ── Payments ─────────────────────────────────────────── --}}
@if($repair->payments->isNotEmpty())
## Payments

<x-mail::table>
| Method | Amount |
|:-------|-------:|
@foreach($repair->payments as $payment)
| @if($payment->method === 'split' && $payment->split_part)
{{ ucfirst($payment->split_part) }} (split)
@else
{{ ucfirst($payment->method) }}
@endif
@if($payment->note) — {{ $payment->note }}@endif | £{{ number_format($payment->amount, 2) }} |
@endforeach
</x-mail::table>

@if($outstanding > 0)
> ⚠️ **Outstanding Balance: £{{ number_format($outstanding, 2) }}**
@else
> ✅ **Fully Paid**
@endif

---
@endif

{{-- ── Notes ────────────────────────────────────────────── --}}
@if($repair->notes)
**Notes:** {{ $repair->notes }}

---
@endif

{{-- ── Footer ──────────────────────────────────────────── --}}
{{ $settings['receipt_footer'] ?? 'Thank you for choosing us!' }}

@if(!empty($settings['repair_warranty']))
*{{ $settings['repair_warranty'] }}*
@endif

@if(!empty($settings['repair_terms']))
*{{ $settings['repair_terms'] }}*
@endif

<x-mail::button :url="url('/repairs/' . $repair->id . '/receipt')" color="green">
View Receipt Online
</x-mail::button>

Thanks,
**{{ $repair->shop->name }}**

</x-mail::message>