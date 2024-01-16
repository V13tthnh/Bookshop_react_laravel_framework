<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50|regex:/^[\pL\s]+$/u',
            'email' => [
                'required', 
                'email', 
                'unique:customers,email,'.$this->id.',id'
            ],
            'password' => [
                'required',
                'min:4',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])/u',
            ],
            'confirm_password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "* Vui lòng nhập tên!",
            'name.regex' => "* Tên chỉ chứa ký tự hoa, thường!",
            'name.min' => "* Tên tối thiểu :min ký tự!",
            'name.max' => "* Tên tối đa :max ký tự!",

            'email.required' => "* Vui lòng nhập email!",
            'email.email' => "* Email phải có ký tự @!",
            'email.unique' => "* Email đã tồn tại!",

            'password.required' => "Vui lòng nhập mật khẩu",
            'password.min' => "* Mật khẩu tối đa :min ký tự",
            'password.max' => "* Mật khẩu tối đa :max ký tự",
            'password.regex' => "* Mật khẩu phải bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt!",

            'confirm_password.required' => "* Vui lòng nhập lại mật khẩu!"
        ];
    }
}
