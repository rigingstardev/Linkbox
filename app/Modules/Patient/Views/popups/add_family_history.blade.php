{!! Form::open(['url' => route('patient.post.family_history'),'class' => 'bootstrap-modal-form', 'id' => 'postFamilyHistory', 'method' => 'post']) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Family History</h4>
</div>
<div class="modal-body">

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Illness</span>
        {!!  Form::hidden('family_history_id', isset($familyHistoryData->id) ? $familyHistoryData->id : '') !!}
        {!! Form::text('illness', isset($familyHistoryData->illness) ? $familyHistoryData->illness : old('illness') , ['id' => 'illness', 'class' => 'form-control', 'placeholder' => 'Specify illness']) !!}
    </div>

    <div class="col-sm-12 mrgn-btm-20">
        <span class="display-block mrgn-btm-10"> Relation</span>
        {!! Form::text('relation', isset($familyHistoryData->relation) ? $familyHistoryData->relation : old('relation'), ['id' => 'relation', 'class' => 'form-control', 'placeholder' => 'Please enter relation.','size' => '50x5','maxlength' => '1000']) !!}

    </div>


    <div class="clearfix"></div>

</div>
<div class="modal-footer">

    {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
</div>
{!! Form::close() !!}