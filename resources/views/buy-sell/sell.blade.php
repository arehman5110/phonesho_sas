<x-app-layout>
<x-slot name="title">Sell Device — {{ $device->model_name }}</x-slot>

@push('styles')
<style>
    .field-err{color:#ef4444;font-size:.72rem;font-weight:600;margin-top:3px;display:none;}
    .field-err.show{display:block;}
    input.err,select.err{border-color:#ef4444!important;}
    @keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
    .shake{animation:shake .3s ease;}
</style>
@endpush

<x-page-header
    title="Sell Device"
    subtitle="{{ $device->model_name }}"
    :breadcrumbs="[
        ['label'=>'Dashboard',  'route'=>'dashboard'],
        ['label'=>'Buy & Sell', 'route'=>'buy-sell.index'],
        ['label'=>'Sell — '.$device->model_name],
    ]">
    <x-slot name="actions">
        <a href="{{ route('buy-sell.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
        </a>
    </x-slot>
</x-page-header>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ════ LEFT — Form ════ --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Device summary card --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Device Being Sold</span>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Model</p>
                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $device->model_name }}</p>
                </div>
                @if($device->brand)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Brand</p>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $device->brand->name }}</p>
                </div>
                @endif
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Condition</p>
                    @php
                        $condColor = match($device->condition) {
                            'new'         => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                            'used'        => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                            'refurbished' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                            'faulty'      => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                            default       => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full {{ $condColor }}">
                        {{ $device->condition_label }}
                    </span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Buy Price</p>
                    <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">£{{ number_format($device->purchase_price,2) }}</p>
                </div>
                @if($device->imei)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">IMEI</p>
                    <p class="text-xs font-mono text-gray-600 dark:text-gray-400">{{ $device->imei }}</p>
                </div>
                @endif
                @if($device->storage || $device->color)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Specs</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ implode(' · ', array_filter([$device->storage, $device->color])) }}
                    </p>
                </div>
                @endif
                @if($device->buyTransaction?->customer)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Bought From</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $device->buyTransaction->customer->name }}</p>
                </div>
                @endif
                @if($device->notes)
                <div class="col-span-2 sm:col-span-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Notes</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 bg-amber-50 dark:bg-amber-900/20
                               rounded-lg px-3 py-2 border border-amber-100 dark:border-amber-800">
                        {{ $device->notes }}
                    </p>
                </div>
                @endif
            </div>
        </div>

        {{-- Buyer --}}
        <x-form-section title="Buyer" color="blue">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </x-slot>
            <p class="text-xs text-gray-400 mb-3">Who are you selling to? (optional)</p>
            <x-customer-search field-name="sell_customer_id" />
        </x-form-section>

        {{-- Sale details --}}
        <x-form-section title="Sale Details" color="indigo">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </x-slot>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Sell Price <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold pointer-events-none">£</span>
                        <input type="number" id="inp-sell-price" min="0.01" step="0.01" placeholder="0.00"
                               oninput="updateProfit()"
                               class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      font-semibold outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>
                    <p class="field-err" id="err-sell-price"></p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Discount <span class="text-gray-400 font-normal normal-case">(optional)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-semibold pointer-events-none">£</span>
                        <input type="number" id="inp-discount" min="0" step="0.01" value="0"
                               oninput="updateProfit()"
                               class="w-full pl-8 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                      font-semibold outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Payment Method</label>
                    <select id="inp-pay-method"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                   outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 transition-all">
                        <option value="cash">💵 Cash</option>
                        <option value="card">💳 Card</option>
                        <option value="bank_transfer">🏦 Bank Transfer</option>
                        <option value="trade">🔄 Trade</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Payment Status</label>
                    <select id="inp-pay-status"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                   outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 transition-all">
                        <option value="paid">✅ Paid</option>
                        <option value="partial">🔵 Partial</option>
                        <option value="unpaid">⏳ Unpaid</option>
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Notes</label>
                    <input type="text" id="inp-notes" placeholder="Sale notes, accessories handed over..."
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                  outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>

            </div>
        </x-form-section>

    </div>

    {{-- ════ RIGHT — Summary ════ --}}
    <div class="space-y-4 sticky top-6">

        {{-- Financials --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">Financials</p>
            </div>
            <div class="p-5 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Buy Price</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">
                        £{{ number_format($device->purchase_price,2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Sell Price</span>
                    <span id="sum-sell" class="text-sm font-bold text-gray-900 dark:text-white">—</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Discount</span>
                    <span id="sum-discount" class="text-sm font-semibold text-red-500">—</span>
                </div>
                <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-800 pt-3">
                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300">Final Amount</span>
                    <span id="sum-final" class="text-base font-black text-indigo-600 dark:text-indigo-400">—</span>
                </div>
            </div>
        </div>

        {{-- Profit/Loss box --}}
        <div id="profit-box" style="display:none"
             class="rounded-2xl border-2 p-5 text-center transition-all">
            <p id="profit-label" class="text-xs font-bold uppercase tracking-widest mb-2"></p>
            <p id="profit-val" class="text-4xl font-black"></p>
            <p id="profit-margin" class="text-xs text-gray-400 mt-2"></p>
        </div>

        {{-- Error --}}
        <div id="global-err" style="display:none"
             class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold
                    bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span id="global-err-text"></span>
        </div>

        {{-- Submit --}}
        <button type="button" id="submit-btn" onclick="submitSell()"
                class="w-full py-3.5 rounded-2xl text-sm font-black text-white bg-indigo-600
                       hover:bg-indigo-700 active:scale-[.99] transition-all
                       flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span id="submit-text">Complete Sale</span>
        </button>

        <a href="{{ route('buy-sell.index') }}"
           class="w-full py-2.5 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                  flex items-center justify-center">
            Cancel
        </a>

    </div>
</div>

@include('customers.modals.create')

@push('scripts')
<script>
window.REPAIR_CONFIG = {
    routes: {
        customers     : '{{ route("customers.search") }}',
        customerStore : '{{ route("customers.store") }}',
        customerUpdate: '/api/customers/{id}',
        customerStats : '{{ route("customers.stats", "__ID__") }}'.replace('__ID__','{id}'),
    },
    csrf: '{{ csrf_token() }}',
};

const BUY_PRICE = {{ (float)$device->purchase_price }};
let _customerId = null;
document.addEventListener('customer-selected', e => _customerId = e.detail.id);
document.addEventListener('customer-cleared',  () => _customerId = null);

function updateProfit() {
    const sell     = parseFloat(document.getElementById('inp-sell-price')?.value) || 0;
    const discount = parseFloat(document.getElementById('inp-discount')?.value)   || 0;
    const final    = Math.max(0, sell - discount);
    const profit   = final - BUY_PRICE;
    const margin   = final > 0 ? (profit/final*100) : 0;

    document.getElementById('sum-sell').textContent     = sell     ? '£'+sell.toFixed(2)     : '—';
    document.getElementById('sum-discount').textContent = discount ? '-£'+discount.toFixed(2) : '—';
    document.getElementById('sum-final').textContent    = final    ? '£'+final.toFixed(2)    : '—';

    const box = document.getElementById('profit-box');
    if (sell > 0) {
        box.style.display='block';
        const lbl=document.getElementById('profit-label');
        const val=document.getElementById('profit-val');
        const mrg=document.getElementById('profit-margin');
        if (profit>0) {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-emerald-600 dark:text-emerald-400';
            lbl.textContent='📈 Profit';
            val.className='text-4xl font-black text-emerald-600 dark:text-emerald-400';
        } else if (profit<0) {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-red-500';
            lbl.textContent='📉 Loss';
            val.className='text-4xl font-black text-red-500';
        } else {
            box.className='rounded-2xl border-2 p-5 text-center transition-all border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800';
            lbl.className='text-xs font-bold uppercase tracking-widest mb-2 text-gray-400';
            lbl.textContent='Break Even';
            val.className='text-4xl font-black text-gray-500';
        }
        val.textContent=(profit>=0?'+':'')+'£'+Math.abs(profit).toFixed(2);
        mrg.textContent=Math.abs(margin).toFixed(1)+'% margin';
    } else { box.style.display='none'; }
}

async function submitSell() {
    const btn = document.getElementById('submit-btn');
    const txt = document.getElementById('submit-text');
    const errBox = document.getElementById('global-err');
    const errTxt = document.getElementById('global-err-text');
    document.querySelectorAll('.field-err').forEach(e=>e.classList.remove('show'));
    document.querySelectorAll('.err').forEach(e=>e.classList.remove('err'));
    errBox.style.display='none';

    const sell = parseFloat(document.getElementById('inp-sell-price')?.value);
    if (!sell||sell<=0) {
        const el=document.getElementById('err-sell-price');
        if(el){el.textContent='Enter a valid sell price.';el.classList.add('show');}
        document.getElementById('inp-sell-price')?.classList.add('err');
        btn.classList.add('shake'); setTimeout(()=>btn.classList.remove('shake'),400);
        return;
    }

    btn.disabled=true; txt.textContent='Processing...';
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
    const body = {
        selling_price : sell,
        discount      : parseFloat(document.getElementById('inp-discount')?.value)||0,
        customer_id   : _customerId||null,
        payment_method: document.getElementById('inp-pay-method')?.value,
        payment_status: document.getElementById('inp-pay-status')?.value,
        notes         : document.getElementById('inp-notes')?.value?.trim()||null,
    };

    try {
        const res  = await fetch('{{ route("buy-sell.sell", $device) }}', {
            method:'POST',
            headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
            body:JSON.stringify(body),
        });
        const data = await res.json();
        if (data.success) {
            window.location='{{ route("buy-sell.index") }}';
        } else {
            errTxt.textContent = data.message||'Failed to process sale.';
            errBox.style.display='flex';
            btn.disabled=false; txt.textContent='Complete Sale';
        }
    } catch(e) {
        errTxt.textContent='Network error. Please try again.';
        errBox.style.display='flex';
        btn.disabled=false; txt.textContent='Complete Sale';
    }
}
</script>
@endpush
</x-app-layout>