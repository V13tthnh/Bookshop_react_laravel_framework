<?php

namespace App\Imports;

use App\Models\Author;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Str;

class AuthorsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    public function model(array $row)
    {
        return new Author([
            'name' => $row['name'],
            'description' => $row['description'],
            'slug' => Str::slug($row['name']),
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'regex:/^[\pL\s]+$/u', //regex chỉ nhận ký tự hoa, thường
                'min:4','max:55',
            ],
            'description' => 'required|min:25',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => "Tên tác giả không được để trống!",
            'name.regex' => "Tên tác giả chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên tác giả tối thiểu :min ký tự!",
            'name.max' => "Tên tác giả tối đa :max ký tự!",
            'description.required' => "Mô tả không được để trống!",
            'description.min' => "Mô tả tối thiểu :min ký tự!",
           
        ];
    }
}
