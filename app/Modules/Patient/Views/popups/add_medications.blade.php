{!! Form::open(['url' => route('patient.post.medications'),'class' => 'bootstrap-modal-form', 'id' => 'postMedications', 'method' => 'post']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Medications</h4>
</div>
<div class="modal-body">

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Type</span>
        {!!  Form::hidden('medications_id', isset($medicationsData->id) ? $medicationsData->id : '') !!}
        {!! Form::text('type', isset($medicationsData->type) ? $medicationsData->type : old('type') , ['id' => 'medications_type', 'class' => 'form-control', 'placeholder' => 'Specify Medication']) !!}
    </div>

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Description</span>
        {!! Form::textarea('description', isset($medicationsData->description) ? $medicationsData->description : old('description'), ['id' => 'medications_description', 'class' => 'form-control', 'placeholder' => 'Please enter description.','size' => '50x5','maxlength' => '1000']) !!}

    </div>


    <div class="clearfix"></div>

</div>
<div class="modal-footer">

    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
</div>
{!! Form::close() !!}