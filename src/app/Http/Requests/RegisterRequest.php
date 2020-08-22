<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:4|max:35',
            'email' => 'required|email|unique:users,email|min:5|max:255',
            'password' => 'required|min:4|max:255',
            'url' => 'unique:users,url|min:1|max:35',
        ];
    }
}
