@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1> {{$questionSets->title}} Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content" @if($questionSets->bg_image) style="background-image: url({{asset('uploads/question_set/' . $questionSets->bg_image)}})" @endif>

            <section class="content-sub-header">
         <h4 class="pull-left">
            <!--{{$questionSets->title}}--> 
            Questions <span class="txt-blue">{{count((array)$questionCategories)}}</span></h4>
      </section>

      <div class="content-sub mrgn-btm-20 mrgn-tp-10 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12">
               <b>{{$questionSets->title}}</b>
            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p>{{$questionSets->description}}</p>
            </div>
         </div>
      </div>
      <?php $i = 0 ?>
      @foreach ( $questionCategories as $row) <?php
      $i++;

      $isMainQuestion   = $row->ans_question_category_id;
      ?>
      <div class="content-sub mrgn-btm-20 pdng-0" id="view-question-settings-{{$row->id}}">
         <div class="content-sub-heading @if(!is_null($isMainQuestion)){{'unread'}}@endif ">
            <div class="col-sm-12"> 
               <!--   start if(is_null($isMainQuestion))   show category for the main questions only.-->
               @if(is_null($isMainQuestion)) 
               <?php $prevMainQuestion = $i; ?>
               <b><?php /* @if (Request::segment(2) =='questionSetPreview') {{$row->category->category}} @else {{$row->category}}@endif */ ?>
                  {{$row->category}} 
               </b> 
               @else
               <b>{{'Next Question to ask if the answer of "Question '.$prevMainQuestion.'"  is '.$row->ans_option.':'}}</b>
               @endif
               <!--   end if(is_null($isMainQuestion))   show category for the main questions only.-->


            </div>
            <div class="clearfix"></div>
         </div>
         <div class="content-area-sub">
            <div class="col-sm-12 mrgn-btm-25">

               @include('layouts.answer_options')
               @if($row->answer_method !='mcq')
            </div>
            @endif
            <div class="clearfix"></div> 
         </div>
      </div>
      @endforeach
      <?php
      $back             = '/questionSet';
      if (collect(request()->segments())->last() == 'create-set')
          $back             = '/createQuestionSet';
      else if (collect(request()->segments())->last() == 'published-list')
          $back             = '/questionSet';
      else if (!is_numeric(collect(request()->segments())->last()))
          $back             = '/question-set-detail/' . $questionSets->id;
      ?>
      <div class = "btn-wrap"><button type = "button" class = "btn btn-third mrgn-lft-15" title = "Back" onclick = "location.href ='{{url('physician'.$back)}}'">Back</button></div>


   </section>
   <!--/.content -->
</div>
<!--/.content-wrapper -->
@endsection