<?php if($message = Session::get('status')): ?>
<div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert"></button>

   <i class="fa fa-check-circle fa-lg fa-fw"></i> 
   <?php if(is_array($message)): ?> <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($m); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php else: ?> <?php echo e($message); ?> <?php endif; ?>  

</div>
<?php endif; ?> 
<?php if($message = Session::get('success')): ?>
<div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert"></button>

   <i class="fa fa-check-circle fa-lg fa-fw"></i> 
   <?php if(is_array($message)): ?> <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($m); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php else: ?> <?php echo e($message); ?> <?php endif; ?>  

</div>
<?php endif; ?> 
<?php if($message = Session::get('error')): ?>
<div class="alert alert-danger">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-times-circle fa-lg fa-fw"></i> 
      <?php if(is_array($message)): ?> <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($m); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?> <?php echo e($message); ?> <?php endif; ?>  
   </strong>
</div>
<?php endif; ?> 
<?php if($message = Session::get('warning')): ?>
<div class="alert alert-warning">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-exclamation-circle fa-lg fa-fw"></i> 
      <?php if(is_array($message)): ?> <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($m); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?> <?php echo e($message); ?> <?php endif; ?>  
   </strong>
</div>
<?php endif; ?> 
<?php if($message = Session::get('info')): ?>
<div class="alert alert-info">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-info-circle fa-lg fa-fw"></i> 
      <?php if(is_array($message)): ?> <?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($m); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?> <?php echo e($message); ?> <?php endif; ?>  
   </strong>
</div>
<?php endif; ?>
<?php if(count($errors) > 0): ?>
<div class="alert alert-danger">
   <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <div>
       <!--<i class="fa fa-times-circle fa-lg fa-fw"></i>-->
      <?php echo e($error); ?>

   </div>
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>