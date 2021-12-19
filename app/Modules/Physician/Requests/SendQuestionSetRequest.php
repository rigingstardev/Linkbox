<?php namespace App\Modules\Physician\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SendQuestionSetRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules      = [];
        $selectType = $this->request->get('selectType');
        // sigle for text box value  , list for checkbox option
        if ($selectType == 'single') {
            if (array_key_exists("chkBxEmail", $_REQUEST))
                $rules["email"] = 'bail|required|email|max:255';
            if (array_key_exists("chkBxText", $_REQUEST)) {
                $rules["phone"]        = 'bail|required|min:10|max:15|regex:/^\+?[^a-zA-Z]{5,}$/|min:10|max:15';
                $rules["country_code"] = 'bail|required|max:5|regex:/^\+?[^a-zA-Z]{1,}$/';
            }
        } else if ($selectType == 'list') {
            $selected  = 0;
            $totalRows = $this->request->get('totalRows');
            for ($i = 1; $i <= $totalRows; $i++) {
                if (array_key_exists("checkPatient$i", $_REQUEST)) {
                    $selected++;
                }
            }
            if ($selected == 0) {
                $rules["validatePatient"] = 'required';
            }
        }
        if (array_key_exists("customMessage", $_REQUEST))
            $rules["customMessage"]      = 'bail|required|max:255';
        if (array_key_exists("customMessagePopUp", $_REQUEST))
            $rules["customMessagePopUp"] = 'bail|required|max:255';
        return $rules;
    }

    function messages()
    {
        $selectType = $this->request->get('selectType');
        // sigle for text box value  , list for checkbox option
        $messages   = [];
        if ($selectType == 'list') {
            $selected  = 0;
            $totalRows = $this->request->get('totalRows');
            if ($selected == 0) {
                $messages["validatePatient.required"] = trans("custom.specify_recipient");
            }
            if (array_key_exists("customMessagePopUp", $_REQUEST)) {
                $messages["customMessagePopUp.required"] = trans("Physician::messages.specify_message_to_send");
            }
            return $messages;
        }
        if ($selectType == 'single') {
            if (array_key_exists("chkBxText", $_REQUEST)) {
                $messages["phone.required"] = trans("custom.specify_phone");
                $messages["phone.min"]      = trans("custom.phone_min");
                $messages["phone.max"]      = trans("custom.phone_max");
                $messages["phone.regex"]    = trans("custom.phone_regex_format");
            }
        }
        if (array_key_exists("customMessage", $_REQUEST)) {
            $messages["customMessage.required"] = trans("Physician::messages.specify_message_to_send");
        }
         return $messages;
    }

    public function authorize()
    {
        return true;
    }
}
