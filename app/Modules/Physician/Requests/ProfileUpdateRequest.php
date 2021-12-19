<?php namespace App\Modules\Physician\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
class ProfileUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'physician_name' => 'required|max:255',
            'email' => 'bail|required|email|max:255|unique:users,id,' . Auth::id().' ',
            'speciality' => 'required',
            'hospital_name' => 'required|max:255',
            'npi_number' => 'required|max:255',
            'city' => 'required|max:255',
            'country_code' => 'bail|required|max:5|regex:/^\+?[^a-zA-Z]{1,}$/',
            'contact_number' => 'bail|required|min:10|max:15|regex:/^\+?[^a-zA-Z]{5,}$/',
            'profile_description' => 'max:1000',
        ];
    }

    public function messages()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }
}
