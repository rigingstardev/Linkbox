<?php
//echo "<pre>";
//print_r($result);
//exit;
?>
@if(count($result) > 0)
@foreach($result as $ques)
<?php
$questionSegs = explode('[CC]', $ques->question);
print_r($questionSegs);
?>
<div class="">
   <!--radio radio-info-->
   <!--<input type="radio" id="question_opt_1" value="1" name="rdbQuestion"  checked="" onclick="enableDisableTextbox('disable')">-->
   <p for="question_opt_1">
      <?php $question     = ''; ?>
      <span id="serialNo{{$rid}}"></span>
      <!--@if($optionFlag==1)-->
      <?php // $question = $ques->question    ?>
      <!--@else-->
      <!--@if(count($ques)>0)-->
<?php // $question = $ques->question    ?>
      <!--@endif-->
      <!--@endif-->
      <span id="span-question-segment-{{$rid}}">{{$questionSegs[0]}}<?php echo replaceTextWithActualValue('', '[CC]', $questionSet->title, '[CC]', 'cc') ?>@if(count($questionSegs)>1){{$questionSegs[1]}}@endif</span>
<!--      <span id="question-seg-2"></span>
      <span id="question-seg-3"></span>-->
<?php //echo replaceTextWithActualValue('', '[CC]', $questionSet->title, $ques->question, 'cc')   ?>
<?php echo showQusetionCategoryComments($ques->comments, '') ?>
   </p><div class="clearfix"></div>
   <input type="hidden" name="question" id="question" value="{{$ques->question }}" >

</div> <div class="clearfix"></div>
@endforeach
@endif

<div class=" question-calendar mrgn-tp-15 mrgn-btm-15">
   <!--radio radio-info-->
   <!--<input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')">-->
   <p for="question_opt_2" class="col-sm-4">
   <div class="col-sm-12 time-set pdng-0 ">

      <div class="col-sm-3 pdng-lft-0">
         <input class="form-control question-segment seg-{{$rid}}" placeholder="{{trim($questionSegs[0])}}" value="{{trim($questionSegs[0])}}" id="labelQuestionPart1" name="labelQuestionPart1" >
      </div>
      <?php
      $strCC        = '[CC]';
      $ccClass = '';
      if ($ques->category_id == 11){
          $strCC        = '';
          $ccClass = 'hidden';
      }
      ?>


      <input id="currentRowId" name="currentRowId" type="text" value="{{$rid}}" >
      <input id="labelQuestionPart2" name="labelQuestionPart2" type="text" value="{{$strCC}}" >
      <span class="ago pull-left pdng-tp-7 pdng-rgt-15" ><?php echo replaceTextWithActualValue('', $strCC, $questionSet->title, $strCC, 'cc') ?></span>
      <input class="question-segment seg-{{$rid}}" type="text" value="<?php echo replaceTextWithActualValue('', $strCC, $questionSet->title, $strCC, 'cc') ?>" >

      <div class="col-sm-3 pdng-lft-0">
         <input class="form-control question-segment seg-{{$rid}} {{$ccClass}}" placeholder="@if(count($questionSegs)>1){{trim($questionSegs[1])}}@endif"  value="@if(count($questionSegs)>1){{trim($questionSegs[1])}}@endif" id="labelQuestionPart3" name="labelQuestionPart3"  >
      </div>
   </div>
</p>
<div class="clearfix"></div>
</div>

<!--end displaying quetion section-->
<p><b>Answering Method</b></p>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 time-set pdng-0 mrgn-tp-15 @if($answer_method == 'mcq' || $answer_method == 'dropDown') {{'mrgn-btm-25'}} @else {{'mrgn-btm-10'}} @endif min-w" >
   <select id="answeringMethod{{$rid}}" name="answeringMethod{{$rid}}" class="selectpicker show-tick " onchange="showAnswerOption(this.value, {{$rid}}, {{$qid}}, {{$cid}})">
      <option value="dateT" @if($answer_method == 'dateT') {{ 'selected=selected'}} @endif>Date & Time</option>
      <option value="dropDown"  @if($answer_method == 'dropDown') {{ 'selected=selected'}} @endif>Dropdown</option>
      <option value="mcq"  @if($answer_method == 'mcq') {{ 'selected=selected'}} @endif>Multiple choice</option>
      <option value="rating"  @if($answer_method == 'rating') {{ 'selected=selected'}} @endif>Rating</option>
      <option value="textBox"  @if($answer_method == 'textBox') {{ 'selected=selected'}} @endif>Textbox</option>
   </select>
</div>
<input type="hidden" id="prevAnsweringMethod{{$rid}}" name="prevAnsweringMethod{{$rid}}" value="{{$answer_method}}" >
<div class="clearfix"></div>