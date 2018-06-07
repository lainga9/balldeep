<?php

namespace Lainga9\BallDeep\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreFormNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::guard('balldeep')->user();

        return ! is_null($user) && $user->isAn('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'content' => 'required'
        ];
    }
}