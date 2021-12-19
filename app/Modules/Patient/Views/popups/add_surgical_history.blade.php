{!! Form::open(['url' => route('patient.post.surgical_history'),'class' => 'bootstrap-modal-form', 'id' => 'postSurgicalHistory', 'method' => 'post']) !!}
<div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <h4 class="modal-title" id="myModalLabel">Surgical History</h4>
</div>
<div class="modal-body">

   <div class="col-sm-12 mrgn-btm-20">
      <span class="display-block mrgn-btm-10"> Surgery</span>
      {!!  Form::hidden('surgical_history_id', isset($surgicalHistoryData->id) ? $surgicalHistoryData->id : '') !!}
      {!! Form::text('surgery', isset($surgicalHistoryData->surgery) ? $surgicalHistoryData->surgery : old('surgery') , ['id' => 'surgery', 'class' => 'form-control', 'placeholder' => 'Specify medical history']) !!}
   </div>

   <div class="col-sm-12 mrgn-btm-20">
      <span class="display-block mrgn-btm-10"> Date of surgery</span>
      <div class='input-group date mrgn-tp-15 mrgn-btm-25' id='datetimepicker3' style="width:100%">
         <input type='text' class="form-control" id = 'surgery_date' name = 'surgery_date' placeholder = 'Select Date.' onclick = 'this.blur();' value=<?php isset($surgicalHistoryData->surgery_date) ? Carbon\Carbon::parse($surgicalHistoryData->surgery_date)->format('m/d/Y') : old('surgery_date') ?> />
      <span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>
      </div>
      <div class="error_surgery_date error"></div>
   </div>

   <div class="clearfix"></div>

</div>
<div class="modal-footer">

   {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
</div>
{!! Form::close() !!}
<script type="text/javascript">
   $(function () {
         $('#datetimepicker3').datetimepicker({
         format: 'DD/MM/YYYY'
         });
   });
 </script>
