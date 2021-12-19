<?php echo $__env->make('layouts.answer_entry_options', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-------------------          question header section ------------------------>
</div>

<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5"> 
   <div class="col-sm-3 col-md-2 pdng-lft-0 ">
      <select id="basic" class="selectpicker show-tick form-control">
         <?php for($i=1; $i<=100;$i++): ?>
         <option><?php echo e($i); ?></option>
         <?php endfor; ?>
      </select>
   </div>  
   <div class="col-sm-3 col-md-2">
      <select id="basic" class="selectpicker show-tick form-control">
         <option>Year(s)</option>
         <option>Month(s)</option>
         <option>Week(s)</option>
         <option>Day(s)</option>
         <option>Hour(s)</option>
      </select>
   </div>
   <div class="col-sm-3 col-md-2"> 
       <?php $def = 'ago';?>
      <?php if(count((array)$categoryOptions)>0): ?>
      <?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $def = $opt->default_option?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
      <?php endif; ?>
      <input type="text"  name="txt3ComboAnswer" id="txt3ComboAnswer" value="<?php echo e($def); ?>" class="form-control" >
   </div>

</div>
<?php echo $__env->make('layouts.answer_entry_footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

