<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50|unique:categories,name,'.$this->id.',id',
            'description' => 'required|min:20',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên thể loại!",
            'name.min' => "Tên thể loại ít nhất :min ký tự!",
            'name.max' => "Tên thể loại tối đa :max ký tự!",
            'name.unique' => "Tên thể loại đã tồn tại!",
            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
