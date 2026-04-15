<x-app-layout>
<x-slot name="title">Create Voucher</x-slot>

<x-page-header
    title="Create Voucher"
    subtitle="Create a new discount voucher or promo code"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Vouchers',  'route' => 'vouchers.index'],
        ['label' => 'Create'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('vouchers.index') }}"
           class="px-4 py-2 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            Cancel
        </a>
    </x-slot>
</x-page-header>

<div class="max-w-2xl">
    @include('vouchers.partials.form', [
        'voucher'       => null,
        'customers'     => $customers,
        'suggestedCode' => $suggestedCode,
        'action'        => route('vouchers.store'),
        'method'        => 'POST',
    ])
</div>

</x-app-layout>