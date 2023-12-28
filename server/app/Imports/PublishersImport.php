<?php

namespace App\Imports;

use App\Models\Publisher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

class PublishersImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;    
    public function model(array $row)
    {
        return new Publisher([
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
            'name' => ['required', 'min:4', 'max:50','regex:/^[\pL\s]+$/u','unique:publishers,name'],
            'description' => 'required|min:50',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => "Tên nhà xuất bản không được rỗng!",
            'name.min' => "Tên nhà xuất bản ít nhất :min ký tự!",
            'name.max' => "Tên nhà xuất bản tối đa :max ký tự!",
            'name.regex' => "Tên nhà xuất bản chỉ chứa ký tự hoa, thường",
            'name.unique' => "Tên nhà xuất bản đã tồn tại!",

            'description.required' => "Vui lòng nhập mô tả!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
