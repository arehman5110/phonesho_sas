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
 <?php $__env->slot('title', null, []); ?> <?php echo e($shop->name); ?> <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => ''.e($shop->name).'','subtitle' => 'Shop Details','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops',     'route' => 'shops.index'],
        ['label' => $shop->name],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => ''.e($shop->name).'','subtitle' => 'Shop Details','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Shops',     'route' => 'shops.index'],
        ['label' => $shop->name],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('shops.edit', $shop)); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Shop
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

<?php if(session('success')): ?>
<div x-data="{show:true}" x-show="show" x-init="setTimeout(()=>show=false,4000)" x-transition
     class="flex items-center gap-3 px-4 py-3 rounded-xl mb-5
            bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
            text-green-800 dark:text-green-300 text-sm font-semibold">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    
    <div class="lg:col-span-2 space-y-5">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center gap-3 px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="w-7 h-7 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Shop Information</span>
            </div>
            <div class="p-5 grid grid-cols-2 sm:grid-cols-3 gap-5">
                <?php $__currentLoopData = [
                    ['Phone', $shop->phone],
                    ['Email', $shop->email],
                    ['Address', $shop->address],
                    ['City', $shop->city],
                    ['Country', $shop->country],
                    ['Currency', ($shop->currency_symbol ?? '£') . ' ' . ($shop->currency ?? 'GBP')],
                    ['Timezone', $shop->timezone ?? 'Europe/London'],
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$label, $value]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1"><?php echo e($label); ?></p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($value ?: '—'); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 bg-gray-50 dark:bg-gray-800
                        border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-7 h-7 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200">Users</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400">
                        <?php echo e($shop->users->count()); ?>

                    </span>
                </div>
                <button type="button" onclick="document.getElementById('assign-user-form').classList.toggle('hidden')"
                        class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold
                               bg-indigo-600 hover:bg-indigo-700 text-white transition-all border-none cursor-pointer">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add User
                </button>
            </div>

            
            <div id="assign-user-form" class="hidden px-5 py-4 border-b border-gray-100 dark:border-gray-800
                                              bg-indigo-50/50 dark:bg-indigo-900/10">
                <form method="POST" action="<?php echo e(route('shops.assign.user', $shop)); ?>" class="flex gap-3 flex-wrap">
                    <?php echo csrf_field(); ?>
                    <select name="user_id" required
                            class="flex-1 min-w-48 px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl
                                   text-sm outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                   focus:border-indigo-500 transition-all">
                        <option value="">Select user...</option>
                        <?php $__currentLoopData = $allUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (! ($shop->users->contains($u->id))): ?>
                        <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?> (<?php echo e($u->email); ?>)</option>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <select name="role"
                            class="px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-xl
                                   text-sm outline-none bg-white dark:bg-gray-800 text-gray-900 dark:text-white
                                   focus:border-indigo-500 transition-all">
                        <option value="staff">Staff</option>
                        <option value="shop_admin">Shop Admin</option>
                    </select>
                    <button type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                                   text-white transition-all border-none cursor-pointer">
                        Assign
                    </button>
                </form>
            </div>

            
            <?php $__empty_1 = true; $__currentLoopData = $shop->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between px-5 py-3.5
                        border-b border-gray-100 dark:border-gray-800 last:border-0
                        group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center
                                text-white text-xs font-black flex-shrink-0">
                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white"><?php echo e($user->name); ?></p>
                        <p class="text-xs text-gray-400"><?php echo e($user->email); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                                 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 capitalize">
                        <?php echo e(str_replace('_', ' ', $user->pivot->role ?? 'staff')); ?>

                    </span>
                    <?php if($user->pivot->is_active): ?>
                    <span class="w-2 h-2 rounded-full bg-emerald-500" title="Active"></span>
                    <?php else: ?>
                    <span class="w-2 h-2 rounded-full bg-gray-400" title="Inactive"></span>
                    <?php endif; ?>
                    <form method="POST" action="<?php echo e(route('shops.remove.user', [$shop, $user])); ?>"
                          onsubmit="return confirm('Remove <?php echo e($user->name); ?> from this shop?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="w-6 h-6 rounded-full flex items-center justify-center
                                       bg-red-50 dark:bg-red-900/20 text-red-400
                                       hover:bg-red-100 opacity-0 group-hover:opacity-100
                                       transition-all border-none cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center text-sm text-gray-400">No users assigned to this shop</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-5 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-800 dark:text-gray-200">Status</h3>
                <?php if($shop->is_active): ?>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                             bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>Active
                </span>
                <?php else: ?>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold
                             bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400">
                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>Inactive
                </span>
                <?php endif; ?>
            </div>
            <div class="text-xs text-gray-400 space-y-1">
                <p>Created: <?php echo e($shop->created_at->format('d/m/Y')); ?></p>
                <p>Updated: <?php echo e($shop->updated_at->format('d/m/Y')); ?></p>
            </div>
        </div>

        <a href="<?php echo e(route('shops.edit', $shop)); ?>"
           class="w-full py-2.5 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                  text-white transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Shop
        </a>

        <form method="POST" action="<?php echo e(route('shops.destroy', $shop)); ?>"
              onsubmit="return confirm('Delete <?php echo e($shop->name); ?>? This cannot be undone.')">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="submit"
                    class="w-full py-2.5 rounded-xl text-sm font-bold bg-red-600 hover:bg-red-700
                           text-white transition-all flex items-center justify-center gap-2 border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Shop
            </button>
        </form>
    </div>

</div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/shops/show.blade.php ENDPATH**/ ?>