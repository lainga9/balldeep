<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetaFieldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'      => 'required|regex:/^\w+$/',
            'label'     => 'required',
            'excerpt'   => 'nullable|max:255',
            'type'      => 'required',
            'options'   => 'required_if:type,select'
        ];

        return $rules;
    }
}
