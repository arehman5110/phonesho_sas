<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — {{ $title ?? 'Dashboard' }}</title>

    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased
             bg-gray-100 dark:bg-gray-950
             transition-colors duration-200">

<div class="flex h-screen overflow-hidden">

    {{-- Mobile Overlay --}}
    <div id="sidebarOverlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden">
    </div>

    {{-- Sidebar --}}
    <aside id="sidebar"
           class="w-64 flex flex-col flex-shrink-0 z-30
                  fixed inset-y-0 left-0
                  transition-transform duration-300 ease-in-out
                  bg-white dark:bg-gray-900
                  border-r border-gray-200 dark:border-gray-700">
        <x-sidebar />
    </aside>

    {{-- Spacer — pushes content right when sidebar is open on desktop --}}
    <div id="sidebarSpacer" class="flex-shrink-0 transition-all duration-300"
         style="width: 256px;">
    </div>

    {{-- Main Content --}}
    <div class="flex flex-col flex-1 overflow-hidden min-w-0">
        <x-navbar />
        <main class="flex-1 overflow-y-auto p-6">
            <x-alert />
            {{ $slot }}
        </main>
    </div>

</div>

<script>
    // ── State ─────────────────────────────────
    let sidebarOpen = true;
    const sidebar       = document.getElementById('sidebar');
    const overlay       = document.getElementById('sidebarOverlay');
    const spacer        = document.getElementById('sidebarSpacer');
    const iconMoon      = document.getElementById('iconMoon');
    const iconSun       = document.getElementById('iconSun');
    const SIDEBAR_WIDTH = 256;

    // ── Init ──────────────────────────────────
    // Read saved state — default open on desktop, closed on mobile
    const savedState = localStorage.getItem('sidebarOpen');
    if (savedState !== null) {
        sidebarOpen = savedState === 'true';
    } else {
        sidebarOpen = window.innerWidth >= 1024;
    }
    applySidebar(false); // apply without animation on load

    // ── Toggle ────────────────────────────────
    function toggleSidebar() {
        sidebarOpen = !sidebarOpen;
        localStorage.setItem('sidebarOpen', sidebarOpen);
        applySidebar(true);
    }

    function applySidebar(animate) {
        if (!animate) {
            sidebar.style.transition = 'none';
            spacer.style.transition  = 'none';
        } else {
            sidebar.style.transition = '';
            spacer.style.transition  = '';
        }

        if (sidebarOpen) {
            // Open
            sidebar.style.transform = 'translateX(0)';
            spacer.style.width      = SIDEBAR_WIDTH + 'px';

            // Show overlay only on mobile
            if (window.innerWidth < 1024) {
                overlay.classList.remove('hidden');
            }
        } else {
            // Closed
            sidebar.style.transform = 'translateX(-' + SIDEBAR_WIDTH + 'px)';
            spacer.style.width      = '0px';
            overlay.classList.add('hidden');
        }

        // Re-enable transitions after a frame
        if (!animate) {
            requestAnimationFrame(() => {
                sidebar.style.transition = '';
                spacer.style.transition  = '';
            });
        }
    }

    // ── Resize ────────────────────────────────
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            overlay.classList.add('hidden');
        }
    });

    // ── Dark Mode ─────────────────────────────
    function toggleDarkMode() {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', isDark);
        updateDarkModeIcons(isDark);
    }

    function updateDarkModeIcons(isDark) {
        if (!iconMoon || !iconSun) return;
        if (isDark) {
            iconMoon.classList.add('hidden');
            iconSun.classList.remove('hidden');
        } else {
            iconMoon.classList.remove('hidden');
            iconSun.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const isDark = localStorage.getItem('darkMode') === 'true';
        updateDarkModeIcons(isDark);
    });
</script>

@stack('scripts')
</body>
</html>