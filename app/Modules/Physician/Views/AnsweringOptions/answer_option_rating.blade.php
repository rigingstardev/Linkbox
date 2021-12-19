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
 <?php /*<div class=" pdng-0 pdng-0 q-edit mrgn-btm-15 mrgn-tp-15">
  [CC]  <input class="form-control width-dynamic proba dva"  placeholder="is rated to be on the scale of"> 
   <select id="basic" class="selectpicker show-tick col-sm-1">
      @for($i=10;$i>=7;$i--)
      <option value="{{$i}}">{{$i}}</option>
      @endfor
   </select>.
</div>*/?>
</div>
<div class="clearfix"></div>
@include('layouts.answer_entry_footer') 
<!--<div class=" narrative-edit mrgn-btm-20">
   <p><b>Narrative Output : </b>[CC] is rated to be on the scale of [X].</p>
</div>-->
