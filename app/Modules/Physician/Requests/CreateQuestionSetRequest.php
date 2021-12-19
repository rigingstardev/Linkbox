<?php namespace App\Modules\Physician\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionSetRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if (array_key_exists('requestType', $_REQUEST)) {
            $checkType = $this->request->get('requestType');
            if ($checkType == 'head' || $checkType == 'all') {
                $rules['chiefComplaint'] = 'required|max:100';
                $description             = trim($_REQUEST['description']);
                $description             = str_replace("\r\n", "\n", $description);
                $description             = str_replace("\r", "\n", $description);
                if (strlen($description) > 1500)
                    $rules['description']    = 'bail|required|max:1500';
                else
                    $rules['description']    = 'required';
            }

            if (($checkType == 'category' || $checkType == 'all') && (!array_key_exists('checkFormatType', $_REQUEST) )) {
                $maxCount = $this->request->get('categoryCount');
                $j        = 0;
                for ($i = 1; $i <= $maxCount; $i++) {
                    if (array_key_exists('category' . $i, $_REQUEST)) {
                        $j++;
                        if ($i == 10)// checking if others category selected
                            $rules['other_question'] = 'bail|required|max:255';
                    }
                }
                if ($j == 0)
                    $rules['category'] = 'required';
            }
            if (array_key_exists('checkFormatType', $_REQUEST)) {
                if (array_key_exists('category10', $_REQUEST))// checking if others category selected
                    $rules['other_question'] = 'bail|required|max:255';
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'category.required' => trans("custom.select_any_category"),
            'chiefComplaint.max' => trans("custom.category_max_length"),
            'description.max' => trans("custom.description_max_length"),
            'other_question.required' => trans("custom.specify_other_question"),
            'other_question.max' => trans("custom.other_question_max_length"),
        ];
    }

    public function authorize()
    {
        return true;
    }
}
