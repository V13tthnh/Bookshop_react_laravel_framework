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
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:1|max:100',
            'book_id' => 'required|array',
            'book_id.*' => 'numeric|min:1',
            'import_unit_price' => 'required|array',
            'import_unit_price.*' => 'numeric|min:10000|max:750000000',
            'export_unit_price' => 'required|array',
            'export_unit_price.*' => 'numeric|min:10000|max:750000000',
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

            'book_id.required' => "Vui lòng chọn sản phẩm hợp lệ!",
            'book_id.*.numeric' => "Vui lòng chọn sản phẩm hợp lệ!",
            'book_id.*.min' => "Vui lòng chọn sản phẩm hợp lệ!",
            
            'quantity.required' => "Vui lòng chọn số lượng nhập!",
            'quantity.*.numeric'=> "Số lượng phải là kiểu số nguyên!",
            'quantity.*.min' => "Số lượng nhập tối thiểu là :min!",
            'quantity.*.max' => "Số lượng nhập tối đa là :max!",
            
            'import_unit_price.required' => "Vui lòng chọn giá nhập!",
            'import_unit_price.*.numeric' => "Giá trị nhập phải là kiểu số!",
            'import_unit_price.*.min' => "Giá trị nhập tối thiểu :min!",
            'import_unit_price.*.max' => "Giá trị nhập tối đa :max!",

            'export_unit_price.required' => "Vui lòng chọn giá bán!",
            'export_unit_price.*.numeric' => "Giá trị bán phải là kiểu số!",
            'export_unit_price.*.min' => "Giá trị bán tối thiểu :min!",
            'export_unit_price.*.max' => "Giá trị bán tối đa :max!",
        ];
    }
}
