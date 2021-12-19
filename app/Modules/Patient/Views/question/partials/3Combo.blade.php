<?php
$comboAnswer = unserialize($CurAnswer[$qSets->id][$qSets->category_id]);
$ans2 = "";
if ($qSets->defaultOptions)  {       
      foreach ($qSets->defaultOptions as $defaultOpt)  {         
          if ($defaultOpt->question_category_id == $qSets->id){
               $ans2 =  $defaultOpt->default_option;
          }  
      }
}
?>
<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5"> 
   <div class="col-sm-2  pdng-lft-0 ">
      <select id="1_basic_{!! $qSets->id !!}" onchange="changeOptions(this.value, {{$qSets->id}})" class="selectpicker show-tick form-control {!! $clinicalCls !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}][3combo][1]">
         <option value=''>[Select]</option>
         @for($i=1; $i<=100;$i++)
         <?php $selOption   = ($i == $comboAnswer[0]) ? 'selected=selected' : ""; ?>
         <option value="{{$i}}" {!! $selOption !!} >{{$i}}</option>
         @endfor
      </select>
   </div>  
   <div class="col-sm-2">
      <select id="2_basic_{!! $qSets->id !!}" class="selectpicker show-tick form-control {!! $clinicalCls !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}][3combo][2]">
         <option value=''>[Select]</option>
         <option value="Years" @if ('Years' == $comboAnswer[1]) {!! 'selected=selected' !!} @endif >Years</option>
         <option value="Months" @if ('Months' == $comboAnswer[1]) {!! 'selected=selected' !!} @endif >Months</option>
         <option value="Weeks" @if ('Weeks' == $comboAnswer[1]) {!! 'selected=selected' !!} @endif >Weeks</option>
         <option value="Days" @if ('Days' == $comboAnswer[1]) {!! 'selected=selected' !!} @endif >Days</option>
         <option value="Hours" @if ('Hours' == $comboAnswer[1]) {!! 'selected=selected' !!} @endif >Hours</option>
      </select>
   </div>
   <div class="col-sm-2">
      @if(!empty($ans2))
         <label class="mrgn-btm-5 pdng-lft-0 mrgn-tp-5">{!! $ans2 !!}</label>
         <input id="3_basic_{!! $qSets->id !!}" type="hidden" value="{!! $ans2 !!}"   class="form-control" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}][3combo][3]" >
      @else
         <input id="3_basic_{!! $qSets->id !!}" type="text" value="{!! $comboAnswer[2] !!}"   class="form-control {!! $clinicalCls !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}][3combo][3]" >
      @endif
   </div>
</div>