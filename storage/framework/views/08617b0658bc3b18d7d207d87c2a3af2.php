<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?> — <?php echo e($title ?? 'Dashboard'); ?></title>

    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php echo $__env->yieldPushContent('styles'); ?>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased
             bg-gray-100 dark:bg-gray-950
             transition-colors duration-200">

<div class="flex h-screen overflow-hidden">

    
    <div id="sidebarOverlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/50 z-20 hidden lg:hidden">
    </div>

    
    <aside id="sidebar"
           class="w-64 flex flex-col flex-shrink-0 z-30
                  fixed inset-y-0 left-0
                  transition-transform duration-300 ease-in-out
                  bg-white dark:bg-gray-900
                  border-r border-gray-200 dark:border-gray-700">
        <?php if (isset($component)) { $__componentOriginal2880b66d47486b4bfeaf519598a469d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2880b66d47486b4bfeaf519598a469d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $attributes = $__attributesOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $component = $__componentOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__componentOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
    </aside>

    
    <div id="sidebarSpacer" class="flex-shrink-0 transition-all duration-300"
         style="width: 256px;">
    </div>

    
    <div class="flex flex-col flex-1 overflow-hidden min-w-0">
        <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
        <main class="flex-1 overflow-y-auto p-6">
            <?php if (isset($component)) { $__componentOriginal5194778a3a7b899dcee5619d0610f5cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $attributes = $__attributesOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__attributesOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf)): ?>
<?php $component = $__componentOriginal5194778a3a7b899dcee5619d0610f5cf; ?>
<?php unset($__componentOriginal5194778a3a7b899dcee5619d0610f5cf); ?>
<?php endif; ?>
            <?php echo e($slot); ?>

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

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/layouts/app.blade.php ENDPATH**/ ?>