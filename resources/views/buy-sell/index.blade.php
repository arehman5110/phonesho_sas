<x-app-layout>
<x-slot name="title">Buy & Sell</x-slot>

@push('styles')
<style>
    .stat-card.active{border-color:#6366f1!important;box-shadow:0 0 0 2px rgba(99,102,241,.2);}
    #device-table-wrap{position:relative;transition:opacity .15s;}
    #device-table-wrap.loading{opacity:.4;pointer-events:none;}
    #dt-bar{display:none;position:absolute;top:0;left:0;right:0;height:3px;
        background:linear-gradient(90deg,#6366f1 0%,#a5b4fc 50%,#6366f1 100%);
        background-size:200% 100%;animation:dtSlide 1s linear infinite;z-index:10;}
    @keyframes dtSlide{0%{background-position:200% 0}100%{background-position:-200% 0}}
    .loading #dt-bar{display:block;}
</style>
@endpush

<x-page-header
    title="Buy & Sell"
    subtitle="Manage device purchases and sales"
    :breadcrumbs="[['label'=>'Dashboard','route'=>'dashboard'],['label'=>'Buy & Sell']]">
    <x-slot name="actions">
        <a href="{{ route('buy-sell.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buy Device
        </a>
    </x-slot>
</x-page-header>

@if(session('success'))
<div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

{{-- ── Stats Cards ──────────────────────────── --}}
@php $sf = request('status',''); @endphp
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">

    <a href="{{ route('buy-sell.index', array_merge(request()->except(['status','page']),[])) }}"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all {{ $sf==='' ? 'active':'' }}">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total</p>
        <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">all devices</p>
    </a>

    <a href="{{ route('buy-sell.index', array_merge(request()->except(['status','page']),['status'=>'in_stock'])) }}"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-emerald-400 hover:shadow-md transition-all {{ $sf==='in_stock' ? 'active':'' }}">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">In Stock</p>
        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['in_stock'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">available</p>
    </a>

    <a href="{{ route('buy-sell.index', array_merge(request()->except(['status','page']),['status'=>'sold'])) }}"
       onclick="showTableLoading()"
       class="stat-card bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
              rounded-2xl p-4 hover:border-indigo-400 hover:shadow-md transition-all {{ $sf==='sold' ? 'active':'' }}">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Sold</p>
        <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ $stats['sold'] }}</p>
        <p class="text-xs text-gray-400 mt-0.5">completed</p>
    </a>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stock Value</p>
        <p class="text-2xl font-black text-amber-600 dark:text-amber-400">£{{ number_format($stats['total_value'],2) }}</p>
        <p class="text-xs text-gray-400 mt-0.5">purchase cost</p>
    </div>
</div>

{{-- ── Filters ──────────────────────────────── --}}
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 mb-4">
    <div class="flex flex-wrap gap-3 items-center">
        <div class="relative flex-1 min-w-48">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" id="filter-search" value="{{ request('search') }}"
                   placeholder="Search model, IMEI, serial..."
                   class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                          text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                          placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900 transition-all">
        </div>
        <select id="filter-status"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       cursor-pointer focus:border-indigo-500 transition-all">
            <option value="">All Status</option>
            <option value="in_stock"     {{ request('status')==='in_stock'     ? 'selected':'' }}>✅ In Stock</option>
            <option value="sold"         {{ request('status')==='sold'         ? 'selected':'' }}>💰 Sold</option>
            <option value="reserved"     {{ request('status')==='reserved'     ? 'selected':'' }}>🔒 Reserved</option>
            <option value="under_repair" {{ request('status')==='under_repair' ? 'selected':'' }}>🔧 Under Repair</option>
        </select>
        <select id="filter-condition"
                class="px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                       outline-none bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300
                       cursor-pointer focus:border-indigo-500 transition-all">
            <option value="">All Conditions</option>
            <option value="new"         {{ request('condition')==='new'         ? 'selected':'' }}>🌟 A — New</option>
            <option value="used"        {{ request('condition')==='used'        ? 'selected':'' }}>✅ B — Good</option>
            <option value="refurbished" {{ request('condition')==='refurbished' ? 'selected':'' }}>🔧 C — Average</option>
            <option value="faulty"      {{ request('condition')==='faulty'      ? 'selected':'' }}>⚠️ D — Faulty</option>
        </select>
        @if(request()->hasAny(['search','status','condition']))
        <a href="{{ route('buy-sell.index') }}" onclick="showTableLoading()"
           class="px-3 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                  text-gray-500 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all">
            Clear ✕
        </a>
        @endif
    </div>
</div>

{{-- ── Table ────────────────────────────────── --}}
<div id="device-table-wrap"
     class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden"
     style="position:relative;">
    <div id="dt-bar"></div>
    <div id="device-list-body">
        @include('buy-sell.partials.device-list', compact('devices'))
    </div>
</div>

@push('scripts')
<script>
function showTableLoading() {
    document.getElementById('device-table-wrap')?.classList.add('loading');
}

// Auto-filter on change
(function() {
    const base = '{{ route("buy-sell.index") }}';
    let st;

    function go() {
        showTableLoading();
        const p = new URLSearchParams();
        const s = document.getElementById('filter-search')?.value;
        const st= document.getElementById('filter-status')?.value;
        const c = document.getElementById('filter-condition')?.value;
        if(s)  p.set('search',s);
        if(st) p.set('status',st);
        if(c)  p.set('condition',c);
        window.location = base + (p.toString() ? '?'+p : '');
    }

    document.getElementById('filter-search')?.addEventListener('input', ()=>{ clearTimeout(st); st=setTimeout(go,350); });
    document.getElementById('filter-status')?.addEventListener('change', go);
    document.getElementById('filter-condition')?.addEventListener('change', go);
    window.addEventListener('pageshow', ()=>document.getElementById('device-table-wrap')?.classList.remove('loading'));
})();
</script>
@endpush
</x-app-layout>