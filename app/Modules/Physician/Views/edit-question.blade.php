{{ Form::open(['role' => 'form', 'name' => 'frmEditQuestion'.$rid, 'url'=>'physician/frmEditQuestion', 'id' => 'frmEditQuestion'.$rid,'autocomplete' => 'off']) }}
@foreach ($result as $data)

<div class="content-sub mrgn-btm-20 pdng-0" id="category-edit-{{$rid}}">

   <div class="content-sub-heading">
      <div class="col-sm-12">
         <b>{{$data->category->category}}</b>
         <a href="#" class="edit pull-right" id="not-done" onclick="setQuestionFlags('delete',{{$rid}},{{$cid}},{{$qid}})"><i class="fa fa-trash-o" ></i></a>
      </div>
      <div class="clearfix"></div>
   </div>
   <div class="content-area-sub" >

      <div class="col-sm-12" id="div-header">
         <div id="show_answer_option_{{$rid}}"></div>
         <!--      end date and time option list   -->
         <div class="clearfix"></div>
         <div class="col-sm-4 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
            <b>Extra Comments</b>
            <input class="form-control" id="txtComments" name="txtComments" value="{{$data->comments}}" >
         </div>
         <div class="clearfix"></div>
         <div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
            <b class="">Narrative Output</b></div>
         <?php
         $narrativeOutput = '';
         $narrativeOutput = explode('[CC]', $data->narrative_output);
         ?>
         <div class="row mrgn-btm-25">
            <div class="col-sm-4">
               <input class="form-control" id="txtNarrativeOutput1" name="txtNarrativeOutput1" value="{{$narrativeOutput[0]}}"></div>
            <div class="col-sm-4"><select class="form-control" id="txtNarrativeOutput2" name="txtNarrativeOutput2">
                  <option value=""></option>
                  <option value="[CC]"  @if (strpos($data->narrative_output, '[CC]') !== false){{'selected=""'}}@endif>{{$data->title}}</option>
               </select></div>
            <div class="col-sm-4"><input class="form-control" id="txtNarrativeOutput3" name="txtNarrativeOutput3" value="@if(count((array)$narrativeOutput)>1){{$narrativeOutput[1]}}@endif" ></div>
         </div>
      </div>

      <div class="btn-wrap">
         <button type="button" class="btn btn-primary mrgn-lft-15" id="done-btn" onclick="updateQuestionSettings({{$rid}},{{$cid}},{{$qid}},{{$serialNo}})" title="Done">Done</button>
         <button type="button" class="btn btn-default" id="cancel-btn" onclick="resetQuestionSettingsWindow({{$rid}})" title="Cancel">Cancel</button>
      </div>
   </div>
</div>
</div>
@endforeach
<input type="hidden" name="serial{{$rid}}" id="serial{{$rid}}" value="{{$serialNo}}." >
<input type="hidden" name="cid" id="cid" value="{{$cid}}" >
<input type="hidden" name="qid" id="qid" value="{{$qid}}" >
<input type="hidden" name="rid" id="rid" value="{{$rid}}" >
{{ Form::close() }}