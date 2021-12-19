<input id="basic_<?php echo $qSets->id; ?>" type="hidden" value="" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>]" >
<?php if($qSets->defaultOptions): ?>  
    <?php
     if('Y' == $qSets->allow_multiple_answer)                   
        $checkboxArr = unserialize($CurAnswer[$qSets->id][$qSets->category_id]);       
     else
        $checkboxArr = $CurAnswer[$qSets->id][$qSets->category_id];
     ?>   
    
    <?php $__currentLoopData = $qSets->defaultOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $defaultOpt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>           
        <?php if($defaultOpt->question_category_id == $qSets->id): ?>
            <?php $checked = false; 
                if(is_array($checkboxArr)) {
                    if (in_array($defaultOpt->id,$checkboxArr))
                        $checked = true;
                }else {
                    if ($defaultOpt->id == $checkboxArr)
                        $checked = true;
                }
             ?>
            <div class="col-sm-12 mrgn-btm-10">   
                <?php if('Y' == $qSets->allow_multiple_answer): ?>
                <div class="checkbox">
                    <?php echo e(Form::checkbox("answer[$qSets->id][$qSets->category_id][$defaultOpt->id]", 1, $checked,['id'=>"checkbox2_$defaultOpt->id",'class'=>"$clinicalCls"])); ?>                  
                    <label for="checkbox2_<?php echo $defaultOpt->id; ?>">
                        <?php echo $defaultOpt->default_option; ?>

                    </label>
                </div>
                <?php else: ?>
                <div class="radio">
                    <?php echo e(Form::radio("answer[$qSets->id][$qSets->category_id]", $defaultOpt->id, $checked,['id'=>"radio2_$defaultOpt->id",'class'=>"$clinicalCls"])); ?>                  
                    <label for="radio2_<?php echo $defaultOpt->id; ?>">
                        <?php echo $defaultOpt->default_option; ?>

                    </label>
                </div>
                <?php endif; ?>  
             </div> 
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>        
        <input id="basic_<?php echo $qSets->id; ?>" type="text" value="<?php echo $CurDesc[$qSets->id][$qSets->category_id]; ?>" class="form-control <?php echo $clinicalCls; ?>" name="description[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>]" >            
   
<?php endif; ?>