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
 <?php $__env->slot('title', null, []); ?> Vouchers <?php $__env->endSlot(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Loading bar */
    #vlist-wrap { position:relative; transition:opacity .15s; }
    #vlist-wrap.loading { opacity:.4; pointer-events:none; }
    #vlist-bar {
        display:none;position:absolute;top:0;left:0;right:0;height:3px;z-index:10;
        background:linear-gradient(90deg,#6366f1 0%,#a5b4fc 50%,#6366f1 100%);
        background-size:200% 100%;animation:vSlide 1s linear infinite;
    }
    @keyframes vSlide{0%{background-position:200% 0}100%{background-position:-200% 0}}
    .loading #vlist-bar{display:block;}

    /* Row selected */
    tr.selected td { background:#eef2ff!important; }
    .dark tr.selected td { background:#1e1b4b!important; }

    /* Field errors */
    .ferr{color:#ef4444;font-size:.7rem;font-weight:600;margin-top:2px;display:none;}
    .ferr.show{display:block;}
    input.err,select.err{border-color:#ef4444!important;}
    @keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-5px)}40%{transform:translateX(5px)}60%{transform:translateX(-3px)}80%{transform:translateX(3px)}}
    .shake{animation:shake .3s ease;}
</style>
<?php $__env->stopPush(); ?>

<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Vouchers','subtitle' => 'Create and manage discount vouchers','breadcrumbs' => [['label'=>'Dashboard','route'=>'dashboard'],['label'=>'Vouchers']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Vouchers','subtitle' => 'Create and manage discount vouchers','breadcrumbs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label'=>'Dashboard','route'=>'dashboard'],['label'=>'Vouchers']])]); ?>
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


<div class="flex items-center gap-2 flex-wrap mb-4">
    <?php
        $cur = request('status','');
        $tabs = [
            [''        , 'All',      $summary['total'],   'gray'],
            ['active'  , 'Active',   $summary['active'],  'emerald'],
            ['inactive', 'Inactive', $summary['inactive'] ?? 0, 'gray'],
            ['expired' , 'Expired',  $summary['expired'], 'red'],
            ['used'    , 'Used',     $summary['used']     ?? 0, 'orange'],
        ];
    ?>
    <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$val, $label, $count, $color]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $active = $cur === $val;
        $cls = $active
            ? match($color){
                'emerald'=>'bg-emerald-500 text-white border-emerald-500',
                'red'    =>'bg-red-500 text-white border-red-500',
                'orange' =>'bg-orange-500 text-white border-orange-500',
                default  =>'bg-indigo-600 text-white border-indigo-600',
              }
            : 'bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-indigo-300';
    ?>
    <button type="button"
            onclick="VoucherPage.filterStatus('<?php echo e($val); ?>')"
            class="tab-btn inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-sm font-bold
                   border transition-all cursor-pointer <?php echo e($cls); ?>"
            data-status="<?php echo e($val); ?>">
        <?php if($active && $color === 'emerald'): ?>
        <span class="w-2 h-2 rounded-full bg-white"></span>
        <?php endif; ?>
        <?php echo e($label); ?>

        <span class="text-xs <?php echo e($active ? 'opacity-80' : 'text-gray-400'); ?>"><?php echo e($count); ?></span>
    </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>


