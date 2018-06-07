<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitFormRequest extends FormRequest
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
        $form = $this->route('form');

        $rules = [];

        foreach( $form->fields as $field )
        {
            if( $field->required )
            {
                $rules[$field->name] = 'required';
            }
        }

        return $rules;
    }
}
