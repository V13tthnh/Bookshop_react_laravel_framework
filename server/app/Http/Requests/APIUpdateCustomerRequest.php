<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIUpdateCustomerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            "name" => 'required|min:4|max:50|regex:/^[\pL\s]+$/u',
            "email" => [
                'email',
                'unique:customers,email,' . $this->id . ',id'
            ],
            "address" => 'required|string|max:255',
            "phone" => 'required|regex:/^0[0-9]{9,10}$/',
            "password" => [
                'min:4',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])/u',
            ],
            //"image" => 'image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên!",
            'name.regex' => "Tên chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên chứa tối thiểu :min ký tự!",
            'name.max' => "Tên chứa tối đa :max ký tự!",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.string' => "Địa chỉ phải là một chuỗi ký tự!",
            'address.max' => "Địa chỉ tối đa :max ký tự!",

            'phone.required' => "Số điện thoại không được bỏ trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'email.email' => "Email phải có ký tự @!",
            'email.unique' => "Email đã tồn tại!",

            'password.min' => "Mật khẩu tối đa :min ký tự!",
            'password.max' => "Mật khẩu tối đa :max ký tự!",
            'password.regex' => "Mật khẩu phải bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt!",

            // 'image.image' => "Vui lòng chỉ chọn file ảnh!",
            // 'image.mimes' => "Vui lòng chọn ảnh có đuôi jpeg,png,jpg!",
            // 'image.max' => "Vui lòng chọn ảnh dung lượng dưới :max kilobyte!",
        ];
    }
}
