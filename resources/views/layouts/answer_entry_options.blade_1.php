@foreach($result as $ques)
<div class="radio radio-info">
   <input type="radio" id="question_opt_1" value="1" name="rdbQuestion"  checked="" onclick="enableDisableTextbox('disable')">
   <label for="question_opt_1">
      <span id="serialNo{{$rid}}"></span> 
      @if($optionFlag==1){{$ques->question}}@else {{$defaultQustionOfAnswerType->question}} @endif</label>
   <input type="hidden" name="question" id="question" value="{{$ques->question}}" >
</div>
@endforeach
<div class="radio radio-info question-calendar mrgn-btm-25">
  <!--<input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')"> When did [CC] begin?-->
   <label for="question_opt_2">
      <div class="col-xs-12 col-sm-10 col-md-6 col-lg-4 time-set pdng-0">
         <input type="radio" id="question_opt_2" value="2" name="rdbQuestion" onclick="enableDisableTextbox('enable')">
         @if($answer_method == 'dateT')
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="When did" id="labelQuestionPart1" name="labelQuestionPart1" disabled=""></div>
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="[CC]" >
         <span class="ago pull-left pdng-tp-7 pdng-rgt-15" >[CC]</span>
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="Start"  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>
         <span class="ago pull-left pdng-tp-7">?</span>
         <input id="labelQuestionPart4" name="labelQuestionPart4" type="hidden" value="?" >
         @endif

         @if($answer_method == 'mcq' || $answer_method == 'dropDown')
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="Does anything make the "  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>.
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="Does anything make the " >
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="[CC]" >
         <span class="ago pull-left pdng-tp-7 pdng-rgt-15" >[CC]</span>
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder="worse"  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>
         <span class="ago pull-left pdng-tp-7">worse ?</span>
         @endif
         @if($answer_method == 'rating')
         <div class="col-sm-5 pdng-lft-0">
            <input class="form-control" placeholder="How would you like to rate your sickness level?"  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>.
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="How would you like to rate your sickness level?" >
         @endif

         @if($answer_method == 'textBox')
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder=" Where exactly is the "  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>.
         <input id="labelQuestionPart2" name="labelQuestionPart2" type="hidden" value="[CC]" >
         <span class="ago pull-left pdng-tp-7 pdng-rgt-15" >[CC]</span>
         <div class="col-sm-5 pdng-lft-0"><input class="form-control" placeholder=" located? "  id="labelQuestionPart3" name="labelQuestionPart3" disabled=""></div>
         @endif
      </div>
   </label>
   <div class="clearfix"></div>
</div>
<!--end displaying quetion section-->
<p><b>Answering Method</b></p>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 time-set pdng-0 mrgn-tp-15 @if($answer_method == 'mcq' || $answer_method == 'dropDown') {{'mrgn-btm-25'}} @else {{'mrgn-btm-10'}} @endif min-w" >
   <select id="answeringMethod{{$rid}}" name="answeringMethod{{$rid}}" class="selectpicker show-tick " onchange="showAnswerOption(this.value, {{$rid}}, {{$qid}})">
      <option value="dateT" @if($answer_method == 'dateT') {{ 'selected=selected'}} @endif>Date & Time</option>
      <option value="dropDown"  @if($answer_method == 'dropDown') {{ 'selected=selected'}} @endif>Dropdown</option>
      <option value="mcq"  @if($answer_method == 'mcq') {{ 'selected=selected'}} @endif>Multiple choice</option>
      <option value="rating"  @if($answer_method == 'rating') {{ 'selected=selected'}} @endif>Rating</option>
      <option value="textBox"  @if($answer_method == 'textBox') {{ 'selected=selected'}} @endif>Textbox</option>
   </select>
</div>
<input type="hidden" id="prevAnsweringMethod{{$rid}}" name="prevAnsweringMethod{{$rid}}" value="{{$answer_method}}" >
<div class="clearfix"></div>