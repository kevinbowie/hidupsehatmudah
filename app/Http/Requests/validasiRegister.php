<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validasiRegister extends FormRequest
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
            'usernames' => 'required|max:50',
            'passwords' => 'required',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'emails' => 'email|required|max:50',
            'height' => 'required',
            'weight' => 'required',
            'birthday' => 'required',
            'activity' => 'required',
        ];
    }

    public function messages(){
        $msg = 'harus diisi !';
        return[
            'usernames.required' => 'username ' . $msg,
            'passwords.required' => 'password ' . $msg,
            'first_name.required' => 'nama depan ' . $msg,
            'last_name.required' => 'nama belakang ' . $msg,
            'emails.required' => 'email ' . $msg,
            'emails.email' => 'format email tidak tepat',
            'height.required' => 'tinggi badan ' . $msg,
            'weight.required' => 'berat badan ' . $msg,
            'birthday.required' => 'tanggal lahir ' . $msg,
            'activity.required' => 'aktifitas fisik ' . $msg,
        ];
    }
}
