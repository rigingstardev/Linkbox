@php use Vinkla\Hashids\Facades\Hashids; @endphp
@extends('layouts.layout3')

@section('content')
<!-- Content Wrapper. Contains page content -->


<div class="content-wrapper">
   <!-- Content Header (Page header) -->

   @foreach ($questionSets as $questionSet) 
   <?php $status                                                 = $questionSet->status; ?>

   <section class="content-header">
      <h1>{{ $questionSet->question->title }} Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content content-library"  @if($questionSet->question->bg_image) style="background-image: url({{asset('uploads/question_set/' . $questionSet->question->bg_image)}})" @endif>

            @include('includes.alerts')

            {!! Form::open(['route' => ['patient.question.answers',Hashids::encode($questionSet->id)],'id'=>'patientAnswerFrm','name'=>'patientAnswerFrm']) !!}
            
            <div class="content-library-bg"></div>    

      <?php $total                                                  = count($questionSet->question->questionSetWithoutCQ) - ($questionSet->question->questionSetsWoCQyesNoCount->count()); ?>
      <?php $answered                                               = count($questionSet->answers); ?>      

      <h4 class="pull-left">Questions <span class="txt-blue">{!! $total !!}  </span></h4>
      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">   

            </div></div>
      </section>

      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading"> 
            <div class="col-sm-12">
               <b>{{ $questionSet->question->title }}</b>

            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p>{{ $questionSet->question->description }}</p>
            </div>
         </div>
      </div>
      <?php
      $pos                                                    = 1;
      $yesnoquestions                                         = [];
      $questions                                              = [];
      ?> 
      @foreach ( $questionSet->question->questionSetWithoutCQ as $masterqSets)            
      @if ('yesNo' == $masterqSets->answer_method )              
      @foreach ( $masterqSets->yesNoQuestions as $yesno)                 
      <?php $yesnoquestions[$yesno->ans_question_category_id]       = ['option' => $yesno->ans_option, 'qcatId' => $yesno->question_category_id]; ?>  
      @endforeach  
      @endif 
<?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ""; ?>                                        
      <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = ""; ?> 
      @foreach ($questionSet->answers as $answerdet) 
      @if ($answerdet->question_category_id == $masterqSets->id)
      <?php  $CurAnswer[$masterqSets->id][$masterqSets->category_id] = $answerdet->answer; ?>                  
      <?php $CurDesc[$masterqSets->id][$masterqSets->category_id]   = $answerdet->description;  ?>    
             
      @endif
      @endforeach   
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
                                                     <?php $clinicalCls                                            = ''; ?>
                                                     @if('1' == $masterqSets->clinical_question)
<?php $clinicalCls                                            = 'clinical'; ?>
                                                     <label class="lbl-clinic">Clinical Question</label>
                                                     @endif
                                                     <p class="mrgn-btm-15"><span class="slnumber">{!! $pos++ !!} </span> . {!! strReplaceCC($masterqSets->question,$questionSet->question->title) !!}
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
                                            <?php $templateYesno                                          = ''; ?>
