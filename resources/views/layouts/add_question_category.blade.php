<div class="modal-dialog modal-lg" role="document">
   <div class="modal-content">
      {!! Form::open(['role' => 'form', 'name' => 'frmCategory', 'url'=>'physician/editCategory', 'id' => 'frmCategory','autocomplete' => 'off']) !!}
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" <span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel">Add Question categories to the Question Set.</h4>
      </div>
      <div class="modal-body">
         <?php
         $selectedList                         = array();
         $selectedQuestions                    = array();
         $newQuestion                          = array();
         $cId                                  = '';
         ?>
         <!--------- start selected questions and category list ------------>
         @if(count($selectedCategories)>0)
         @foreach ($selectedCategories as $row)
         <?php
         $cId                                  = $row->category_id;
         $masterID                             = $row->master_question_id;
         // selected categories
         $selectedList[]                       = $cId;
         // selected quetsion id
         $selectedQuestions[]                  = $row->master_question_id;
         $selectedQuestions['question'][$cId]  = $row->question;
         $newQuestion[$cId . '--' . $masterID] = $row->question;
         // selected quetsion by category
         $selectedQuestions['cID'][$cId][]     = $row->master_question_id;
         ?>
         @endforeach
         @endif


         <!--------- end selected questions and category list ------------>
         <!--************-->
         <!--------- start master questions and category list ------------>
         <?php $qcount                               = 0; ?>
         @if(count($masterQuestions)>0)
         @foreach ($masterQuestions as $row)

         <?php
         // master quetsion details
         $cId                                  = $row->category_id;
         // master quetsion id by category
         $masterQuestionsList['qid'][$cId][]   = $row->id;
         // master quetsion by category
         $masterQuestionsList[$cId][]          = $row->question;
         // mapping question with its master id
         $questionWithId[$cId][$row->question] = $row->id;
         // $masterQuestionsList[]         = $row->question;
         $qcount++;
         ?>
         @endforeach
         @endif
         <!--------- end master questions and category list ------------>
         <!--------- start master   category list and selected questions ------------>
 
         @if(count($categories)>0)
         @foreach($categories as $category)
         <div class="col-sm-12 mrgn-btm-20">
            <div class="checkbox @if(in_array($category->id, $selectedList)) {{'disable-check'}}@endif " >
               <input id="category{{$category->id}}" onclick="selectOrDeselectQuestions({{$category->id}}, 'category', 0)"  name="category{{$category->id}}"  @if(in_array($category->id, $selectedList)) {{'checked'}} {{'disabled'}} @endif type="checkbox" value="{{$category->id}}" @if($category->id == 10) {{'class=other-catgy'}}@endif>
                      <label for="category{{$category->id}}"> {{ $category->category}}</label></div>
         </div>

         <!--------- start selected category list and selected questions ------------>
         @if(count($masterQuestionsList[$category->id])>0)
         @for($k=0;$k<count($masterQuestionsList[$category->id]); $k++)
            <?php
            $masterQuesId                         = $masterQuestionsList['qid'][$category->id][$k];
            $masterQuestion                       = $masterQuestionsList[$category->id][$k];
            $masterQID                            = $questionWithId[$category->id][$masterQuestion];
            // checking if the question is in selected category. if so it will show the selected question else default question
            if (key_exists($category->id . '--' . $masterQID, $newQuestion))
                $displayQuestion                      = $newQuestion[$category->id . '--' . $masterQID];
            else
                $displayQuestion                      = $masterQuestion;
            ?>

            <div class="col-sm-12 mrgn-btm-20 mrgn-lft-25 ">
               <!--div with chcking if the category is selected, if so disabling the chckbox inside-->
               <div class="checkbox @if(in_array($category->id, $selectedList)) {{'disable-check'}}@endif ">
                  <input class="question-{{$category->id}} @if( $category->id ==10) {{'other-catgy'}} @endif"  onclick="selectOrDeselectQuestions({{$category->id}}, 'masterQuestion', {{$masterQuesId}})" id="masterQuestion{{$masterQuesId}}"   name="masterQuestion{{$masterQuesId}}"
                         @if(in_array($masterQuesId, $selectedQuestions)) {{'checked'}} {{'disabled'}} @endif type="checkbox" value="{{$masterQuesId}}" >
                         @if( $category->id ==10)
                         <div class="col-sm-12 col-lg-6" id="div_other_question">
                     <input type='text' class="form-control div_other_question @if(!key_exists($category->id . '--' . $masterQID, $newQuestion)) {{'hidden'}} @endif" id="other_question" name="other_question" maxlength="255" placeholder="{{$displayQuestion}}" value="{{$displayQuestion}}" @if(key_exists($category->id . '--' . $masterQID, $newQuestion)) {{'disabled'}} @endif>
                  </div>
                  <!--else of the category >id == 10-->
                  @else
                  <label for="masterQuestion{{$masterQuesId}}"> {{$displayQuestion}}</label>
                  <!--end if ------ checking the category >id == 10-->
                  @endif
               </div>
            </div>
            @endfor
            @endif

            <!--------- end selected category list and selected questions ------------>
            <input type="hidden" id="masterQuestionsCount-{{$category->id}}" name="masterQuestionsCount-{{$category->id}}" value="{{count($masterQuestionsList[$category->id])}}" >
            <?php
            $selQuesCount                         = 0;

            if (key_exists('cID', $selectedQuestions) && key_exists($category->id, $selectedQuestions['cID']))
                $selQuesCount = count($selectedQuestions['cID'][$category->id]);
            else
                $selQuesCount = 0;
            ?>
            <input type="hidden" id="selectedQuestionsCount-{{$category->id}}" name="masterQuestionsCount-{{$category->id}}" value="{{$selQuesCount}}" >


            @endforeach
            @endif
            <!--------- end master   category list and selected questions ------------>
            <div class="clearfix"></div>
<!--                           <input type="hidden" id="chiefComplaint" name="chiefComplaint" value="1" >
            <input type="hidden" id="description" name="description" value="1" >-->
            <input type="hidden" id="requestType" name="requestType" value="category" >
            <input type="hidden" id="qid" name="qid" value="{{$id}}" >
            <input type="hidden" id="category" name="category" value="" >
            <input type="hidden" id="checkFormatType" name="checkFormatType" value="" >
            <input type="hidden" id="categoryCount" name="categoryCount" value="{{($qcount)}}" >
            <input type="hidden" id="totalSelectedCategoryCount" name="totalSelectedCategoryCount" value="{{count($selectedQuestions)}}" >
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary update-category-list" title="Done">Done</button>
            </div>
            {!! Form::close() !!}
      </div>
   </div>