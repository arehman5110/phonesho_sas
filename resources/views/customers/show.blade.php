<x-app-layout>
<x-slot name="title">Customer Details</x-slot>

<x-page-header
    :title="$customer->name"
    subtitle="Customer history including repairs and POS sales"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Customers', 'route' => 'customers.index'],
        ['label' => $customer->name],
    ]">
    <x-slot name="actions">
        <a href="{{ route('customers.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                  text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            Back to Customers
        </a>
    </x-slot>
</x-page-header>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4 mb-5">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Total Repairs</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $summary['total_repairs'] }}</p>
    </div>
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Repair Value</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">£{{ number_format($summary['total_repair_value'], 2) }}</p>
    </div>
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Total POS Sales</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $summary['total_sales'] }}</p>
    </div>
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-4">
        <p class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">POS Sales Value</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">£{{ number_format($summary['total_sales_value'], 2) }}</p>
    </div>
    <div class="rounded-2xl border border-indigo-200 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 p-4">
        <p class="text-xs uppercase tracking-wider text-indigo-600 dark:text-indigo-300">Total Value</p>
        <p class="text-2xl font-bold text-indigo-700 dark:text-indigo-200 mt-1">£{{ number_format($summary['total_spent'], 2) }}</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-semibold text-gray-900 dark:text-white">Recent Repairs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/80 text-xs uppercase tracking-wider text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Reference</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($customer->repairs as $repair)
                    <tr>
                        <td class="px-4 py-3">
                            <a href="{{ route('repairs.show', $repair) }}" class="font-semibold text-indigo-600 dark:text-indigo-300 hover:underline">
                                {{ $repair->reference }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $repair->status?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">£{{ number_format((float) $repair->final_price, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-500 dark:text-gray-400">{{ $repair->created_at?->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No repairs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
            <h3 class="font-semibold text-gray-900 dark:text-white">Recent POS Sales</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800/80 text-xs uppercase tracking-wider text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Reference</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-right">Amount</th>
                        <th class="px-4 py-3 text-right">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($customer->sales as $sale)
                    <tr>
                        <td class="px-4 py-3">
                            <a href="{{ route('sales.receipt', $sale) }}" class="font-semibold text-indigo-600 dark:text-indigo-300 hover:underline">
                                {{ $sale->reference }}
                            </a>
                        </td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ ucfirst($sale->payment_status) }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">£{{ number_format((float) $sale->final_amount, 2) }}</td>
                        <td class="px-4 py-3 text-right text-gray-500 dark:text-gray-400">{{ $sale->created_at?->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No sales found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>