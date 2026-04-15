@php
    $totalPaid   = $sale->payments->sum('amount');
    $outstanding = max(0, (float) $sale->final_amount - $totalPaid);

    $statusBadge = match($sale->payment_status) {
        'paid'     => 'background:#dcfce7;color:#166534;',
        'partial'  => 'background:#dbeafe;color:#1e40af;',
        'pending'  => 'background:#fef9c3;color:#713f12;',
        'refunded' => 'background:#fee2e2;color:#991b1b;',
        default    => 'background:#f1f5f9;color:#475569;',
    };

    $methodIcon = match($sale->payment_method) {
        'cash'  => '💵',
        'card'  => '💳',
        'split' => '✂️',
        'trade' => '🔄',
        default => '💰',
    };

    $methodStyle = match($sale->payment_method) {
        'cash'  => 'background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;',
        'card'  => 'background:#eff6ff;color:#1e40af;border:1px solid #bfdbfe;',
        'split' => 'background:#faf5ff;color:#6b21a8;border:1px solid #e9d5ff;',
        'trade' => 'background:#fff7ed;color:#9a3412;border:1px solid #fed7aa;',
        default => 'background:#f8fafc;color:#475569;border:1px solid #e2e8f0;',
    };
@endphp

{{-- ── Main Row ─────────────────────────────────── --}}
<tr class="sale-row group hover:bg-indigo-50/40
           dark:hover:bg-indigo-900/10 transition-colors"
    onclick="SalesIndex.toggleRow({{ $sale->id }}, this)">

    {{-- Chevron --}}
    <td class="px-4 py-4 w-8">
        <div id="chevron-{{ $sale->id }}"
             class="w-6 h-6 rounded-full flex items-center justify-center
                    bg-gray-100 dark:bg-gray-800 text-gray-400
                    transition-all group-hover:bg-indigo-100
                    dark:group-hover:bg-indigo-900/40
                    group-hover:text-indigo-500">
            <svg class="w-3.5 h-3.5 transition-transform duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </td>

    {{-- Reference + Date --}}
    <td class="px-4 py-4">
        <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
            {{ $sale->reference }}
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
            {{ $sale->created_at->format('d/m/Y H:i') }}
        </p>
    </td>

    {{-- Customer --}}
    <td class="px-4 py-4">
        @if($sale->customer)
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ $sale->customer->name }}
            </p>
            @if($sale->customer->phone)
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $sale->customer->phone }}
            </p>
            @endif
        @else
            <span class="text-xs italic text-gray-400 dark:text-gray-600">
                Walk-in
            </span>
        @endif
    </td>

    {{-- Items --}}
    <td class="px-4 py-4 hidden sm:table-cell">
        <p class="text-sm font-semibold text-gray-900 dark:text-white">
            {{ $sale->items->count() }}
            {{ Str::plural('item', $sale->items->count()) }}
        </p>
        @if($sale->items->isNotEmpty())
        <p class="text-xs text-gray-500 dark:text-gray-400
                   truncate max-w-36">
            {{ $sale->items->take(2)->pluck('product_name')->implode(', ') }}
            @if($sale->items->count() > 2)
                +{{ $sale->items->count() - 2 }} more
            @endif
        </p>
        @endif
    </td>

    {{-- Method --}}
    <td class="px-4 py-4 hidden md:table-cell">
        <span style="display:inline-flex;align-items:center;gap:5px;
                     padding:3px 10px;border-radius:999px;
                     font-size:0.75rem;font-weight:700;
                     {{ $methodStyle }}">
            {{ $methodIcon }} {{ ucfirst($sale->payment_method ?? 'N/A') }}
        </span>
    </td>

    {{-- Status --}}
    <td class="px-4 py-4 hidden md:table-cell">
        <span style="display:inline-flex;align-items:center;gap:5px;
                     padding:3px 10px;border-radius:999px;
                     font-size:0.75rem;font-weight:700;
                     {{ $statusBadge }}">
            <span style="width:6px;height:6px;border-radius:50%;
                         background:currentColor;display:inline-block;
                         opacity:0.7;flex-shrink:0;">
            </span>
            {{ ucfirst($sale->payment_status) }}
        </span>
        @if($outstanding > 0)
            <p class="text-xs text-red-500 dark:text-red-400
                       font-medium mt-0.5">
                £{{ number_format($outstanding, 2) }} owed
            </p>
        @endif
    </td>

    {{-- Total --}}
    <td class="px-4 py-4 hidden lg:table-cell">
        <p class="text-sm font-bold text-gray-900 dark:text-white">
            £{{ number_format($sale->final_amount, 2) }}
        </p>
        @if($sale->discount > 0)
            <p class="text-xs text-red-500 dark:text-red-400">
                -£{{ number_format($sale->discount, 2) }} disc
            </p>
        @endif
    </td>

    {{-- Actions --}}
    <td class="px-4 py-4" onclick="event.stopPropagation()">
        <div class="flex items-center gap-1.5
                    opacity-0 group-hover:opacity-100 transition-opacity">
            <a href="{{ route('sales.receipt', $sale) }}"
               target="_blank"
               title="View Receipt"
               class="w-7 h-7 rounded-lg flex items-center justify-center
                      bg-emerald-50 dark:bg-emerald-900/30
                      text-emerald-600 dark:text-emerald-400
                      hover:bg-emerald-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none"
                     stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0
                             012-2h5.586a1 1 0 01.707.293l5.414 5.414a1
                             1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </a>
        </div>
    </td>

