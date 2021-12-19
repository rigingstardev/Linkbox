<?php namespace App\Modules\Physician\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeNarrativeOutputRequest extends FormRequest
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
        $rules["defaultnarrativeoutput"]    = 'bail|required';
        return $rules;
    }
    public function messages()
    {
        $messages = [];
        $messages["defaultnarrativeoutput.required"] = trans("Physician::messages.specify_narrative_output");  
        return $messages;
    }
    public function authorize()
    {
        return true;
    }
}
