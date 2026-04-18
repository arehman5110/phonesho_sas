<x-app-layout>
<x-slot name="title">Shops</x-slot>

<x-page-header
    title="Shops"
    subtitle="Manage all shops in the system"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('shops.create') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>
            Add Shop
        </a>
    </x-slot>
</x-page-header>

@if(session('success'))
<div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition
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

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">

    {{-- Stats bar --}}
    <div class="grid grid-cols-3 divide-x divide-gray-100 dark:divide-gray-800
                border-b border-gray-200 dark:border-gray-700">
        @php
            $totalShops  = $shops->total();
            $activeShops = \App\Models\Shop::where('is_active', true)->count();
        @endphp
        <div class="px-5 py-4 text-center">
            <p class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalShops }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Total</p>
        </div>
        <div class="px-5 py-4 text-center">
            <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $activeShops }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Active</p>
        </div>
        <div class="px-5 py-4 text-center">
            <p class="text-2xl font-black text-red-500">{{ $totalShops - $activeShops }}</p>
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-0.5">Inactive</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800 text-left">
                    <th class="px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Shop
                    </th>
                    <th class="px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">
                        Contact
                    </th>
                    <th class="px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">
                        Users
                    </th>
                    <th class="px-5 py-3 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($shops as $shop)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group">

                    {{-- Shop name + city --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center
                                        flex-shrink-0 font-black text-sm text-white
                                        bg-gradient-to-br from-indigo-500 to-indigo-600">
                                {{ strtoupper(substr($shop->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $shop->name }}
                                </p>
                                @if($shop->city)
                                <p class="text-xs text-gray-400">{{ $shop->city }}</p>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Contact --}}
                    <td class="px-5 py-4 hidden sm:table-cell">
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $shop->phone ?: '—' }}
                        </p>
                        @if($shop->email)
                        <p class="text-xs text-gray-400">{{ $shop->email }}</p>
                        @endif
                    </td>

                    {{-- Users count --}}
                    <td class="px-5 py-4 hidden md:table-cell">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full
                                     text-xs font-bold bg-indigo-50 dark:bg-indigo-900/30
                                     text-indigo-700 dark:text-indigo-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $shop->users_count }} {{ Str::plural('user', $shop->users_count) }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-4">
                        @if($shop->is_active)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30
                                     text-emerald-700 dark:text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            Active
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full
                                     text-xs font-bold bg-red-100 dark:bg-red-900/30
                                     text-red-700 dark:text-red-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            Inactive
                        </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('shops.show', $shop) }}"
                               title="View"
                               class="w-7 h-7 rounded-lg flex items-center justify-center
                                      bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400
                                      hover:bg-indigo-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('shops.edit', $shop) }}"
                               title="Edit"
                               class="w-7 h-7 rounded-lg flex items-center justify-center
                                      bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400
                                      hover:bg-amber-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('shops.destroy', $shop) }}"
                                  onsubmit="return confirm('Delete {{ $shop->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Delete"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center
                                               bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400
                                               hover:bg-red-100 transition-colors border-none cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No shops yet</p>
                        <a href="{{ route('shops.create') }}"
                           class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold
                                  text-indigo-600 dark:text-indigo-400 hover:underline">
                            Add your first shop →
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($shops->hasPages())
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $shops->links() }}
    </div>
    @endif

</div>
</x-app-layout>