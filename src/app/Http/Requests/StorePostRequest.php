<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::guard('balldeep')->user();

        /**
         * When creating a post we have the post type
         * as a route parameter. When updating a post
         * though we have the post model
         * 
         * @var PostType
         */
        $type = $this->method() == 'POST' ? 
                $this->route('postType') :
                $this->route('post')->type;

        return $user && $user->can('create', $type);
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

        return $rules;
    }
}
