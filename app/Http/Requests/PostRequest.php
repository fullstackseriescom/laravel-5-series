<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // https://mattstauffer.co/blog/laravel-5.0-form-requests#4.-create-your-formrequest
        return \Auth::check() && (\Auth::user()->hasPermissionTo('post_create') || \Auth::user()->hasPermissionTo('post_edit'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:posts,title,'.$this->id.'|max:255',
            'body' => 'required',
        ];
    }
}
