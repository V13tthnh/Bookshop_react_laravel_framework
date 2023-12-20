<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50|regex:/^[\pL\s]+$/u',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'email' => [
                'required', 
                'email', 
                'unique:admins,email,'.$this->id.',id'
            ],
            'password' => [
                'required',
                'min:4',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])/u',
            ],
            'role' => 'required|in:1,2,3'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên admin!",
            'name.regex' => "Tên admin chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên admin tối thiểu :min ký tự!",
            'name.max' => "Tên admin tối đa :max ký tự!",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.string' => "Địa chỉ phải là một chuỗi ký tự!",
            'address.max' => "Địa chỉ tối đa :max ký tự!",

            'phone.required' => "Số điện thoại không được bỏ trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'email.required' => "Vui lòng nhập email!",
            'email.email' => "Email phải có ký tự @!",
            'email.unique' => "Email đã tồn tại!",

            'password.required' => "Vui lòng nhập mật khẩu",
            'password.min' => "Mật khẩu tối đa :min ký tự",
            'password.max' => "Mật khẩu tối đa :max ký tự",
            'password.regex' => "Mật khẩu phải bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt!",

            'avatar.mimes' => "Vui lòng chọn ảnh có đuôi jpeg,png,jpg,gif",
            'avatar.max' => "Vui lòng chọn ảnh dung lượng dưới :max kilobyte!",

            'role.required' => "Vui lòng chọn quyền admin!",
            'role.in' => "Vui lòng chọn quyền admin hợp lệ!"
        ];
    }
}
