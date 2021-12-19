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
@include('layouts.answer_entry_options')
<!-------------------          question header section ------------------------>
</div>
<div class="clearfix"></div>
<?php $k             = 1 ?>
@if(count((array)$categoryOptions)>0)
@foreach($categoryOptions as $opt)
<?php
$defaultOption = '';
if ($opt->default_option != 'date' && $opt->default_option != 'time'&& $opt->default_option != 'both')
    $defaultOption = $opt->default_option
    ?>
<div class="checkbox radio-info q-edit-check mrgn-btm-25" id="dropDownOption{{'-'.$rid.'-'.$k}}">
   <input id="dropDownOptionCheck{{'-'.$rid.'-'.$k}}" name="dropDownOptionCheck{{'-'.$rid.'-'.$k}}"  value="{{$opt->id}}" type="checkbox" @if($opt->option_status==1) {{'checked'}} @endif>
          <label for="dropDownOptionCheck{{'-'.$rid.'-'.$k}}" class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
      <div class="col-xs-11 pdng-lft-0 check-edit-input">
         <input type="text"class="form-control" name="txtOption{{'-'.$rid.'-'.$k}}" id="txtOption{{'-'.$rid.'-'.$k}}"  placeholder="{{$defaultOption}}" value="{{$defaultOption}}">
         <input type="hidden"class="form-control" name="hiddenOption{{'-'.$rid.'-'.$k}}" id="hiddenOption{{'-'.$rid.'-'.$k}}" value="{{$defaultOption}}">
         <input type="hidden"class="form-control" name="hiddenID{{'-'.$rid.'-'.$k}}" id="hiddenID{{'-'.$rid.'-'.$k}}" value="{{$opt->id}}">
      </div>
      <div class="col-xs-1 pdng-0">
         @if($k==1)
         <a href="javascript:void(0)" class="add-icon" onclick="manageCheckbox('add',{{$rid}}, {{$k}})"><i class="fa fa-plus-square" ></i></a>
         @else
         <a href="javascript:void(0)" class="txt-red delete-icon" onclick="manageCheckbox('dbdelete',{{$rid}}, {{$k}})"><i class="fa fa-times"></i></a>
         @endif
      </div>
   </label>
   <div class="clearfix"></div>
</div>
<?php $k++ ?>
@endforeach
@else
<div class="checkbox radio-info q-edit-check mrgn-btm-25" id="dropDownOption{{'-'.$rid.'-'.$k}}">
   <input id="dropDownOptionCheck{{'-'.$rid.'-'.$k}}" name="dropDownOptionCheck{{'-'.$rid.'-'.$k}}" checked value="1" type="checkbox" >
   <label for="dropDownOptionCheck{{'-'.$rid.'-'.$k}}" class="col-xs-12 col-sm-8 col-md-6 col-lg-5">
      <div class="col-xs-11 pdng-lft-0 check-edit-input">
         <input type="text"class="form-control" name="txtOption{{'-'.$rid.'-'.$k}}" id="txtOption{{'-'.$rid.'-'.$k}}"  placeholder="" value="">
         <input type="hidden"class="form-control" name="hiddenOption{{'-'.$rid.'-'.$k}}" id="hiddenOption{{'-'.$rid.'-'.$k}}" value="">
         <input type="hidden"class="form-control" name="hiddenID{{'-'.$rid.'-'.$k}}" id="hiddenID{{'-'.$rid.'-'.$k}}" value="">
      </div>
      <div class="col-xs-1 pdng-0">
         @if($k==1)
         <a href="javascript:void(0)" class="add-icon" onclick="manageCheckbox('add',{{$rid}}, {{$k}})"><i class="fa fa-plus-square" ></i></a>
         @else
         <a href="javascript:void(0)" class="txt-red delete-icon" onclick="manageCheckbox('dbdelete',{{$rid}}, {{$k}})"><i class="fa fa-times"></i></a>
         @endif
      </div>
   </label>
   <div class="clearfix"></div>
</div>
<?php $k++ ?>
@endif
<input type="hidden" name="dropDownOptionCount{{$rid}}" id="dropDownOptionCount{{$rid}}" value="{{($k-1)}}" >
<input type="hidden" name="dropDownOptionCheckBoxCount{{$rid}}" id="dropDownOptionCheckBoxCount{{$rid}}" value="" >

<br>
@include('layouts.answer_entry_footer')
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

