<?php namespace App\Modules\Physician\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerMethodRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $checkboxChecked = 0;
        $rules           = [];
        $rid             = $this->request->get('rid');
        $answeringMethod = $this->request->get('answeringMethod' . $rid);
        if ($answeringMethod == 'mcq' || $answeringMethod == 'dropDown') {
            $maxCount = $this->request->get('dropDownOptionCount' . $rid);
            for ($i = 1; $i <= $maxCount; $i++) {
                // checking if the option is active by selecting the check box
                if (array_key_exists("txtOption-$rid-$i", $_REQUEST)) {
                    // $currentDefaultOption    = $reqData["txtOption-$rid-$i"];
                    $rules["txtOption-$rid-$i"] = 'required|max:255';
                }
                // checking if the option is active by selecting the check box
                if (array_key_exists("dropDownOptionCheck-$rid-$i", $_REQUEST)) {
                    $checkboxChecked++;
                }
            }
            if ($checkboxChecked == 0) {
                $rules["dropDownOptionCheckBoxCount$rid"] = 'required';
            }
        } else if ($answeringMethod == '3Combo') {
            $rules["txt3ComboAnswer"] = 'required|max:255';
        } else if ($answeringMethod == 'yesNo') {

          /*  $ansYesNoYes = $this->request->get('ansYesNoYes');
            $ansYesNoNo  = $this->request->get('ansYesNoNo');
            if ($ansYesNoYes == '' && $ansYesNoNo == '') {
                $rules["ansYesNoYes"] = 'required';
            } else {*/
               // if ($ansYesNoYes != '')
                    $rules["ansYesNoYes"] = 'required';
                    $rules["ansYesNoNo"] = 'required';
                    $rules["ansYesNoYesQuestion"] = 'required';
              //  if ($ansYesNoNo != '')
                    $rules["ansYesNoNoQuestion"]  = 'required';
           // }
        }

        return $rules;
    }

    public function messages()
    {
        $messages        = [];
        $rid             = $this->request->get('rid');
        $answeringMethod = $this->request->get('answeringMethod' . $rid);
        if ($answeringMethod == 'mcq' || $answeringMethod == 'dropDown') {
            $maxCount = $this->request->get('dropDownOptionCount' . $rid);
            for ($i = 1; $i <= $maxCount; $i++) {
                // checking if the option is active by selecting the check box
                if (array_key_exists("txtOption-$rid-$i", $_REQUEST)) {
                    // $currentDefaultOption    = $reqData["txtOption-$rid-$i"];
                    $messages["txtOption-$rid-$i.required"] = trans("custom.specify_option");
                    $messages["txtOption-$rid-$i.max"]      = trans("custom.text_option_max_length");
                }
            }
            $messages["dropDownOptionCheckBoxCount$rid.required"] = trans("custom.specify_option_only");
        } else if ($answeringMethod == '3Combo') {
            $messages["txt3ComboAnswer.required"] = trans("Physician::messages.specify_duration_text");
            $messages["txt3ComboAnswer.max"]      = trans("custom.text_option_max_length");
        } else if ($answeringMethod == 'yesNo') {
         /*   $ansYesNoYes                      = $this->request->get('ansYesNoYes');
            $ansYesNoNo                       = $this->request->get('ansYesNoNo');
            if ($ansYesNoYes == '' && $ansYesNoNo == '')
                $messages["ansYesNoYes.required"] = trans("Physician::messages.specify_yes_no_answer");
            else {*/
           //     if ($ansYesNoYes != '')
                   
                    $messages["ansYesNoYes.required"] = trans("Physician::messages.specify_question_if_answer_is_yes");
                    $messages["ansYesNoNo.required"] = trans("Physician::messages.specify_question_if_answer_is_yes");
                    $messages["ansYesNoYesQuestion.required"] = trans("Physician::messages.specify_question_if_answer_is_yes");
             //   if ($ansYesNoNo != '')
                    $messages["ansYesNoNoQuestion.required"]  = trans("Physician::messages.specify_question_if_answer_is_no");
         //   }
        }
        return $messages;
    }

    public function authorize()
    {
        return true;
    }
}
