<x-app-layout>
<x-slot name="title">Products</x-slot>

<x-page-header
    title="Products"
    subtitle="Create new or edit existing products"
    :breadcrumbs="[
        ['label' => 'Dashboard',  'route' => 'dashboard'],
        ['label' => 'Products',   'route' => 'products.index'],
        ['label' => 'Create'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('products.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800
                  transition-all">
            ← Back
        </a>
    </x-slot>
</x-page-header>

@include('products.partials.form', [
    'product'    => null,
    'categories' => $categories,
    'brands'     => $brands,
])

@push('scripts')
<script>
window.PRODUCT_CONFIG = {
    routes: {
        autocomplete : '{{ route("products.autocomplete") }}',
        store        : '{{ route("products.store") }}',
        update       : '/products/{id}',
    },
};
</script>
@vite('resources/js/product/index.js')
@endpush

</x-app-layout>