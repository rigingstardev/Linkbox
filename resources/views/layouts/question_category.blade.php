<?php
$i                = 0;
$prevRowId        = 0;
$prevMainQuestion = '';
?>
<!--    start  foreach ( $selectedCategories as $row)       -->
@foreach ( $selectedCategories as $row) 
<!--// checking for the question is subquestion for yes / no type question-->
<?php
$i++;
$isMainQuestion   = $row->ans_question_category_id;
$isMainQuestionDisabled   ='';
// getting the question status. checking whether parent the question is disabled or not
if(is_null($isMainQuestion))
$isMainQuestionDisabled   = $row->quest_status;
?>

<div class="content-sub mrgn-btm-15 pdng-0  @if($row->created_via=='C') {{'unread'}} @endif" id="view-question-settings-{{$row->id}}" >
   <div class="content-sub-heading @if(!is_null($isMainQuestion)){{'unread'}}@endif ">
      <div class="col-sm-12">
         <!--   start if(is_null($isMainQuestion))   show category for the main questions only.-->
         @if(is_null($isMainQuestion)) 
         <?php $prevMainQuestion = $i; //replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc'); ?>
         <b>{{$row->category}}</b>
         @else
         <b >{{'Next Question to ask if the answer of "Question '.$prevMainQuestion.'"  is '.$row->ans_option.':'}}</b>
         @endif
         <!--   end if(is_null($isMainQuestion))   show category for the main questions only.-->

         <!--    start  if(Request::segment(1) != 'admin')        -->
         @if(Request::segment(1) != 'admin') 

         <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
         @if(!in_array($row->id, $yesNoSubQuestions))
         <a href="javascript:void(0)" id="delete-{{$row->id}}" class="edit pull-right delete-question remove-tooltip" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete" onclick="setQuestionFlags('delete',{{$row->id}},{{$row->category_id}},{{$row->question_id}})"><i class="fa fa-trash-o" ></i></a> 
         @endif
         <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->

         @endif
         <!--    end  if(Request::segment(1) != 'admin')        -->
         <!--if(is_null($isMainQuestion))-->
      </div>
      <div class="clearfix"></div>
   </div>
   <!--endif-->
   <div class="content-area-sub">
      <div class="col-sm-12 mrgn-btm-15">
         <!-- checking for login type-->
         <!--    start  if(Request::segment(1) != 'admin')        -->

         @if(Request::segment(1) != 'admin')
         <div class="btn-group question-options">
            <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
            @if(!in_array($row->id, $yesNoSubQuestions))
            <div class="btn clinical-q">
               <div class="checkbox">
                  <input type="checkbox" class="@if($row->clinical_question==1){{'checked clinical-question'}}@endif" id="clinicalQuestion{{$row->id}}" name="clinicalQuestion{{$row->id}}" value="{{$row->category_id}}" onclick="setQuestionFlags('clinicalQuestion',{{$row->id}},{{$row->category_id}},{{$row->question_id}})" @if($row->clinical_question==1) {{'checked'}}@endif ><label for="clinicalQuestion{{$row->id}}">Clinical Question</label>
               </div>
            </div>
            @endif
            <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
           
            <button type="button" class="btn remove-tooltip" data-toggle="tooltip" data-placement="top" title="Edit" id="edit-question-{{$row->category_id}}" onclick="editQuestionSettings({{$row->id}},{{$row->category_id}},{{$row->question_id}}, {{$i}},'{{$row->answer_method}}')"><i class="fa fa-pencil-square-o" ></i></button>
            <!--    start  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->
            @if(!in_array($row->id, $yesNoSubQuestions))
            <button type="button" class="btn remove-tooltip"   data-toggle="tooltip" data-placement="top" @if($row->quest_status==1) {{'title=Enabled'}}@else  {{'title=Disabled'}} @endif  onclick="setQuestionFlags('disable',{{$row->id}},{{$row->category_id}},{{$row->question_id}})" id="question-status-{{$row->id}}"><i class="fa fa-ban" id="disabled-{{$row->id}}" @if($row->quest_status != 1) {{'style=color:#ccc;'}} @endif   ></i></button>
            <button type="button" class="btn remove-tooltip" data-toggle="tooltip" data-placement="top" title="Copy" onclick="setQuestionFlags('copy',{{$row->id}},{{$row->category_id}},{{$row->question_id}})"><i class="fa fa-files-o"></i></button>
            @endif
            <!--    end  if(!in_array($row->id, $yesNoSubQuestions))  // checking for the question is sub question of Yes/No type question    -->

         </div>
         @endif
         <!--    end  if(Request::segment(1) != 'admin')        -->

         @include('layouts.answer_options')

         <!--    start  if($row->answer_method !='mcq')        -->
         @if($row->answer_method !='mcq')
      </div>
      @endif
      <!--    end  if($row->answer_method !='mcq')        -->
      <div class="clearfix"></div>
      <div class="col-sm-12">
         <b class="mrgn-btm-10 display-block">Narrative Output</b>
         <p><?php echo str_replace('[CC]', $questionSet->title, $row->narrative_output_p1); ?></p>
      </div> 
   </div> 
   <!--if(is_null($isMainQuestion))-->
</div>
<!--endif-->
<div class="content-sub mrgn-btm-15 pdng-0 hidden" id="edit-question-settings-{{$row->id}}" >edit-question-settings-{{$row->id}}</div>
<input type="hidden" id="prevAnsMethod{{$row->id}}" name="prevAnsMethod{{$row->id}}" value="{{$row->answer_method}}" >
@endforeach 