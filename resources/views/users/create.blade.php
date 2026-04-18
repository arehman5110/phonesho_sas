<x-app-layout>
<x-slot name="title">Add Shop</x-slot>

<x-page-header
    title="Add New Shop"
    subtitle="Fill in the details to create a new shop"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops',     'route' => 'shops.index'],
        ['label' => 'Add Shop'],
    ]">
    <x-slot name="actions">
        <a href="{{ route('shops.index') }}"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
        </a>
    </x-slot>
</x-page-header>

@if($errors->any())
<div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-5
            bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <ul class="text-sm text-red-700 dark:text-red-400 space-y-0.5">
        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('shops.store') }}">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="lg:col-span-2 space-y-5">

        {{-- Basic Info --}}
        <x-form-section title="Shop Details" color="indigo">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </x-slot>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Shop Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Phone Fix Manchester"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Phone
                    </label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="+44 161 000 0000"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           placeholder="shop@example.com"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Address
                    </label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           placeholder="123 High Street"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        City
                    </label>
                    <input type="text" name="city" value="{{ old('city') }}"
                           placeholder="Manchester"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Country
                    </label>
                    <input type="text" name="country" value="{{ old('country', 'United Kingdom') }}"
                           placeholder="United Kingdom"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
            </div>
        </x-form-section>

        {{-- Currency --}}
        <x-form-section title="Currency & Timezone" color="emerald">
            <x-slot name="icon">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </x-slot>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Currency Code
                    </label>
                    <input type="text" name="currency" value="{{ old('currency', 'GBP') }}"
                           placeholder="GBP"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Symbol
                    </label>
                    <input type="text" name="currency_symbol" value="{{ old('currency_symbol', '£') }}"
                           placeholder="£"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Timezone
                    </label>
                    <select name="timezone"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                   text-sm outline-none bg-gray-50 dark:bg-gray-800
                                   text-gray-900 dark:text-white cursor-pointer
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        @foreach(['Europe/London','Europe/Paris','America/New_York','America/Chicago','America/Los_Angeles','Asia/Dubai','Asia/Karachi','Asia/Kolkata','Australia/Sydney'] as $tz)
                        <option value="{{ $tz }}" {{ old('timezone','Europe/London') === $tz ? 'selected' : '' }}>
                            {{ $tz }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-form-section>

    </div>

    {{-- Right: Status + Save --}}
    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Status</h3>
            <input type="hidden" name="is_active" id="is_active_val"
                   value="{{ old('is_active', '1') ? '1' : '0' }}">
            <div class="flex items-center gap-3 cursor-pointer select-none"
                 onclick="toggleActive(this)">
                <div id="toggle-track"
                     class="relative w-11 h-6 flex-shrink-0 rounded-full transition-colors duration-200
                            {{ old('is_active', '1') ? 'bg-indigo-600' : 'bg-gray-300 dark:bg-gray-600' }}">
                    <span id="toggle-knob"
                          class="absolute top-[2px] left-[2px] w-5 h-5 bg-white rounded-full
                                 shadow-md transition-transform duration-200 block
                                 {{ old('is_active', '1') ? 'translate-x-5' : 'translate-x-0' }}">
                    </span>
                </div>
                <span id="toggle-label"
                      class="text-sm font-semibold transition-colors duration-200
                             {{ old('is_active', '1') ? 'text-indigo-600 dark:text-indigo-400'
                                                 : 'text-gray-400 dark:text-gray-500' }}">
                    {{ old('is_active', '1') ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <p class="text-xs text-gray-400">Inactive shops cannot be accessed by users.</p>
        </div>

        <script>
        function toggleActive(el) {
            const hidden = document.getElementById('is_active_val');
            const track  = document.getElementById('toggle-track');
            const knob   = document.getElementById('toggle-knob');
            const label  = document.getElementById('toggle-label');
            const isOn   = hidden.value === '1';

            if (isOn) {
                hidden.value = '0';
                track.className  = track.className.replace('bg-indigo-600', 'bg-gray-300 dark:bg-gray-600');
                knob.className   = knob.className.replace('translate-x-5', 'translate-x-0');
                label.textContent = 'Inactive';
                label.className  = label.className
                    .replace('text-indigo-600 dark:text-indigo-400', 'text-gray-400 dark:text-gray-500');
            } else {
                hidden.value = '1';
                track.className  = track.className.replace('bg-gray-300 dark:bg-gray-600', 'bg-indigo-600');
                knob.className   = knob.className.replace('translate-x-0', 'translate-x-5');
                label.textContent = 'Active';
                label.className  = label.className
                    .replace('text-gray-400 dark:text-gray-500', 'text-indigo-600 dark:text-indigo-400');
            }
        }
        </script>

        <button type="submit"
                class="w-full py-3 rounded-xl text-sm font-bold
                       bg-indigo-600 hover:bg-indigo-700 active:scale-95
                       text-white transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7"/>
            </svg>
            Create Shop
        </button>
        <a href="{{ route('shops.index') }}"
           class="w-full py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all
                  flex items-center justify-center">
            Cancel
        </a>
    </div>

</div>
</form>
</x-app-layout>