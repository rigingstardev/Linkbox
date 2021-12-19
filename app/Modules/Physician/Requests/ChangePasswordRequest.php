<?php

namespace App\Modules\Physician\Requests;

use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'old_password' => 'required|max:255',
            'password' => 'bail|required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@!#$%]).*$/|same:verify_password',
            'verify_password' => 'bail|required|min:10',
        ];
    }

    public function messages() {
        return [];
    }

    public function authorize() {
        return true;
    }

}
