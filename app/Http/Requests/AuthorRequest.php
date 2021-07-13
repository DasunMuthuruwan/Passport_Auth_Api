<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'password' => 'required|confirmed'
        ];
    }

    public function messages()
    {
       return [
            'name.required' => 'name field is required',
            'email.required' => 'email field is required',
            'password.required' => 'password field is required'
        ];
    }
}
