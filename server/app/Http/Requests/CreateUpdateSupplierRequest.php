<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:4',
                'max:50',
                'regex:/^[\pL\s]+$/u',
                'unique:suppliers,name,'.$this->id.',id'
            ],
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'description' => 'required|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên nhà cung cấp!",
            'name.min' => "Tên nhà cung cấp ít nhất :min ký tự!",
            'name.max' => "Tên nhà cung cấp tối đa :max ký tự!",
            'name.regex' => "Tên nhà cung cấp chỉ chứa ký tự hoa, thường",
            'name.unique' => "Tên nhà cung cấp đã tồn tại!",

            'address.required' => "Vui lòng nhập địa chỉ!",
            'address.max' => "Địa chỉ nhà cung cấp tối đa :max ký tự!",

            'phone.required' => "Vui lòng nhập số điện thoại!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
