<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
 <?php $__env->slot('title', null, []); ?> Add User <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Add New User','subtitle' => 'Create a new user account','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Users',     'route' => 'users.index'],
        ['label' => 'Add User'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Add New User','subtitle' => 'Create a new user account','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Users',     'route' => 'users.index'],
        ['label' => 'Add User'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('users.index')); ?>"
           class="px-4 py-2.5 rounded-xl text-sm font-semibold
                  border border-gray-200 dark:border-gray-700
                  text-gray-600 dark:text-gray-400
                  hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
            ← Back
        </a>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="flex items-start gap-3 px-4 py-3 rounded-xl mb-5
            bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <ul class="text-sm text-red-700 dark:text-red-400 space-y-0.5">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('users.store')); ?>">
<?php echo csrf_field(); ?>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="lg:col-span-2 space-y-5">

        <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Account Details','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Account Details','color' => 'indigo']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                           placeholder="John Smith"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                           placeholder="john@example.com"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" required
                           placeholder="Min. 8 characters"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                           placeholder="Repeat password"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $attributes = $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $component = $__componentOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Role & Shops','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Role & Shops','color' => 'purple']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" required
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        <option value="staff"       <?php echo e(old('role') === 'staff'       ? 'selected' : ''); ?>>Staff</option>
                        <option value="shop_admin"  <?php echo e(old('role') === 'shop_admin'  ? 'selected' : ''); ?>>Shop Admin</option>
                        <option value="super_admin" <?php echo e(old('role') === 'super_admin' ? 'selected' : ''); ?>>Super Admin</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Assign to Shop
                    </label>
                    <select name="shop_id"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        <option value="">No shop (assign later)</option>
                        <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($shop->id); ?>" <?php echo e(old('shop_id') == $shop->id ? 'selected' : ''); ?>>
                            <?php echo e($shop->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $attributes = $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__attributesOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c)): ?>
<?php $component = $__componentOriginalb95fb6157a10b6449458ef38a3dd045c; ?>
<?php unset($__componentOriginalb95fb6157a10b6449458ef38a3dd045c); ?>
<?php endif; ?>

    </div>

    <div class="space-y-4">
        <button type="submit"
                class="w-full py-3 rounded-xl text-sm font-bold
                       bg-indigo-600 hover:bg-indigo-700 active:scale-95
                       text-white transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Create User
        </button>
        <a href="<?php echo e(route('users.index')); ?>"
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/users/edit.blade.php ENDPATH**/ ?>