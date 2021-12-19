@include('layouts.answer_entry_options')
<!-------------------          question header section ------------------------>
</div> 
<?php
$optionSettings = array();
if (count((array)$yesNoQues) > 0) {

    for ($k = 0; $k < count((array)$yesNoQues); $k++) {
        $optionSettings[$yesNoQues[$k]['ans_option']] = $yesNoQues[$k]['category_question_id'];
    }
}
?>
<div class="col-sm-12 mrgn-btm-5 mrgn-tp-5">
   <div class="col-sm-2 col-md-2 pdng-lft-0 ">
      <!--onchange="getNextQuestionToAsk('Yes', this.value,{{$rid}},{{$qid}},{{$cid}})"-->
      <select id="ansYesNoYes" name="ansYesNoYes"   class="selectpicker show-tick form-control">
         <!-- <option value=""> </option> -->
         <option value="Yes" <?php if (key_exists('Yes', $optionSettings)) echo 'selected' ?>>If Yes</option>
      </select>
   </div> 

   <div class="col-sm-12 col-md-6 pdng-lft-0 ">
      <select id="ansYesNoYesQuestion" name="ansYesNoYesQuestion" class="selectpicker show-tick form-control">
         <option value="">Select Question</option>
         <?php
         foreach ($yesNoMasterQues as $mQues) {
             echo '<option value="' . $mQues->id . '"';
             if (key_exists('Yes', $optionSettings) && $optionSettings['Yes'] == $mQues->id)
                 echo 'selected';
             echo ' >' . $mQues->question . ' ( ' . $mQues->category . ' )</option>';
         }
         ?>
      </select>
   </div>
</div>
<div class="col-sm-12 mrgn-btm-5 mrgn-tp-5">
   <div class="col-sm-2 col-md-2 pdng-lft-0 ">
      <!--onchange="getNextQuestionToAsk('No', this.value,{{$rid}},{{$qid}},{{$cid}})"-->
      <select id="ansYesNoNo" name="ansYesNoNo"  class="selectpicker show-tick form-control">
         <!-- <option value=""></option> -->
         <option value="No" <?php if (key_exists('No', $optionSettings)) echo 'selected' ?>>If No</option>
      </select>
   </div>
   <div class="col-sm-12 col-md-6 pdng-lft-0 ">
      <select id="ansYesNoNoQuestion" name="ansYesNoNoQuestion" class="selectpicker show-tick form-control">
         <option value=""> Select Question</option>
         <?php
         foreach ($yesNoMasterQues as $mQues) {
             echo '<option value="' . $mQues->id . '"';
             if (key_exists('No', $optionSettings) && $optionSettings['No'] == $mQues->id)
                 echo 'selected';
             echo ' >' . $mQues->question . ' ( ' . $mQues->category . ' )</option>';
         }
         ?>
      </select>
   </div>
</div>
</div>
@include('layouts.answer_entry_footer')

