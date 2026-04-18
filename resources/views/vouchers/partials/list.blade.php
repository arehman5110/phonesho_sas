<div class="overflow-x-auto">
<table class="w-full">
    <thead>
        <tr class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Discount</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Customer</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Expires</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Uses</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
            <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
    @forelse($vouchers as $voucher)
    @php
        $expired = $voucher->expiry_date && \Carbon\Carbon::parse($voucher->expiry_date)->isPast();
        $used    = $voucher->usage_limit  && $voucher->used_count >= $voucher->usage_limit;
        $active  = $voucher->is_active && !$expired && !$used;
        $status  = $active ? 'active' : ($expired ? 'expired' : ($used ? 'used' : 'inactive'));

        $data = json_encode([
            'id'               => $voucher->id,
            'code'             => $voucher->code,
            'type'             => $voucher->type,
            'value'            => (float) $voucher->value,
            'usage_limit'      => $voucher->usage_limit,
            'used_count'       => $voucher->used_count,
            'min_order_amount' => (float) $voucher->min_order_amount,
            'assigned_to'      => $voucher->assigned_to,
            'expiry_date'      => $voucher->expiry_date
                ? \Carbon\Carbon::parse($voucher->expiry_date)->format('Y-m-d') : null,
            'is_active' => (bool) $voucher->is_active,
            'notes'     => $voucher->notes,
        ]);
    @endphp
    <tr id="vrow-{{ $voucher->id }}"
        class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group cursor-pointer"
        onclick="VoucherPage.selectVoucher({{ $data }})">

        <td class="px-5 py-3.5">
            <span class="font-mono text-sm font-black text-indigo-600 dark:text-indigo-400">
                {{ $voucher->code }}
            </span>
        </td>

        <td class="px-5 py-3.5">
            <p class="text-sm font-bold text-gray-900 dark:text-white">
                {{ $voucher->formatted_value }} off
            </p>
            @if($voucher->min_order_amount > 0)
            <p class="text-xs text-gray-400">Min £{{ number_format($voucher->min_order_amount,2) }}</p>
            @endif
        </td>

        <td class="px-5 py-3.5 hidden sm:table-cell">
            <span class="text-sm text-gray-700 dark:text-gray-300">
                {{ $voucher->assignedCustomer?->name ?? 'Any' }}
            </span>
        </td>

        <td class="px-5 py-3.5 hidden md:table-cell">
            @if($voucher->expiry_date)
            <span class="text-sm {{ $expired ? 'text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300' }}">
                {{ \Carbon\Carbon::parse($voucher->expiry_date)->format('d/m/Y') }}
            </span>
            @else
            <span class="text-sm text-gray-400">Never</span>
            @endif
        </td>

        <td class="px-5 py-3.5 hidden md:table-cell">
            <span class="text-sm text-gray-700 dark:text-gray-300">
                {{ $voucher->usage_limit ? $voucher->used_count . ' / ' . $voucher->usage_limit : $voucher->used_count }}
            </span>
        </td>

        <td class="px-5 py-3.5">
            <span class="inline-flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full
                {{ $active  ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' :
                   ($expired ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' :
                   ($used    ? 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400' :
                               'bg-gray-100 dark:bg-gray-800 text-gray-500')) }}">
                @if($active)<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>@endif
                {{ ucfirst($status) }}
            </span>
        </td>

        <td class="px-5 py-3.5" onclick="event.stopPropagation()">
            <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                {{-- Edit --}}
                <button type="button" onclick="VoucherPage.selectVoucher({{ $data }})"
                        title="Edit"
                        class="w-7 h-7 rounded-lg flex items-center justify-center
                               bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400
                               hover:bg-amber-100 transition-colors border-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                {{-- Print --}}
                <button type="button"
                        onclick="VoucherPage.printVoucher('{{ route('vouchers.print', $voucher) }}')"
                        title="Print"
                        class="w-7 h-7 rounded-lg flex items-center justify-center
                               bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400
                               hover:bg-emerald-100 transition-colors border-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0
                                 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2
                                 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                </button>
                {{-- Email --}}
                <button type="button"
                        onclick="VoucherPage.openEmailModal('{{ route('vouchers.email', $voucher) }}','{{ addslashes($voucher->code) }}','{{ addslashes($voucher->assignedCustomer?->email ?? '') }}','{{ (bool)$voucher->assigned_to }}')"
                        title="Send Email"
                        class="w-7 h-7 rounded-lg flex items-center justify-center
                               bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400
                               hover:bg-blue-100 transition-colors border-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0
                                 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </button>
                {{-- Delete --}}
                <button type="button"
                        onclick="VoucherPage.deleteVoucher({{ $voucher->id }},'{{ $voucher->code }}')"
                        title="Delete"
                        class="w-7 h-7 rounded-lg flex items-center justify-center
                               bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400
                               hover:bg-red-100 transition-colors border-none cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="px-5 py-14 text-center">
            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300 dark:text-gray-600" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <p class="text-sm font-semibold text-gray-400 dark:text-gray-500">No vouchers found</p>
        </td>
    </tr>
    @endforelse
    </tbody>
</table>
</div>
@if($vouchers->hasPages())
<div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
    {{ $vouchers->links() }}
</div>
@endif