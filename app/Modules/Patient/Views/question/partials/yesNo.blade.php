<?php $yesblock=$noblock="";?>
<?php if ('yes' == $CurAnswer[$qSets->id][$qSets->category_id]); ?>
<?php foreach($yesnoquestions as $yesnokey=>$yesnoval) {
  if('Yes' == $yesnoval['option'])
    $yesblock = 'blk_'.$yesnokey;
  elseif('No' == $yesnoval['option'])
    $noblock = 'blk_'.$yesnokey;
}
?>
<div class="col-sm-3 pdng-0 yesnodiv">
	 <div class="col-sm-12 mrgn-btm-10">         
        <div class="radio">
            {{ Form::radio("answer[$qSets->id][$qSets->category_id]", "yes", ('yes' == $CurAnswer[$qSets->id][$qSets->category_id])?true:false,['id'=>"radio2_".$qSets->id."_".$qSets->category_id."_y",'class'=>"$clinicalCls yesnoqtn",'data-showid' => "$yesblock",'data-qid' => "$qSets->id" ]) }}                  
            <label for="radio2_{!! $qSets->id !!}_{!! $qSets->category_id !!}_y">
               Yes
            </label>
        </div>        
     </div>  
      <div class="col-sm-12 mrgn-btm-10">         
        <div class="radio">
            {{ Form::radio("answer[$qSets->id][$qSets->category_id]", "no", ('no' == $CurAnswer[$qSets->id][$qSets->category_id])?true:false ,['id'=>"radio2_".$qSets->id."_".$qSets->category_id."_n",'class'=>"$clinicalCls yesnoqtn",'data-showid' => "$noblock",'data-qid' => "$qSets->id"]) }}                  
            <label for="radio2_{!! $qSets->id !!}_{!! $qSets->category_id !!}_n">
               No
            </label>
        </div>        
     </div>  
</div>