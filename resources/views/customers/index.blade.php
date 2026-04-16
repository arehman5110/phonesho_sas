<x-app-layout>
<x-slot name="title">Customers</x-slot>

<x-page-header
    title="Customers"
    subtitle="Browse all customers and view their repairs and POS sales"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Customers'],
    ]" />

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-4 mb-4">
    <form method="GET" action="{{ route('customers.index') }}" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-64">
            <label for="search" class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Search</label>
            <input id="search" name="search" value="{{ $search }}" type="text"
                   placeholder="Name, phone, or email..."
                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm
                          bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none transition-all">
        </div>
        <button type="submit"
                class="px-4 py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700 text-white transition-all">
            Search
        </button>
    </form>
</div>

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800/80 text-gray-600 dark:text-gray-300 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">Customer</th>
                    <th class="px-4 py-3 text-left">Contact</th>
                    <th class="px-4 py-3 text-center">Repairs</th>
                    <th class="px-4 py-3 text-center">POS Sales</th>
                    <th class="px-4 py-3 text-right">Total Value</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($customers as $customer)
                @php
                    $repairValue = (float) ($customer->repairs_sum_final_price ?? 0);
                    $salesValue = (float) ($customer->sales_sum_final_amount ?? 0);
                @endphp
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $customer->name }}</p>
                        @if($customer->address)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $customer->address }}</p>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                        <div>{{ $customer->phone ?: '—' }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $customer->email ?: '—' }}</div>
                    </td>
                    <td class="px-4 py-3 text-center font-semibold text-gray-800 dark:text-gray-200">{{ $customer->repairs_count }}</td>
                    <td class="px-4 py-3 text-center font-semibold text-gray-800 dark:text-gray-200">{{ $customer->sales_count }}</td>
                    <td class="px-4 py-3 text-right font-bold text-gray-900 dark:text-white">£{{ number_format($repairValue + $salesValue, 2) }}</td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('customers.show', $customer) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold
                                  bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300
                                  hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No customers found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
        {{ $customers->links() }}
    </div>
    @endif
</div>
</x-app-layout>