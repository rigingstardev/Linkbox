@php use Vinkla\Hashids\Facades\Hashids; @endphp
@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->


<div class="content-wrapper">
   <!-- Content Header (Page header) -->

   @foreach ($questionSets as $questionSet) 
   <?php $status = $questionSet->status; ?>

   <section class="content-header">
      <h1>{{ $questionSet->question->title }} Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content content-library">

      @include('includes.alerts')

      {!! Form::open(['route' => ['physician.question.answers',Hashids::encode($questionSet->id)],'id'=>'physicianAnswerFrm','name'=>'physicianAnswerFrm']) !!}

      <div class="content-library-bg"></div>
      
      <?php 
      // echo '<pre>';print_r($questionSet->answers);exit;
      $total                                      = count($questionSet->question->questionSets) - ($questionSet->question->questionSetsyesNoCount->count()); ?>
      <?php $answered                                   = count($questionSet->answers); ?>       
      <h4 class="pull-left">Questions <span class="txt-blue">{!! $total !!}</span></h4>
      <h5 class="pull-right">Patient : <span class="txt-blue">{{ $questionSet->patient->first_name ." ".$questionSet->patient->last_name }}</span></h5>
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
       <?php $pos= 1; $yesnoquestions = []; $questions = [];?>           
        @foreach ( $questionSet->question->questionSets as $masterqSets)            
            @if ('yesNo' == $masterqSets->answer_method )              
                @foreach ( $masterqSets->yesNoQuestions as $yesno)                 
                  <?php $yesnoquestions[$yesno->ans_question_category_id] =  ['option'=>$yesno->ans_option,'qcatId'=>$yesno->question_category_id]; ?>  
                @endforeach  
            @endif 
            <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = ""; ?>                                        
            <?php $CurDesc[$masterqSets->id][$masterqSets->category_id] = ""; ?> 
            @foreach ($questionSet->answers as $answerdet) 
                @if ($answerdet->question_category_id == $masterqSets->id)
                    <?php $CurAnswer[$masterqSets->id][$masterqSets->category_id] = $answerdet->answer; ?>                  
                    <?php $CurDesc[$masterqSets->id][$masterqSets->category_id] = $answerdet->description; ?>                  
                @endif
            @endforeach   
            <?php $template                                   = 'Patient::question.partials.' . $masterqSets->answer_method; ?>           
           <!--  To List main questions -->
            @foreach ($category as  $cKey => $cValue) 
                 @if ($masterqSets->category_id == $cKey && !in_array($masterqSets->id,$questions))
                        <?php $questions[] = $masterqSets->id; ?>            
                        <div class="content-sub mrgn-btm-20 pdng-0"  id="{!! 'blk_'.$masterqSets->id !!}">
                           <div class="content-sub-heading">
                              <div class="col-sm-12">
                                 <b>{!! $cValue !!}</b>
                              </div>
                              <div class="clearfix"></div>
                           </div>
                           <div class="content-area-sub questions">                   
                              <div class="col-md-12 mrgn-btm-25">
                                 <?php $clinicalCls                                = ''; ?>
                                 @if('1' == $masterqSets->clinical_question)
                                 <?php $clinicalCls                                = 'clinical'; ?>
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
                                <?php $templateYesno = ''; ?>
                                <?php $hiddenCls = $yesnoCls =  $yesnoQuesId = ''; $subCnt = '';?>
                                @foreach ($questionSet->question->questionSets as $qSetsYesNo)                                                                 
                                    @if ($yesno->ans_question_category_id == $qSetsYesNo->id && !in_array($qSetsYesNo->id,$questions))
                                       <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id] = ""; ?>                                        
                                       <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id] = ""; ?> 
                                         @foreach ($questionSet->answers as $answerdet) 
                                             @if ($answerdet->question_category_id == $qSetsYesNo->id)
                                                 <?php $CurAnswer[$qSetsYesNo->id][$qSetsYesNo->category_id] = $answerdet->answer; ?>                  
                                                 <?php $CurDesc[$qSetsYesNo->id][$qSetsYesNo->category_id] = $answerdet->description; ?>                  
                                             @endif
                                         @endforeach   
                                         <?php $questions[] = $qSetsYesNo->id; ?>                  
                                         <?php if(array_key_exists($qSetsYesNo->id,$yesnoquestions)) {
                                                  if(array_values($CurAnswer[$yesnoquestions[$qSetsYesNo->id]['qcatId']])[0] != strtolower($yesnoquestions[$qSetsYesNo->id]['option']))
                                                  {
                                                    $hiddenCls='hidden';  
                                                  }else
                                                    $subCnt = $pos++;

                                                   
                                                  $yesnoCls = "yesno_".$yesnoquestions[$qSetsYesNo->id]['qcatId'];
                                                } 
                                          ?> 
                                     <?php $templateYesno                                   = 'Patient::question.partials.' . $qSetsYesNo->answer_method; ?>           
                                     <div class="content-sub mrgn-btm-20 pdng-0 questions {!! $hiddenCls !!} {!! $yesnoCls !!}"  id="{!! 'blk_'.$qSetsYesNo->id !!}">
                                         <div class="content-sub-heading">
                                            <div class="col-sm-12">
                                               <b>{!! $qSetsYesNo->category->category !!}</b>
                                            </div>
                                            <div class="clearfix"></div>
                                         </div>
                                         <div class="content-area-sub">                   
                                            <div class="col-md-12 mrgn-btm-25">
                                               <?php $clinicalCls                                = ''; ?>
                                               @if('1' == $qSetsYesNo->clinical_question)
                                               <?php $clinicalCls                                = 'clinical'; ?>
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
          @if ('completed' == $status && hasPermission('medical_records_edit'))
          <button type="submit" class="btn btn-primary mrgn-lft-15 submitButton">Done</button>
          @endif
          <a href="{!! route('physician.patient.details',Hashids::encode($questionSet->patient->id)) !!}"><button type="button" class="btn btn-default mrgn-lft-15" onclick="location.href = '{!! route('physician.patient.details',$questionSet->patient->id) !!}'">Cancel</button></a>
        
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
    // Disable edit if patient is not yet responded or closed the Question Set
    @if ('completed' != $status || !(hasPermission('medical_records_edit')))
      $('#physicianAnswerFrm input, #physicianAnswerFrm select').prop('disabled', true);
      $('.clinical').prop('disabled', true);
    @endif    
    $(document).on('click', '.submitButton', function (event) {
       event.preventDefault();
       removeWithClass(params.errorClass);      
       if(!(confirm("{!! trans('Patient::messages.confirm_submit') !!}"))){        
          return false;
       }       
       $('.submitButton').attr('disabled', true);
       $.ajax({
          type: "POST",
          url: $('#physicianAnswerFrm').attr('action'),
          data: $('#physicianAnswerFrm').serialize(),
          success: function (response) {
             var respArray = JSON.parse(response);
             $('.submitButton').attr('disabled', false);
             if (respArray.success) {
                if (respArray.redirectUrl) {
                   setTimeout(function () {
                      $(location).attr("href", respArray.redirectUrl);
                   }, 500);
                }
             } else {
                showDBChangeAlert('error', params.dbChangeError);
             }
          },
          error: function (response) {
             $('.submitButton').attr('disabled', false);
             showValidation(response, params.errorClass);
          }
       });
    })
    $(document).on('click','.yesnoqtn',function(){        
        $('.yesno_'+$(this).data('qid')).addClass('hidden');
        $('.yesno_'+$(this).data('qid')+ ' input').val('');
        $('#'+$(this).data('showid')).removeClass('hidden')
        cnt = 1;         
        $('div .questions').each(function(i, elem){            
            if(!$(this).hasClass('hidden')) {
                $(this).find('span.slnumber').html( cnt );  
                cnt++;
            }          
        });
    });  
</script>
@endsection