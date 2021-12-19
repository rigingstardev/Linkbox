<div class="col-sm-3 pdng-0">
   <!-- <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked=""> -->
   <!--  <label for="inlineRadio1" class="datepicker-control"> -->       
        <!-- <div class="input-group datetimepicker">
            <input type="text" class="date-picker form-control" value="{!! $CurAnswer[$qSets->id][$qSets->category_id] !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}]">
            <span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>
        </div>  -->
        <div class="input-group datepicker-control date form_date" data-date="" data-date-format="mm/dd/yyyy">
            <input class="form-control {!! $clinicalCls !!}" onClick="this.blur()" type="text" value="{!! $CurAnswer[$qSets->id][$qSets->category_id] !!}" name="answer[{!! $qSets->id !!}][{!! $qSets->category_id !!}]" readonly>            
			      <span class="input-group-addon  calendar-icn-bg"><span class="fa fa-calendar icon-calendar"></span></span>
        </div>	
   <!--  </label> -->
</div>