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
 <?php $__env->slot('title', null, []); ?> Users <?php $__env->endSlot(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Users','subtitle' => 'Manage all users','breadcrumbs' => [
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Users'],
    ]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Users','subtitle' => 'Manage all users','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
        ['label' => 'Dashboard', 'route' => 'dashboard'],
        ['label' => 'Users'],
    ])]); ?>
     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('users.create')); ?>"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold
                  bg-indigo-600 hover:bg-indigo-700 active:scale-95 text-white transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add User
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

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">

    
    <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800">
        <div class="relative max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
            </svg>
            <input type="text" placeholder="Search users..."
                   oninput="filterUsers(this.value)"
                   class="w-full pl-9 pr-4 py-2 border border-gray-200 dark:border-gray-700 rounded-xl
                          text-sm outline-none bg-gray-50 dark:bg-gray-800
                          text-gray-900 dark:text-white
                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                          focus:bg-white dark:focus:bg-gray-900 transition-all">
        </div>
    </div>

    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden sm:table-cell">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">Shops</th>
                    <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden lg:table-cell">Joined</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody id="users-tbody" class="divide-y divide-gray-100 dark:divide-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors group"
                    data-name="<?php echo e(strtolower($user->name)); ?>"
                    data-email="<?php echo e(strtolower($user->email)); ?>">

                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center
                                        flex-shrink-0 text-white text-sm font-black
                                        bg-gradient-to-br from-indigo-500 to-purple-600">
                                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white"><?php echo e($user->name); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($user->email); ?></p>
                            </div>
                        </div>
                    </td>

                    <td class="px-5 py-4 hidden sm:table-cell">
                        <?php $role = $user->getRoleNames()->first() ?>
                        <?php if($role): ?>
                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-bold
                                     <?php echo e($role === 'super_admin' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400' :
                                        ($role === 'shop_admin' ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' :
                                         'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400')); ?>">
                            <?php echo e(str_replace('_', ' ', ucfirst($role))); ?>

                        </span>
                        <?php else: ?>
                        <span class="text-xs text-gray-400 italic">No role</span>
                        <?php endif; ?>
                    </td>

                    <td class="px-5 py-4 hidden md:table-cell">
                        <?php if($user->shops->count() > 0): ?>
                        <div class="flex flex-wrap gap-1">
                            <?php $__currentLoopData = $user->shops->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="text-xs px-2 py-0.5 rounded-md
                                         bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                                <?php echo e($s->name); ?>

                            </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($user->shops->count() > 2): ?>
                            <span class="text-xs text-gray-400">+<?php echo e($user->shops->count() - 2); ?> more</span>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <span class="text-xs text-gray-400 italic">No shops</span>
                        <?php endif; ?>
                    </td>

                    <td class="px-5 py-4 hidden lg:table-cell">
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            <?php echo e($user->created_at->format('d/m/Y')); ?>

                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" title="Edit"
                               class="w-7 h-7 rounded-lg flex items-center justify-center
                                      bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400
                                      hover:bg-amber-100 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <?php if (! ($user->id === auth()->id())): ?>
                            <form method="POST" action="<?php echo e(route('users.destroy', $user)); ?>"
                                  onsubmit="return confirm('Delete <?php echo e($user->name); ?>?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" title="Delete"
                                        class="w-7 h-7 rounded-lg flex items-center justify-center
                                               bg-red-50 dark:bg-red-900/30 text-red-500 dark:text-red-400
                                               hover:bg-red-100 transition-colors border-none cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300 dark:text-gray-600" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">No users yet</p>
                        <a href="<?php echo e(route('users.create')); ?>"
                           class="mt-3 inline-flex items-center gap-1.5 text-sm font-bold
                                  text-indigo-600 dark:text-indigo-400 hover:underline">
                            Add your first user →
                        </a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($users->hasPages()): ?>
    <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-800">
        <?php echo e($users->links()); ?>

    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function filterUsers(term) {
    const t = term.toLowerCase();
    document.querySelectorAll('#users-tbody tr[data-name]').forEach(row => {
        const match = row.dataset.name.includes(t) || row.dataset.email.includes(t);
        row.style.display = match ? '' : 'none';
    });
}
</script>
<?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/users/index.blade.php ENDPATH**/ ?>