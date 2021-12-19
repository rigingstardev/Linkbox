<?php 
namespace App\Modules\Physician\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminStaffCreateRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                   = [];
        $rules = [
            'name' => 'required|max:255',           
            //'email' => 'required|email|max:255|unique:users,email,NULL,id,user_role,"S"',
            'email' =>  ['required',
                         'email', 
                         'max:255',                        
                          Rule::unique('users')->where(function ($query) {
                                $query->where('user_role', 'S');
                                $query->orWhere('user_role', 'D');
                          })
                        ],
            'password' => 'required|regex:/^.*(?=.{10})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*[@!#$%]).*$/',
            'permission' => 'required|min:1'
        ];
        return $rules;
    }
   /* public function messages()
    {
        
    }*/
    public function authorize()
    {
        return true;
    }
}