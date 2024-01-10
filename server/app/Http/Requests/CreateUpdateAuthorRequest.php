<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateUpdateAuthorRequest extends FormRequest
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
                'regex:/^[\pL\s]+$/u', //regex chỉ nhận ký tự hoa, thường
                'min:4','max:55',
            ],
            'description' => 'required|min:20',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên tác giả!",
            'name.regex' => "Tên tác giả chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên tác giả tối thiểu :min ký tự!",
            'name.max' => "Tên tác giả tối đa :max ký tự!",
            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả tối thiểu :min ký tự!",
            'image.mimes' => "Vui lòng chọn ảnh có đuôi :mimes",
            'image.max' => "Vui lòng chọn ảnh dung lượng dưới :max kilobyte!"
        ];
    }
}
