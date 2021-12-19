<?php

namespace App\Modules\Physician\Requests;

use Illuminate\Support\Facades\Auth;
 use Illuminate\Foundation\Http\FormRequest;
 
class EditImageRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages() {
        return [];
    }

    public function authorize() {
        return true;
    }

}
