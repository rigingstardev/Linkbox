<input id="basic_{!! $qSets->id !!}" type="hidden" value="" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}]" >
@if ($qSets->defaultOptions)  
    <?php
     if('Y' == $qSets->allow_multiple_answer)                   
        $checkboxArr = unserialize($CurAnswer[$qSets->id][$qSets->category_id]);       
     else
        $checkboxArr = $CurAnswer[$qSets->id][$qSets->category_id];
     ?>   
    
    @foreach ($qSets->defaultOptions as $defaultOpt)           
        @if ($defaultOpt->question_category_id == $qSets->id)
            <?php $checked = false; 
                if(is_array($checkboxArr)) {
                    if (in_array($defaultOpt->id,$checkboxArr))
                        $checked = true;
                }else {
                    if ($defaultOpt->id == $checkboxArr)
                        $checked = true;
                }
             ?>
            <div class="col-sm-12 mrgn-btm-10">   
                @if('Y' == $qSets->allow_multiple_answer)
                <div class="checkbox">
                    {{ Form::checkbox("answer[$qSets->id][$qSets->category_id][$defaultOpt->id]", 1, $checked,['id'=>"checkbox2_$defaultOpt->id",'class'=>"$clinicalCls"]) }}                  
                    <label for="checkbox2_{!! $defaultOpt->id !!}">
                        {!! $defaultOpt->default_option !!}
                    </label>
                </div>
                @else
                <div class="radio">
                    {{ Form::radio("answer[$qSets->id][$qSets->category_id]", $defaultOpt->id, $checked,['id'=>"radio2_$defaultOpt->id",'class'=>"$clinicalCls"]) }}                  
                    <label for="radio2_{!! $defaultOpt->id !!}">
                        {!! $defaultOpt->default_option !!}
                    </label>
                </div>
                @endif  
             </div> 
        @endif
    @endforeach        
        <input id="basic_{!! $qSets->id !!}" type="text" value="{!! $CurDesc[$qSets->id][$qSets->category_id] !!}" class="form-control {!! $clinicalCls !!}" name="description[{!! $qSets->id !!}][{!! $qSets->category_id !!}]" >            
   
@endif