<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => 'required|integer|min:1|unique:discounts,book_id,'.$this->id.',id',
            'percent' => 'required|numeric|min:10|max:99',
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d',
            
        ];
    }

    public function messages(): array
    {
        return [
            'percent.required' => "Vui lòng nhập giảm giá!",
            'percent.numeric' => "Giảm giá là kiểu số!",
            'percent.min' => "Giá trị giảm tối thiểu là :min%!",
            'percent.max' => "Giá trị giảm tối đa là :max%!!",

            'start_date.required' => "Vui lòng nhập ngày bắt đầu!",
            'start_date.date' => "Vui lòng nhập ngày bắt đầu hợp lệ!",
            'start_date.date_format' => "Ngày bắt đầu phải đúng định dạng :date_format!",

            'end_date.required' => "Vui lòng nhập ngày bắt đầu!",
            'end_date.date' => "Vui lòng nhập ngày bắt đầu hợp lệ!",
            'end_date.date_format' => "Ngày bắt đầu phải đúng định dạng :date_format!",

            'book_id.required' => "Vui lòng chọn Sách!",
            'book_id.integer' => "Vui lòng chọn Sách hợp lệ!",
            'book_id.min' => "Giá trị của sách không hợp lệ!",
            'book_id.unique' => "Sách này đang được giảm giá, vui lòng chọn sách khác!",
        ];
    }
}
