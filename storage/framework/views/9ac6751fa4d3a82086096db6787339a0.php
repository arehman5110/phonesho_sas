<header class="h-16 flex items-center justify-between px-6 flex-shrink-0
               bg-white dark:bg-gray-900
               border-b border-gray-200 dark:border-gray-800
               transition-colors duration-200">

    
    <div class="flex items-center gap-4">

        
        <button onclick="toggleSidebar()"
                class="p-2 rounded-lg transition-colors
                       text-gray-500 dark:text-gray-400
                       hover:bg-gray-100 dark:hover:bg-gray-800"
                title="Toggle Sidebar">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        
        <?php if(isset($activeShop)): ?>
        <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg
                    bg-blue-50 dark:bg-blue-900/30
                    text-blue-700 dark:text-blue-300 text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2
                         0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5
                         10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <?php echo e($activeShop->name ?? 'No Shop'); ?>

        </div>
        <?php endif; ?>

    </div>

    
    <div class="flex items-center gap-1">

        
        <?php if(isset($userShops) && $userShops->count() > 1): ?>
        <a href="<?php echo e(route('shop.select')); ?>"
           title="Switch Shop"
           class="p-2 rounded-lg transition-colors
                  text-gray-500 dark:text-gray-400
                  hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
            </svg>
        </a>
        <?php endif; ?>

        
        <button onclick="toggleDarkMode()"
                title="Toggle Dark Mode"
                id="darkModeBtn"
                class="p-2 rounded-lg transition-colors
                       text-gray-500 dark:text-gray-400
                       hover:bg-gray-100 dark:hover:bg-gray-800">

            
            <svg id="iconMoon" class="w-5 h-5" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20.354 15.354A9 9 0 018.646 3.646 9.003
                         9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
            </svg>

            
            <svg id="iconSun" class="w-5 h-5 hidden" fill="none"
                 stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343
                         17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707
                         M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>

        </button>

        
        <button class="relative p-2 rounded-lg transition-colors
                       text-gray-500 dark:text-gray-400
                       hover:bg-gray-100 dark:hover:bg-gray-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                         6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
                         6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3
                         0 11-6 0v-1m6 0H9"/>
            </svg>
            <span class="absolute top-1.5 right-1.5 w-2 h-2
                         bg-red-500 rounded-full"></span>
        </button>

        
        <div class="relative ml-1" x-data="{ open: false }">

            <button @click="open = !open"
                    class="flex items-center gap-2 px-2 py-1.5 rounded-lg
                           transition-colors
                           hover:bg-gray-100 dark:hover:bg-gray-800">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center
                            justify-center text-white text-sm font-bold flex-shrink-0">
                    <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                </div>
                <span class="hidden md:block text-sm font-medium
                             text-gray-700 dark:text-gray-300">
                    <?php echo e(auth()->user()->name); ?>

                </span>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200"
                     :class="open ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 rounded-xl shadow-lg z-50
                        bg-white dark:bg-gray-800
                        border border-gray-200 dark:border-gray-700"
                 style="display:none;">

                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                        <?php echo e(auth()->user()->name); ?>

                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                        <?php echo e(auth()->user()->email); ?>

                    </p>
                    <span class="inline-block mt-1.5 text-xs px-2 py-0.5 rounded-full
                                 bg-blue-100 dark:bg-blue-900/50
                                 text-blue-700 dark:text-blue-300 capitalize">
                        <?php echo e(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'No Role')); ?>

                    </span>
                </div>

                <div class="py-1">
                    <a href="<?php echo e(route('profile.edit')); ?>"
                       class="flex items-center gap-3 px-4 py-2 text-sm
                              text-gray-700 dark:text-gray-300
                              hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0
                                  018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        My Profile
                    </a>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 py-1">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-4 py-2
                                       text-sm text-red-600 dark:text-red-400
                                       hover:bg-red-50 dark:hover:bg-red-900/20
                                       transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M17 16l4-4m0 0l-4-4m4
                                      4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7
                                      a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</header><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/navbar.blade.php ENDPATH**/ ?>