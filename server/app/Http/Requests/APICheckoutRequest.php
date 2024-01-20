<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APICheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => 'required|numeric',
            'name' => 'required|min:4|max:50|regex:/^[\pL\s]+$/u',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'format' => 'required',
        ];
    }

    public function messages(){
        return [
            'customer_id.required' => "Vui lòng đăng nhập để có thể mua hàng!",
            'customer_id.numeric' => "Dữ liệu người dùng lỗi!",

            'name.required' => "Vui lòng nhập tên người nhận!",
            'name.regex' => "Tên chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên tối thiểu :min ký tự!",
            'name.max' => "Tên tối đa :max ký tự!",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.string' => "Địa chỉ phải là một chuỗi ký tự!",
            'address.max' => "Địa chỉ tối đa :max ký tự!",

            'phone.required' => "Số điện thoại không được bỏ trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'format.required' => "Vui lòng chọn hình thức thanh toán!",
        ];
    }
}
