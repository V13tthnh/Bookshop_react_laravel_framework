<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdatePublisherRequest extends FormRequest
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
                'regex:/^[\pL\s]+$/u',
                'unique:publishers,name,'.$this->id.',id'
            ],
            'description' => 'required|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên nhà xuất bản!",
            'name.min' => "Tên nhà xuất bản ít nhất :min ký tự!",
            'name.max' => "Tên nhà xuất bản tối đa :max ký tự!",
            'name.regex' => "Tên nhà xuất bản chỉ chứa ký tự hoa, thường",
            'name.unique' => "Tên nhà xuất bản đã tồn tại!",

            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
