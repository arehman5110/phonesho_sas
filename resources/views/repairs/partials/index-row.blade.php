@php
    $statusColors = [
        'green'  => 'badge-green',
        'blue'   => 'badge-blue',
        'yellow' => 'badge-yellow',
        'orange' => 'badge-orange',
        'red'    => 'badge-red',
        'purple' => 'badge-purple',
        'gray'   => 'badge-gray',
    ];
    $badgeClass  = $statusColors[$repair->status?->color ?? 'gray'] ?? 'badge-gray';
    $totalPaid   = $repair->payments->sum('amount');
    $outstanding = max(0, $repair->final_price - $totalPaid);
@endphp

{{-- Main Row --}}
<tr class="repair-row group hover:bg-indigo-50/40
           dark:hover:bg-indigo-900/10 transition-colors"
    onclick="RepairIndex.toggleRow({{ $repair->id }}, this)">

    {{-- Chevron --}}
    <td class="px-4 py-4 w-8">
        <div id="chevron-{{ $repair->id }}"
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

    {{-- Reference --}}
<td class="px-4 py-4">
    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
        {{ $repair->reference }}
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
        {{ $repair->created_at->format('d/m/Y H:i') }}
    </p>

    {{-- Warranty Badge --}}
    @if($repair->is_warranty_return)
    <div class="flex items-center gap-1.5 mt-1.5">
        <span class="inline-flex items-center gap-1 px-2 py-0.5
                     rounded-full text-xs font-bold
                     bg-amber-100 dark:bg-amber-900/40
                     text-amber-700 dark:text-amber-400">
            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955
                         0 0112 2.944a11.955 11.955 0 01-8.618
                         3.04A12.02 12.02 0 003 9c0 5.591 3.824
                         10.29 9 11.622 5.176-1.332 9-6.03
                         9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Warranty
        </span>

        {{-- Link to original repair --}}
        @if($repair->parentRepair)
        <a href="{{ route('repairs.show', $repair->parentRepair) }}"
           onclick="event.stopPropagation()"
           title="View original repair"
           class="text-xs text-amber-600 dark:text-amber-400
                  hover:text-amber-800 dark:hover:text-amber-300
                  font-semibold underline underline-offset-2
                  transition-colors">
            ← {{ $repair->parentRepair->reference }}
        </a>
        @endif
    </div>
    @endif

</td>

    {{-- Customer --}}
    <td class="px-4 py-4">
        @if($repair->customer)
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ $repair->customer->name }}
            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ $repair->customer->phone ?? '—' }}
            </p>
        @else
            <span class="text-xs italic text-gray-400 dark:text-gray-600">
                Walk-in
            </span>
        @endif
    </td>

    {{-- Devices --}}
    <td class="px-4 py-4 hidden sm:table-cell">
        @foreach($repair->devices->take(2) as $device)
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300
                       truncate max-w-36">
                📱 {{ $device->device_name ?? $device->deviceType?->name ?? 'Device' }}
            </p>
        @endforeach
        @if($repair->devices->count() > 2)
            <p class="text-xs text-gray-400">+{{ $repair->devices->count() - 2 }} more</p>
        @endif
        @if($repair->devices->isEmpty())
            <span class="text-xs text-gray-400">—</span>
        @endif
    </td>

    {{-- Status --}}
    <td class="px-4 py-4 hidden md:table-cell">
        @if($repair->status)
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1
                         rounded-full text-xs font-semibold {{ $badgeClass }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                {{ $repair->status->name }}
            </span>
        @endif
    </td>

    {{-- Total --}}
    <td class="px-4 py-4 hidden lg:table-cell">
        <p class="text-sm font-bold text-gray-900 dark:text-white">
            £{{ number_format($repair->final_price, 2) }}
        </p>
        @if($outstanding > 0)
            <p class="text-xs text-red-500 font-medium">
                £{{ number_format($outstanding, 2) }} owed
            </p>
        @else
            <p class="text-xs text-emerald-500 font-medium">Paid</p>
        @endif
    </td>

    {{-- Assigned --}}
    <td class="px-4 py-4 hidden xl:table-cell">
        @if($repair->assignedTo)
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full bg-indigo-500
                            flex items-center justify-center
                            text-white text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($repair->assignedTo->name, 0, 1)) }}
                </div>
                <span class="text-xs font-medium text-gray-700
                             dark:text-gray-300 truncate max-w-24">
                    {{ $repair->assignedTo->name }}
                </span>
            </div>
        @else
            <span class="text-xs italic text-gray-400">Unassigned</span>
        @endif
    </td>

  
   {{-- Actions --}}
