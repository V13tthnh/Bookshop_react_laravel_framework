<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APIReviewHandler extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
        return [
            'rating' => 'required|numeric|min:1|max:5',
            'comment' => 'required|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => "Vui lòng chọn số sao đánh giá!",
            'rating.min' => "Vui lòng chọn số sao đánh tối thiểu :min sao!",
            'rating.max' => "Số sao đánh giá tối đa là :max sao!",
            'rating.numeric' => "Dữ liệu đánh giá lỗi!",

            'comment.required' => "Vui lòng nhập nội dung đánh giá sản phẩm!",
            'comment.min' => "Nội dung đánh giá ít nhất :min ký tự!",
        ];
    }
}
