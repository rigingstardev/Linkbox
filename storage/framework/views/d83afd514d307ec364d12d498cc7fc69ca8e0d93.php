<!--<div class="radio radio-info question-calendar mrgn-btm-25">
   <input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')">
   <label for="question_opt_2">
      <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 time-set pdng-0">
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="When did" id="labelQuestionPart1" name="labelQuestionPart1" disabled=""></div>
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="[CC]" >
         <span class="ago pull-left pdng-tp-7 pdng-rgt-15" >[CC]</span>
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="Start"  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>
         <span class="ago pull-left pdng-tp-7">?</span>
         <input id="labelQuestionPart4" name="labelQuestionPart4" type="hidden" value="?" >
      </div>
   </label>
   <div class="clearfix"></div>
</div>-->
<?php echo $__env->make('layouts.answer_entry_options', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-------------------          question header section ------------------------>
</div>
<div class="clearfix"></div>
<?php $k             = 1 ?>
<?php if(count((array)$categoryOptions)>0): ?>
<?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$defaultOption = '';
if ($opt->default_option != 'date' && $opt->default_option != 'time'&& $opt->default_option != 'both')
    $defaultOption = $opt->default_option
    ?>
<div class="checkbox radio-info q-edit-check mrgn-btm-25" id="dropDownOption<?php echo e('-'.$rid.'-'.$k); ?>">
   <input id="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>" name="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>"  value="<?php echo e($opt->id); ?>" type="checkbox" <?php if($opt->option_status==1): ?> <?php echo e('checked'); ?> <?php endif; ?>>
          <label for="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>" class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
      <div class="col-xs-11 pdng-lft-0 check-edit-input">
         <input type="text"class="form-control" name="txtOption<?php echo e('-'.$rid.'-'.$k); ?>" id="txtOption<?php echo e('-'.$rid.'-'.$k); ?>"  placeholder="<?php echo e($defaultOption); ?>" value="<?php echo e($defaultOption); ?>">
         <input type="hidden"class="form-control" name="hiddenOption<?php echo e('-'.$rid.'-'.$k); ?>" id="hiddenOption<?php echo e('-'.$rid.'-'.$k); ?>" value="<?php echo e($defaultOption); ?>">
         <input type="hidden"class="form-control" name="hiddenID<?php echo e('-'.$rid.'-'.$k); ?>" id="hiddenID<?php echo e('-'.$rid.'-'.$k); ?>" value="<?php echo e($opt->id); ?>">
      </div>
      <div class="col-xs-1 pdng-0">
         <?php if($k==1): ?>
         <a href="javascript:void(0)" class="add-icon" onclick="manageCheckbox('add',<?php echo e($rid); ?>, <?php echo e($k); ?>)"><i class="fa fa-plus-square" ></i></a>
         <?php else: ?>
         <a href="javascript:void(0)" class="txt-red delete-icon" onclick="manageCheckbox('dbdelete',<?php echo e($rid); ?>, <?php echo e($k); ?>)"><i class="fa fa-times"></i></a>
         <?php endif; ?>
      </div>
   </label>
   <div class="clearfix"></div>
</div>
<?php $k++ ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
<div class="checkbox radio-info q-edit-check mrgn-btm-25" id="dropDownOption<?php echo e('-'.$rid.'-'.$k); ?>">
   <input id="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>" name="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>" checked value="1" type="checkbox" >
   <label for="dropDownOptionCheck<?php echo e('-'.$rid.'-'.$k); ?>" class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
      <div class="col-xs-11 pdng-lft-0 check-edit-input">
         <input type="text"class="form-control" name="txtOption<?php echo e('-'.$rid.'-'.$k); ?>" id="txtOption<?php echo e('-'.$rid.'-'.$k); ?>"  placeholder="" value="">
         <input type="hidden"class="form-control" name="hiddenOption<?php echo e('-'.$rid.'-'.$k); ?>" id="hiddenOption<?php echo e('-'.$rid.'-'.$k); ?>" value="">
         <input type="hidden"class="form-control" name="hiddenID<?php echo e('-'.$rid.'-'.$k); ?>" id="hiddenID<?php echo e('-'.$rid.'-'.$k); ?>" value="">
      </div>
      <div class="col-xs-1 pdng-0">
         <?php if($k==1): ?>
         <a href="javascript:void(0)" class="add-icon" onclick="manageCheckbox('add',<?php echo e($rid); ?>, <?php echo e($k); ?>)"><i class="fa fa-plus-square" ></i></a>
         <?php else: ?>
         <a href="javascript:void(0)" class="txt-red delete-icon" onclick="manageCheckbox('dbdelete',<?php echo e($rid); ?>, <?php echo e($k); ?>)"><i class="fa fa-times"></i></a>
         <?php endif; ?>
      </div>
   </label>
   <div class="clearfix"></div>
</div>
<?php $k++ ?>
<?php endif; ?>
<input type="hidden" name="dropDownOptionCount<?php echo e($rid); ?>" id="dropDownOptionCount<?php echo e($rid); ?>" value="<?php echo e(($k-1)); ?>" >
<input type="hidden" name="dropDownOptionCheckBoxCount<?php echo e($rid); ?>" id="dropDownOptionCheckBoxCount<?php echo e($rid); ?>" value="" >

<br>
<?php echo $__env->make('layouts.answer_entry_footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php /*
  <div class=" narrative-edit mrgn-btm-20">
  <p id="div-show-narrative-output"><b>Narrative Output : </b>
  @foreach ($result as $ques)
  {{$ques->narrative_output}}
  @endforeach
  </p>
  <p class="mrgn-tp-20">
  @if(count($narrativeOutput)> 0)
  @foreach($narrativeOutput as $outout)
  <!--check to display text box content-->
  @if($outout->display_in_textbox==0)
  {{ $outout->display_text}}
  <input type="hidden" id="narrativeOut{{$outout->display_order}}" name="narrativeOut{{$outout->display_order}}" value="{{$outout->display_text}}"/>
  @elseif($outout->display_in_textbox==1)
  <input type="text" class="form-control width-dynamic proba dva" id="narrativeOut{{$outout->display_order}}" name="narrativeOut{{$outout->display_order}}" placeholder="{{$outout->display_text}}" value="{{$outout->display_text}}"/>
  @endif
  @endforeach
  @endif
  <input type="hidden" id="narrativeOutCount" name="narrativeOutCount" value="{{$outout->display_order}}"/>
  </p>
  </div> */ ?>

