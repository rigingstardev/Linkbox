<?php 
namespace App\Modules\Physician\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionCreateRequest extends FormRequest
{
   /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules                   = [];                  
        if(0 == FormRequest::get('token')) {
            $rules = [
                'number' => 'required|regex:/["0-9"]$/|min:10',  
                'exp_month' =>  'required',                        
                'exp_year' => 'required',
                'cvc' => 'required|regex:/^\d{3,4}$/'
            ];
        }
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