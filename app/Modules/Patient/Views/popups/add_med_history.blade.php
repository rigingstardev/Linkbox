{!! Form::open(['url' => route('patient.post.med_history'),'class' => 'bootstrap-modal-form', 'id' => 'postMedHistory', 'method' => 'post']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Past Medical History</h4>
</div>
<div class="modal-body">

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Type</span>
        {!!  Form::hidden('med_history_id', isset($medHistoryData->id) ? $medHistoryData->id : '') !!}
        {!! Form::text('type', isset($medHistoryData->type) ? $medHistoryData->type : old('type') , ['id' => 'med_history_type', 'class' => 'form-control', 'placeholder' => 'Specify medical history']) !!}
    </div>

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Description</span>
        {!! Form::textarea('description', isset($medHistoryData->description) ? $medHistoryData->description : old('description'), ['id' => 'med_history_description', 'class' => 'form-control', 'placeholder' => 'Please enter description.','size' => '50x5','maxlength' => '1000']) !!}

    </div>


    <div class="clearfix"></div>

</div>
<div class="modal-footer">

    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
</div>
{!! Form::close() !!}