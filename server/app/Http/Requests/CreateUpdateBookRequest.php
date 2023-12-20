<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:200|unique:books,name,' . $this->id . ',id',
            'code' => 'required|string|max:13',
            'description' => 'required|min:40',
            'weight' => 'required|numeric|max:10000',
            'format' => 'required|string|max:20',
            'year' => 'required|numeric|digits:4',
            'language' => 'required|string|max:20',
            'size' => 'required|string|max:20',
            'num_pages' => 'required|numeric|max:5000',
            'translator' => 'required|string|max:50',
            'supplier_id' => 'required|integer|not_in:0',
            'publisher_id' => 'required|integer|not_in:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên sách!",
            'name.max' => "Tên sách tối đa :max ký tự!",
            'name.unique' => "Tên sách đã tồn tại!",

            'code.required' => "Vui lòng nhập mã sách!",
            'code.max' => "Mã sách tối đa :max ký tự!",

            'size.required' => "Vui lòng nhập kích thước!",
            'size.size' => "Kích thước tối đa :size ký tự!",

            'language.required' => "Vui lòng nhập ngôn ngữ!",
            'language.max' => "Ngôn ngữ tối đa :max ký tự!",

            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!",

            'weight.required' => "Vui lòng nhập trọng lượng sách!",
            'weight.numeric' => "Trọng lượng phải là kiểu số!",
            'weight.max' => "Trọng lượng tối đa là :max gr!",

            'format.required' => "Vui lòng nhập hình thức!",
            'format.max' => "Mã sách tối đa :max ký tự!",

            'year.required' => "Vui lòng nhập năm XB!",
            'year.numeric' => 'Năm xuất bản chỉ chứa ký số!',
            'year.digits' => "Năm xuất bản tối đa :digits số!",

            'num_pages.required' => "Vui lòng nhập số trang!",
            'num_pages.numeric' => "Số trang phải là kiểu số nguyên!",
            'num_pages.max' => "Số trang tối đa là :max trang!",

            'translator.required' => "Vui lòng nhập người dịch!",
            'translator.max' => "Người dịch chứa tối đa :max ký tự!",

            'publisher_id.required' => "Vui lòng chọn nhà xuất bản!",
            'publisher_id.integer' => "Vui lòng chọn nhà xuất bản hợp lệ!",

            'supplier_id.required' => "Vui lòng chọn nhà cung cấp!",
            'supplier_id.integer' => "Vui lòng chọn nhà cung cấp hợp lệ!",
        ];
    }
}
