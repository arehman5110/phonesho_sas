


<div class="flex items-center gap-3 px-5 py-5
            border-b border-gray-200 dark:border-gray-700">
    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center
                justify-center flex-shrink-0">
        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0
                     00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
        </svg>
    </div>
    <div class="overflow-hidden">
        <div class="font-bold text-sm truncate
                    text-gray-900 dark:text-white">
            <?php echo e(config('app.name', 'PhoneShop')); ?>

        </div>
        <div class="text-xs truncate
                    text-gray-500 dark:text-gray-400">
            <?php echo e($activeShop->name ?? 'No Shop Selected'); ?>

        </div>
    </div>
</div>




<nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">

    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('dashboard')).'','active' => request()->routeIs('dashboard'),'icon' => 'home']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('dashboard')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('dashboard')),'icon' => 'home']); ?>
        Dashboard
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginald32807dc8f6c938009036f3d7a97d64e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald32807dc8f6c938009036f3d7a97d64e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-group','data' => ['label' => 'Sales']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Sales']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $attributes = $__attributesOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $component = $__componentOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__componentOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view sales')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('sales.index')).'','active' => request()->routeIs('sales.*'),'icon' => 'shopping-cart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('sales.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('sales.*')),'icon' => 'shopping-cart']); ?>
        Point of Sale
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view repairs')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('repairs.index')).'','active' => request()->routeIs('repairs.*'),'icon' => 'wrench-screwdriver']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('repairs.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('repairs.*')),'icon' => 'wrench-screwdriver']); ?>
        Repairs
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view buy_sell')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('buy-sell.index')).'','active' => request()->routeIs('buy-sell.*'),'icon' => 'arrows-right-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('buy-sell.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('buy-sell.*')),'icon' => 'arrows-right-left']); ?>
        Buy & Sell
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginald32807dc8f6c938009036f3d7a97d64e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald32807dc8f6c938009036f3d7a97d64e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-group','data' => ['label' => 'Inventory']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Inventory']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $attributes = $__attributesOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $component = $__componentOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__componentOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view products')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('products.index')).'','active' => request()->routeIs('products.*'),'icon' => 'cube']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('products.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('products.*')),'icon' => 'cube']); ?>
        Products
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view customers')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('customers.index')).'','active' => request()->routeIs('customers.*'),'icon' => 'users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('customers.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('customers.*')),'icon' => 'users']); ?>
        Customers
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view vouchers')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('vouchers.index')).'','active' => request()->routeIs('vouchers.*'),'icon' => 'ticket']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('vouchers.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('vouchers.*')),'icon' => 'ticket']); ?>
        Vouchers
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['view reports','view settings','view shops','view users'])): ?>
    <?php if (isset($component)) { $__componentOriginald32807dc8f6c938009036f3d7a97d64e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald32807dc8f6c938009036f3d7a97d64e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-group','data' => ['label' => 'Admin']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Admin']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $attributes = $__attributesOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__attributesOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald32807dc8f6c938009036f3d7a97d64e)): ?>
<?php $component = $__componentOriginald32807dc8f6c938009036f3d7a97d64e; ?>
<?php unset($__componentOriginald32807dc8f6c938009036f3d7a97d64e); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view reports')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('reports.index')).'','active' => request()->routeIs('reports.*'),'icon' => 'chart-bar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('reports.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('reports.*')),'icon' => 'chart-bar']); ?>
        Reports
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view shops')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('shops.index')).'','active' => request()->routeIs('shops.*'),'icon' => 'building-storefront']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('shops.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('shops.*')),'icon' => 'building-storefront']); ?>
        Shops
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view users')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('users.index')).'','active' => request()->routeIs('users.*'),'icon' => 'user-group']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('users.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('users.*')),'icon' => 'user-group']); ?>
        Users
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view settings')): ?>
    <?php if (isset($component)) { $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-link','data' => ['href' => ''.e(route('settings.index')).'','active' => request()->routeIs('settings.*'),'icon' => 'cog-6-tooth']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('settings.index')).'','active' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request()->routeIs('settings.*')),'icon' => 'cog-6-tooth']); ?>
        Settings
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $attributes = $__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__attributesOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300)): ?>
<?php $component = $__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300; ?>
<?php unset($__componentOriginal3d3185cbc95d2b4d3b41182ae7d7a300); ?>
<?php endif; ?>
    <?php endif; ?>

</nav>




<div class="border-t border-gray-200 dark:border-gray-700 px-4 py-4">
    <div class="flex items-center gap-3">

        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center
                    justify-center flex-shrink-0 text-white text-sm font-bold">
            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

        </div>

        <div class="flex-1 overflow-hidden">
            <div class="text-sm font-medium truncate
                        text-gray-900 dark:text-white">
                <?php echo e(auth()->user()->name); ?>

            </div>
            <div class="text-xs truncate capitalize
                        text-gray-500 dark:text-gray-400">
                <?php echo e(str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'No Role')); ?>

            </div>
        </div>

        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit"
                    title="Logout"
                    class="transition-colors
                           text-gray-400 dark:text-gray-500
                           hover:text-red-500 dark:hover:text-red-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3
                             3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </form>

    </div>
</div><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/components/sidebar.blade.php ENDPATH**/ ?>