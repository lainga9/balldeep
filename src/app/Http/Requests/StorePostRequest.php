<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        $rules = [
            'name'      => 'required',
            'excerpt'   => 'nullable|max:255'
        ];

        // if( count($meta = $this->get('meta')) )
        // {
        //     foreach( $meta as $key => $value )
        //     {
        //         $rules[$key] = 'required';
        //     }
        // }

        return $rules;
    }
}
