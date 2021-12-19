<?php namespace App\Modules\Physician\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteQSRequest extends FormRequest
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
        $rules["qid"]    = 'bail|required|numeric';
        return $rules;
    }

    public function messages()
    {
        $messages = [];

        $messages["qid.required"] = trans("Physician::messages.specify_delete_question");
        $messages["qid.numeric"]  = trans("Physician::messages.specify_valid_question_set");
 
        return $messages;
    }

    public function authorize()
    {
        return true;
    }
}
