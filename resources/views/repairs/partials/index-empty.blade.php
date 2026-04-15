<tr>
    <td colspan="8">
        <div class="flex flex-col items-center justify-center
                    py-16 text-gray-400 dark:text-gray-600">
            <svg class="w-16 h-16 mb-4 opacity-40" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="1.5"
                      d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0
                         002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828
                         15H9v-2.828l8.586-8.586z"/>
            </svg>
            <p class="text-sm font-semibold text-gray-500
                       dark:text-gray-400">
                No repairs found
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                Try adjusting your filters or
                <a href="{{ route('repairs.create') }}"
                   class="text-indigo-500 hover:text-indigo-700
                          font-semibold">
                    create a new repair
                </a>
            </p>
        </div>
    </td>
</tr>