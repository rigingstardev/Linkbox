<?php namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialHistoryRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'patient_smoke' => 'required',
            'patient_drink' => 'required',
            'patient_drug' => 'required',
        ];
    }
}
