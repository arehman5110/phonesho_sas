<x-app-layout>
<x-slot name="title">Buy Device(s)</x-slot>

@push('styles')
<style>
    /* Errors */
    .ferr{color:#ef4444;font-size:.7rem;font-weight:600;margin-top:2px;display:none;}
    .ferr.show{display:block;}
    input.ierr,select.ierr{border-color:#ef4444!important;}
    /* Card entrance */
    .device-card{animation:cardIn .18s ease;}
    @keyframes cardIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
    @keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
    .shake{animation:shake .3s ease;}
    /* AC */
    .ac-item.hi{background:#eef2ff!important;}
    .dark .ac-item.hi{background:#1e1b4b!important;}
    /* Payment modal */
    #pay-modal{position:fixed;inset:0;z-index:1000;background:rgba(15,23,42,.75);
        display:none;align-items:center;justify-content:center;padding:16px;}
    #pay-modal.open{display:flex;}
    /* Mode tab */
    .mode-tab{transition:all .2s ease;cursor:pointer;flex:1;border:none;outline:none;}
</style>
@endpush

<x-page-header
    title="Buy Device(s)"
    subtitle="Record one or multiple device purchases at once"
    :breadcrumbs="[
        ['label'=>'Dashboard','route'=>'dashboard'],
        ['label'=>'Buy & Sell','route'=>'buy-sell.index'],
        ['label'=>'Buy Device(s)'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('buy-sell.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200
                  dark:border-gray-700 text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
        </a>
    </x-slot>
</x-page-header>

<div x-data="BuyDevices()" x-init="init()">

{{-- ══ Mode Tab ══ --}}
<div class="flex rounded-2xl overflow-hidden mb-5 shadow-lg" style="min-height:96px;">
    {{-- Buy tab --}}
    <button type="button"
            class="mode-tab flex flex-col items-center justify-center gap-2 py-6 px-8"
            :class="mode==='buy'
                ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white'
                : 'bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'"
            @click="mode='buy'; resetDevices()">
        <div class="flex items-center gap-3">
            <svg class="w-7 h-7" :class="mode==='buy'?'opacity-90':'opacity-40'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184
                         1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            <div class="text-left">
                <p class="text-lg font-black tracking-tight">Buying Device</p>
                <p class="text-sm" :class="mode==='buy'?'opacity-80':'opacity-50'">Customer selling to you</p>
            </div>
        </div>
    </button>
    {{-- Divider --}}
    <div class="w-px" :class="mode==='buy'?'bg-blue-500':'bg-gray-200 dark:bg-gray-700'"></div>
    {{-- Sell tab --}}
    <button type="button"
            class="mode-tab flex flex-col items-center justify-center gap-2 py-6 px-8"
            :class="mode==='sell'
                ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white'
                : 'bg-white dark:bg-gray-900 text-gray-400 dark:text-gray-500 hover:bg-gray-50 dark:hover:bg-gray-800'"
            @click="mode='sell'; resetDevices()">
        <div class="flex items-center gap-3">
            <svg class="w-7 h-7" :class="mode==='sell'?'opacity-90':'opacity-40'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0
                         2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21
                         12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-left">
                <p class="text-lg font-black tracking-tight">Selling Device</p>
                <p class="text-sm" :class="mode==='sell'?'opacity-80':'opacity-50'">You selling to customer</p>
            </div>
        </div>
    </button>
</div>

{{-- 65/35 layout --}}
<div class="flex gap-5 items-start">

    {{-- ══════════ LEFT 65% ══════════ --}}
    <div class="min-w-0 space-y-4" style="flex:0 0 65%;">

        {{-- Customer --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Buying From</span>
                <span class="text-xs text-gray-400">(optional)</span>
            </div>
            <div class="p-5">
                <x-customer-search field-name="customer_id" />
            </div>
        </div>

        {{-- Device cards --}}
        <template x-for="(dev, idx) in devices" :key="dev.id">
            <div class="device-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden"
                 :class="dev.hasError ? 'border-red-300 dark:border-red-700' : ''">

                {{-- Card header --}}
                <div class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-200 dark:border-gray-700"
                     :class="mode==='buy'
                        ? 'bg-gray-50 dark:bg-gray-800'
                        : 'bg-emerald-50/60 dark:bg-emerald-900/10'">
                    {{-- Number badge --}}
                    <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 font-black text-xs text-white"
                         :class="mode==='buy' ? 'bg-indigo-600' : 'bg-emerald-600'"
                         x-text="idx + 1"></div>

                    <span class="text-sm font-bold text-gray-700 dark:text-gray-200 whitespace-nowrap">
                        Device <span x-text="idx + 1"></span>
                    </span>

                    {{-- SELL mode: inventory picker in header --}}
                    <div x-show="mode==='sell'" class="flex-1 mx-2" style="display:none;">
                        <select :id="'inv-'+dev.id"
                                @change="pickInventory(dev, $event.target)"
                                class="w-full pl-3 pr-8 py-2 border border-emerald-200 dark:border-emerald-700
                                       rounded-xl text-sm outline-none bg-white dark:bg-gray-800
                                       text-gray-700 dark:text-gray-300 cursor-pointer
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 transition-all">
                            <option value="">🏷️ Pick from inventory (optional)...</option>
                            @foreach($stockDevices as $sd)
                            <option value="{{ $sd->id }}"
                                    data-device="{{ str_replace("'","&#39;",json_encode([
                                        'id'            => $sd->id,
                                        'model_name'    => $sd->model_name,
                                        'brand'         => $sd->brand?->name ?? '',
                                        'storage'       => $sd->storage ?? '',
                                        'color'         => $sd->color  ?? '',
                                        'imei'          => $sd->imei   ?? '',
                                        'purchase_price'=> (float)$sd->purchase_price,
                                        'selling_price' => $sd->selling_price ? (float)$sd->selling_price : null,
                                        'notes'         => $sd->notes ?? '',
                                    ])) }}">
                                {{ $sd->model_name }}{{ $sd->brand ? ' — '.$sd->brand->name : '' }}{{ $sd->storage ? ' · '.$sd->storage : '' }} · £{{ number_format($sd->purchase_price,2) }} cost
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BUY mode: show model name after typing --}}
                    <span x-show="mode==='buy' && dev.model_name"
                          class="text-sm font-normal text-gray-400 truncate max-w-48"
                          x-text="'— ' + dev.model_name"></span>

                    <div class="ml-auto flex items-center gap-2 flex-shrink-0">
                        <button type="button" x-show="mode==='buy'" @click="duplicate(idx)"
                                class="flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold
                                       border border-gray-200 dark:border-gray-700 text-gray-500
                                       hover:border-indigo-300 hover:text-indigo-600 transition-all cursor-pointer bg-transparent">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Duplicate
                        </button>
                        <button type="button" x-show="devices.length > 1" @click="remove(idx)"
                                class="w-7 h-7 rounded-lg flex items-center justify-center bg-red-50
                                       dark:bg-red-900/20 text-red-400 hover:bg-red-100 hover:text-red-600
                                       transition-all cursor-pointer border-none">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-5 space-y-4">

                    {{-- ROW 1: Device Type / Brand / Model --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Device Type</label>
                            <select x-model="dev.device_type"
                                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                           outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                           cursor-pointer focus:border-indigo-500 transition-all">
                                <option value="">Select...</option>
                                <option value="smartphone">📱 Smartphone</option>
                                <option value="tablet">📟 Tablet</option>
                                <option value="laptop">💻 Laptop</option>
                                <option value="desktop">🖥️ Desktop</option>
                                <option value="smartwatch">⌚ Smartwatch</option>
                                <option value="earbuds">🎧 Earbuds / AirPods</option>
                                <option value="console">🎮 Gaming Console</option>
                                <option value="charger">🔌 Charger / Cable</option>
                                <option value="accessory">🔧 Accessory</option>
                                <option value="other">📦 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Brand</label>
                            <input type="text" x-model="dev.brand_name" placeholder="e.g. Apple"
                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                Model <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" x-model="dev.model_name"
                                       @input.debounce.300ms="acSearch(dev)"
                                       @keydown.arrow-down.prevent="acDown(dev)"
                                       @keydown.arrow-up.prevent="acUp(dev)"
                                       @keydown.enter.prevent="acEnter(dev)"
                                       @keydown.escape="dev.acOpen=false"
                                       @focus="dev.model_name.length>0&&(dev.acOpen=true)"
                                       @blur="setTimeout(()=>dev.acOpen=false,160)"
                                       placeholder="e.g. iPhone 15 Pro"
                                       autocomplete="off"
                                       :class="dev.err_model?'ierr':''"
                                       class="w-full pl-3 pr-8 py-2.5 border border-gray-200 dark:border-gray-700
                                              rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                                              text-gray-900 dark:text-white placeholder-gray-400
                                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                              focus:bg-white dark:focus:bg-gray-900 transition-all">
                                <div x-show="dev.acLoading" class="absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-3.5 h-3.5 animate-spin text-indigo-400" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                                    </svg>
                                </div>
                            </div>
                            {{-- AC Dropdown --}}
                            <div x-show="dev.acOpen"
                                 class="absolute left-0 right-0 top-full mt-1 z-50 bg-white dark:bg-gray-800
                                        border border-gray-200 dark:border-gray-700 rounded-xl shadow-xl
                                        max-h-48 overflow-y-auto"
                                 style="display:none;">
                                <template x-for="(p,pi) in dev.acResults" :key="p.id">
                                    <div @mousedown.prevent="acPick(dev,p)"
                                         :class="{'hi':dev.acHi===pi}"
                                         class="ac-item flex items-center justify-between px-3 py-2.5 cursor-pointer
                                                text-sm border-b border-gray-100 dark:border-gray-700/50 last:border-0
                                                hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <div class="min-w-0 flex-1">
                                            <p class="font-semibold text-gray-900 dark:text-white truncate" x-text="p.name"></p>
                                            <p class="text-xs text-gray-400 truncate" x-text="[p.category,p.brand].filter(Boolean).join(' · ')"></p>
                                        </div>
                                        <span class="text-xs font-bold text-indigo-600 ml-2 flex-shrink-0" x-text="p.formatted_price"></span>
                                    </div>
                                </template>
                                <div x-show="!dev.acLoading&&dev.acResults.length===0&&dev.model_name.trim().length>1" class="px-4 py-4 text-center">
                                    <p class="text-xs text-gray-400 mb-2">No products found</p>
                                    <button type="button" @mousedown.prevent="dev.acOpen=false"
                                            class="w-full py-1.5 rounded-xl border-2 border-dashed border-indigo-300 dark:border-indigo-700
                                                   text-xs font-semibold text-indigo-600 hover:bg-indigo-50">
                                        Use "<span x-text="dev.model_name"></span>"
                                    </button>
                                </div>
                            </div>
                            <p x-show="dev.err_model" x-text="dev.err_model" class="ferr show mt-1"></p>
                        </div>
                    </div>

                    {{-- ROW 2: Colour / Storage / IMEI / Grade --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Colour</label>
                            <input type="text" x-model="dev.color" placeholder="e.g. Black"
                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Storage / Spec</label>
                            <input type="text" x-model="dev.storage" placeholder="e.g. 256GB"
                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">IMEI / Serial</label>
                            <input type="text" x-model="dev.imei" maxlength="20" placeholder="15 digits"
                                   :class="dev.err_imei?'ierr':''"
                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          font-mono outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                            <p x-show="dev.err_imei" x-text="dev.err_imei" class="ferr show mt-1"></p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                Grade <span class="text-red-500">*</span>
                            </label>
                            <select x-model="dev.condition"
                                    :class="dev.err_condition?'ierr':''"
                                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                           outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                           cursor-pointer focus:border-indigo-500 transition-all">
                                <option value="">Select...</option>
                                <option value="grade_a">⭐ Grade A — Pristine</option>
                                <option value="grade_b">✅ Grade B — Good</option>
                                <option value="grade_c">🟡 Grade C — Average</option>
                                <option value="grade_d">🟠 Grade D — Poor</option>
                                <option value="faulty">⚠️ Faulty</option>
                            </select>
                            <p x-show="dev.err_condition" x-text="dev.err_condition" class="ferr show mt-1"></p>
                        </div>
                    </div>

                    {{-- ROW 3: Price / Target Sell (buy only) / Warranty --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                <span x-text="mode==='buy' ? 'Buy Price £' : 'Sell Price £'"></span>
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 pointer-events-none">£</span>
                                <input type="number" x-model="dev.purchase_price" @input="calcTotals()"
                                       min="0" step="0.01" placeholder="0.00"
                                       :class="dev.err_price?'ierr':''"
                                       class="w-full pl-7 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                              text-sm font-semibold outline-none bg-gray-50 dark:bg-gray-800
                                              text-gray-900 dark:text-white focus:border-emerald-500
                                              focus:ring-2 focus:ring-emerald-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                            </div>
                            <p x-show="dev.err_price" x-text="dev.err_price" class="ferr show mt-1"></p>
                        </div>
                        <div x-show="mode==='buy'">
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Target Sell £</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-gray-400 pointer-events-none">£</span>
                                <input type="number" x-model="dev.selling_price" @input="calcTotals()"
                                       min="0" step="0.01" placeholder="0.00"
                                       class="w-full pl-7 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                              text-sm font-semibold outline-none bg-gray-50 dark:bg-gray-800
                                              text-gray-900 dark:text-white focus:border-indigo-500
                                              focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Warranty</label>
                            <input type="text" x-model="dev.warranty" placeholder="e.g. 3 months"
                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                          outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                    </div>


                    {{-- ROW 4: Notes --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Item Notes</label>
                        <textarea x-model="dev.notes" rows="2"
                                  placeholder="Any notes about this device..."
                                  class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                                         outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                         placeholder-gray-400 resize-none focus:border-indigo-500
                                         focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </textarea>
                    </div>

                </div>
            </div>
        </template>

        {{-- Add device --}}
        <button type="button" @click="addDevice()"
                class="w-full py-4 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-700
                       text-sm font-semibold text-gray-500 dark:text-gray-400
                       hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50/50
                       dark:hover:border-emerald-700 dark:hover:text-emerald-400 dark:hover:bg-emerald-900/10
                       transition-all flex items-center justify-center gap-2 cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            + Add Device
        </button>

        {{-- Error banner --}}
        <div x-show="globalErr" x-transition style="display:none;"
             class="flex items-start gap-3 px-4 py-3.5 rounded-xl
                    bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-semibold text-red-700 dark:text-red-400" x-text="globalErr"></p>
        </div>

    </div>{{-- end left --}}

    {{-- ══════════ RIGHT 35% ══════════ --}}
    <div class="space-y-4 lg:sticky lg:top-6" style="flex:0 0 35%;">

        {{-- ── Summary Card (matches reference image) ── --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">

            {{-- Total price hero --}}
            <div class="px-6 pt-6 pb-4 text-center border-b border-gray-100 dark:border-gray-800">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1"
                   x-text="mode==='buy' ? 'Total Purchase Cost' : 'Total Selling Price'"></p>
                <p class="font-black leading-none mt-2"
                   :class="mode==='buy'
                       ? 'text-indigo-600 dark:text-indigo-400'
                       : 'text-emerald-600 dark:text-emerald-400'"
                   style="font-size:2.8rem;font-family:Georgia,serif;"
                   x-text="'£'+totalBuy.toFixed(2)"></p>
            </div>

            {{-- Stats rows --}}
            <div class="px-6 py-4 space-y-3 border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Devices</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="devices.length"></span>
                </div>
                {{-- Per device lines --}}
                <template x-for="(d,i) in devices" :key="d.id">
                    <div class="flex items-center justify-between" x-show="d.model_name || d.purchase_price">
                        <span class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-32"
                              x-text="d.model_name || ('Device '+(i+1))"></span>
                        <span class="text-sm font-semibold"
                              :class="mode==='buy' ? 'text-gray-900 dark:text-white' : 'text-emerald-600 dark:text-emerald-400'"
                              x-text="d.purchase_price ? '£'+parseFloat(d.purchase_price).toFixed(2) : '—'"></span>
                    </div>
                </template>
                <div class="flex items-center justify-between pt-1">
                    <span class="text-sm text-gray-500">Initial Payment</span>
                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400"
                          x-text="'£'+totalPaid().toFixed(2)"></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-gray-900 dark:text-white">Balance Due</span>
                    <span class="text-sm font-black"
                          :class="outstanding()>0 ? 'text-red-500' : 'text-emerald-600 dark:text-emerald-400'"
                          x-text="outstanding()>0 ? '£'+outstanding().toFixed(2) : '£0.00'"></span>
                </div>
                {{-- Profit line (buy mode, when target sell set) --}}
                <div x-show="mode==='buy' && totalSell > 0" class="flex items-center justify-between pt-1 border-t border-gray-100 dark:border-gray-800" style="display:none;">
                    <span class="text-xs text-gray-400">Expected Profit</span>
                    <span class="text-sm font-black"
                          :class="(totalSell-totalBuy)>=0?'text-emerald-600 dark:text-emerald-400':'text-red-500'"
                          x-text="((totalSell-totalBuy)>=0?'+':'')+'£'+Math.abs(totalSell-totalBuy).toFixed(2)"></span>
                </div>
            </div>

            {{-- Mode info box --}}
            <div class="mx-4 my-4 px-4 py-3 rounded-xl"
                 :class="mode==='buy'
                    ? 'bg-indigo-50 dark:bg-indigo-900/20'
                    : 'bg-emerald-50 dark:bg-emerald-900/20'">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="text-base" x-text="mode==='buy' ? '📥' : '📤'"></span>
                    <p class="text-sm font-bold"
                       :class="mode==='buy' ? 'text-indigo-700 dark:text-indigo-300' : 'text-emerald-700 dark:text-emerald-300'"
                       x-text="mode==='buy' ? 'Buying Mode' : 'Selling Mode'"></p>
                </div>
                <p class="text-xs ml-6"
                   :class="mode==='buy' ? 'text-indigo-500 dark:text-indigo-400' : 'text-emerald-600 dark:text-emerald-400'"
                   x-text="mode==='buy'
                       ? 'Customer is selling a device to you'
                       : 'You are selling a device to the customer'">
                </p>
            </div>

            {{-- Payments list --}}
            <div x-show="payments.length > 0" class="px-4 pb-3 space-y-1.5" style="display:none;">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider px-1 mb-2">Payments</p>
                <template x-for="(p,i) in payments" :key="i">
                    <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-gray-50 dark:bg-gray-800 group">
                        <div class="flex items-center gap-2">
                            <span x-text="methodIcon(p.method)"></span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 capitalize" x-text="p.label"></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-bold text-emerald-600" x-text="'£'+p.amount.toFixed(2)"></span>
                            <button type="button" @click="removePayment(i)"
                                    class="w-4 h-4 rounded-full bg-red-100 text-red-400 hover:text-red-600
                                           opacity-0 group-hover:opacity-100 flex items-center justify-center
                                           border-none cursor-pointer transition-all">
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Add payment button --}}
            <div class="px-4 pb-4">
                <button type="button" @click="openPayModal()"
                        class="w-full py-2.5 rounded-xl text-sm font-semibold border-2 border-dashed
                               border-emerald-300 dark:border-emerald-700 text-emerald-600
                               dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/10
                               transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span x-text="payments.length===0 ? 'Add Payment' : 'Add Another Payment'"></span>
                </button>
            </div>

        </div>

        {{-- Save Deal button --}}
        <button type="button" @click="submit()" :disabled="submitting"
                class="w-full py-4 rounded-2xl text-base font-black text-white
                       active:scale-[.99] disabled:opacity-60 disabled:cursor-not-allowed
                       transition-all flex items-center justify-center gap-2 shadow-lg"
                :class="mode==='buy'
                    ? 'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-500/20'
                    : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20'">
            <svg x-show="submitting" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-text="submitting ? 'Saving...' : 'Save Deal'"></span>
        </button>

        <a href="{{ route('buy-sell.index') }}"
           class="w-full py-3 rounded-2xl text-sm font-semibold border-2 border-gray-200
                  dark:border-gray-700 text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                  flex items-center justify-center">
            Cancel
        </a>

    </div>{{-- end right --}}
</div>{{-- end flex --}}

{{-- ═══════════════════════════════════════════════ --}}
{{-- PAYMENT MODAL (same structure as repair)        --}}
{{-- ═══════════════════════════════════════════════ --}}
<div id="pay-modal" @click.self="closePayModal()">
    <div id="pay-modal-box"
         style="transform:scale(.95);opacity:0;transition:all .18s;max-height:90vh;overflow-y:auto;"
         class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800 sticky top-0 bg-white dark:bg-gray-900 z-10">
            <h3 class="text-base font-bold text-gray-900 dark:text-white">Add Payment</h3>
            <button type="button" @click="closePayModal()"
                    class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-100 dark:bg-gray-800
                           text-gray-500 hover:bg-gray-200 hover:text-red-500 transition-all border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 space-y-5">

            {{-- Total / Outstanding --}}
            <div class="text-center py-4 rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50
                        dark:from-emerald-900/20 dark:to-teal-900/20
                        border border-emerald-100 dark:border-emerald-800">
                <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mb-1">Total Due</p>
                <p class="text-4xl font-black text-emerald-700 dark:text-emerald-300" style="font-family:'Georgia',serif;"
                   x-text="'£'+totalBuy.toFixed(2)"></p>
                <div x-show="outstanding() > 0 && payments.length > 0"
                     class="mt-2 text-xs font-semibold text-amber-600 dark:text-amber-400">
                    Outstanding: <span x-text="'£'+outstanding().toFixed(2)"></span>
                </div>
            </div>

            {{-- Existing payments --}}
            <div x-show="payments.length > 0">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Payments Added</p>
                <div class="space-y-1.5 mb-3">
                    <template x-for="(p,i) in payments" :key="i">
                        <div class="flex items-center justify-between px-3 py-2 rounded-xl
                                    bg-gray-50 dark:bg-gray-800">
                            <div class="flex items-center gap-2">
                                <span x-text="methodIcon(p.method)"></span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300" x-text="p.label"></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="'£'+p.amount.toFixed(2)"></span>
                                <button type="button" @click="removePayment(i)"
                                        class="w-5 h-5 rounded-full bg-red-50 text-red-400 hover:text-red-600
                                               flex items-center justify-center border-none cursor-pointer">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Method selector --}}
            <div>
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Payment Method</p>
                <div class="grid grid-cols-4 gap-2">
                    <template x-for="m in payMethods" :key="m.value">
                        <button type="button" @click="pm.method = m.value; pm.showSplit = m.value==='split'"
                                :class="pm.method===m.value
                                    ?'border-emerald-500 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400'
                                    :'border-gray-200 dark:border-gray-700 text-gray-500 hover:border-emerald-300'"
                                class="flex flex-col items-center gap-1.5 py-3 rounded-xl border-2
                                       cursor-pointer transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" :d="m.icon"/>
                            </svg>
                            <span class="text-xs font-bold" x-text="m.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- CASH/TRADE — amount input --}}
            <div x-show="pm.method==='cash'||pm.method==='trade'">
                <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Amount £</p>
                {{-- Quick amounts --}}
                <div class="grid grid-cols-5 gap-1.5 mb-2">
                    <template x-for="amt in [5,10,20,50]" :key="amt">
                        <button type="button" @click="pm.amount = amt.toFixed(2); calcChange()"
                                class="py-2 rounded-lg text-xs font-bold border border-gray-200 dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400
                                       hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-400 transition-all"
                                x-text="'£'+amt"></button>
                    </template>
                    <button type="button" @click="pm.amount = outstanding().toFixed(2); calcChange()"
                            class="py-2 rounded-lg text-xs font-bold border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400
                                   hover:bg-emerald-50 hover:text-emerald-600 hover:border-emerald-400 transition-all">
                        Exact
                    </button>
                </div>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold pointer-events-none">£</span>
                    <input type="number" x-model="pm.amount" @input="calcChange()"
                           min="0" step="0.01" placeholder="0"
                           class="w-full pl-8 pr-4 py-3 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-xl font-black outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white focus:border-emerald-500
                                  focus:ring-2 focus:ring-emerald-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                {{-- Change --}}
                <div x-show="pm.change > 0"
                     class="mt-2 flex items-center justify-between px-4 py-2.5 rounded-xl
                            bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800">
                    <span class="text-sm font-semibold text-emerald-700 dark:text-emerald-400">Change Due</span>
                    <span class="text-base font-black text-emerald-600 dark:text-emerald-400"
                          x-text="'£'+pm.change.toFixed(2)"></span>
                </div>
            </div>

            {{-- CARD — no amount needed (use outstanding) --}}
            <div x-show="pm.method==='card'"
                 class="flex flex-col items-center py-4 gap-3">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500
                            flex items-center justify-center shadow-lg shadow-amber-200 dark:shadow-amber-900/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <p class="text-sm font-semibold text-gray-600 dark:text-gray-400">Present card to terminal</p>
                <p class="text-lg font-black text-gray-900 dark:text-white"
                   x-text="'£'+outstanding().toFixed(2)+' will be charged'"></p>
            </div>

            {{-- SPLIT --}}
            <div x-show="pm.method==='split'" class="space-y-3">
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-xl p-4">
                    <p class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-3">1st Payment</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Method</label>
                            <select x-model="pm.split1method"
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm
                                           outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer">
                                <option value="cash">💵 Cash</option>
                                <option value="card">💳 Card</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Amount £</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm pointer-events-none">£</span>
                                <input type="number" x-model="pm.split1amount" @input="updateSplit2()"
                                       min="0" step="0.01" placeholder="0.00"
                                       class="w-full pl-7 pr-2 py-2 border border-gray-200 dark:border-gray-700 rounded-lg
                                              text-sm font-bold outline-none bg-white dark:bg-gray-800
                                              text-gray-900 dark:text-white focus:border-indigo-400 transition-all">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-4">
                    <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-3">2nd Payment</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Method</label>
                            <select x-model="pm.split2method"
                                    class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm
                                           outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer">
                                <option value="card">💳 Card</option>
                                <option value="cash">💵 Cash</option>
                                <option value="other">💰 Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Amount £</label>
                            <div class="relative">
                                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm pointer-events-none">£</span>
                                <input type="number" x-model="pm.split2amount" readonly
                                       class="w-full pl-7 pr-2 py-2 border border-gray-200 dark:border-gray-700 rounded-lg
                                              text-sm font-bold outline-none bg-gray-50 dark:bg-gray-700
                                              text-gray-500 dark:text-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Note --}}
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Note (optional)</label>
                <input type="text" x-model="pm.note" placeholder="e.g. deposit, partial payment..."
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                              outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                              placeholder-gray-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6 flex gap-3">
            <button type="button" @click="closePayModal()"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                Cancel
            </button>
            <button type="button" @click="addPayment()"
                    class="flex-1 py-3 rounded-xl text-sm font-bold bg-emerald-600 hover:bg-emerald-700
                           active:scale-95 text-white transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Payment
            </button>
        </div>
    </div>
</div>

</div>{{-- end x-data --}}

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

function BuyDevices() {
    return {
        devices    : [],
        payments   : [],
        customerId : null,
        totalBuy   : 0,
        totalSell  : 0,
        submitting : false,
        globalErr  : '',
        _uid       : 0,

        // Payment modal state
        pm: { method:'cash', amount:'', note:'', change:0, split1method:'cash', split1amount:'', split2method:'card', split2amount:'', showSplit:false },

        payMethods: [
            { value:'cash',  label:'Cash',  icon:'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z' },
            { value:'card',  label:'Card',  icon:'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z' },
            { value:'split', label:'Split', icon:'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4' },
            { value:'trade', label:'Trade', icon:'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
        ],

        // ── Mode & sell ───────────────────────────────────────
        mode           : 'buy',
        sellDeviceId   : '',
        stockFilter    : '',
        sellInfo       : { name:'', meta:'', cost:'' },

        // ── Init ─────────────────────────────────────────────
        init() {
            this.addDevice();
            document.addEventListener('customer-selected', e => this.customerId = e.detail.id);
            document.addEventListener('customer-cleared',  () => this.customerId = null);
            document.addEventListener('keydown', e => { if(e.key==='Escape') this.closePayModal(); });
        },

        resetDevices() {
            this.devices  = [];
            this.addDevice();
            this.sellDeviceId = '';
            this.sellInfo     = { name:'', meta:'', cost:'' };
            this.payments     = [];
            this.calcTotals();
        },

        loadSellDevice() {
            if (!this.sellDeviceId) return;
            const opt = document.querySelector('#sell-device-select option[value="' + this.sellDeviceId + '"]');
            if (!opt) return;
            try {
                const d   = JSON.parse(opt.dataset.device);
                const dev = this.devices[0] || this._blank();
                if (!this.devices.length) this.devices.push(dev);
                dev.model_name     = d.model_name || '';
                dev.brand_name     = d.brand || '';
                dev.device_grade   = d.grade || '';
                dev.imei           = d.imei  || '';
                dev.storage        = d.storage || '';
                dev.color          = d.color   || '';
                dev.purchase_price = d.selling_price || d.purchase_price || '';
                dev.selling_price  = '';
                this.sellInfo = {
                    name : d.model_name + (d.brand ? ' — ' + d.brand : ''),
                    meta : [d.grade, d.storage, d.color].filter(Boolean).join(' · '),
                    cost : '£' + parseFloat(d.purchase_price).toFixed(2),
                };
                this.calcTotals();
            } catch(e) { console.error(e); }
        },

        filterStock() {},

        pickInventory(dev, selectEl) {
            const opt = selectEl.options[selectEl.selectedIndex];
            if (!opt || !opt.dataset.device) return;
            try {
                const d = JSON.parse(opt.getAttribute('data-device'));
                dev.model_name     = d.model_name || '';
                dev.brand_name     = d.brand      || '';
                dev.imei           = d.imei        || '';
                dev.storage        = d.storage     || '';
                dev.color          = d.color       || '';
                dev.purchase_price = d.selling_price || d.purchase_price || '';
                dev._inv_id        = d.id;
                this.calcTotals();
            } catch(e) { console.error(e); }
        },

        // ── Payment helpers ───────────────────────────────────
        totalPaid()    { return this.payments.reduce((s,p) => s+p.amount, 0); },
        outstanding()  { return Math.max(0, this.totalBuy - this.totalPaid()); },

        methodIcon(m) {
            return {cash:'💵',card:'💳',split:'🔀',trade:'🔄',other:'💰'}[m]||'💳';
        },

        openPayModal() {
            this.pm = { method:'cash', amount:'', note:'', change:0,
                        split1method:'cash', split1amount:'', split2method:'card',
                        split2amount: this.outstanding().toFixed(2), showSplit:false };
            const modal = document.getElementById('pay-modal');
            const box   = document.getElementById('pay-modal-box');
            modal.classList.add('open');
            requestAnimationFrame(()=>requestAnimationFrame(()=>{
                box.style.transform='scale(1)'; box.style.opacity='1';
            }));
        },

        closePayModal() {
            const box = document.getElementById('pay-modal-box');
            box.style.transform='scale(.95)'; box.style.opacity='0';
            setTimeout(()=>document.getElementById('pay-modal').classList.remove('open'), 180);
        },

        calcChange() {
            const tendered = parseFloat(this.pm.amount) || 0;
            const owed     = this.outstanding();
            this.pm.change = Math.max(0, tendered - owed);
        },

        updateSplit2() {
            const a1      = parseFloat(this.pm.split1amount) || 0;
            const owed    = this.outstanding();
            this.pm.split2amount = Math.max(0, owed - a1).toFixed(2);
        },

        addPayment() {
            const method = this.pm.method;
            const note   = this.pm.note || null;

            if (method === 'split') {
                const a1 = parseFloat(this.pm.split1amount) || 0;
                const a2 = parseFloat(this.pm.split2amount) || 0;
                if (a1 <= 0 && a2 <= 0) { this._toast('Enter payment amounts', 'error'); return; }
                if (a1 > 0) this.payments.push({ method:'split', amount:a1, label:this._cap(this.pm.split1method)+' (split)', note });
                if (a2 > 0) this.payments.push({ method:'split', amount:a2, label:this._cap(this.pm.split2method)+' (split)', note:null });

            } else if (method === 'card') {
                const owed = this.outstanding();
                if (owed <= 0) { this._toast('No outstanding balance', 'error'); return; }
                this.payments.push({ method:'card', amount:owed, label:'Card', note });

            } else {
                const amount = parseFloat(this.pm.amount) || 0;
                if (amount <= 0) { this._toast('Enter an amount', 'error'); return; }
                const capped = Math.min(amount, this.outstanding());
                this.payments.push({ method, amount:capped, label:this._cap(method), note });
            }

            if (this.outstanding() <= 0) {
                this.closePayModal();
                this._toast('Payment complete!', 'success');
            } else {
                this.pm.amount = '';
                this.pm.note   = '';
                this.pm.change = 0;
                this._toast('Payment added — £'+this.outstanding().toFixed(2)+' remaining', 'success');
            }
        },

        removePayment(i) { this.payments.splice(i, 1); },

        _cap(s) { return s.charAt(0).toUpperCase()+s.slice(1); },

        // ── Device management ─────────────────────────────────
        _blank() {
            return {
                id:'d'+(++this._uid),
                device_type:'', model_name:'', brand_name:'', warranty:'',
                condition:'', device_status:'available',
                imei:'', serial_number:'', storage:'', color:'',
                purchase_price:'', selling_price:'', notes:'',
                err_model:'', err_condition:'', err_imei:'', err_price:'',
                hasError:false,
                acResults:[], acLoading:false, acOpen:false, acHi:-1, _acTimer:null,
            };
        },

        addDevice()  { this.devices.push(this._blank()); },
        remove(i)    { this.devices.splice(i,1); this.calcTotals(); },

        duplicate(i) {
            const s = this.devices[i];
            const c = this._blank();
            Object.assign(c, { device_type:s.device_type, model_name:s.model_name, brand_name:s.brand_name,
                condition:s.condition, device_status:s.device_status,
                storage:s.storage, color:s.color, purchase_price:s.purchase_price,
                selling_price:s.selling_price, notes:s.notes });
            this.devices.splice(i+1, 0, c);
            this.calcTotals();
        },

        // ── Autocomplete ──────────────────────────────────────
        acSearch(dev) {
            clearTimeout(dev._acTimer);
            const q = dev.model_name.trim();
            if (!q) { dev.acOpen=false; return; }
            dev.acLoading=true; dev.acOpen=true;
            dev._acTimer = setTimeout(async () => {
                try {
                    const r = await fetch(`/products/autocomplete?q=${encodeURIComponent(q)}`,
                        {headers:{'X-Requested-With':'XMLHttpRequest'}});
                    dev.acResults = await r.json(); dev.acHi=-1;
                } catch(e) { dev.acResults=[]; }
                finally { dev.acLoading=false; }
            }, 300);
        },
        acDown(dev)  { dev.acHi=Math.min(dev.acHi+1,dev.acResults.length-1); },
        acUp(dev)    { dev.acHi=Math.max(dev.acHi-1,-1); },
        acEnter(dev) { dev.acHi>=0&&dev.acResults[dev.acHi]?this.acPick(dev,dev.acResults[dev.acHi]):(dev.acOpen=false); },
        acPick(dev,p) {
            dev.model_name=p.name; dev.acOpen=false; dev.acHi=-1; dev.err_model=''; dev.hasError=false;
            if (!dev.brand_name && p.brand) dev.brand_name=p.brand;
        },

        // ── Totals ────────────────────────────────────────────
        calcTotals() {
            this.totalBuy  = this.devices.reduce((s,d)=>s+(parseFloat(d.purchase_price)||0),0);
            this.totalSell = this.devices.reduce((s,d)=>s+(parseFloat(d.selling_price)||0),0);
        },

        // ── Validation ────────────────────────────────────────
        validate() {
            let ok=true; this.globalErr='';
            this.devices.forEach(d => {
                d.err_model=''; d.err_condition=''; d.err_imei=''; d.err_price=''; d.hasError=false;
                if (!d.model_name.trim()) { d.err_model='Model name is required.'; ok=false; d.hasError=true; }
                if (!d.condition)         { d.err_condition='Grade is required.';   ok=false; d.hasError=true; }
                const p=parseFloat(d.purchase_price);
                if (d.purchase_price===''||isNaN(p)||p<0) { d.err_price='Enter a valid price.'; ok=false; d.hasError=true; }
                if (d.imei&&!/^\d{15}$/.test(d.imei)) { d.err_imei='IMEI must be 15 digits.'; ok=false; d.hasError=true; }
            });
            if (!ok) this.globalErr='Please fix the errors highlighted below.';
            return ok;
        },

        // ── Submit ────────────────────────────────────────────
        async submit() {
            if (!this.validate()) return;
            this.submitting=true; this.globalErr='';
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            const body = {
                mode           : this.mode,
                sell_device_id : this.mode==='sell' ? (this.sellDeviceId||null) : null,
                customer_id    : this.customerId||null,
                payment_method : this.pm.method,
                payment_status : this.payments.length===0?'unpaid':(this.outstanding()<=0?'paid':'partial'),
                payments       : this.payments.map(p=>({method:p.method,amount:p.amount,note:p.note})),
                devices        : this.devices.map(d=>({
                    device_type   : d.device_type||null,
                    model_name    : d.model_name.trim(),
                    brand_name    : d.brand_name.trim()||null,
                    condition     : d.condition,

                    device_status : d.device_status,
                    imei          : d.imei.trim()||null,
                    serial_number : d.serial_number.trim()||null,
                    storage       : d.storage.trim()||null,
                    color         : d.color.trim()||null,
                    purchase_price: parseFloat(d.purchase_price)||0,
                    selling_price : parseFloat(d.selling_price)||null,
                    notes         : d.notes.trim()||null,
                })),
            };
            try {
                const url  = this.mode==='sell'
                    ? (this.sellDeviceId ? `{{ url('buy-sell') }}/${this.sellDeviceId}/sell` : '{{ route("buy-sell.buy") }}')
                    : '{{ route("buy-sell.buy") }}';
                const res  = await fetch(url, {
                    method:'POST',
                    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,
                             'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                    body:JSON.stringify(body),
                });
                const data = await res.json();
                if (data.success) {
                    window.location='{{ route("buy-sell.index") }}';
                } else {
                    if (data.errors) {
                        Object.entries(data.errors).forEach(([k,v])=>{
                            const m=k.match(/^devices\.(\d+)\.(.+)$/);
                            if (m&&this.devices[+m[1]]) {
                                const map={model_name:'err_model',condition:'err_condition',
                                           imei:'err_imei',purchase_price:'err_price'};
                                if (map[m[2]]) { this.devices[+m[1]][map[m[2]]]=Array.isArray(v)?v[0]:v; this.devices[+m[1]].hasError=true; }
                            }
                        });
                        this.globalErr='Please fix the errors highlighted below.';
                    } else { this.globalErr=data.message||'Failed to save.'; }
                }
            } catch(e) { this.globalErr='Network error. Please try again.'; }
            finally { this.submitting=false; }
        },

        _toast(msg, type='success') {
            const el=document.createElement('div');
            el.style.cssText=`position:fixed;bottom:24px;right:24px;z-index:9999;padding:10px 18px;
                border-radius:12px;color:#fff;font-size:.85rem;font-weight:700;
                background:${type==='success'?'#10b981':'#ef4444'};transform:translateY(10px);
                opacity:0;transition:all .25s ease;box-shadow:0 8px 24px rgba(0,0,0,.15);`;
            el.textContent=msg; document.body.appendChild(el);
            requestAnimationFrame(()=>requestAnimationFrame(()=>{el.style.transform='translateY(0)';el.style.opacity='1';}));
            setTimeout(()=>{el.style.opacity='0';el.style.transform='translateY(10px)';setTimeout(()=>el.remove(),250);},3500);
        },
    };
}
</script>
@endpush
</x-app-layout>