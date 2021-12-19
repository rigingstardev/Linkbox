<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'bail|required|email|max:255|unique:patients,id,' . Auth::guard('patient')->user()->id.' ',
            'gender' => 'required',
            'dob' => 'required|max:255',
            'country_code' => 'bail|required|max:5|regex:/^\+?[^a-zA-Z]{1,}$/',
            'contact_number' => 'bail|required|min:10|max:15|regex:/^\+?[^a-zA-Z]{5,}$/',
        ];
    }
}
