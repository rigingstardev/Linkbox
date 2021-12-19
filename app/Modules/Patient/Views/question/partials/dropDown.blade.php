<div class="col-md-3 pdng-0 mrgn-btm-15">
    <select id="basic_{!! $qSets->id !!}" class="selectpicker show-tick form-control {!! $clinicalCls !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}]">
        <option value="">Select</option>
        @if ($qSets->defaultOptions)         
            @foreach ($qSets->defaultOptions as $defaultOpt)           
                @if ($defaultOpt->question_category_id == $qSets->id)
                    <option value="{!! $defaultOpt->id !!}" @if ($CurAnswer[$qSets->id][$qSets->category_id] == $defaultOpt->id) selected @endif >{!! $defaultOpt->default_option !!}</option>
                @endif
            @endforeach
        @endif
    </select>           
</div>
<div class="col-md-3"> 
    <input id="basic_{!! $qSets->id !!}" type="text" value="{!! $CurDesc[$qSets->id][$qSets->category_id] !!}"  class="form-control {!! $clinicalCls !!}" name="description[{!! $qSets->id !!}][{!! $qSets->category_id !!}]" >
</div>