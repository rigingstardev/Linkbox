@extends('layouts.layout2')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>{{$questionSet->title}} Question Set</h1>
   </section>

   <!-- Main content -->
   <section class="content">
      @include('layouts.show_alert_message') 
      <section class="content-sub-header">

         <h4 class="pull-left">Questions <span class="txt-blue">{{count((array)$selectedCategories)}}</span></h4>

         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row">
               <button type="button" class="btn btn-third btn-block btn-min-width-235 mrgn-btm-15 " title="Add Question Categories"  data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-square-o"></i> Add Question Categories</button>

               <!-- Modal -->
               <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  @include('layouts.add_question_category')     
               </div>
            </div></div>
      </section>

      <div class="content-sub mrgn-btm-20 pdng-0" id="questionset-view">
         <div class="content-sub-heading">
            <div class="col-sm-12">
               <b>{{$questionSet->title}}</b>
               <a href="javascript:void(0)" class="edit pull-right" id="questionset-edit-btn" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo nl2br($questionSet->description) ?></p>
            </div>
         </div>
      </div>
      <div class="content-sub mrgn-btm-20 pdng-0 hidden" id="questionset-edit">
         {!! Form::open(['role' => 'form', 'name' => 'frmQuestionSet', 'url'=>'physician/editQuestionSet', 'id' => 'frmQuestionSet','autocomplete' => 'off']) !!}
         <div class="content-sub  mrgn-btm-20">
            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Chief Complaint:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4  input-main">
                  <input class="form-control autoComplete" type="text" maxlength="100"  id="chiefComplaint" name="chiefComplaint" value="{{$questionSet->title}}" data-suggest="chiefComplaint"></div>
               <div class="clearfix"></div>
            </div>

            <div class="col-sm-12 mrgn-btm-20">
               <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 pdng-0 pdng-tp-7">Description:</div>
               <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4 input-main">
                  <textarea class="form-control count-chars" rows="4" maxlength="1500" id="description" name="description">{{$questionSet->description}}</textarea></div>
               <div class="clearfix"></div>
            </div>
            <input type="hidden" id="qid" name="qid" value="{{$id}}" >
            <input type="hidden" id="requestType" name="requestType" value="head" >

            <input type="hidden" id="categoryCount" name="categoryCount" value="1" >
            <input type="hidden" name="category1" id="category1" value="1">
            <div class="btn-wrap">
               <button type="button" class="btn btn-primary mrgn-lft-15" id="questionset-done-btn" title="Done">Done</button>
               <button type="button" class="btn btn-default" id="questionset-cancel-btn" title="Cancel">Cancel</button> </div>
         </div>
         {!! Form::close() !!}
      </div>
      @if($defaultOutput)
      <div class="content-sub mrgn-btm-20 pdng-0" id="defaultoutput-view">
         <div class="content-sub-heading">
            <div class="col-sm-12">
               <b>Narrative Output</b>
               <a href="javascript:void(0)" class="edit pull-right" id="defaultoutput-edit-btn" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>
            </div>
            <div class="clearfix"></div>
         </div> 
         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo str_replace('[CC]', $questionSet->title, $defaultOutput->narrative_output); ?></p>
            </div>
         </div>       
      </div>
      <div class="content-sub mrgn-btm-20 pdng-0 hidden" id="defaultoutput-edit">
         {!! Form::open(['role' => 'form', 'name' => 'frmQuestionSetNarrativeOutput', 'url'=> route('question.defaultoutput.edit'), 'id' => 'frmQuestionSetNarrativeOutput','autocomplete' => 'off']) !!}         
            <div class="content-sub-heading">
               <div class="col-sm-12">
                  <b>Narrative Output</b>                  
               </div>
               <div class="clearfix"></div>
            </div> 
            <div class="content-sub  mrgn-btm-20">
            <div class="content-area-sub">  
               <div class="row">  
                  <div class="col-sm-4"><input class="form-control" id="defaultnarrativeoutput" name="defaultnarrativeoutput" maxlength="500" value="{{$defaultOutput->narrative_output}}" ></div>
               </div>
            </div>           
            <input type="hidden" id="noutput_id" name="noutput_id" value="{{$defaultOutput->id}}" >
            <input type="hidden" id="qid" name="qid" value="{{$id}}">          
            <div class="btn-wrap">
               <button type="button" class="btn btn-primary mrgn-lft-15" id="defaultoutput-done-btn" title="Done">Done</button>
               <button type="button" class="btn btn-default" id="defaultoutput-cancel-btn" title="Cancel">Cancel</button>
            </div>  
         </div>      
         {!! Form::close() !!}
      </div>
      @endif
      <!------- listing question category's-------->
      @include('layouts.question_category')     

      <div class="btn-wrap">
         <button type="button" class="btn btn-primary mrgn-lft-15" onclick="buildQuestionSet({{$qid}})">Build Question Set</button>
         <button type="button" class="btn btn-primary mrgn-lft-15" onclick="location.href = '{{url('physician/createQuestionSet')}}'">Back</button>
      </div>

      <input type="hidden" name="checkOrigin" id="checkOrigin" value="Edit" >
   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection