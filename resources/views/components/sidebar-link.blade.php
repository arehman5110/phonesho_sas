@props([
    'href'   => '#',
    'active' => false,
    'icon'   => '',
])

<a href="{{ $href }}"
   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm
          font-medium transition-all duration-150 group
          {{ $active
            ? 'bg-blue-600 text-white'
            : 'text-gray-600 dark:text-gray-400
               hover:bg-gray-100 dark:hover:bg-gray-800
               hover:text-gray-900 dark:hover:text-white' }}">

    {{-- Dot indicator --}}
    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0
                 {{ $active
                   ? 'bg-white'
                   : 'bg-gray-300 dark:bg-gray-600
                      group-hover:bg-blue-500' }}">
    </span>

    <span>{{ $slot }}</span>

</a>