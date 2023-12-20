<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateGoodsReceivedNoteRequest extends FormRequest
{
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|integer|not_in:0',
            'formality' => 'required|string|not_in:0',
            // 'book_id' => 'array|integer|not_in:0',
            // 'quantity' => 'array|numeric|min:0|max:200',
            // 'import_unit_price' => 'array|numeric|min:0|max:750000000',
            // 'export_unit_price' => 'array|numeric|min:0|max:750000000',
        ];
    }

    public function messages(): array
    {
        return [
            'supplier_id.required' => "Vui lòng nhập nhà cung cấp!",
            'supplier_id.integer' => "Vui lòng chọn nhà cung cấp hợp lệ!",
            'supplier_id.not_in' => "Vui lòng chọn nhà cung cấp hợp lệ!",

            'formality.required' => "Vui lòng chọn hình thức thanh toán!",
            'formality.string' => "Vui lòng chọn hình thức thanh toán hợp lệ!",
            'formality.not_in' => "Vui lòng chọn hình thức thanh toán hợp lệ!",

            // 'book_id.integer' => "Vui lòng chọn sản phẩm hợp lệ!",
            // 'book_id.not_in' => "Vui lòng chọn sản phẩm hợp lệ!",
            
            // 'quantity.numeric' => "Số lượng chỉ được nhập bằng số!",
            // 'quantity.min' => "Số lượng nhập tối thiểu phải lớn hơn :min!",
            // 'quantity.max' => "Số lượng nhập tối đa là :max!",
            
            // 'import_unit_price.number' => "Giá trị nhập phải là một chữ số!",
            // 'import_unit_price.min' => "Giá trị nhập phải lớn hơn :min!",
            // 'import_unit_price.max' => "Giá trị nhập phải nhỏ hơn :max!",

            // 'export_unit_price.numeric' => "Giá trị bán phải là một chữ số!",
            // 'export_unit_price.min' => "Giá trị bán phải lớn hơn :min!",
            // 'export_unit_price.max' => "Giá trị bán phải bé hơn :max!",
        ];
    }
}
