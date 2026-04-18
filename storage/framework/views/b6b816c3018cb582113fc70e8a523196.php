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
 <?php $__env->slot('title', null, []); ?> Edit <?php echo e($shop->name); ?> <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Edit '.e($shop->name).'','subtitle' => 'Update shop details','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops',     'route' => 'shops.index'],
        ['label' => $shop->name, 'route' => 'shops.show', 'params' => $shop],
        ['label' => 'Edit'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit '.e($shop->name).'','subtitle' => 'Update shop details','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops',     'route' => 'shops.index'],
        ['label' => $shop->name, 'route' => 'shops.show', 'params' => $shop],
        ['label' => 'Edit'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('shops.show', $shop)); ?>"
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

<form method="POST" action="<?php echo e(route('shops.update', $shop)); ?>">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2 space-y-5">

        <?php if (isset($component)) { $__componentOriginalb95fb6157a10b6449458ef38a3dd045c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb95fb6157a10b6449458ef38a3dd045c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Shop Details','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Shop Details','color' => 'indigo']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Shop Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="<?php echo e(old('name', $shop->name)); ?>" required
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                  text-sm outline-none bg-gray-50 dark:bg-gray-800
                                  text-gray-900 dark:text-white
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                  focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Phone</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $shop->phone)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email', $shop->email)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Address</label>
                    <input type="text" name="address" value="<?php echo e(old('address', $shop->address)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">City</label>
                    <input type="text" name="city" value="<?php echo e(old('city', $shop->city)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Country</label>
                    <input type="text" name="country" value="<?php echo e(old('country', $shop->country)); ?>"
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-section','data' => ['title' => 'Currency & Timezone','color' => 'emerald']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Currency & Timezone','color' => 'emerald']); ?>
             <?php $__env->slot('icon', null, []); ?> 
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
             <?php $__env->endSlot(); ?>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Currency Code</label>
                    <input type="text" name="currency" value="<?php echo e(old('currency', $shop->currency)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Symbol</label>
                    <input type="text" name="currency_symbol" value="<?php echo e(old('currency_symbol', $shop->currency_symbol)); ?>"
                           class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Timezone</label>
                    <select name="timezone"
                            class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white cursor-pointer focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all">
                        <?php $__currentLoopData = ['Europe/London','Europe/Paris','America/New_York','America/Chicago','America/Los_Angeles','Asia/Dubai','Asia/Karachi','Asia/Kolkata','Australia/Sydney']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($tz); ?>" <?php echo e(old('timezone', $shop->timezone ?? 'Europe/London') === $tz ? 'selected' : ''); ?>><?php echo e($tz); ?></option>
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
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-5 space-y-4">
            <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Status</h3>
            <label class="flex items-center gap-3 cursor-pointer">
                <div class="relative">
                    <input type="checkbox" name="is_active" value="1"
                           <?php echo e(old('is_active', $shop->is_active) ? 'checked' : ''); ?>

                           class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer
                                peer-checked:bg-indigo-600 transition-colors
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:rounded-full after:h-5 after:w-5
                                after:transition-all peer-checked:after:translate-x-5"></div>
                </div>
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active</span>
            </label>
        </div>

        <button type="submit"
                class="w-full py-3 rounded-xl text-sm font-bold
                       bg-indigo-600 hover:bg-indigo-700 active:scale-95
                       text-white transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save Changes
        </button>
        <a href="<?php echo e(route('shops.show', $shop)); ?>"
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/shops/edit.blade.php ENDPATH**/ ?>