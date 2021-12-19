<div class="col-sm-1 pdng-0"> 
    <?php echo e(Form::selectRange("answer[$qSets->id][$qSets->category_id]", 10, 1, $CurAnswer[$qSets->id][$qSets->category_id], ['id'=>'basic','class'=>"selectpicker show-tick form-control $clinicalCls"])); ?>

</div>