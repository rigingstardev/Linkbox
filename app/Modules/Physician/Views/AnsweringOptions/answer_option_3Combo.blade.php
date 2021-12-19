@include('layouts.answer_entry_options')
<!-------------------          question header section ------------------------>
</div>

<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5"> 
   <div class="col-sm-3 col-md-2 pdng-lft-0 ">
      <select id="basic" class="selectpicker show-tick form-control">
         @for($i=1; $i<=100;$i++)
         <option>{{$i}}</option>
         @endfor
      </select>
   </div>  
   <div class="col-sm-3 col-md-2">
      <select id="basic" class="selectpicker show-tick form-control">
         <option>Year(s)</option>
         <option>Month(s)</option>
         <option>Week(s)</option>
         <option>Day(s)</option>
         <option>Hour(s)</option>
      </select>
   </div>
   <div class="col-sm-3 col-md-2"> 
       <?php $def = 'ago';?>
      @if(count((array)$categoryOptions)>0)
      @foreach($categoryOptions as $opt)
    <?php $def = $opt->default_option?>

      @endforeach 
      @endif
      <input type="text"  name="txt3ComboAnswer" id="txt3ComboAnswer" value="{{$def}}" class="form-control" >
   </div>

</div>
@include('layouts.answer_entry_footer')

