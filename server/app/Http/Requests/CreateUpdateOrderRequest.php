<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|numeric',
            'name' => 'required|string|min:10|max:55|regex:/^[\pL\s]+$/u',
            'address' => 'required|string|min:25|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'shipping_fee' => 'min:30|max:45',
            'note' => 'string'
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.required' => "Người dùng chưa đăng nhập!",
            'customer_id.numeric' => "Dữ liệu người dùng không hợp lệ!",

            'name.required' => "Tên không được bỏ trống!",
            'name.regex' => "Tên chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên tối thiểu :min ký tự!",
            'name.max' => "Tên tối đa :max ký tự!",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.string' => "Địa chỉ phải là một chuỗi ký tự!",
            'address.max' => "Địa chỉ tối đa :max ký tự!",
            'address.min' => "Tên tối thiểu :min ký tự!",

            'phone.required' => "Số điện thoại không được bỏ trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'shipping_fee.min' => "Phí ship tối thiểu :min đ",
            'shipping_fee.max' => "Phí ship tối đa :max đ",

            'note.string' => 'Dữ liệu ghi chú không hợp lệ!'
        ];
    }
}
