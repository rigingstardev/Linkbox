<?php
$comboAnswer = unserialize($CurAnswer[$qSets->id][$qSets->category_id]);
$ans2 = "";
if ($qSets->defaultOptions)  {       
      foreach ($qSets->defaultOptions as $defaultOpt)  {         
          if ($defaultOpt->question_category_id == $qSets->id){
               $ans2 =  $defaultOpt->default_option;
          }  
      }
}
?>
<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5"> 
   <div class="col-sm-2  pdng-lft-0 ">
      <select id="1_basic_<?php echo $qSets->id; ?>" onchange="changeOptions(this.value, <?php echo e($qSets->id); ?>)" class="selectpicker show-tick form-control <?php echo $clinicalCls; ?>" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>][3combo][1]">
         <option value=''>[Select]</option>
         <?php for($i=1; $i<=100;$i++): ?>
         <?php $selOption   = ($i == $comboAnswer[0]) ? 'selected=selected' : ""; ?>
         <option value="<?php echo e($i); ?>" <?php echo $selOption; ?> ><?php echo e($i); ?></option>
         <?php endfor; ?>
      </select>
   </div>  
   <div class="col-sm-2">
      <select id="2_basic_<?php echo $qSets->id; ?>" class="selectpicker show-tick form-control <?php echo $clinicalCls; ?>" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>][3combo][2]">
         <option value=''>[Select]</option>
         <option value="Years" <?php if('Years' == $comboAnswer[1]): ?> <?php echo 'selected=selected'; ?> <?php endif; ?> >Years</option>
         <option value="Months" <?php if('Months' == $comboAnswer[1]): ?> <?php echo 'selected=selected'; ?> <?php endif; ?> >Months</option>
         <option value="Weeks" <?php if('Weeks' == $comboAnswer[1]): ?> <?php echo 'selected=selected'; ?> <?php endif; ?> >Weeks</option>
         <option value="Days" <?php if('Days' == $comboAnswer[1]): ?> <?php echo 'selected=selected'; ?> <?php endif; ?> >Days</option>
         <option value="Hours" <?php if('Hours' == $comboAnswer[1]): ?> <?php echo 'selected=selected'; ?> <?php endif; ?> >Hours</option>
      </select>
   </div>
   <div class="col-sm-2">
      <?php if(!empty($ans2)): ?>
         <label class="mrgn-btm-5 pdng-lft-0 mrgn-tp-5"><?php echo $ans2; ?></label>
         <input id="3_basic_<?php echo $qSets->id; ?>" type="hidden" value="<?php echo $ans2; ?>"   class="form-control" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>][3combo][3]" >
      <?php else: ?>
         <input id="3_basic_<?php echo $qSets->id; ?>" type="text" value="<?php echo $comboAnswer[2]; ?>"   class="form-control <?php echo $clinicalCls; ?>" name="answer[<?php echo $qSets->id; ?>][<?php echo $qSets->category_id; ?>][3combo][3]" >
      <?php endif; ?>
   </div>
</div>