</tr>

{{-- ── Expandable Row ───────────────────────────── --}}
<tr id="expand-{{ $sale->id }}" class="sale-expand">
    <td colspan="8"
        class="px-0 py-0"
        style="background:linear-gradient(to bottom,
               #f0f4ff 0%,#f8faff 100%);">

        <div style="border-top:3px solid #6366f1;
                    border-bottom:3px solid #e0e7ff;
                    padding:20px 24px;">

            {{-- Header bar --}}
            <div style="display:flex;align-items:center;gap:8px;
                        margin-bottom:16px;flex-wrap:wrap;">

                <span style="background:#6366f1;color:#fff;padding:3px 12px;
                             border-radius:999px;font-size:0.72rem;
                             font-weight:800;letter-spacing:0.05em;">
                    {{ $sale->reference }}
                </span>

                <span style="display:inline-flex;align-items:center;gap:4px;
                             padding:3px 10px;border-radius:999px;
                             font-size:0.72rem;font-weight:700;
                             {{ $statusBadge }}">
                    {{ ucfirst($sale->payment_status) }}
                </span>

                <span style="display:inline-flex;align-items:center;gap:4px;
                             padding:3px 10px;border-radius:999px;
                             font-size:0.72rem;font-weight:700;
                             {{ $methodStyle }}">
                    {{ $methodIcon }} {{ ucfirst($sale->payment_method ?? '') }}
                </span>

                <div style="margin-left:auto;">
                    <a href="{{ route('sales.receipt', $sale) }}"
                       target="_blank"
                       onclick="event.stopPropagation()"
                       style="display:inline-flex;align-items:center;gap:4px;
                              padding:6px 14px;border-radius:8px;
                              font-size:0.75rem;font-weight:700;
                              background:#6366f1;color:#fff;
                              text-decoration:none;transition:background 0.15s;"
                       onmouseover="this.style.background='#4f46e5'"
                       onmouseout="this.style.background='#6366f1'">
                        🖨 Receipt
                    </a>
                </div>

            </div>

            {{-- Content Grid --}}
            <div style="display:grid;
                        grid-template-columns:repeat(auto-fit, minmax(260px,1fr));
                        gap:16px;">

                {{-- Items Card --}}
                <div style="background:#fff;border-radius:14px;padding:16px;
                            border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    <p style="font-size:0.65rem;font-weight:700;color:#94a3b8;
                              text-transform:uppercase;letter-spacing:0.05em;
                              margin-bottom:12px;">
                        Items ({{ $sale->items->count() }})
                    </p>

                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach($sale->items as $item)
                        <div style="display:flex;justify-content:space-between;
                                    align-items:center;gap:8px;">
                            <div style="min-width:0;flex:1;">
                                <p style="font-size:0.8rem;font-weight:700;
                                          color:#1e293b;margin:0;
                                          white-space:nowrap;overflow:hidden;
                                          text-overflow:ellipsis;">
                                    {{ $item->product_name }}
                                </p>
                                <p style="font-size:0.7rem;color:#94a3b8;
                                          margin:2px 0 0;">
                                    {{ $item->quantity }} ×
                                    £{{ number_format($item->price, 2) }}
                                </p>
                            </div>
                            <span style="font-size:0.82rem;font-weight:800;
                                         color:#6366f1;white-space:nowrap;
                                         flex-shrink:0;">
                                £{{ number_format($item->line_total, 2) }}
                            </span>
                        </div>
                        @endforeach
                    </div>

                </div>

                {{-- Summary Card --}}
                <div style="background:#fff;border-radius:14px;padding:16px;
                            border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    {{-- Totals --}}
                    <p style="font-size:0.65rem;font-weight:700;color:#94a3b8;
                              text-transform:uppercase;letter-spacing:0.05em;
                              margin-bottom:10px;">
                        Summary
                    </p>

                    <div style="display:flex;justify-content:space-between;
                                font-size:0.78rem;margin-bottom:4px;">
                        <span style="color:#6b7280;">Subtotal</span>
                        <span style="font-weight:600;color:#1e293b;">
                            £{{ number_format($sale->total_amount, 2) }}
                        </span>
                    </div>

                    @if($sale->discount > 0)
                    <div style="display:flex;justify-content:space-between;
                                font-size:0.78rem;margin-bottom:4px;">
                        <span style="color:#6b7280;">Discount</span>
                        <span style="font-weight:700;color:#ef4444;">
                            -£{{ number_format($sale->discount, 2) }}
                        </span>
                    </div>
                    @endif

                    <div style="display:flex;justify-content:space-between;
                                font-size:0.9rem;font-weight:800;
                                padding:8px 0;margin:6px 0;
                                border-top:2px solid #e0e7ff;
                                border-bottom:2px solid #e0e7ff;">
                        <span style="color:#1e293b;">Total</span>
                        <span style="color:#6366f1;">
                            £{{ number_format($sale->final_amount, 2) }}
                        </span>
                    </div>

                    {{-- Payments --}}
                    @if($sale->payments->isNotEmpty())
                    <p style="font-size:0.65rem;font-weight:700;color:#94a3b8;
                              text-transform:uppercase;letter-spacing:0.05em;
                              margin:10px 0 6px;">
                        Payments
                    </p>
                    @foreach($sale->payments as $payment)
                    <div style="display:flex;justify-content:space-between;
                                font-size:0.78rem;margin-bottom:4px;">
                        <span style="color:#6b7280;text-transform:capitalize;">
                            @if($payment->method === 'split' && $payment->split_part)
                                {{ ucfirst($payment->split_part) }} (split)
                            @else
                                {{ ucfirst($payment->method) }}
                            @endif
                            @if($payment->note)
                                <span style="color:#cbd5e1;font-size:0.7rem;">
                                    — {{ $payment->note }}
                                </span>
                            @endif
                        </span>
                        <span style="font-weight:700;color:#1e293b;">
                            £{{ number_format($payment->amount, 2) }}
                        </span>
                    </div>
                    @endforeach
                    @endif

                    {{-- Outstanding / Paid --}}
                    @if($outstanding > 0)
                    <div style="margin-top:8px;background:#fee2e2;
                                border-radius:8px;padding:8px 10px;
                                display:flex;justify-content:space-between;">
                        <span style="color:#ef4444;font-weight:700;
                                     font-size:0.78rem;">
                            Outstanding
                        </span>
                        <span style="color:#ef4444;font-weight:800;
                                     font-size:0.82rem;">
                            £{{ number_format($outstanding, 2) }}
                        </span>
                    </div>
                    @else
                    <div style="margin-top:8px;background:#dcfce7;
                                border-radius:8px;padding:6px 10px;
                                text-align:center;">
                        <span style="color:#166534;font-weight:700;
                                     font-size:0.75rem;">
                            ✓ Fully Paid
                        </span>
                    </div>
                    @endif

                    {{-- Notes --}}
                    @if($sale->notes)
                    <div style="margin-top:10px;background:#fffbeb;
                                border-radius:8px;padding:8px 10px;
                                border:1px solid #fde68a;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#92400e;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:2px;">
                            Notes
                        </p>
                        <p style="font-size:0.75rem;color:#78350f;margin:0;">
                            {{ $sale->notes }}
                        </p>
                    </div>
                    @endif

                    {{-- Served by --}}
                    <div style="margin-top:10px;padding-top:8px;
                                border-top:1px solid #f1f5f9;
                                font-size:0.72rem;color:#94a3b8;">
                        Served by:
                        <strong style="color:#374151;">
                            {{ $sale->createdBy?->name ?? 'Staff' }}
                        </strong>
                    </div>

                </div>

            </div>
        </div>
    </td>
</tr>