<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateComboRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50|unique:combos,name,'.$this->id.',id',
            'quantity' => 'required|numeric|min:1|max:200',
            'price' => 'required|numeric|min:1|max:10000000',
            'supplier_id' => 'required|numeric|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên thể loại!",
            'name.min' => "Tên combo ít nhất :min ký tự!",
            'name.max' => "Tên combo tối đa :max ký tự!",
            'name.unique' => "Tên combo đã tồn tại!",
            'quantity.required' => "Vui lòng nhập số lượng!",
            'quantity.numeric' => "Số lượng là kiểu số!",
            'quantity.min' => "Số lượng tối thiểu :min!",
            'quantity.max' => "Số lượng tối đa: max!",
            'price.required' => "Vui lòng nhập giá bán hợp lệ!",
            'price.numeric' => "Giá là kiêu số!",
            'price.min' => "Giá tối thiểu :min!",
            'price.max' => "Giá tối đa :max!",
            'supplier_id.required' => "Vui lòng chọn nhà cung cấp!",
            'supplier_id.min' => "Vui lòng chọn nhà cung cấp hợp lệ!"
        ];
    }
}