<td class="px-4 py-4" onclick="event.stopPropagation()">
    <div class="flex items-center gap-1.5
                opacity-0 group-hover:opacity-100 transition-opacity">

        {{-- View --}}
        <a href="{{ route('repairs.show', $repair) }}"
           title="View"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-indigo-50 dark:bg-indigo-900/30
                  text-indigo-600 dark:text-indigo-400
                  hover:bg-indigo-100 dark:hover:bg-indigo-900/50
                  transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732
                         7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542
                         7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268
                         -2.943-9.542-7z"/>
            </svg>
        </a>

        {{-- Receipt --}}
        <a href="{{ route('repairs.receipt', $repair) }}"
           target="_blank"
           title="Print Receipt"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-emerald-50 dark:bg-emerald-900/30
                  text-emerald-600 dark:text-emerald-400
                  hover:bg-emerald-100 dark:hover:bg-emerald-900/50
                  transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0
                         00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2
                         2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12
                         V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
        </a>

    </div>
</td>

</tr>

{{-- ── Expanded Row ─────────────────────────────── --}}
<tr id="expand-{{ $repair->id }}" class="repair-expand">
    <td colspan="8"
        class="px-0 py-0"
        style="background:linear-gradient(to bottom,
               #f0f4ff 0%, #f8faff 100%);"
        >
        <div style="border-top:3px solid #6366f1;
                    border-bottom:3px solid #e0e7ff;
                    padding:20px 24px;">

            {{-- Header bar --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <div style="background:#6366f1;color:#fff;
                                padding:3px 12px;border-radius:999px;
                                font-size:0.72rem;font-weight:800;
                                letter-spacing:0.05em;">
                        {{ $repair->reference }}
                    </div>
                    @if($repair->status)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1
                                 rounded-full text-xs font-semibold
                                 {{ $badgeClass }}">
                        {{ $repair->status->name }}
                    </span>
                    @endif
                    @if($repair->delivery_type)
                    <span class="text-xs font-semibold px-2 py-1
                                 rounded-full bg-gray-200 dark:bg-gray-700
                                 text-gray-600 dark:text-gray-300">
                        {{ $repair->delivery_type_label }}
                    </span>
                    @endif
                </div>
                <div class="ml-auto flex items-center gap-2">
                    @if($repair->assignedTo)
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        Assigned to
                        <strong class="text-gray-700 dark:text-gray-300">
                            {{ $repair->assignedTo->name }}
                        </strong>
                    </span>
                    @endif
                    <a href="{{ route('repairs.show', $repair) }}"
                       onclick="event.stopPropagation()"
                       class="flex items-center gap-1.5 px-3 py-1.5
                              rounded-lg text-xs font-bold
                              bg-indigo-600 hover:bg-indigo-700
                              text-white transition-all">
                        View Full →
                    </a>
                </div>
            </div>

            {{-- Single unified grid --}}
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
                        gap:16px;">

                {{-- Each Device --}}
                @foreach($repair->devices as $device)
                <div style="background:#fff;border-radius:14px;
                            padding:16px;border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    {{-- Device title row --}}
                    <div style="display:flex;align-items:center;
                                gap:8px;margin-bottom:12px;
                                padding-bottom:10px;
                                border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:1.2rem;">📱</span>
                        <div style="min-width:0;">
                            <p style="font-size:0.82rem;font-weight:800;
                                      color:#1e293b;margin:0;
                                      white-space:nowrap;overflow:hidden;
                                      text-overflow:ellipsis;">
                                {{ $device->device_name ?? 'Device' }}
                            </p>
                            <p style="font-size:0.7rem;color:#94a3b8;
                                      margin:0;">
                                {{ implode(' · ', array_filter([
                                    $device->deviceType?->name,
                                    $device->color,
                                    $device->imei ? 'IMEI: '.$device->imei : null
                                ])) ?: '—' }}
                            </p>
                        </div>
                        <span style="margin-left:auto;font-size:0.8rem;
                                     font-weight:800;color:#6366f1;
                                     white-space:nowrap;">
                            £{{ number_format($device->price, 2) }}
                        </span>
                    </div>

                    {{-- Fields grid --}}
                    <div style="display:grid;grid-template-columns:1fr 1fr;
                                gap:8px;font-size:0.75rem;">

                        {{-- Issue --}}
                        @if($device->issue)
                        <div style="grid-column:1/-1;">
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Issues
                            </p>
                            <p style="color:#374151;font-weight:600;">
                                {{ $device->issue }}
                            </p>
                        </div>
                        @endif

                        {{-- Repair Type --}}
                        @if($device->repair_type)
                        <div>
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Repair Type
                            </p>
                            <p style="color:#374151;font-weight:600;">
                                {{ $device->repair_type }}
                            </p>
                        </div>
                        @endif

                        {{-- Warranty --}}
                        <div>
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Warranty
                            </p>
                            <span style="font-size:0.7rem;font-weight:700;
                                         padding:2px 8px;border-radius:999px;
                                         {{ $device->warranty_status === 'active'
                                             ? 'background:#dcfce7;color:#166534;'
                                             : ($device->warranty_status === 'expired'
                                                 ? 'background:#fee2e2;color:#991b1b;'
                                                 : 'background:#f1f5f9;color:#475569;') }}">
                                {{ $device->warranty_label }}
                            </span>
                        </div>

                        {{-- Parts --}}
                        @if($device->parts->isNotEmpty())
                        <div style="grid-column:1/-1;">
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:4px;">
                                Parts Used
                            </p>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                @foreach($device->parts as $part)
                                <span style="background:#eef2ff;color:#4338ca;
                                             font-size:0.7rem;font-weight:700;
                                             padding:2px 8px;border-radius:6px;">
                                    {{ $part->name }}
                                    @if($part->quantity > 1)
                                        <span style="opacity:0.6;">×{{ $part->quantity }}</span>
                                    @endif
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Notes --}}
                        @if($device->notes)
                        <div style="grid-column:1/-1;
                                    background:#fafafa;border-radius:8px;
                                    padding:6px 10px;margin-top:2px;">
                            <p style="color:#94a3b8;font-size:0.65rem;
                                      font-weight:700;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Notes
                            </p>
                            <p style="color:#6b7280;font-size:0.75rem;">
                                {{ $device->notes }}
                            </p>
                        </div>
                        @endif

                    </div>
                </div>
                @endforeach

                {{-- Payments & Info combined --}}
                <div style="background:#fff;border-radius:14px;
                            padding:16px;border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    {{-- Totals --}}
                    <div style="padding-bottom:12px;margin-bottom:12px;
                                border-bottom:1px solid #f1f5f9;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Pricing
                        </p>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Total</span>
                            <span style="font-weight:800;color:#1e293b;">
                                £{{ number_format($repair->final_price, 2) }}
                            </span>
                        </div>
                        @if($repair->discount > 0)
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Discount</span>
                            <span style="font-weight:700;color:#ef4444;">
                                -£{{ number_format($repair->discount, 2) }}
                            </span>
                        </div>
                        @endif
                        @if($totalPaid > 0)
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Paid</span>
                            <span style="font-weight:700;color:#10b981;">
                                £{{ number_format($totalPaid, 2) }}
                            </span>
                        </div>
                        @endif
                        @if($outstanding > 0)
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;padding:6px 8px;
                                    background:#fee2e2;border-radius:8px;
                                    margin-top:4px;">
                            <span style="color:#ef4444;font-weight:700;">
                                Outstanding
                            </span>
                            <span style="font-weight:800;color:#ef4444;">
                                £{{ number_format($outstanding, 2) }}
                            </span>
                        </div>
                        @endif
                    </div>

                    {{-- Payments list --}}
                    @if($repair->payments->isNotEmpty())
                    <div style="margin-bottom:12px;padding-bottom:12px;
                                border-bottom:1px solid #f1f5f9;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Payments
                        </p>
                        @foreach($repair->payments as $payment)
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
                    </div>
                    @endif

                    {{-- Meta --}}
                    <div style="font-size:0.75rem;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Info
                        </p>
                        <div style="display:grid;grid-template-columns:1fr 1fr;
                                    gap:6px;">
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Book-in
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    {{ $repair->book_in_date?->format('d/m/Y') ?? '—' }}
                                </p>
                            </div>
                            @if($repair->completion_date)
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Due
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    {{ $repair->completion_date->format('d/m/Y') }}
                                </p>
                            </div>
                            @endif
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Created by
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    {{ $repair->createdBy?->name ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Repair notes --}}
                    @if($repair->notes)
                    <div style="margin-top:10px;background:#fffbeb;
                                border-radius:8px;padding:8px 10px;
                                border:1px solid #fde68a;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#92400e;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:2px;">
                            Notes
                        </p>
                        <p style="font-size:0.75rem;color:#78350f;">
                            {{ $repair->notes }}
                        </p>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </td>
</tr>