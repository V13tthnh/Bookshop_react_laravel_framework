<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateSliderRequest extends FormRequest
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
                'unique:sliders,name,' . $this->id . ',id',
            ],
            'start_date' => 'required|date|date_format:Y-m-d',
            'end_date' => 'required|date|date_format:Y-m-d',
            'book_id' => 'required|integer',
            'image' => 'image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tiêu đề cho slider!",
            'name.min' => "Tên slider ít nhất :min ký tự!",
            'name.max' => "Tên slider tối đa :max ký tự!",
            'name.unique' => "Tên slider đã tồn tại!",

            'start_date.required' => "Vui lòng nhập ngày bắt đầu!",
            'start_date.date' => "Vui lòng nhập ngày bắt đầu hợp lệ!",
            'start_date.date_format' => "Ngày bắt đầu phải đúng định dạng :date_format!",

            'end_date.required' => "Vui lòng nhập ngày bắt đầu!",
            'end_date.date' => "Vui lòng nhập ngày bắt đầu hợp lệ!",
            'end_date.date_format' => "Ngày bắt đầu phải đúng định dạng :date_format!",

            'book_id.required' => "Vui lòng chọn sản phẩm",
            'book_id.integer' => "Vui lòng chọn sản phẩm hợp lệ",

            'image.required' => "Vui lòng chọn ảnh!",
            'image.image' => "Vui lòng chỉ chọn file ảnh!",
            // 'image.mimes' => "Vui lòng chọn ảnh có đuôi jpeg,png,jpg!",
            'image.max' => "Vui lòng chọn ảnh dung lượng dưới :max kilobyte!",
        ];
    }
}
