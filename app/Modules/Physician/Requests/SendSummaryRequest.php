<?php namespace App\Modules\Physician\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SendSummaryRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules["email"] = 'bail|required|email|max:255';
        return $rules;
    }

    function messages()
    {
        $messages["email.required"] = trans("custom.specify_email");
        $messages["email.max"]      = trans("custom.email_max");
        return $messages;
    }

    public function authorize()
    {
        return true;
    }
}
