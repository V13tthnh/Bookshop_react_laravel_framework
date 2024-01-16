<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class APICommentReplyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'reply_text' => 'required|max:150'
        ];
    }

    public function messages(): array
    {
        return [
            'reply_text.required' => "* Vui lòng nhập bình luận!",
            'reply_text.max' => "* Chỉ được bình luận tối đa :max ký tự!",
        ];
    }
}
