<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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

            'avatar.mimes' => "Vui lòng chọn ảnh có đuôi :mimes",
            'avatar.max' => "Vui lòng chọn ảnh dung lượng dưới :max kilobyte!",
            
            'role.required' => "Vui lòng chọn quyền admin!",
            'role.in' => "Vui lòng chọn quyền admin hợp lệ!"
        ];
    }
}
