<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:25',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Vui lòng nhập tên danh mục!",
            'name.min' => "Tên danh mục ít nhất :min ký tự!"
        ];
    }
}
