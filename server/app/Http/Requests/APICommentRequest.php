<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APICommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment_text' => 'required|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'comment_text.required' => "* Vui lòng nhập bình luận!",
            'comment_text.max' => "* Chỉ được bình luận tối đa :max ký tự!",
        ];
    }
}
