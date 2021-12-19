@php use Vinkla\Hashids\Facades\Hashids; @endphp
@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   @foreach ($questionSets as $questionSet) 
   <?php $status                                                 = $questionSet->status; ?>
   <section class="content-header">
      <h1>{{ $questionSet->title }} Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content content-library"  @if($questionSet->bg_image) style="background-image: url({{asset('uploads/question_set/' . $questionSet->question->bg_image)}})" @endif>

            @include('includes.alerts')

            {!! Form::open(['route' => ['physician.question.set_preview_answers', Hashids::encode($questionSet->id)],'id'=>'patientAnswerFrm','name'=>'patientAnswerFrm']) !!}

            <div class="content-library-bg"></div>

      <?php //$total                                                  = count($questionSet->questionSetWithoutCQ) - ($questionSet->questionSetsWoCQyesNoCount->count()); ?>
      <?php //$answered                                               = count($questionSet->answers);  ?>      

      <h4 class="pull-left">Questions <span class="txt-blue">{{-- $total --}}  </span></h4>
      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">   

            </div></div>
      </section>

      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12">
               <b>{{ $questionSet->title }}</b>

            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p>{{ $questionSet->description }}</p>
            </div>
         </div>
      </div>
      <?php
      $pos                                                    = 1;
      $yesnoquestions                                         = [];
      $questions                                              = [];
      ?> 
      
      @foreach ( $questionSet->questionSetWithoutCQ as $masterqSets)            
        @if ('yesNo' == $masterqSets->answer_method )              
          @foreach ( $masterqSets->yesNoQuestions as $yesno)                 
          <?php $yesnoquestions[$yesno->ans_question_category_id] = ['option' => $yesno->ans_option, 'qcatId' => $yesno->question_category_id]; ?>  
          @endforeach  
        @endif 
        <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ""; ?>                                        
        <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = ""; ?> 
        @if ($questionSet->answers)
         @foreach ($questionSet->answers as $answerdet) 
            @if ($answerdet->question_category_id == $masterqSets->id)
               <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ''; ?>                  
               <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = ''; ?>                  
            @endif
         @endforeach   
        @endif
        <?php $template                                               = 'Patient::question.partials.' . $masterqSets->answer_method; ?>           
      <!--  To List main questions -->
      @foreach ($category as  $cKey => $cValue) 
      @if ($masterqSets->category_id == $cKey && !in_array($masterqSets->id,$questions))
      <?php $questions[]                                            = $masterqSets->id; ?>            
      <div class="content-sub mrgn-btm-20 pdng-0"  id="{!! 'blk_'.$masterqSets->id !!}">
               <div class="content-sub-heading">
                  <div class="col-sm-12">
                     <b>{!! $cValue !!}</b>
                  </div>
                  <div class="clearfix"></div>
               </div>
               <div class="content-area-sub questions">                   
                  <div class="col-md-12 mrgn-btm-25">
                     <?php $clinicalCls                           = ''; ?>
                     @if('1' == $masterqSets->clinical_question)
                     <?php $clinicalCls                            = 'clinical'; ?>
                     <label class="lbl-clinic">Clinical Question</label>
                     @endif
                     <p class="mrgn-btm-15"><span class="slnumber">{!! $pos++ !!} </span> . {!! strReplaceCC($masterqSets->question,$questionSet->title) !!}
                        @if ($masterqSets->comments != "")
                        <a class="txt-large mrgn-lft-15" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="{!! $masterqSets->comments !!}" data-original-title="{!! $masterqSets->comments !!}">
                           <i class="fa fa-info-circle"></i>
                        </a>
                        @endif
                     </p>

                     @include($template,['qSets' => $masterqSets])  
                  </div>
               </div>
            </div> 
            <!-- To list YesNo questions -->
            @if ('yesNo' == $masterqSets->answer_method ) 
            @foreach ( $masterqSets->yesNoQuestions as $yesno) 
            <?php 
               $templateYesno                                          = ''; 
            ?>
            <?php 
               $hiddenCls                                              = $yesnoCls = $yesnoQuesId = '';
               $subCnt                                                 = '';
            ?>
            @foreach ($questionSet->questionSets as $qSetsYesNo)
               @if ($yesno->ans_question_category_id == $qSetsYesNo->id && !in_array($qSetsYesNo->id,$questions))
               <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = ""; ?>                                        
               <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = ""; ?> 
               @if($questionSet->answers)
                  @foreach ($questionSet->answers as $answerdet) 
                     @if ($answerdet->question_category_id == $qSetsYesNo->id)
                        <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = $answerdet->answer; ?>                  
                        <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = $answerdet->description; ?>                  
                     @endif
                  @endforeach   
               @endif
               <?php $questions[]                                            = $qSetsYesNo->id; ?>                  
               <?php
                  if (array_key_exists($qSetsYesNo->id, $yesnoquestions)) {
                     if (array_values($CurAnswer[$yesnoquestions[$qSetsYesNo->id]['qcatId']])[0] != strtolower($yesnoquestions[$qSetsYesNo->id]['option'])) {
                           $hiddenCls = 'hidden';
                     } else
                           $subCnt = $pos++;

                     $yesnoCls = "yesno_" . $yesnoquestions[$qSetsYesNo->id]['qcatId'];
                  }
               ?> 
               <?php $templateYesno = 'Patient::question.partials.' . $qSetsYesNo->answer_method; ?>           
               <div class="content-sub mrgn-btm-20 pdng-0 questions {!! $hiddenCls !!} {!! $yesnoCls !!}"  id="{!! 'blk_'.$qSetsYesNo->id !!}">
                  <div class="content-sub-heading">
                     <div class="col-sm-12">
                     <b>{!! $qSetsYesNo->category->category !!}</b>
                     </div>
                     <div class="clearfix"></div>
                  </div>
                  <div class="content-area-sub">                   
                     <div class="col-md-12 mrgn-btm-25">
                     <?php $clinicalCls   = ''; ?>
                     @if('1' == $qSetsYesNo->clinical_question)
                        <?php $clinicalCls   = 'clinical'; ?>
                        <label class="lbl-clinic">Clinical Question</label>
                     @endif

                     @if(@$questionSet->question)
                        <p class="mrgn-btm-15"><span class="slnumber">{!! $subCnt !!} </span>. {!! strReplaceCC($qSetsYesNo->question,$questionSet->question->title) !!}
                           @if ($qSetsYesNo->comments != "")
                           <a class="txt-large mrgn-lft-15" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="{!! $qSetsYesNo ->comments !!}" data-original-title="{!! $qSetsYesNo->comments !!}">
                              <i class="fa fa-info-circle"></i>
                           </a>
                           @endif
                        </p>
                     @endif
                     
                     @include($templateYesno,['qSets' => $qSetsYesNo]) 
                  </div>
                  </div>
               </div>  
               @endif         
               @endforeach  
               @endforeach  
               @endif  <!-- End of Yes No Listing -->                                  
               @endif <!-- End of Master Listing -->
               @endforeach <!-- End of Category Iteration -->
            @endforeach  <!-- End of Question Set Iteration -->      
            <div class="clearfix"></div>
         <div class="btn-wrap">            
            <button type="submit" class="btn btn-primary mrgn-lft-15">Save & Preview</button>
         </div>
         @if ($sessionValue)
            <input type="hidden" name="age" value="{{ $sessionValue['age'] }}">
            <input type="hidden" name="gender" value="{{ $sessionValue['gender'] }}">
            <input type="hidden" name="id" value="{{ $sessionValue['id'] }}">
            @endif
         {!! Form::close() !!}
         </section>
         <!-- /.content -->   
         @endforeach
      </div>
      <!-- /.content-wrapper -->
      @endsection
      