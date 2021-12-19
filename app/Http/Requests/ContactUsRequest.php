<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'message' => 'required|max:500',
        ];
    }

    public function messages() {
        return [];
    }

    public function authorize() {
        return true;
    }

}
