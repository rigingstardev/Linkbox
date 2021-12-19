<div class="col-md-3 pdng-0 mrgn-btm-15">
    <select id="basic_<?php echo $qSets->id; ?>" class="selectpicker show-tick form-control <?php echo $clinicalCls; ?>" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>]">
        <option value="">Select</option>
        <?php if($qSets->defaultOptions): ?>         
            <?php $__currentLoopData = $qSets->defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $defaultOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>           
                <?php if($defaultOpt->question_category_id == $qSets->id): ?>
                    <option value="<?php echo $defaultOpt->id; ?>" <?php if($CurAnswer[$qSets->id][$qSets->category_id] == $defaultOpt->id): ?> selected <?php endif; ?> ><?php echo $defaultOpt->default_option; ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select>           
</div>
<div class="col-md-3"> 
    <input id="basic_<?php echo $qSets->id; ?>" type="text" value="<?php echo $CurDesc[$qSets->id][$qSets->category_id]; ?>"  class="form-control <?php echo $clinicalCls; ?>" name="description[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>]" >
</div>