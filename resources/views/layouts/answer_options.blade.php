<?php
$defaultOption         = '';
$quid                  = $row->id;
$rid                   = $quid;
?>
<!--    start  if($row->answer_method =='dateT')        -->
@if($row->answer_method =='dateT')

<!--    start if(count($defaultOptions) > 0)       -->
@if(count($defaultOptions) > 0)

<!--    start foreach($defaultOptions as $opt)      -->
@foreach($defaultOptions as $opt)

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
@if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)

<!--start   if($opt->option_status ==1)-->
@if($opt->option_status ==1)
<?php $defaultOption         = $opt->default_option ?>
@endif
<!--end   if($opt->option_status ==1)-->

@endif
<!--    end   if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)         -->

@endforeach
<!--    end foreach($defaultOptions as $opt)      -->

@endif
<!--    end if(count($defaultOptions) > 0)       -->

<p>{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

<!--    start if($defaultOption =='date' || $defaultOption =='time' ||$defaultOption =='both' )       -->
 <!--   if($defaultOption =='dateT' || $defaultOption =='time' ||$defaultOption =='both' )-->

<!--    start if(Request::segment(1) == 'admin')     -->
@if(Request::segment(1) == 'admin')
<div class=" mrgn-tp-15 col-xs-12 col-sm-6 col-md-6 col-lg-3 pdng-0">
   <div class=" input-group datepicker-control">
      <input type="text" required="" class="date-picker form-control" disabled="">
      <span class="input-group-addon calendar-icn-bg" disabled=""><i class="fa fa-calendar icon-calendar"></i></span>
   </div>
</div>

@else
<!--    else of  if(Request::segment(1) == 'admin')      -->

<div class=" mrgn-tp-15 col-xs-12 col-sm-6 col-md-6 col-lg-3 pdng-0">
   <div class="input-group datepicker-control">
      <input type="text" required="" class="date-picker form-control" disabled="">
      <span class="input-group-addon calendar-icn-bg" disabled=""><i class="fa fa-calendar icon-calendar"></i></span>
   </div>
</div>
@endif
<!--    end if(Request::segment(1) == 'admin')      -->

 <!--   endif-->
<!--    end  if($row->answer_method =='dateT')        -->

<span class="ago pull-left pdng-lft-15 pdng-tp-3"></span>
<div class="clearfix"></div>

@endif
<!--    end if($defaultOption =='date' || $defaultOption =='time' ||$defaultOption =='both' )       -->

<!--    start  if($row->answer_method =='textBox')        -->
@if($row->answer_method =='textBox')
<p class="mrgn-btm-15">{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<div class="col-sm-3 pdng-0">
   <input disabled="" class="form-control">
</div>
@endif
<!--    end  if($row->answer_method =='textBox')        -->

<!--    start  if($row->answer_method =='rating')        -->
@if($row->answer_method =='rating')
<p class="mrgn-btm-15">{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

<div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pdng-0 ">
   <select id="basic" class="selectpicker show-tick form-control">
      @for($i=10; $i>=5;$i--)
      <option>{{$i}}</option>
      @endfor
   </select>
</div>
@endif
<!--    end  if($row->answer_method =='rating')        -->

<!--    start  if($row->answer_method =='dropDown')        -->
@if($row->answer_method =='dropDown')
<p class="mrgn-btm-10">{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<?php $hasOption             = 0; ?>
<!--    start  if(count($defaultOptions) > 0)       -->
@if(count($defaultOptions) > 0)

@foreach($defaultOptions as $opt)

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->
@if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)

<!--    start if($opt->option_status ==1)    -->
@if($opt->option_status ==1)
<?php $hasOption++; ?>
@endif
<!--    end if($opt->option_status ==1)    -->

@endif
<!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->

@endforeach

<div class="col-sm-3 pdng-0">
   <select id="basic" @if($hasOption==0){{'disabled'}} @endif class="selectpicker show-tick form-control  mrgn-btm-10">

           <!--    start  if(count($defaultOptions) > 0)       -->
           @if(count($defaultOptions) > 0)

           <!--    start  foreach($defaultOptions as $opt)      -->
           @foreach($defaultOptions as $opt)

           <!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->
           @if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)

           <!--    start if($opt->option_status ==1)    -->
           @if($opt->option_status ==1)
           <option> {{$opt->default_option }}</option>
      @endif
      <!--    end if($opt->option_status ==1)    -->

      @endif
      <!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)    -->

      @endforeach
      <!--    end  foreach($defaultOptions as $opt)      -->

      @endif
      <!--    end  if(count($defaultOptions) > 0)       -->
   </select>
</div>
<!--end foreach-->
@endif
<!--    end  if(count($defaultOptions) > 0)       -->
<!--end count checking-->
<div class="clearfix"></div>
@endif
<!--    end  if($row->answer_method =='dropDown')        -->

<!--    start  if($row->answer_method =='mcq')        -->
@if($row->answer_method =='mcq')
<p>{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>

</div>
<?php $countOption           = 0 ?>
<!--    start  if(count($defaultOptions) > 0)        -->
@if(count($defaultOptions) > 0)

<!--    start  foreach($defaultOptions as $opt)        -->
@foreach($defaultOptions as $opt)

<!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
@if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)

<!--    start if($opt->option_status ==1)     -->
@if($opt->option_status ==1)
<div class="col-sm-12 mrgn-btm-10">
   <div class="checkbox">
      <input id="checkbox22-{{$opt->id}}" type="checkbox" disabled="" >
      <label for="checkbox22-{{$opt->id}}">
         {{$opt->default_option }}
      </label>
   </div>
</div>
<?php $countOption++ ?>
@endif
<!--    end if($opt->option_status ==1)     -->

@endif
<!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->

@endforeach
<!--    end  foreach($defaultOptions as $opt)        -->

<!--    start if( $countOption ==0)     -->
@if( $countOption ==0)
<div class="col-sm-12 ">
   <div class="checkbox">
      Options not specified.
   </div>
</div>
@endif
<!--    end if( $countOption ==0)     -->

@endif
<!--    end  if(count($defaultOptions) > 0)        -->

<?php $allow_multiple_answer = $row->allow_multiple_answer; ?>
@endif
<!--    end  if($row->answer_method =='mcq')        -->

<!--    start  if($row->answer_method =='3Combo')        -->
@if($row->answer_method =='3Combo')
<p class="mrgn-btm-15">{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?>
</p>
<div class="col-sm-12 mrgn-btm-5 pdng-lft-0 mrgn-tp-5">
   <div class="col-sm-2">
      <select id="basic" class="selectpicker show-tick form-control">
         @for($i=1; $i<=100;$i++)
         <option>{{$i}}</option>
         @endfor
      </select>
   </div>
   <div class="col-sm-2">
      <select id="basic" class="selectpicker show-tick form-control">
         <option>Year(s)</option>
         <option>Month(s)</option>
         <option>Week(s)</option>
         <option>Day(s)</option>
         <option>Hour(s)</option>
      </select>
   </div>
   <div class="col-sm-3">

      <!--    start  if(count($defaultOptions) > 0)        -->
      @if(count($defaultOptions) > 0)

      <!--    start  foreach($defaultOptions as $opt)        -->
      @foreach($defaultOptions as $opt)

      <!--    start if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->
      @if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)

      <!--    start if($opt->option_status ==1)     -->
      @if($opt->option_status ==1)
      <input type="text" name="txt3ComboAnswer" id="txt3ComboAnswer" value="{{$opt->default_option }}" class="form-control" >

      @endif
      <!--    end if($opt->option_status ==1)     -->

      @endif
      <!--    end if($opt->question_category_id == $quid && $opt->category_id == $row->category_id)     -->

      @endforeach
      <!--    end  foreach($defaultOptions as $opt)        -->

      @endif
      <!--    end  if(count($defaultOptions) > 0)        -->
   </div>
</div>
@endif
<!--    end  if($row->answer_method =='3Combo')        -->


<!--    start  if($row->answer_method =='yesNo')        -->
@if($row->answer_method =='yesNo')
<p class="mrgn-btm-15">{{$i}}. <?php
   echo replaceTextWithActualValue($questionSet->steps_completed, '[CC]', $questionSet->title, $row->question, 'cc');
   echo showQusetionCategoryComments($row->comments, '')
   ?></p>
<div class="col-sm-3 pdng-0">
   <select id="basic" class="selectpicker show-tick form-control">
      <option>Yes</option>
      <option>No</option>
   </select>
</div>

@endif
<!--    end  if($row->answer_method =='yesNo')        -->