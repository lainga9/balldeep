<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMetaGroupRequest extends FormRequest
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
            'name'      => 'required',
            'types'     => 'array|min:1'
        ];

        return $rules;
    }
}
