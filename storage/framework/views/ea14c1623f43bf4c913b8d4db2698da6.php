<?php
    $statusColors = [
        'green'  => 'badge-green',
        'blue'   => 'badge-blue',
        'yellow' => 'badge-yellow',
        'orange' => 'badge-orange',
        'red'    => 'badge-red',
        'purple' => 'badge-purple',
        'gray'   => 'badge-gray',
    ];
    $badgeClass  = $statusColors[$repair->status?->color ?? 'gray'] ?? 'badge-gray';
    $totalPaid   = $repair->payments->sum('amount');
    $outstanding = max(0, $repair->final_price - $totalPaid);
?>


<tr class="repair-row group hover:bg-indigo-50/40
           dark:hover:bg-indigo-900/10 transition-colors"
    onclick="RepairIndex.toggleRow(<?php echo e($repair->id); ?>, this)">

    
    <td class="px-4 py-4 w-8">
        <div id="chevron-<?php echo e($repair->id); ?>"
             class="w-6 h-6 rounded-full flex items-center justify-center
                    bg-gray-100 dark:bg-gray-800 text-gray-400
                    transition-all group-hover:bg-indigo-100
                    dark:group-hover:bg-indigo-900/40
                    group-hover:text-indigo-500">
            <svg class="w-3.5 h-3.5 transition-transform duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2.5" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </td>

    
<td class="px-4 py-4">
    <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">
        <?php echo e($repair->reference); ?>

    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
        <?php echo e($repair->created_at->format('d/m/Y H:i')); ?>

    </p>

    
    <?php if($repair->is_warranty_return): ?>
    <div class="flex items-center gap-1.5 mt-1.5">
        <span class="inline-flex items-center gap-1 px-2 py-0.5
                     rounded-full text-xs font-bold
                     bg-amber-100 dark:bg-amber-900/40
                     text-amber-700 dark:text-amber-400">
            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955
                         0 0112 2.944a11.955 11.955 0 01-8.618
                         3.04A12.02 12.02 0 003 9c0 5.591 3.824
                         10.29 9 11.622 5.176-1.332 9-6.03
                         9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Warranty
        </span>

        
        <?php if($repair->parentRepair): ?>
        <a href="<?php echo e(route('repairs.show', $repair->parentRepair)); ?>"
           onclick="event.stopPropagation()"
           title="View original repair"
           class="text-xs text-amber-600 dark:text-amber-400
                  hover:text-amber-800 dark:hover:text-amber-300
                  font-semibold underline underline-offset-2
                  transition-colors">
            ← <?php echo e($repair->parentRepair->reference); ?>

        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>

</td>

    
    <td class="px-4 py-4">
        <?php if($repair->customer): ?>
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                <?php echo e($repair->customer->name); ?>

            </p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
                <?php echo e($repair->customer->phone ?? '—'); ?>

            </p>
        <?php else: ?>
            <span class="text-xs italic text-gray-400 dark:text-gray-600">
                Walk-in
            </span>
        <?php endif; ?>
    </td>

    
    <td class="px-4 py-4 hidden sm:table-cell">
        <?php $__empty_1 = true; $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate max-w-36 mb-0.5 last:mb-0">
                📱 <?php echo e($device->device_name ?? $device->deviceType?->name ?? 'Device'); ?>

            </p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <span class="text-xs text-gray-400">—</span>
        <?php endif; ?>
    </td>

    
    <td class="px-4 py-4 hidden md:table-cell">
        <?php $__empty_1 = true; $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $dStatusColors = [
                'green'  => 'badge-green',
                'blue'   => 'badge-blue',
                'yellow' => 'badge-yellow',
                'orange' => 'badge-orange',
                'red'    => 'badge-red',
                'purple' => 'badge-purple',
                'gray'   => 'badge-gray',
            ];
            $dBadge = $dStatusColors[$device->status?->color ?? 'gray'] ?? 'badge-gray';
        ?>
        <div class="mb-0.5 last:mb-0">
            <?php if($device->status): ?>
                <span class="inline-flex items-center gap-1 px-2 py-0.5
                             rounded-full text-xs font-semibold <?php echo e($dBadge); ?>">
                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70 flex-shrink-0"></span>
                    <?php echo e($device->status->name); ?>

                </span>
            <?php else: ?>
                <span class="text-xs text-gray-400">—</span>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <span class="text-xs text-gray-400">—</span>
        <?php endif; ?>
    </td>

    
    <td class="px-4 py-4 hidden lg:table-cell">
        <p class="text-sm font-bold text-gray-900 dark:text-white">
            £<?php echo e(number_format($repair->final_price, 2)); ?>

        </p>
        <?php if($outstanding > 0): ?>
            <p class="text-xs text-red-500 font-medium">
                £<?php echo e(number_format($outstanding, 2)); ?> owed
            </p>
        <?php else: ?>
            <p class="text-xs text-emerald-500 font-medium">Paid</p>
        <?php endif; ?>
    </td>

   
