<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa758e6a82983efcbf593f765e026bd9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>


# <?php echo new \Illuminate\Support\EncodedHtmlString($settings['receipt_header'] ?? $repair->shop->name); ?>


<?php if($repair->shop->address): ?>
<?php echo new \Illuminate\Support\EncodedHtmlString($repair->shop->address); ?>

<?php endif; ?>
<?php if($repair->shop->phone): ?>
Tel: <?php echo new \Illuminate\Support\EncodedHtmlString($repair->shop->phone); ?>

<?php endif; ?>
<?php if(!empty($settings['tax_number'])): ?>
VAT: <?php echo new \Illuminate\Support\EncodedHtmlString($settings['tax_number']); ?>

<?php endif; ?>

---


**Repair #:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->reference); ?>

**Date:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->created_at->format('d/m/Y H:i')); ?>

<?php if($repair->book_in_date): ?>
**Book-in:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->book_in_date->format('d/m/Y')); ?>

<?php endif; ?>
<?php if($repair->completion_date): ?>
**Est. Completion:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->completion_date->format('d/m/Y')); ?>

<?php endif; ?>
<?php if($repair->status): ?>
**Status:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->status->name); ?>

<?php endif; ?>
**Served by:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->createdBy?->name ?? 'Staff'); ?>

**Delivery:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->delivery_type_label); ?>


---


<?php if($repair->customer): ?>
## Customer

**<?php echo new \Illuminate\Support\EncodedHtmlString($repair->customer->name); ?>**
<?php if($repair->customer->phone): ?>
📞 <?php echo new \Illuminate\Support\EncodedHtmlString($repair->customer->phone); ?>

<?php endif; ?>
<?php if($repair->customer->email): ?>
✉ <?php echo new \Illuminate\Support\EncodedHtmlString($repair->customer->email); ?>

<?php endif; ?>
<?php if($repair->customer->address): ?>
📍 <?php echo new \Illuminate\Support\EncodedHtmlString($repair->customer->address); ?>

<?php endif; ?>

---
<?php endif; ?>


## Devices (<?php echo new \Illuminate\Support\EncodedHtmlString($repair->devices->count()); ?>)

<?php $__currentLoopData = $repair->devices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $device): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
### 📱 <?php echo new \Illuminate\Support\EncodedHtmlString($device->device_name ?? $device->deviceType?->name ?? 'Device'); ?>


<?php if (isset($component)) { $__componentOriginal85530901ee91af5decf39e8ed3495cde = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85530901ee91af5decf39e8ed3495cde = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::table'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
| Field | Detail |
|:------|:-------|
<?php if($device->deviceType): ?>
| Type | <?php echo new \Illuminate\Support\EncodedHtmlString($device->deviceType->name); ?> |
<?php endif; ?>
<?php if($device->color): ?>
| Color | <?php echo new \Illuminate\Support\EncodedHtmlString($device->color); ?> |
<?php endif; ?>
<?php if($device->imei): ?>
| IMEI | `<?php echo new \Illuminate\Support\EncodedHtmlString($device->imei); ?>` |
<?php endif; ?>
<?php if($device->issue): ?>
| Issues | <?php echo new \Illuminate\Support\EncodedHtmlString($device->issue); ?> |
<?php endif; ?>
<?php if($device->repair_type): ?>
| Repair Type | <?php echo new \Illuminate\Support\EncodedHtmlString($device->repair_type); ?> |
<?php endif; ?>
<?php if($device->warranty_status !== 'none'): ?>
| Warranty | <?php echo new \Illuminate\Support\EncodedHtmlString($device->warranty_label); ?> |
<?php endif; ?>
| Price | **£<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($device->price, 2)); ?>** |
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $attributes = $__attributesOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__attributesOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $component = $__componentOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__componentOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>

<?php if($device->parts->isNotEmpty()): ?>
**Parts Used:**
<?php $__currentLoopData = $device->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
- <?php echo new \Illuminate\Support\EncodedHtmlString($part->name); ?><?php if($part->quantity > 1): ?> × <?php echo new \Illuminate\Support\EncodedHtmlString($part->quantity); ?><?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(!$loop->last): ?>
---
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

---


## Summary

<?php if (isset($component)) { $__componentOriginal85530901ee91af5decf39e8ed3495cde = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85530901ee91af5decf39e8ed3495cde = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::table'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
| | |
|:--|--:|
| Subtotal | £<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($repair->total_price, 2)); ?> |
<?php if($repair->discount > 0): ?>
| Discount | -£<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($repair->discount, 2)); ?> |
<?php endif; ?>
| **Total** | **£<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($repair->final_price, 2)); ?>** |
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $attributes = $__attributesOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__attributesOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $component = $__componentOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__componentOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>

---


<?php if($repair->payments->isNotEmpty()): ?>
## Payments

<?php if (isset($component)) { $__componentOriginal85530901ee91af5decf39e8ed3495cde = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85530901ee91af5decf39e8ed3495cde = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::table'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
| Method | Amount |
|:-------|-------:|
<?php $__currentLoopData = $repair->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php if($payment->method === 'split' && $payment->split_part): ?>
<?php echo new \Illuminate\Support\EncodedHtmlString(ucfirst($payment->split_part)); ?> (split)
<?php else: ?>
<?php echo new \Illuminate\Support\EncodedHtmlString(ucfirst($payment->method)); ?>

<?php endif; ?>
<?php if($payment->note): ?> — <?php echo new \Illuminate\Support\EncodedHtmlString($payment->note); ?><?php endif; ?> | £<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($payment->amount, 2)); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $attributes = $__attributesOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__attributesOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85530901ee91af5decf39e8ed3495cde)): ?>
<?php $component = $__componentOriginal85530901ee91af5decf39e8ed3495cde; ?>
<?php unset($__componentOriginal85530901ee91af5decf39e8ed3495cde); ?>
<?php endif; ?>

<?php if($outstanding > 0): ?>
> ⚠️ **Outstanding Balance: £<?php echo new \Illuminate\Support\EncodedHtmlString(number_format($outstanding, 2)); ?>**
<?php else: ?>
> ✅ **Fully Paid**
<?php endif; ?>

---
<?php endif; ?>


<?php if($repair->notes): ?>
**Notes:** <?php echo new \Illuminate\Support\EncodedHtmlString($repair->notes); ?>


---
<?php endif; ?>


<?php echo new \Illuminate\Support\EncodedHtmlString($settings['receipt_footer'] ?? 'Thank you for choosing us!'); ?>


<?php if(!empty($settings['repair_warranty'])): ?>
*<?php echo new \Illuminate\Support\EncodedHtmlString($settings['repair_warranty']); ?>*
<?php endif; ?>

<?php if(!empty($settings['repair_terms'])): ?>
*<?php echo new \Illuminate\Support\EncodedHtmlString($settings['repair_terms']); ?>*
<?php endif; ?>

<?php if (isset($component)) { $__componentOriginal15a5e11357468b3880ae1300c3be6c4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::button'),'data' => ['url' => url('/repairs/' . $repair->id . '/receipt'),'color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(url('/repairs/' . $repair->id . '/receipt')),'color' => 'green']); ?>
View Receipt Online
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $attributes = $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $component = $__componentOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>

Thanks,
**<?php echo new \Illuminate\Support\EncodedHtmlString($repair->shop->name); ?>**

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $attributes = $__attributesOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?><?php /**PATH C:\Users\Your Tech Point\Desktop\Shop\phonesho_sas\resources\views/emails/repair-receipt.blade.php ENDPATH**/ ?>