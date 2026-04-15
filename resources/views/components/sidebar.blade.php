{{-- ---------------------------------------- --}}
{{-- Logo                                     --}}
{{-- ---------------------------------------- --}}
<div class="flex items-center gap-3 px-5 py-5
            border-b border-gray-200 dark:border-gray-700">
    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center
                justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                     00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
    </div>
    <div class="overflow-hidden">
        <div class="font-bold text-sm truncate
                    text-gray-900 dark:text-white">
            {{ config('app.name', 'PhoneShop') }}
        </div>
        <div class="text-xs truncate
                    text-gray-500 dark:text-gray-400">
            {{ $activeShop->name ?? 'No Shop Selected' }}
        </div>
    </div>
</div>

{{-- ---------------------------------------- --}}
{{-- Navigation                               --}}
{{-- ---------------------------------------- --}}
<nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

    <x-sidebar-link
        href="{{ route('dashboard') }}"
        :active="request()->routeIs('dashboard')"
        icon="home">
        Dashboard
    </x-sidebar-link>

    {{-- Sales --}}
    <x-sidebar-group label="Sales" />

    @can('view sales')
    <x-sidebar-link
        href="{{ route('sales.index') }}"
        :active="request()->routeIs('sales.*')"
        icon="shopping-cart">
        Point of Sale
    </x-sidebar-link>
    @endcan

    @can('view repairs')
    <x-sidebar-link
        href="{{ route('repairs.index') }}"
        :active="request()->routeIs('repairs.*')"
        icon="wrench-screwdriver">
        Repairs
    </x-sidebar-link>
    @endcan

    @can('view buy_sell')
    <x-sidebar-link
        href="{{ route('buy-sell.index') }}"
        :active="request()->routeIs('buy-sell.*')"
        icon="arrows-right-left">
        Buy & Sell
    </x-sidebar-link>
    @endcan

    {{-- Inventory --}}
    <x-sidebar-group label="Inventory" />

    @can('view products')
    <x-sidebar-link
        href="{{ route('products.index') }}"
        :active="request()->routeIs('products.*')"
        icon="cube">
        Products
    </x-sidebar-link>
    @endcan

    @can('view customers')
    <x-sidebar-link
        href="{{ route('customers.index') }}"
        :active="request()->routeIs('customers.*')"
        icon="users">
        Customers
    </x-sidebar-link>
    @endcan

    @can('view vouchers')
    <x-sidebar-link
        href="{{ route('vouchers.index') }}"
        :active="request()->routeIs('vouchers.*')"
        icon="ticket">
        Vouchers
    </x-sidebar-link>
    @endcan

    {{-- Admin --}}
    @canany(['view reports','view settings','view shops','view users'])
    <x-sidebar-group label="Admin" />
    @endcanany

    @can('view reports')
    <x-sidebar-link
        href="{{ route('reports.index') }}"
        :active="request()->routeIs('reports.*')"
        icon="chart-bar">
        Reports
    </x-sidebar-link>
    @endcan

    @can('view shops')
    <x-sidebar-link
        href="{{ route('shops.index') }}"
        :active="request()->routeIs('shops.*')"
        icon="building-storefront">
        Shops
    </x-sidebar-link>
    @endcan

    @can('view users')
    <x-sidebar-link
        href="{{ route('users.index') }}"
        :active="request()->routeIs('users.*')"
        icon="user-group">
        Users
    </x-sidebar-link>
    @endcan

    @can('view settings')
    <x-sidebar-link
        href="{{ route('settings.index') }}"
        :active="request()->routeIs('settings.*')"
        icon="cog-6-tooth">
        Settings
    </x-sidebar-link>
    @endcan

</nav>

{{-- ---------------------------------------- --}}
{{-- Bottom User Info                         --}}
{{-- ---------------------------------------- --}}
<div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
    <div class="flex items-center gap-3">

        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center
                    justify-center flex-shrink-0 text-white text-sm font-bold">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <div class="flex-1 overflow-hidden">
            <div class="text-sm font-medium truncate
                        text-gray-900 dark:text-white">
                {{ auth()->user()->name }}
            </div>
            <div class="text-xs truncate capitalize
                        text-gray-500 dark:text-gray-400">
                {{ str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'No Role') }}
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    title="Logout"
                    class="transition-colors
                           text-gray-400 dark:text-gray-500
                           hover:text-red-500 dark:hover:text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3
                             3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>

    </div>
</div>