<div class="flex gap-5 items-start">

    
    <div class="flex-1 min-w-0">

        
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700
                    rounded-2xl px-4 py-3 mb-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/>
                </svg>
                <input type="text" id="v-search" placeholder="Search voucher code..."
                       class="w-full pl-9 pr-4 py-2.5 border border-gray-200 dark:border-gray-700
                              rounded-xl text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white placeholder-gray-400
                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
            </div>
        </div>

        
        <div id="vlist-wrap"
             class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <div id="vlist-bar"></div>
            <div id="vlist-body">
                <?php echo $__env->make('vouchers.partials.list', compact('vouchers','summary'), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>

    </div>

    
    <div class="w-96 flex-shrink-0 sticky top-6">
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">

            
            <div class="flex items-center justify-between px-5 py-4
                        border-b border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4"/>
                    </svg>
                    <h3 id="form-title" class="text-sm font-bold text-gray-900 dark:text-white">Create Voucher</h3>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="delete-btn" style="display:none"
                            onclick="VoucherPage.deleteCurrentVoucher()"
                            class="flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold
                                   bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400
                                   hover:bg-red-100 transition-all border-none cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete
                    </button>
                    <button type="button" id="reset-btn" onclick="VoucherPage.newVoucher()"
                            class="text-xs font-semibold text-gray-400 hover:text-gray-600 transition-colors
                                   bg-transparent border-none cursor-pointer">
                        Reset
                    </button>
                </div>
            </div>

            <form id="voucher-form" class="px-5 py-5 space-y-4" onsubmit="return false">
                <input type="hidden" id="f-id">

                
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Code <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="text" id="f-code" maxlength="50" placeholder="E.G. SAVE20"
                               class="flex-1 px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                      text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      font-mono uppercase placeholder-gray-300
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                        <button type="button" onclick="VoucherPage.generateCode()"
                                class="px-3 py-2.5 rounded-xl text-xs font-bold
                                       border border-gray-200 dark:border-gray-700
                                       bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400
                                       hover:border-indigo-300 hover:text-indigo-600 transition-all cursor-pointer">
                            Generate
                        </button>
                    </div>
                    <p class="ferr" id="err-code"></p>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Type <span class="text-red-500">*</span>
                        </label>
                        <select id="f-type" onchange="VoucherPage.updateValueHint()"
                                class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                       text-sm outline-none bg-gray-50 dark:bg-gray-800
                                       text-gray-900 dark:text-white cursor-pointer
                                       focus:border-indigo-500 transition-all">
                            <option value="fixed">£ Fixed Off</option>
                            <option value="percentage">% Percent Off</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Value <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span id="value-prefix" class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 pointer-events-none">£</span>
                            <input type="number" id="f-value" min="0.01" step="0.01" placeholder="e.g. 10"
                                   class="w-full pl-7 pr-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                          text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                          focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                          focus:bg-white dark:focus:bg-gray-900 transition-all">
                        </div>
                        <p class="ferr" id="err-value"></p>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Min Spend £
                        </label>
                        <input type="number" id="f-min-order" min="0" step="0.01" value="0"
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                      text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Uses Limit
                        </label>
                        <input type="number" id="f-usage-limit" min="1" placeholder="Blank = unlimited"
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                      text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      placeholder-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                        <p class="ferr" id="err-usage"></p>
                    </div>
                </div>

                
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Expires
                        </label>
                        <input type="date" id="f-expiry"
                               class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                      text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10
                                      focus:bg-white dark:focus:bg-gray-900 transition-all">
                        <p class="ferr" id="err-expiry"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                            Customer (optional)
                        </label>
                        <select id="f-customer"
                                class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                       text-sm outline-none bg-gray-50 dark:bg-gray-800
                                       text-gray-700 dark:text-gray-300 cursor-pointer
                                       focus:border-indigo-500 transition-all">
                            <option value="">Any customer</option>
                            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <div class="relative">
                        <input type="checkbox" id="f-active-cb" checked
                               onchange="document.getElementById('f-active').value=this.checked?'1':'0'"
                               class="w-4 h-4 accent-indigo-600 cursor-pointer">
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Active immediately</span>
                    <input type="hidden" id="f-active" value="1">
                </label>

                
                <div>
                    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                        Notes <span class="font-normal normal-case text-gray-400">(optional)</span>
                    </label>
                    <textarea id="f-notes" rows="2" placeholder="Internal notes..."
                              class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                     text-sm outline-none bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white
                                     placeholder-gray-300 resize-none focus:border-indigo-500
                                     focus:ring-2 focus:ring-indigo-500/10 focus:bg-white dark:focus:bg-gray-900 transition-all">
                    </textarea>
                </div>

                
                <button type="button" id="save-btn" onclick="VoucherPage.save()"
                        class="w-full py-3 rounded-xl text-sm font-bold bg-indigo-600 hover:bg-indigo-700
                               active:scale-95 text-white transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span id="save-btn-text">Create Voucher</span>
                </button>

            </form>
        </div>
    </div>

</div>



<iframe id="v-print-frame" style="display:none;position:absolute;"></iframe>


<div id="v-email-modal"
     style="display:none;position:fixed;inset:0;z-index:9999;
            background:rgba(15,23,42,.75);align-items:center;
            justify-content:center;padding:16px;"
     onclick="if(event.target===this)VoucherPage.closeEmailModal()">
    <div id="v-email-box"
         style="transform:scale(.95);opacity:0;transition:all .18s;"
         class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl">

        <div class="flex items-center justify-between px-6 py-4
                    border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">Send Voucher by Email</h3>
                    <p id="v-email-code" class="text-xs text-gray-400"></p>
                </div>
            </div>
            <button type="button" onclick="VoucherPage.closeEmailModal()"
                    class="w-8 h-8 rounded-full flex items-center justify-center
                           bg-gray-100 dark:bg-gray-800 text-gray-500
                           hover:bg-gray-200 hover:text-red-500 transition-all border-none cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 space-y-4">

            
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    To <span class="text-red-500">*</span>
                </label>
                <input type="email" id="v-email-to" placeholder="customer@example.com"
                       oninput="document.getElementById('v-email-err').style.display='none'"
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                              text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white placeholder-gray-400
                              focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all
                              disabled:opacity-50 disabled:cursor-not-allowed">
                <p id="v-email-assigned-note" style="display:none"
                   class="text-xs text-blue-500 mt-1">
                    📧 Pre-filled from the assigned customer
                </p>
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Subject <span class="text-red-500">*</span>
                </label>
                <input type="text" id="v-email-subject"
                       oninput="document.getElementById('v-email-err').style.display='none'"
                       class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                              text-sm outline-none bg-gray-50 dark:bg-gray-800
                              text-gray-900 dark:text-white placeholder-gray-400
                              focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10
                              focus:bg-white dark:focus:bg-gray-900 transition-all">
            </div>

            
            <div>
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                    Message <span class="text-gray-400 font-normal normal-case">(optional)</span>
                </label>
                <textarea id="v-email-message" rows="3"
                          placeholder="Add a personal message..."
                          class="w-full px-3.5 py-2.5 border border-gray-200 dark:border-gray-700 rounded-xl
                                 text-sm outline-none bg-gray-50 dark:bg-gray-800
                                 text-gray-900 dark:text-white placeholder-gray-400 resize-none
                                 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/10
                                 focus:bg-white dark:focus:bg-gray-900 transition-all">
                </textarea>
            </div>

            
            <div id="v-email-err" style="display:none"
                 class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold
                        bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800
                        text-red-600 dark:text-red-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="v-email-err-text"></span>
            </div>

            
            <div id="v-email-ok" style="display:none"
                 class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-semibold
                        bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800
                        text-green-700 dark:text-green-400">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span id="v-email-ok-text"></span>
            </div>

        </div>

        <div class="px-6 pb-6 flex gap-3">
            <button type="button" onclick="VoucherPage.closeEmailModal()"
                    class="flex-1 py-3 rounded-xl text-sm font-semibold border border-gray-200 dark:border-gray-700
                           text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                Cancel
            </button>
            <button type="button" id="v-email-send" onclick="VoucherPage.sendEmail()"
                    class="flex-1 py-3 rounded-xl text-sm font-bold bg-blue-600 hover:bg-blue-700
                           active:scale-95 text-white transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span id="v-email-send-text">Send Email</span>
            </button>
        </div>

    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
const VoucherPage = (() => {
    const csrf    = document.querySelector('meta[name="csrf-token"]')?.content;
    const baseUrl = '<?php echo e(route("vouchers.index")); ?>';
    const storeUrl= '<?php echo e(route("vouchers.store")); ?>';
    let suggested = '<?php echo e($suggestedCode); ?>';
    let currentId = null;
    let statusFilter = '<?php echo e(request("status","")); ?>';
    let searchTimer;

    // ── Init ──────────────────────────────────────────────
    function init() {
        document.getElementById('v-search')?.addEventListener('input', () => {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(_fetchList, 350);
        });
        newVoucher();
    }

    // ── Filter by status tab ──────────────────────────────
    function filterStatus(status) {
        statusFilter = status;
        // Update tab styles
        document.querySelectorAll('.tab-btn').forEach(btn => {
            const isActive = btn.dataset.status === status;
            btn.classList.remove('bg-indigo-600','bg-emerald-500','bg-red-500','bg-orange-500',
                                  'border-indigo-600','border-emerald-500','border-red-500','border-orange-500',
                                  'text-white','bg-white','dark:bg-gray-900',
                                  'border-gray-200','dark:border-gray-700','text-gray-600','dark:text-gray-400');
            if (isActive) {
                btn.classList.add('bg-indigo-600','border-indigo-600','text-white');
            } else {
                btn.classList.add('bg-white','dark:bg-gray-900','border-gray-200','dark:border-gray-700',
                                  'text-gray-600','dark:text-gray-400');
            }
        });
        _fetchList();
    }

    // ── Fetch list ────────────────────────────────────────
    async function _fetchList() {
        const search = document.getElementById('v-search')?.value || '';
        const wrap   = document.getElementById('vlist-wrap');
        wrap.classList.add('loading');
        const p = new URLSearchParams();
        if (search)       p.set('search', search);
        if (statusFilter) p.set('status', statusFilter);
        try {
            const res  = await fetch(`${baseUrl}?${p}`, {
                headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json','X-CSRF-TOKEN':csrf}
            });
            const data = await res.json();
            document.getElementById('vlist-body').innerHTML = data.html;
            if (currentId) _highlightRow(currentId);
        } catch(e) {}
        finally { wrap.classList.remove('loading'); }
    }

    // ── New voucher ───────────────────────────────────────
    function newVoucher() {
        currentId = null;
        _clearErrors();
        document.getElementById('f-id').value          = '';
        document.getElementById('f-code').value        = suggested;
        document.getElementById('f-type').value        = 'fixed';
        document.getElementById('f-value').value       = '';
        document.getElementById('f-usage-limit').value = '';
        document.getElementById('f-min-order').value   = '0';
        document.getElementById('f-expiry').value      = '';
        document.getElementById('f-customer').value    = '';
        document.getElementById('f-notes').value       = '';
        document.getElementById('f-active-cb').checked = true;
        document.getElementById('f-active').value      = '1';
        _setMode('create');
        updateValueHint();
        document.querySelectorAll('tr.selected').forEach(r=>r.classList.remove('selected'));
    }

    // ── Select voucher from table row ─────────────────────
    function selectVoucher(data) {
        currentId = data.id;
        _clearErrors();
        document.getElementById('f-id').value          = data.id;
        document.getElementById('f-code').value        = data.code;
        document.getElementById('f-type').value        = data.type;
        document.getElementById('f-value').value       = data.value;
        document.getElementById('f-usage-limit').value = data.usage_limit || '';
        document.getElementById('f-min-order').value   = data.min_order_amount || '0';
        document.getElementById('f-expiry').value      = data.expiry_date || '';
        document.getElementById('f-customer').value    = data.assigned_to || '';
        document.getElementById('f-notes').value       = data.notes || '';
        const on = !!data.is_active;
        document.getElementById('f-active-cb').checked = on;
        document.getElementById('f-active').value      = on ? '1' : '0';
        _setMode('edit', data.code);
        updateValueHint();
        _highlightRow(data.id);
    }

    // ── Save ──────────────────────────────────────────────
    async function save() {
        if (!_validate()) return;
        const btn = document.getElementById('save-btn');
        const txt = document.getElementById('save-btn-text');
        btn.disabled = true; txt.textContent = 'Saving...';
        const isEdit = !!currentId;
        const body = {
            code             : document.getElementById('f-code').value.trim().toUpperCase(),
            type             : document.getElementById('f-type').value,
            value            : document.getElementById('f-value').value,
            usage_limit      : document.getElementById('f-usage-limit').value || null,
            min_order_amount : document.getElementById('f-min-order').value || 0,
            expiry_date      : document.getElementById('f-expiry').value || null,
            assigned_to      : document.getElementById('f-customer').value || null,
            is_active        : document.getElementById('f-active').value === '1',
            notes            : document.getElementById('f-notes').value || null,
        };
        try {
            const res  = await fetch(isEdit ? `<?php echo e(url('vouchers')); ?>/${currentId}` : storeUrl, {
                method : isEdit ? 'PUT' : 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
                body   : JSON.stringify(body),
            });
            const data = await res.json();
            if (data.success) {
                _toast('✓ ' + data.message, 'success');
                if (!isEdit) { suggested = data.new_code || ''; newVoucher(); }
                else { _setMode('edit', data.voucher.code); }
                _fetchList();
            } else {
                const e = data.errors || {};
                if (e.code)  _showErr('err-code', e.code[0],  'f-code');
                if (e.value) _showErr('err-value',e.value[0], 'f-value');
                _toast(data.message || 'Failed to save.', 'error');
            }
        } catch(e) { _toast('Network error.', 'error'); }
        finally { btn.disabled=false; txt.textContent = isEdit ? 'Save Changes' : 'Create Voucher'; }
    }

    // ── Delete ────────────────────────────────────────────
    async function deleteVoucher(id, code) {
        if (!confirm(`Delete voucher "${code}"?`)) return;
        try {
            const res  = await fetch(`<?php echo e(url('vouchers')); ?>/${id}`, {
                method:'DELETE',headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}
            });
            const data = await res.json();
            if (data.success) {
                _toast('✓ ' + data.message, 'success');
                if (currentId === id) newVoucher();
                _fetchList();
            }
        } catch(e) { _toast('Failed to delete.', 'error'); }
    }

    function deleteCurrentVoucher() {
        if (currentId) deleteVoucher(currentId, document.getElementById('f-code').value);
    }

    // ── Helpers ───────────────────────────────────────────
    function generateCode() {
        const c='ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; let code='';
        for(let i=0;i<8;i++) code+=c[Math.floor(Math.random()*c.length)];
        document.getElementById('f-code').value=code;
        document.getElementById('err-code')?.classList.remove('show');
        document.getElementById('f-code')?.classList.remove('err');
    }

    function updateValueHint() {
        const pct = document.getElementById('f-type')?.value==='percentage';
        const pre = document.getElementById('value-prefix');
        const inp = document.getElementById('f-value');
        if(pre) pre.textContent = pct ? '%' : '£';
        if(inp) { inp.placeholder=pct?'e.g. 10':'e.g. 5.00'; pct?inp.setAttribute('max','100'):inp.removeAttribute('max'); }
    }

    function _setMode(mode, code='') {
        document.getElementById('form-title').innerHTML   = mode==='edit'
            ? `<span class="text-gray-400 text-xs font-normal mr-1">Editing</span>${code}`
            : 'Create Voucher';
        document.getElementById('save-btn-text').textContent = mode==='edit' ? 'Save Changes' : 'Create Voucher';
        document.getElementById('delete-btn').style.display  = mode==='edit' ? 'flex' : 'none';
        const icon = document.querySelector('#save-btn svg path');
        if (icon) icon.setAttribute('d', mode==='edit' ? 'M5 13l4 4L19 7' : 'M12 4v16m8-8H4');
    }

    function _highlightRow(id) {
        document.querySelectorAll('tr.selected').forEach(r=>r.classList.remove('selected'));
        const row = document.getElementById(`vrow-${id}`);
        if(row) { row.classList.add('selected'); row.scrollIntoView({block:'nearest'}); }
    }

    function _validate() {
        let ok=true; _clearErrors();
        const code=document.getElementById('f-code').value.trim();
        const val =parseFloat(document.getElementById('f-value').value);
        const type=document.getElementById('f-type').value;
        const exp =document.getElementById('f-expiry').value;
        const usg =document.getElementById('f-usage-limit').value;
        if(!code)                      {_showErr('err-code','Code is required.','f-code');ok=false;}
        else if(!/^[A-Z0-9]+$/i.test(code)){_showErr('err-code','Letters & numbers only.','f-code');ok=false;}
        else if(code.length>50)        {_showErr('err-code','Max 50 characters.','f-code');ok=false;}
        if(!val||val<=0)               {_showErr('err-value','Value must be greater than 0.','f-value');ok=false;}
        else if(type==='percentage'&&val>100){_showErr('err-value','Percentage cannot exceed 100.','f-value');ok=false;}
        if(exp&&!currentId&&new Date(exp)<=new Date()){_showErr('err-expiry','Expiry must be in the future.','f-expiry');ok=false;}
        if(usg&&(parseInt(usg)<1||!Number.isInteger(parseFloat(usg)))){_showErr('err-usage','Must be a whole number ≥ 1.','f-usage-limit');ok=false;}
        if(!ok){document.getElementById('voucher-form').classList.add('shake');setTimeout(()=>document.getElementById('voucher-form').classList.remove('shake'),400);}
        return ok;
    }

    function _showErr(errId,msg,inputId){
        const el=document.getElementById(errId); if(el){el.textContent=msg;el.classList.add('show');}
        document.getElementById(inputId)?.classList.add('err');
    }
    function _clearErrors(){
        document.querySelectorAll('.ferr').forEach(e=>e.classList.remove('show'));
        document.querySelectorAll('.err').forEach(e=>e.classList.remove('err'));
    }
    function _toast(msg,type='success'){
        const el=document.createElement('div');
        el.style.cssText=`position:fixed;bottom:24px;right:24px;z-index:9999;padding:10px 18px;
            border-radius:12px;color:#fff;font-size:.85rem;font-weight:700;
            background:${type==='success'?'#10b981':'#ef4444'};transform:translateY(10px);
            opacity:0;transition:all .25s ease;box-shadow:0 8px 24px rgba(0,0,0,.15);`;
        el.textContent=msg; document.body.appendChild(el);
        requestAnimationFrame(()=>requestAnimationFrame(()=>{el.style.transform='translateY(0)';el.style.opacity='1';}));
        setTimeout(()=>{el.style.opacity='0';el.style.transform='translateY(10px)';setTimeout(()=>el.remove(),250);},3500);
    }

    // ── Print voucher (inline, no new page) ──────────────
    async function printVoucher(url) {
        try {
            const res  = await fetch(url, { headers:{'Accept':'text/html'} });
            const html = await res.text();
            const frame = document.getElementById('v-print-frame');
            frame.srcdoc = html;
            frame.onload = () => { frame.contentWindow.focus(); frame.contentWindow.print(); };
        } catch(e) { _toast('Failed to load print view.','error'); }
    }

    // ── Email modal ───────────────────────────────────────
    let _emailUrl = '';

    function openEmailModal(url, code, customerEmail, hasCustomer) {
        _emailUrl = url;
        const isAssigned = hasCustomer === 'true' || hasCustomer === true;

        document.getElementById('v-email-code').textContent    = code;
        document.getElementById('v-email-to').value            = customerEmail || '';
        document.getElementById('v-email-to').disabled         = !!(isAssigned && customerEmail);
        document.getElementById('v-email-subject').value       = `Your Voucher Code: ${code}`;
        document.getElementById('v-email-message').value       = '';
        document.getElementById('v-email-err').style.display   = 'none';
        document.getElementById('v-email-ok').style.display    = 'none';
        document.getElementById('v-email-send').disabled       = false;
        document.getElementById('v-email-send-text').textContent = 'Send Email';
        document.getElementById('v-email-assigned-note').style.display =
            (isAssigned && customerEmail) ? 'block' : 'none';

        const modal = document.getElementById('v-email-modal');
        const box   = document.getElementById('v-email-box');
        modal.style.display = 'flex';
        requestAnimationFrame(()=>requestAnimationFrame(()=>{
            box.style.transform='scale(1)'; box.style.opacity='1';
        }));
        setTimeout(()=>{
            if (!document.getElementById('v-email-to').disabled)
                document.getElementById('v-email-to')?.focus();
            else
                document.getElementById('v-email-subject')?.focus();
        }, 200);
    }

    function closeEmailModal() {
        const box = document.getElementById('v-email-box');
        box.style.transform='scale(.95)'; box.style.opacity='0';
        setTimeout(()=>{ document.getElementById('v-email-modal').style.display='none'; }, 180);
    }

    async function sendEmail() {
        const to      = document.getElementById('v-email-to').value.trim();
        const subject = document.getElementById('v-email-subject').value.trim();
        const message = document.getElementById('v-email-message').value.trim();
        const btn     = document.getElementById('v-email-send');
        const err     = document.getElementById('v-email-err');
        const errTxt  = document.getElementById('v-email-err-text');
        const ok      = document.getElementById('v-email-ok');

        // Validation
        err.style.display = 'none'; ok.style.display = 'none';
        if (!to) { errTxt.textContent='Email address is required.'; err.style.display='flex'; return; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(to)) { errTxt.textContent='Please enter a valid email address.'; err.style.display='flex'; return; }
        if (!subject) { errTxt.textContent='Subject is required.'; err.style.display='flex'; return; }
        if (subject.length > 255) { errTxt.textContent='Subject is too long (max 255 characters).'; err.style.display='flex'; return; }

        btn.disabled = true;
        document.getElementById('v-email-send-text').textContent = 'Sending...';

        try {
            const res  = await fetch(_emailUrl, {
                method :'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
                body   : JSON.stringify({ email:to, subject, message: message||null }),
            });
            const data = await res.json();
            if (data.success) {
                ok.style.display = 'flex';
                document.getElementById('v-email-ok-text').textContent = data.message;
                document.getElementById('v-email-send-text').textContent = '✓ Sent!';
                setTimeout(()=>closeEmailModal(), 2000);
            } else {
                errTxt.textContent = data.message || 'Failed to send.';
                err.style.display = 'flex';
                btn.disabled = false;
                document.getElementById('v-email-send-text').textContent = 'Send Email';
            }
        } catch(e) {
            errTxt.textContent = 'Network error. Please try again.';
            err.style.display = 'flex';
            btn.disabled = false;
            document.getElementById('v-email-send-text').textContent = 'Send Email';
        }
    }

    document.addEventListener('keydown', e => { if(e.key==='Escape') closeEmailModal(); });

    return { init, newVoucher, selectVoucher, filterStatus, generateCode,
             updateValueHint, save, deleteVoucher, deleteCurrentVoucher,
             printVoucher, openEmailModal, closeEmailModal, sendEmail };
})();

document.addEventListener('DOMContentLoaded', ()=>VoucherPage.init());
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
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/vouchers/index.blade.php ENDPATH**/ ?>