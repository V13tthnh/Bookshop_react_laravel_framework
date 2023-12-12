<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateFormDashBoardLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required', 
                'email', 
            ],
            'password' => [
                'required',
                'min:4',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])/u',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => "Vui lòng nhập email!",
            'email.email' => "Email phải có ký tự @!",
            'email.unique' => "Email đã tồn tại!",

            'password.required' => "Vui lòng nhập mật khẩu",
            'password.min' => "Mật khẩu tối đa :min ký tự",
            'password.max' => "Mật khẩu tối đa :max ký tự",
            'password.regex' => "Mật khẩu phải bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt!",
        ];
    }
}