<?php $hiddenCls                                              = $yesnoCls                                               = $yesnoQuesId                                            = '';
$subCnt                                                 = '';
?>
                                            @foreach ($questionSet->question->questionSets as $qSetsYesNo)                                                                 
                                            @if ($yesno->ans_question_category_id == $qSetsYesNo->id && !in_array($qSetsYesNo->id,$questions))
                                            <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = ""; ?>                                        
                                            <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = ""; ?> 
                                            @foreach ($questionSet->answers as $answerdet) 
                                            @if ($answerdet->question_category_id == $qSetsYesNo->id)
                                            <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id]   = $answerdet->answer; ?>                  
                                            <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id]     = $answerdet->description; ?>                  
                                            @endif
                                            @endforeach   
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
                                                                                                                                          <p class="mrgn-btm-15"><span class="slnumber">{!! $subCnt !!} </span>. {!! strReplaceCC($qSetsYesNo->question,$questionSet->question->title) !!}
                                                                                                                                             @if ($qSetsYesNo->comments != "")
                                                                                                                                             <a class="txt-large mrgn-lft-15" href="javascript:void(0)" data-toggle="tooltip" data-placement="right" title="{!! $qSetsYesNo ->comments !!}" data-original-title="{!! $qSetsYesNo->comments !!}">
                                                                                                                                                <i class="fa fa-info-circle"></i>
                                                                                                                                             </a>
                                                                                                                                             @endif
                                                                                                                                          </p>
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
                                                                                                                                 <div class="content-sub total_display mrgn-btm-20">
                                                                                                                                    <div class="total"> Total           
                                                                                                                                       <br><span> {!!  $total !!} </span> </div>
                                                                                                                                    <div class="answered"> Answered
                                                                                                                                       <br><span>{!! $answered !!}</span> </div>
                                                                                                                                    <div class="unanswered"> Unanswered
                                                                                                                                       <br><span>{!! $total-$answered !!} </span> </div>
                                                                                                                                 </div><div class="clearfix"></div>
                                                                                                                                 <div class="btn-wrap">            
                                                                                                                                    @if('completed' != $status)
                                                                                                                                    <button type="submit" data-action="2" class="btn btn-primary mrgn-lft-15 submitButton">Send to Dr. {{ $questionSet->physician->name }} now</button>
                                                                                                                                    <button type="submit" data-action="1" class="btn btn-primary mrgn-lft-15 submitButton">Save and complete later</button>
                                                                                                                                    @else
                                                                                                                                    <a href="{!! route('patient.question.received') !!}"><button type="button" class="btn btn-primary mrgn-lft-15 backButton">Back</button></a>
                                                                                                                                    @endif
                                                                                                                                 </div>
                                                                                                                                 {!! Form::close() !!}
                                            </section>
                                            <!-- /.content -->   
                                            @endforeach
      </div>
      <!-- /.content-wrapper -->
      @endsection
      @section('page_scripts')
      <script>
          @if ('completed' == $status)
                  $('#patientAnswerFrm input, #patientAnswerFrm select').prop('disabled', true);
                  @endif
                  $('.clinical').prop('disabled', true);
          $(document).on('click', '.submitButton', function (event) {
             event.preventDefault();
             removeWithClass(params.errorClass);
             if ('2' == $(this).data('action')) {
                if (!(confirm("{!! trans('Patient::messages.confirm_submit') !!}"))) {
                   return false;
                }
             }
             $('.submitButton').attr('disabled', true);
             $.ajax({
                type: "POST",
                url: $('#patientAnswerFrm').attr('action'),
                data: 'saved=' + $(this).data('action') + '&' + $('#patientAnswerFrm').serialize(),
                success: function (response) {
                   var respArray = JSON.parse(response);
                   $('.submitButton').attr('disabled', false);
                   //if (respArray.success) {
                   if (respArray.redirectUrl) {
                      setTimeout(function () {
                         $(location).attr("href", respArray.redirectUrl);
                      }, 500);
                   }
                   // } else {
                   //showDBChangeAlert('error', params.dbChangeError);
                   //}
                },
                error: function (response) {
                   $('.submitButton').attr('disabled', false);
                   showValidation(response, params.errorClass);
                }
             });
          })
          $(document).on('click', '.yesnoqtn', function () {
             $('.yesno_' + $(this).data('qid')).addClass('hidden');
             $('.yesno_' + $(this).data('qid') + ' input').val('');
             $('#' + $(this).data('showid')).removeClass('hidden')
             cnt = 1;
             $('div .questions').each(function (i, elem) {
                if (!$(this).hasClass('hidden')) {
                   $(this).find('span.slnumber').html(cnt);
                   cnt++;
                }
             });
             //$('div .total span').html($('div .questions').not('.hidden').length)           
          });
          $(document).ready(function () {
              $('.yesnodiv').each(function (index, value){                
                if($(this).find('.yesnoqtn:hidden').length == 0)
                  $(this).find('.yesnoqtn:first').trigger('click');               
              });     
             // $('div .total span').html($('div .questions').not('.hidden').length)        
          })
      </script>
      @endsection