<?php

namespace App\Imports;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class CategoriesImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'description' => $row['description'],
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:50', 'unique:categories,name'],
            'description' => ['required', 'min:50'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => "Tên thể loại không được rỗng!",
            'name.string' => "Tên thể loại là kiểu ký tự!",
            'name.min' => "Tên thể loại ít nhất :min ký tự!",
            'name.max' => "Tên thể loại tối đa :max ký tự!",
            'name.unique' => "Tên thể loại đã tồn tại!",
            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
