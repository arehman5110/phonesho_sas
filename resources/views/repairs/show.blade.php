<x-app-layout>
<x-slot name="title">{{ $repair->reference }}</x-slot>

@push('styles')
<style>
    .badge-green  { background:#dcfce7;color:#166534; }
    .badge-blue   { background:#dbeafe;color:#1e40af; }
    .badge-yellow { background:#fef9c3;color:#713f12; }
    .badge-orange { background:#ffedd5;color:#9a3412; }
    .badge-red    { background:#fee2e2;color:#991b1b; }
    .badge-purple { background:#f3e8ff;color:#6b21a8; }
    .badge-gray   { background:#f1f5f9;color:#475569; }
    .dark .badge-green  { background:#14532d;color:#86efac; }
    .dark .badge-blue   { background:#1e3a8a;color:#93c5fd; }
    .dark .badge-yellow { background:#713f12;color:#fde68a; }
    .dark .badge-orange { background:#7c2d12;color:#fdba74; }
    .dark .badge-red    { background:#7f1d1d;color:#fca5a5; }
    .dark .badge-purple { background:#4a1d96;color:#d8b4fe; }
    .dark .badge-gray   { background:#1e293b;color:#94a3b8; }
</style>
@endpush

{{-- Page Header --}}
<x-page-header
    title="{{ $repair->reference }}"
    subtitle="Repair Detail"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Repairs',   'route' => 'repairs.index'],
        ['label' => $repair->reference],
    ]">
    <x-slot name="actions">
        <a href="{{ route('repairs.receipt', $repair) }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0
                         002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2
                         2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Receipt
        </a>
        <a href="{{ route('repairs.edit', $repair) }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2
                         2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
        <form method="POST" action="{{ route('repairs.destroy', $repair) }}"
              onsubmit="return confirm('Delete {{ $repair->reference }}? This cannot be undone.')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                           bg-red-600 hover:bg-red-700 active:scale-95 text-white transition-all
                           border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5
                             7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete
            </button>
        </form>
    </x-slot>
</x-page-header>

@if(session('success'))
<div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,5000)" x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ══════════════════════ LEFT (2/3) ══════════════════════ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- ① Customer Card ────────────────────────── --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200
                    dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Customer</span>

                @if($repair->is_warranty_return)
                <span class="ml-auto inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                             text-xs font-bold bg-amber-100 dark:bg-amber-900/40
                             text-amber-700 dark:text-amber-400">
                    🛡️ Warranty Return
                    @if($repair->parentRepair)
                    <a href="{{ route('repairs.show', $repair->parentRepair) }}"
                       class="underline underline-offset-1 ml-1">
                        ← {{ $repair->parentRepair->reference }}
                    </a>
                    @endif
                </span>
                @endif
            </div>

            @if($repair->customer)
            <div class="p-5 flex items-center gap-4">
                <div class="w-11 h-11 rounded-full bg-indigo-600 flex items-center
                            justify-center text-white font-black text-base flex-shrink-0">
                    {{ strtoupper(substr($repair->customer->name, 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $repair->customer->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ implode(' · ', array_filter([$repair->customer->phone, $repair->customer->email])) ?: '—' }}
                    </p>
                    @if($repair->customer->address)
                    <p class="text-xs text-gray-400 mt-0.5">{{ $repair->customer->address }}</p>
                    @endif
                </div>
            </div>
            @else
            <div class="p-5">
                <p class="text-sm text-gray-400 italic">Walk-in customer</p>
            </div>
            @endif
        </div>

        {{-- ② Devices — each device in its own card ───── --}}
        <div class="space-y-4">

            {{-- Devices header --}}
            <div class="flex items-center gap-3 px-1">
                <div class="w-7 h-7 rounded-lg bg-green-100 dark:bg-green-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0
                                 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Devices</span>
                <span class="text-xs font-bold px-2 py-0.5 rounded-full
                             bg-green-100 dark:bg-green-900/40
                             text-green-700 dark:text-green-400">
                    {{ $repair->devices->count() }}
                </span>
            </div>

            @forelse($repair->devices as $device)
            @php
                $statusColors = [
                    'green'  => 'badge-green', 'blue'   => 'badge-blue',
                    'yellow' => 'badge-yellow', 'orange' => 'badge-orange',
                    'red'    => 'badge-red',   'purple' => 'badge-purple',
                    'gray'   => 'badge-gray',
                ];
                $dBadge = $statusColors[$device->status?->color ?? 'gray'] ?? 'badge-gray';
            @endphp

            {{-- Individual device card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200
                        dark:border-gray-700 rounded-2xl">

                {{-- Device card header --}}
                <div class="flex items-center justify-between px-5 py-3.5
                            bg-white dark:bg-gray-900
                            border-b border-gray-200 dark:border-gray-700
                            rounded-t-2xl">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                            📱 {{ $device->device_name ?? 'Device' }}
                        </span>
                        @if($device->deviceType)
                        <span class="text-xs text-gray-400">{{ $device->deviceType->name }}</span>
                        @endif
                        @if($device->color)
                        <span class="text-xs text-gray-400">· {{ $device->color }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        {{-- Device status dropdown --}}
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" @click="open = !open"
                                    id="dev-status-pill-{{ $device->id }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1
                                           rounded-full text-xs font-semibold cursor-pointer
                                           border-none transition-all {{ $dBadge }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                <span id="dev-status-label-{{ $device->id }}">
                                    {{ $device->status?->name ?? 'No Status' }}
                                </span>
                                <svg class="w-3 h-3 opacity-60" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition
                                 class="absolute right-0 top-full mt-1.5 z-50
                                        bg-white dark:bg-gray-900
                                        border border-gray-200 dark:border-gray-700
                                        rounded-xl shadow-xl py-1.5 min-w-44"
                                 style="display:none;">
                                @foreach($deviceStatuses as $s)
                                @php $sb = $statusColors[$s->color ?? 'gray'] ?? 'badge-gray'; @endphp
                                <button type="button"
                                        onclick="updateDeviceStatus({{ $device->id }}, {{ $s->id }}, '{{ $s->name }}', '{{ $s->color }}')"
                                        @click="open = false"
                                        class="w-full flex items-center gap-2 px-3 py-2 text-left
                                               hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5
                                                 rounded-full text-xs font-semibold {{ $sb }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                        {{ $s->name }}
                                    </span>
                                </button>
                                @endforeach
                            </div>
                        </div>
                        <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            £{{ number_format($device->price, 2) }}
                        </span>
                    </div>
                </div>

                {{-- Device details --}}
                <div class="px-5 py-4 grid grid-cols-1 sm:grid-cols-2 gap-4">

                    @if($device->imei)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            IMEI / Serial
                        </p>
                        <p class="text-sm font-mono text-gray-700 dark:text-gray-300">
                            {{ $device->imei }}
                        </p>
                    </div>
                    @endif

                    @if($device->issue)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Issues
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $device->issue }}</p>
                    </div>
                    @endif

                    @if($device->repair_type)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Repair Type
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $device->repair_type }}</p>
                    </div>
                    @endif

                    @if($device->parts->isNotEmpty())
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">
                            Parts Used
                        </p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($device->parts as $part)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs
                                         font-semibold bg-indigo-50 dark:bg-indigo-900/30
                                         text-indigo-700 dark:text-indigo-300">
                                {{ $part->name }}
                                @if($part->quantity > 1)
                                <span class="ml-1 opacity-60">×{{ $part->quantity }}</span>
                                @endif
                            </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Warranty — only when device status is_completed --}}
                    @if($device->status?->is_completed)
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Warranty
                        </p>
                        @php
                            $wBadge = match($device->warranty_status) {
                                'active'         => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                'under_warranty' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'expired'        => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                default          => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                            };
                            $wLabel = match($device->warranty_status) {
                                'under_warranty' => '🛡️ Under Warranty',
                                'active'         => '✓ ' . $device->warranty_label . ($device->warranty_expiry_date ? ' until ' . \Carbon\Carbon::parse((string) $device->warranty_expiry_date)->format('d/m/Y') : ''),
                                'expired'        => '✗ Expired',
                                default          => 'No Warranty',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full
                                     text-xs font-bold {{ $wBadge }}">
                            {{ $wLabel }}
                        </span>
                    </div>
                    @endif

                    @if($device->notes)
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                            Device Notes
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50
                                   dark:bg-gray-800/50 rounded-lg px-3 py-2">
                            {{ $device->notes }}
                        </p>
                    </div>
                    @endif

                </div>
            </div>

            @empty
            <div class="bg-white dark:bg-gray-900 border border-gray-200
                        dark:border-gray-700 rounded-2xl p-8 text-center
                        text-gray-400 dark:text-gray-600">
                <p class="text-sm font-semibold">No devices on this repair</p>
            </div>
            @endforelse

        </div>

        {{-- ③ Repair Info — single card ─────────────── --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200
                    dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40
                            flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                    Job Info
                </span>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-5">

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                        Book-in Date
                    </p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $repair->book_in_date?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                        Est. Completion
                    </p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $repair->completion_date?->format('d/m/Y') ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                        Delivery
                    </p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $repair->delivery_type === 'delivery' ? '🚚' : '🏪' }}
                        {{ $repair->delivery_type_label }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">
                        Created By
                    </p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">
                        {{ $repair->createdBy?->name ?? '—' }}
                    </p>
                </div>

                @if($repair->notes)
                <div class="col-span-2 sm:col-span-4 pt-3 border-t
                            border-gray-100 dark:border-gray-800">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1.5">
                        Internal Notes
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $repair->notes }}
                    </p>
                </div>
                @endif

            </div>
        </div>

    </div>

    {{-- ══════════════════════ RIGHT (1/3) ══════════════════════ --}}
    <div class="lg:col-span-1">
        <div class="lg:sticky lg:top-5 space-y-4">

            {{-- Pricing Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200
                        dark:border-gray-700 rounded-2xl overflow-hidden">
                <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                            border-b border-gray-200 dark:border-gray-700">
                    <div class="w-7 h-7 rounded-lg bg-emerald-100 dark:bg-emerald-900/40
                                flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343
                                     2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1
                                     c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Pricing</span>
                </div>
                <div class="p-5 space-y-2.5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                        <span class="font-semibold text-gray-900 dark:text-white">
                            £{{ number_format($repair->total_price, 2) }}
                        </span>
                    </div>
                    @if($repair->discount > 0)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Discount</span>
                        <span class="font-semibold text-red-500">
                            -£{{ number_format($repair->discount, 2) }}
                        </span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold pt-2
                                border-t border-gray-200 dark:border-gray-700">
                        <span class="text-gray-900 dark:text-white">Total</span>
                        <span class="text-emerald-600 dark:text-emerald-400 text-xl">
                            £{{ number_format($repair->final_price, 2) }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Paid</span>
                        <span id="show-paid" class="font-semibold text-emerald-600 dark:text-emerald-400">
                            £{{ number_format($summary['total_paid'], 2) }}
                        </span>
                    </div>
                    <div id="show-outstanding-row"
                         class="{{ $summary['outstanding'] > 0 ? '' : 'hidden' }}">
                        <div class="flex justify-between text-sm font-bold
                                    bg-red-50 dark:bg-red-900/20 px-3 py-2 rounded-xl">
                            <span class="text-red-600 dark:text-red-400">Outstanding</span>
                            <span id="show-outstanding" class="text-red-600 dark:text-red-400">
                                £{{ number_format($summary['outstanding'], 2) }}
                            </span>
                        </div>
                    </div>
                    <div id="show-paid-row"
                         class="{{ $summary['outstanding'] <= 0 ? '' : 'hidden' }}">
                        <div class="flex justify-between text-sm font-bold
                                    bg-emerald-50 dark:bg-emerald-900/20 px-3 py-2 rounded-xl">
                            <span class="text-emerald-600 dark:text-emerald-400">✓ Fully Paid</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Payments Card --}}
            <div class="bg-white dark:bg-gray-900 border border-gray-200
                        dark:border-gray-700 rounded-2xl overflow-hidden">
                <div class="flex items-center justify-between px-5 py-3.5
                            bg-gray-50 dark:bg-gray-800
                            border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/40
                                    flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0
                                         00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-gray-800 dark:text-gray-200">
                            Payments
                        </span>
                    </div>
                    <button type="button" onclick="openPaymentModal()"
                            class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg
                                   text-xs font-bold bg-emerald-600 hover:bg-emerald-700
                                   text-white transition-all border-none cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add
                    </button>
                </div>

                <div id="payments-list" class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($repair->payments as $payment)
                    <div class="flex items-center justify-between px-4 py-3"
                         id="payment-row-{{ $payment->id }}">
                        <div>
                            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 capitalize">
                                {{ $payment->method === 'split' && $payment->split_part
                                    ? ucfirst($payment->split_part) . ' (split)'
                                    : ucfirst($payment->method) }}
                            </p>
                            @if($payment->note)
                            <p class="text-xs text-gray-400">{{ $payment->note }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                £{{ number_format($payment->amount, 2) }}
                            </span>
                            <button type="button" onclick="deletePayment({{ $payment->id }})"
                                    class="w-6 h-6 rounded-full flex items-center justify-center
                                           bg-red-50 dark:bg-red-900/20 text-red-400
                                           hover:bg-red-100 transition-all border-none cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <p id="no-payments-msg"
                       class="px-4 py-4 text-sm text-center text-gray-400 dark:text-gray-500">
                        No payments recorded
                    </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ══════════════════════ PAYMENT MODAL ══════════════════════ --}}
<div id="show-payment-modal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(15,23,42,0.75);align-items:center;
            justify-content:center;padding:16px;"
     onclick="if(event.target===this) closePaymentModal()">

    <div id="show-payment-modal-box"
         style="transform:scale(0.95);opacity:0;transition:all 0.2s;
                max-height:90vh;overflow-y:auto;scrollbar-width:none;"
         class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100
                    dark:border-gray-800 sticky top-0 bg-white dark:bg-gray-900 z-10">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Add Payment</h3>
            <button type="button" onclick="closePaymentModal()"
                    class="w-8 h-8 rounded-full flex items-center justify-center
                           bg-gray-100 dark:bg-gray-800 text-gray-500 hover:bg-gray-200
                           dark:hover:bg-gray-700 hover:text-red-500 transition-all
                           border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 space-y-5">

            {{-- Total / Outstanding --}}
            <div class="text-center py-4 rounded-2xl
                        bg-gradient-to-br from-emerald-50 to-teal-50
                        dark:from-emerald-900/20 dark:to-teal-900/20
                        border border-emerald-100 dark:border-emerald-800">
                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400
                           uppercase tracking-widest mb-1">Outstanding</p>
                <p id="modal-outstanding-display"
                   class="text-4xl font-black text-emerald-700 dark:text-emerald-300"
                   style="font-family:'Georgia',serif;">
                    £{{ number_format($summary['outstanding'], 2) }}
                </p>
            </div>

            {{-- Payment Method --}}
            <div>
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-2">Payment Method</p>
                <div class="grid grid-cols-4 gap-2">
                    @foreach([
                        'cash'  => ['label'=>'Cash',  'icon'=>'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                        'card'  => ['label'=>'Card',  'icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                        'split' => ['label'=>'Split', 'icon'=>'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'],
                        'trade' => ['label'=>'Trade', 'icon'=>'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                    ] as $val => $m)
                    <label class="cursor-pointer">
                        <input type="radio" name="show_payment_method" value="{{ $val }}"
                               class="sr-only peer"
                               onchange="onPayMethodChange('{{ $val }}')"
                               {{ $val === 'cash' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-1.5 py-3 rounded-xl border-2
                                    transition-all cursor-pointer
                                    border-gray-200 dark:border-gray-700
                                    text-gray-500 dark:text-gray-400
                                    peer-checked:border-emerald-500 peer-checked:bg-emerald-50
                                    dark:peer-checked:bg-emerald-900/20
                                    peer-checked:text-emerald-600 dark:peer-checked:text-emerald-400
                                    hover:border-emerald-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="1.8" d="{{ $m['icon'] }}"/>
                            </svg>
                            <span class="text-xs font-bold">{{ $m['label'] }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- CASH fields --}}
            <div id="show-fields-cash">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-2">Amount £</p>
                <div class="grid grid-cols-5 gap-1.5 mb-2">
                    @foreach([5,10,20,50] as $amt)
                    <button type="button" onclick="setShowQuickAmount({{ $amt }})"
                            class="py-2 rounded-lg text-xs font-bold border
                                   border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800
                                   text-gray-600 dark:text-gray-400
                                   hover:bg-emerald-50 hover:text-emerald-600
                                   hover:border-emerald-400 transition-all">
                        £{{ $amt }}
                    </button>
                    @endforeach
                    <button type="button" onclick="setShowExactAmount()"
                            class="py-2 rounded-lg text-xs font-bold border
                                   border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800
                                   text-gray-600 dark:text-gray-400
                                   hover:bg-emerald-50 hover:text-emerald-600
                                   hover:border-emerald-400 transition-all">
                        Exact
                    </button>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">£</span>
                    <input type="number" id="show-pay-amount" min="0" step="0.01"
                           placeholder="0" oninput="updateShowChange()"
                           class="w-full pl-8 pr-4 py-3 border border-gray-200 dark:border-gray-700
                                  rounded-xl text-xl font-black outline-none
                                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div id="show-change-display" style="display:none;"
                     class="mt-2 flex items-center justify-between px-4 py-2.5 rounded-xl
                            bg-emerald-50 dark:bg-emerald-900/20
                            border border-emerald-200 dark:border-emerald-800">
                    <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">
                        Change Due
                    </span>
                    <span id="show-change-amount"
                          class="text-base font-black text-emerald-600 dark:text-emerald-400">
                        £0.00
                    </span>
                </div>
            </div>

            {{-- CARD fields --}}
            <div id="show-fields-card" style="display:none;">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400
                           uppercase tracking-wider mb-2">Amount £</p>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">£</span>
                    <input type="number" id="show-card-amount" min="0.01" step="0.01"
                           placeholder="0"
                           class="w-full pl-8 pr-4 py-3 border border-gray-200 dark:border-gray-700
                                  rounded-xl text-xl font-black outline-none
                                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                  focus:border-amber-400 focus:ring-2 focus:ring-amber-400/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
            </div>

            {{-- SPLIT fields --}}
            <div id="show-fields-split" style="display:none;">
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4 mb-3">
                    <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400
                               uppercase tracking-wider mb-3">1st Payment</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500
                                           uppercase tracking-wider mb-1.5">Method</label>
                            <select id="show-split1-method"
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700
                                           rounded-lg text-sm font-semibold outline-none
                                           bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                                <option value="cash">💵 Cash</option>
                                <option value="card">💳 Card</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500
                                           uppercase tracking-wider mb-1.5">Amount £</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2
                                             text-gray-400 font-bold text-sm pointer-events-none">£</span>
                                <input type="number" id="show-split1-amount" min="0" step="0.01"
                                       placeholder="0.00" oninput="updateShowSplit2()"
                                       class="w-full pl-7 pr-2 py-2 border border-gray-200
                                              dark:border-gray-700 rounded-lg text-sm font-bold
                                              outline-none bg-white dark:bg-gray-800
                                              text-gray-900 dark:text-white focus:border-indigo-400">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4">
                    <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400
                               uppercase tracking-wider mb-3">2nd Payment</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500
                                           uppercase tracking-wider mb-1.5">Method</label>
                            <select id="show-split2-method"
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700
                                           rounded-lg text-sm font-semibold outline-none
                                           bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                                <option value="card">💳 Card</option>
                                <option value="cash">💵 Cash</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500
                                           uppercase tracking-wider mb-1.5">Amount £</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2
                                             text-gray-400 font-bold text-sm pointer-events-none">£</span>
                                <input type="number" id="show-split2-amount" min="0" step="0.01"
                                       placeholder="0.00" readonly
                                       class="w-full pl-7 pr-2 py-2 border border-gray-200
                                              dark:border-gray-700 rounded-lg text-sm font-bold
                                              outline-none bg-gray-50 dark:bg-gray-700
                                              text-gray-500 dark:text-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TRADE fields --}}
            <div id="show-fields-trade" style="display:none;">
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl
                            bg-amber-50 dark:bg-amber-900/20
                            border border-amber-200 dark:border-amber-800 mb-4">
                    <span class="text-xl flex-shrink-0">🔄</span>
                    <p class="text-sm font-semibold text-amber-700 dark:text-amber-400 leading-snug">
                        Customer is trading a device as full or partial payment.
                    </p>
                </div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Trade-in Value
                </label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2
                                 text-gray-400 font-bold pointer-events-none">£</span>
                    <input type="number" id="show-trade-value" min="0" step="0.01"
                           placeholder="0.00"
                           class="w-full pl-8 pr-4 py-3 border border-gray-200 dark:border-gray-700
                                  rounded-xl text-xl font-black outline-none
                                  bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                  focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
            </div>

            {{-- Note --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
                    Note (Optional)
                </label>
                <input type="text" id="show-pay-note"
                       placeholder="e.g. deposit, partial payment..."
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white placeholder-gray-400
                              focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
            </div>

            {{-- Error --}}
            <div id="show-pay-error" style="display:none;"
                 class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        rounded-xl px-4 py-3 text-sm font-semibold text-red-600 dark:text-red-400">
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 flex gap-3">
            <button type="button" onclick="closePaymentModal()"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold
                           border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400
                           hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                Cancel
            </button>
            <button type="button" id="show-pay-submit" onclick="submitShowPayment()"
                    class="flex-1 py-3 rounded-xl text-sm font-bold bg-emerald-600
                           hover:bg-emerald-700 active:scale-95 text-white transition-all
                           flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Payment
            </button>
        </div>

    </div>
</div>

@push('scripts')
<script>
const _CSRF           = '{{ csrf_token() }}';
const _PAYMENT_URL    = '{{ route("repairs.add-payment",    $repair) }}';
const _DEL_PAY_URL    = '/repairs/{{ $repair->id }}/payment/{id}';
const _DEV_STATUS_URL = '/repairs/{{ $repair->id }}/device/{device}/status';

let _outstanding = {{ $summary['outstanding'] }};
let _selectedMethod = 'cash';

// ── Payment Modal ─────────────────────────────────────────────
function openPaymentModal() {
    // Reset form
    _selectedMethod = 'cash';
    const cashRadio = document.querySelector('input[name="show_payment_method"][value="cash"]');
    if (cashRadio) cashRadio.checked = true;
    onPayMethodChange('cash');

    const amountInput = document.getElementById('show-pay-amount');
    if (amountInput) { amountInput.value = ''; }

    document.getElementById('show-pay-note').value = '';
    document.getElementById('show-change-display').style.display = 'none';
    document.getElementById('show-pay-error').style.display = 'none';

    // Update outstanding display
    document.getElementById('modal-outstanding-display').textContent =
        '£' + _outstanding.toFixed(2);

    // Show modal
    const modal = document.getElementById('show-payment-modal');
    const box   = document.getElementById('show-payment-modal-box');
    modal.style.display = 'flex';
    requestAnimationFrame(() => {
        box.style.transform = 'scale(1)';
        box.style.opacity   = '1';
    });
    setTimeout(() => amountInput?.focus(), 200);
}

function closePaymentModal() {
    const modal = document.getElementById('show-payment-modal');
    const box   = document.getElementById('show-payment-modal-box');
    box.style.transform = 'scale(0.95)';
    box.style.opacity   = '0';
    setTimeout(() => { modal.style.display = 'none'; }, 180);
}

function onPayMethodChange(method) {
    _selectedMethod = method;
    ['cash','card','split','trade'].forEach(m => {
        const el = document.getElementById(`show-fields-${m}`);
        if (el) el.style.display = 'none';
    });
    const active = document.getElementById(`show-fields-${method}`);
    if (active) active.style.display = method === 'card' ? 'flex' : 'block';

    if (method === 'split') {
        const s2 = document.getElementById('show-split2-amount');
        const s1 = document.getElementById('show-split1-amount');
        if (s2) s2.value = _outstanding.toFixed(2);
        if (s1) s1.value = '';
    }
    if (method === 'card') {
        const cardInput = document.getElementById('show-card-amount');
        if (cardInput) cardInput.value = _outstanding.toFixed(2);
    }
}

function setShowQuickAmount(amt) {
    const input = document.getElementById('show-pay-amount');
    if (input) { input.value = amt.toFixed(2); updateShowChange(); }
}

function setShowExactAmount() {
    const input = document.getElementById('show-pay-amount');
    if (input) { input.value = _outstanding.toFixed(2); updateShowChange(); }
}

function setShowCardQuickAmount(amt) {
    const input = document.getElementById('show-card-amount');
    if (input) input.value = Math.min(amt, _outstanding).toFixed(2);
}

function setShowCardExactAmount() {
    const input = document.getElementById('show-card-amount');
    if (input) input.value = _outstanding.toFixed(2);
}

function updateShowChange() {
    const tendered = parseFloat(document.getElementById('show-pay-amount')?.value) || 0;
    const change   = tendered - _outstanding;
    const display  = document.getElementById('show-change-display');
    const amt      = document.getElementById('show-change-amount');
    if (tendered > 0 && change >= 0) {
        display.style.display = 'flex';
        amt.textContent = '£' + change.toFixed(2);
    } else {
        display.style.display = 'none';
    }
}

function updateShowSplit2() {
    const a1 = parseFloat(document.getElementById('show-split1-amount')?.value) || 0;
    const s2 = document.getElementById('show-split2-amount');
    if (s2) s2.value = Math.max(0, _outstanding - a1).toFixed(2);
}

// ── Submit Payment ────────────────────────────────────────────
async function submitShowPayment() {
    const errDiv  = document.getElementById('show-pay-error');
    const btn     = document.getElementById('show-pay-submit');
    const note    = document.getElementById('show-pay-note').value.trim() || null;
    errDiv.style.display = 'none';

    let payments = [];

    if (_selectedMethod === 'split') {
        const a1 = parseFloat(document.getElementById('show-split1-amount')?.value) || 0;
        const a2 = parseFloat(document.getElementById('show-split2-amount')?.value) || 0;
        const m1 = document.getElementById('show-split1-method')?.value || 'cash';
        const m2 = document.getElementById('show-split2-method')?.value || 'card';
        if (a1 <= 0 && a2 <= 0) {
            errDiv.textContent = 'Please enter payment amounts.';
            errDiv.style.display = 'block'; return;
        }
        const splitTotal = a1 + a2;
        if (splitTotal > _outstanding + 0.001) {
            errDiv.textContent = `Total split amount £${splitTotal.toFixed(2)} exceeds outstanding balance of £${_outstanding.toFixed(2)}.`;
            errDiv.style.display = 'block'; return;
        }
        if (a1 > 0) payments.push({ method:'split', split_part:m1, amount:a1, note });
        if (a2 > 0) payments.push({ method:'split', split_part:m2, amount:a2, note:null });

    } else if (_selectedMethod === 'card') {
        if (_outstanding <= 0) {
            errDiv.textContent = 'No outstanding balance.';
            errDiv.style.display = 'block'; return;
        }
        const cardAmt = parseFloat(document.getElementById('show-card-amount')?.value) || _outstanding;
        if (cardAmt <= 0) {
            errDiv.textContent = 'Enter a valid card amount.';
            errDiv.style.display = 'block'; return;
        }
        if (cardAmt > _outstanding + 0.001) {
            errDiv.textContent = `Amount £${cardAmt.toFixed(2)} exceeds outstanding balance of £${_outstanding.toFixed(2)}.`;
            errDiv.style.display = 'block'; return;
        }
        payments.push({ method:'card', amount:cardAmt, note });

    } else if (_selectedMethod === 'trade') {
        const val = parseFloat(document.getElementById('show-trade-value')?.value) || 0;
        if (val <= 0) {
            errDiv.textContent = 'Enter a trade-in value.';
            errDiv.style.display = 'block'; return;
        }
        if (val > _outstanding + 0.001) {
            errDiv.textContent = `Trade value £${val.toFixed(2)} exceeds outstanding balance of £${_outstanding.toFixed(2)}.`;
            errDiv.style.display = 'block'; return;
        }
        payments.push({ method:'trade', amount:val, note });

    } else {
        const amt = parseFloat(document.getElementById('show-pay-amount')?.value) || 0;
        if (amt <= 0) {
            errDiv.textContent = 'Enter a valid amount.';
            errDiv.style.display = 'block'; return;
        }
        if (amt > _outstanding + 0.001) {
            errDiv.textContent = `Amount £${amt.toFixed(2)} exceeds outstanding balance of £${_outstanding.toFixed(2)}.`;
            errDiv.style.display = 'block'; return;
        }
        payments.push({ method:'cash', amount:amt, note });
    }

    // Submit each payment
    btn.disabled  = true;
    btn.innerHTML = `<svg width="15" height="15" fill="none" viewBox="0 0 24 24"
        style="animation:spin 1s linear infinite;"><circle cx="12" cy="12" r="10"
        stroke="white" stroke-width="4" opacity="0.25"/><path fill="white"
        d="M4 12a8 8 0 018-8v8H4z"/></svg> Processing...`;

    try {
        for (const pay of payments) {
            const res  = await fetch(_PAYMENT_URL, {
                method : 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _CSRF,
                    'Accept'      : 'application/json',
                },
                body: JSON.stringify(pay),
            });
            const data = await res.json();
            if (!data.success) throw new Error(data.message || 'Failed');

            // Add to payments list in DOM
            _addPaymentRow(pay.method, pay.split_part, pay.amount, pay.note, data.payment_id);

            // Update outstanding
            _outstanding = data.summary?.outstanding ?? Math.max(0, _outstanding - pay.amount);
        }

        closePaymentModal();
        _refreshSummaryUI();
        _toast('Payment recorded', '#10b981');

    } catch(e) {
        errDiv.textContent   = e.message || 'Network error.';
        errDiv.style.display = 'block';
    } finally {
        btn.disabled  = false;
        btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor"
            viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" d="M12 4v16m8-8H4"/></svg> Add Payment`;
    }
}

function _addPaymentRow(method, splitPart, amount, note, id) {
    const noMsg = document.getElementById('no-payments-msg');
    if (noMsg) noMsg.remove();

    const label = method === 'split' && splitPart
        ? splitPart.charAt(0).toUpperCase() + splitPart.slice(1) + ' (split)'
        : method.charAt(0).toUpperCase() + method.slice(1);

    const row = document.createElement('div');
    row.className = 'flex items-center justify-between px-4 py-3';
    if (id) row.id = `payment-row-${id}`;
    row.innerHTML = `
        <div>
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">${label}</p>
            ${note ? `<p class="text-xs text-gray-400">${note}</p>` : ''}
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm font-bold text-gray-900 dark:text-white">
                £${parseFloat(amount).toFixed(2)}
            </span>
            ${id ? `<button type="button" onclick="deletePayment(${id})"
                class="w-6 h-6 rounded-full flex items-center justify-center
                       bg-red-50 dark:bg-red-900/20 text-red-400
                       hover:bg-red-100 transition-all border-none cursor-pointer">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>` : ''}
        </div>`;

    document.getElementById('payments-list').appendChild(row);
}

function _refreshSummaryUI() {
    const outstandingRow = document.getElementById('show-outstanding-row');
    const paidRow        = document.getElementById('show-paid-row');
    const outEl          = document.getElementById('show-outstanding');
    const modalDisp      = document.getElementById('modal-outstanding-display');

    if (outEl) outEl.textContent = '£' + _outstanding.toFixed(2);
    if (modalDisp) modalDisp.textContent = '£' + _outstanding.toFixed(2);

    if (_outstanding > 0) {
        if (outstandingRow) outstandingRow.classList.remove('hidden');
        if (paidRow) paidRow.classList.add('hidden');
    } else {
        if (outstandingRow) outstandingRow.classList.add('hidden');
        if (paidRow) paidRow.classList.remove('hidden');
    }
}

// ── Delete Payment ────────────────────────────────────────────
async function deletePayment(paymentId) {
    if (!confirm('Remove this payment?')) return;
    const url = _DEL_PAY_URL.replace('{id}', paymentId);
    try {
        const res  = await fetch(url, {
            method : 'DELETE',
            headers: { 'X-CSRF-TOKEN':_CSRF, 'Accept':'application/json' },
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById(`payment-row-${paymentId}`)?.remove();
            _outstanding = data.summary?.outstanding ?? _outstanding;
            _refreshSummaryUI();
            _toast('Payment removed', '#10b981');
        }
    } catch(e) { _toast('Failed to remove payment', '#ef4444'); }
}

// ── Device status update ──────────────────────────────────────
async function updateDeviceStatus(deviceId, statusId, name, color) {
    const url = _DEV_STATUS_URL.replace('{device}', deviceId);
    try {
        const res  = await fetch(url, {
            method : 'PATCH',
            headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':_CSRF,'Accept':'application/json' },
            body   : JSON.stringify({ status_id: statusId }),
        });
        const data = await res.json();
        if (data.success) {
            const badgeMap = {
                green:'badge-green',blue:'badge-blue',yellow:'badge-yellow',
                orange:'badge-orange',red:'badge-red',purple:'badge-purple',gray:'badge-gray',
            };
            const pill  = document.getElementById(`dev-status-pill-${deviceId}`);
            const label = document.getElementById(`dev-status-label-${deviceId}`);
            if (pill) {
                pill.className = `inline-flex items-center gap-1.5 px-2.5 py-1
                    rounded-full text-xs font-semibold cursor-pointer border-none
                    transition-all ${badgeMap[color] ?? 'badge-gray'}`;
            }
            if (label) label.textContent = name;
            _toast('Device status: ' + name, '#10b981');
        }
    } catch(e) { _toast('Failed to update status', '#ef4444'); }
}

// ── Toast ─────────────────────────────────────────────────────
function _toast(msg, bg = '#10b981') {
    const t = document.createElement('div');
    t.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:99999;
        padding:10px 18px;border-radius:12px;color:#fff;font-size:0.85rem;
        font-weight:700;background:${bg};box-shadow:0 8px 24px rgba(0,0,0,0.15);
        transform:translateY(10px);opacity:0;transition:all 0.25s ease;`;
    t.textContent = msg;
    document.body.appendChild(t);
    requestAnimationFrame(() => requestAnimationFrame(() => {
        t.style.transform = 'translateY(0)'; t.style.opacity = '1';
    }));
    setTimeout(() => {
        t.style.opacity = '0'; t.style.transform = 'translateY(10px)';
        setTimeout(() => t.remove(), 250);
    }, 3000);
}

// Escape key closes modal
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closePaymentModal();
});
</script>
@endpush

</x-app-layout>