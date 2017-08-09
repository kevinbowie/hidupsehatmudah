<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validasiLogin extends FormRequest
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
            'username' => 'required|min:3|max:30',
            'password' => 'required|min:3',
        ];
    }

    public function messages(){
        return[
            'username.required' => 'username harus diisi',
            'password.required' => 'password harus diisi',  
        ];
    }
}
