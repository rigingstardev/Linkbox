<?php /* @foreach($result as $ques)
  <div class="radio radio-info">
  <input type="radio" id="question_opt_1" value="1" name="rdbQuestion"  checked="" onclick="enableDisableTextbox('disable')">
  <label for="question_opt_1"><span id="serialNo"></span> @if($optionFlag==1){{$ques->question}}@else {{$defaultQustionOfAnswerType->question}} @endif</label>
  <input type="hidden" name="question" id="question" value="{{$ques->question}}" >
  </div>
  @endforeach
  <div class="radio radio-info question-calendar mrgn-btm-25">
  <!--<input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')"> When did [CC] begin?-->
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
  </div>
 */ ?>

<?php echo $__env->make('layouts.answer_entry_options', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

<?php $defaultOption = ''; ?>
<?php $__currentLoopData = $categoryOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($opt->option_status ==1): ?>
<?php $defaultOption = $opt->default_option ?>
<?php endif; ?>
<!--end option status if-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-------------------          question header section ------------------------>
<?php // echo "-------$optionFlag --$option-----$defaultOption----"  ; ?>
<?php if($optionFlag == 0 && $option == 'dateT' ): ?>
<?php $defaultOption = 'both'; ?>
<?php endif; ?>
<!--onclick="setNarrativeOutput(this.value ,<?php echo e($rid); ?>)"-->
<input type="hidden" id="inlineRadioDate" value="date" name="radioInline"   >
<div class="col-xs-12 input-group datepicker-control max-width-306">
   <input type="hidden" required="" class="date-picker form-control" name="txtDate" id="txtDate">
   <!--<span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>-->
</div>
<!--</div>-->
<div class="clearfix"></div>
<!--<div class="radio radio-info question-calendar">
 
   <input type="radio" id="inlineRadioDate" value="date" name="radioInline" onclick="setNarrativeOutput(this.value ,<?php echo e($rid); ?>)" <?php if($defaultOption =='date'): ?> <?php echo e('checked'); ?> <?php endif; ?> >
          <label for="inlineRadioDate" class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
      <div class="col-xs-12 input-group datepicker-control max-width-306">
         <input type="text" required="" class="date-picker form-control" name="txtDate" id="txtDate">
         <span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>
      </div>
   </label>
</div>
<div class="clearfix"></div>
<div class="radio">
   <input type="radio" id="inlineRadioTime" value="time" name="radioInline" onclick="setNarrativeOutput(this.value ,<?php echo e($rid); ?>)"  <?php if($defaultOption =='time'): ?> <?php echo e('checked'); ?> <?php endif; ?>>
          <label for="inlineRadioTime" class="pull-left"> Approximate Time Frame </label>
   <div class="clearfix"></div>
   <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 time-set pdng-0">
      <div class="col-sm-6 time-set-hrs"><select id="basic" class="selectpicker show-tick">
            <?php for($i=10;$i>=7;$i--): ?>
            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
            <?php endfor; ?>
         </select></div>

      <div class="col-sm-6 time-set-min"><select id="basic" class="selectpicker show-tick">
            <?php for($i=10;$i>=7;$i--): ?>
            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
            <?php endfor; ?>
         </select>
      </div>
   </div>
</div>-->
<!--<span class="ago pdng-lft-15 pdng-tp-3">Ago</span>-->
<!--<div class="pdng-tp-3">
   <div class="radio radio-info">
      <input type="radio" id="inlineRadioBoth" value="both" name="radioInline"  onclick="setNarrativeOutput(this.value ,<?php echo e($rid); ?>)" <?php if($defaultOption =='both'): ?> <?php echo e('checked'); ?> <?php endif; ?>>
             <label for="inlineRadioBoth"> Both</label>
   </div>
</div>-->
<div class="clearfix"></div>

</div>
<?php echo $__env->make('layouts.answer_entry_footer', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script>// setNarrativeOutput("<?php echo e($defaultOption); ?>", <?php echo e($rid); ?>);</script>