<td class="px-4 py-4" onclick="event.stopPropagation()">
    <div class="flex items-center gap-1.5
                opacity-0 group-hover:opacity-100 transition-opacity">

        
        <a href="<?php echo e(route('repairs.show', $repair)); ?>"
           title="View"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-indigo-50 dark:bg-indigo-900/30
                  text-indigo-600 dark:text-indigo-400
                  hover:bg-indigo-100 dark:hover:bg-indigo-900/50
                  transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732
                         7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542
                         7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268
                         -2.943-9.542-7z"/>
            </svg>
        </a>

        
        <a href="<?php echo e(route('repairs.receipt', $repair)); ?>"
           target="_blank"
           title="Print Receipt"
           class="w-7 h-7 rounded-lg flex items-center justify-center
                  bg-emerald-50 dark:bg-emerald-900/30
                  text-emerald-600 dark:text-emerald-400
                  hover:bg-emerald-100 dark:hover:bg-emerald-900/50
                  transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0
                         00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2
                         2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12
                         V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
        </a>

    </div>
</td>

</tr>


<tr id="expand-<?php echo e($repair->id); ?>" class="repair-expand">
    <td colspan="7"
        class="px-0 py-0"
        style="background:linear-gradient(to bottom,
               #f0f4ff 0%, #f8faff 100%);"
        >
        <div style="border-top:3px solid #6366f1;
                    border-bottom:3px solid #e0e7ff;
                    padding:20px 24px;">

            
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center gap-2">
                    <div style="background:#6366f1;color:#fff;
                                padding:3px 12px;border-radius:999px;
                                font-size:0.72rem;font-weight:800;
                                letter-spacing:0.05em;">
                        <?php echo e($repair->reference); ?>

                    </div>
                    <?php if($repair->status): ?>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1
                                 rounded-full text-xs font-semibold
                                 <?php echo e($badgeClass); ?>">
                        <?php echo e($repair->status->name); ?>

                    </span>
                    <?php endif; ?>
                    <?php if($repair->delivery_type): ?>
                    <span class="text-xs font-semibold px-2 py-1
                                 rounded-full bg-gray-200 dark:bg-gray-700
                                 text-gray-600 dark:text-gray-300">
                        <?php echo e($repair->delivery_type_label); ?>

                    </span>
                    <?php endif; ?>
                </div>
                <div class="ml-auto flex items-center gap-2">
                    <a href="<?php echo e(route('repairs.show', $repair)); ?>"
                       onclick="event.stopPropagation()"
                       class="flex items-center gap-1.5 px-3 py-1.5
                              rounded-lg text-xs font-bold
                              bg-indigo-600 hover:bg-indigo-700
                              text-white transition-all">
                        View Full →
                    </a>
                </div>
            </div>

            
            <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(240px, 1fr));
                        gap:16px;">

                
                <?php $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background:#fff;border-radius:14px;
                            padding:16px;border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    
                    <div style="display:flex;align-items:center;
                                gap:8px;margin-bottom:12px;
                                padding-bottom:10px;
                                border-bottom:1px solid #f1f5f9;">
                        <span style="font-size:1.2rem;">📱</span>
                        <div style="min-width:0;">
                            <p style="font-size:0.82rem;font-weight:800;
                                      color:#1e293b;margin:0;
                                      white-space:nowrap;overflow:hidden;
                                      text-overflow:ellipsis;">
                                <?php echo e($device->device_name ?? 'Device'); ?>

                            </p>
                            <p style="font-size:0.7rem;color:#94a3b8;
                                      margin:0;">
                                <?php echo e(implode(' · ', array_filter([
                                    $device->deviceType?->name,
                                    $device->color,
                                    $device->imei ? 'IMEI: '.$device->imei : null
                                ])) ?: '—'); ?>

                            </p>
                        </div>
                        <span style="margin-left:auto;font-size:0.8rem;
                                     font-weight:800;color:#6366f1;
                                     white-space:nowrap;">
                            £<?php echo e(number_format($device->price, 2)); ?>

                        </span>
                    </div>

                    
                    <div style="display:grid;grid-template-columns:1fr 1fr;
                                gap:8px;font-size:0.75rem;">

                        
                        <?php if($device->issue): ?>
                        <div style="grid-column:1/-1;">
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Issues
                            </p>
                            <p style="color:#374151;font-weight:600;">
                                <?php echo e($device->issue); ?>

                            </p>
                        </div>
                        <?php endif; ?>

                        
                        <?php if($device->repair_type): ?>
                        <div>
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Repair Type
                            </p>
                            <p style="color:#374151;font-weight:600;">
                                <?php echo e($device->repair_type); ?>

                            </p>
                        </div>
                        <?php endif; ?>

                        
                        <?php if($device->status?->is_completed): ?>
                        <div>
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Warranty
                            </p>
                            <?php
                                $wBg = match($device->warranty_status) {
                                    'active'         => 'background:#dcfce7;color:#166534;',
                                    'under_warranty' => 'background:#dbeafe;color:#1e40af;',
                                    'expired'        => 'background:#fee2e2;color:#991b1b;',
                                    default          => 'background:#f1f5f9;color:#475569;',
                                };
                                $wText = match($device->warranty_status) {
                                    'under_warranty' => '🛡️ Under Warranty',
                                    'active'         => '✓ ' . $device->warranty_label . ($device->warranty_expiry_date ? ' until ' . \Carbon\Carbon::parse((string) $device->warranty_expiry_date)->format('d/m/Y') : ''),
                                    'expired'        => '✗ Expired',
                                    default          => 'No Warranty',
                                };
                            ?>
                            <span style="font-size:0.7rem;font-weight:700;
                                         padding:2px 8px;border-radius:999px;
                                         <?php echo e($wBg); ?>">
                                <?php echo e($wText); ?>

                            </span>
                        </div>
                        <?php endif; ?>

                        
                        <?php if($device->parts->isNotEmpty()): ?>
                        <div style="grid-column:1/-1;">
                            <p style="color:#94a3b8;font-weight:700;
                                      font-size:0.65rem;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:4px;">
                                Parts Used
                            </p>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                <?php $__currentLoopData = $device->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span style="background:#eef2ff;color:#4338ca;
                                             font-size:0.7rem;font-weight:700;
                                             padding:2px 8px;border-radius:6px;">
                                    <?php echo e($part->name); ?>

                                    <?php if($part->quantity > 1): ?>
                                        <span style="opacity:0.6;">×<?php echo e($part->quantity); ?></span>
                                    <?php endif; ?>
                                </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        
                        <?php if($device->notes): ?>
                        <div style="grid-column:1/-1;
                                    background:#fafafa;border-radius:8px;
                                    padding:6px 10px;margin-top:2px;">
                            <p style="color:#94a3b8;font-size:0.65rem;
                                      font-weight:700;text-transform:uppercase;
                                      letter-spacing:0.05em;margin-bottom:2px;">
                                Notes
                            </p>
                            <p style="color:#6b7280;font-size:0.75rem;">
                                <?php echo e($device->notes); ?>

                            </p>
                        </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <div style="background:#fff;border-radius:14px;
                            padding:16px;border:1px solid #e0e7ff;
                            box-shadow:0 1px 4px rgba(99,102,241,0.06);">

                    
                    <div style="padding-bottom:12px;margin-bottom:12px;
                                border-bottom:1px solid #f1f5f9;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Pricing
                        </p>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Total</span>
                            <span style="font-weight:800;color:#1e293b;">
                                £<?php echo e(number_format($repair->final_price, 2)); ?>

                            </span>
                        </div>
                        <?php if($repair->discount > 0): ?>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Discount</span>
                            <span style="font-weight:700;color:#ef4444;">
                                -£<?php echo e(number_format($repair->discount, 2)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($totalPaid > 0): ?>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;">Paid</span>
                            <span style="font-weight:700;color:#10b981;">
                                £<?php echo e(number_format($totalPaid, 2)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($outstanding > 0): ?>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;padding:6px 8px;
                                    background:#fee2e2;border-radius:8px;
                                    margin-top:4px;">
                            <span style="color:#ef4444;font-weight:700;">
                                Outstanding
                            </span>
                            <span style="font-weight:800;color:#ef4444;">
                                £<?php echo e(number_format($outstanding, 2)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($repair->payments->isNotEmpty()): ?>
                    <div style="margin-bottom:12px;padding-bottom:12px;
                                border-bottom:1px solid #f1f5f9;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Payments
                        </p>
                        <?php $__currentLoopData = $repair->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display:flex;justify-content:space-between;
                                    font-size:0.78rem;margin-bottom:4px;">
                            <span style="color:#6b7280;text-transform:capitalize;">
                                <?php if($payment->method === 'split' && $payment->split_part): ?>
                                    <?php echo e(ucfirst($payment->split_part)); ?> (split)
                                <?php else: ?>
                                    <?php echo e(ucfirst($payment->method)); ?>

                                <?php endif; ?>
                                <?php if($payment->note): ?>
                                    <span style="color:#cbd5e1;font-size:0.7rem;">
                                        — <?php echo e($payment->note); ?>

                                    </span>
                                <?php endif; ?>
                            </span>
                            <span style="font-weight:700;color:#1e293b;">
                                £<?php echo e(number_format($payment->amount, 2)); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>

                    
                    <div style="font-size:0.75rem;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#94a3b8;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:8px;">
                            Info
                        </p>
                        <div style="display:grid;grid-template-columns:1fr 1fr;
                                    gap:6px;">
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Book-in
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    <?php echo e($repair->book_in_date?->format('d/m/Y') ?? '—'); ?>

                                </p>
                            </div>
                            <?php if($repair->completion_date): ?>
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Due
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    <?php echo e($repair->completion_date?->format('d/m/Y') ?? '—'); ?>

                                </p>
                            </div>
                            <?php endif; ?>
                            <div>
                                <p style="color:#94a3b8;font-size:0.65rem;
                                          font-weight:700;margin-bottom:1px;">
                                    Created by
                                </p>
                                <p style="color:#374151;font-weight:600;">
                                    <?php echo e($repair->createdBy?->name ?? '—'); ?>

                                </p>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($repair->notes): ?>
                    <div style="margin-top:10px;background:#fffbeb;
                                border-radius:8px;padding:8px 10px;
                                border:1px solid #fde68a;">
                        <p style="font-size:0.65rem;font-weight:700;
                                  color:#92400e;text-transform:uppercase;
                                  letter-spacing:0.05em;margin-bottom:2px;">
                            Notes
                        </p>
                        <p style="font-size:0.75rem;color:#78350f;">
                            <?php echo e($repair->notes); ?>

                        </p>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
        </div>
    </td>
</tr><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/repairs/partials/index-row.blade.php ENDPATH**/ ?>