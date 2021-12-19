<?php /* ?>
<div class=" narrative-edit mrgn-btm-20">
   <p id="div-show-narrative-output-{{$rid}}"><b>Narrative Output : </b>
      @if($optionFlag ==1)
      @foreach ($result as $ques)
      {{$ques->narrative_output}}
      @endforeach
      @else
      {{$defaultQustionOfAnswerType->narrative_output }}
      @endif
   </p>
    <p class="mrgn-tp-20">
      @if(count($narrativeOutput)> 0)
      @foreach($narrativeOutput as $outout)
      <!--check to display text box content-->
      <?php
   $displayText        = trim($outout->display_text) . ' ';
      $displayOrderNumber = $outout->display_order;
      $displayOrder       = '-' . $rid . '-' . $outout->display_order;
       ?>
      @if($outout->display_in_textbox==0)
      <span class="narrativeOut{{$displayOrder}} @if( $answer_method == 'dateT'  && !$outout->text_enabled ) {{'hidden'}}@endif">{{ $displayText}}</span>
      <input type="hidden" id="narrativeOut{{$displayOrder}}"  name="narrativeOut{{$displayOrder}}" value="{{$displayText}}"/>

      @elseif($outout->display_in_textbox==1)
      <input type="text" class="form-control width-dynamic proba dva @if($answer_method == 'dateT'  && !$outout->text_enabled) {{'hidden'}}@endif" id="narrativeOut{{$displayOrder}}" name="narrativeOut{{$displayOrder}}" placeholder="{{$displayText}}" value="{{$displayText}}"/>
      @endif

      <input type="hidden" id="showType{{$displayOrder}}" name="showType{{$displayOrder}}" value="{{$outout->display_in_textbox}}">
      @endforeach

      <input type="hidden" id="narrativeOutCount" name="narrativeOutCount" value="{{$displayOrderNumber}}"/>
      @endif
   </p>
</div>
<?php */ ?>