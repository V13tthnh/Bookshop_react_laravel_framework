<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Str;
class SuppliersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Supplier([
            'name' => $row['name'],
            'address' => $row['address'],
            'phone' => $row['phone'],
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
                'min:4',
                'max:50',
                'regex:/^[\pL\s]+$/u',
                'unique:suppliers,name'
            ],
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'description' => 'required|min:25',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => "Tên nhà cung cấp không được trống!",
            'name.min' => "Tên nhà cung cấp ít nhất :min ký tự!",
            'name.max' => "Tên nhà cung cấp tối đa :max ký tự!",
            'name.regex' => "Tên nhà cung cấp chỉ chứa ký tự hoa, thường",
            'name.unique' => "Tên nhà cung cấp đã tồn tại!",

            'address.required' => "Địa chỉ không được trống!",
            'address.max' => "Địa chỉ nhà cung cấp tối đa :max ký tự!",

            'phone.required' => "Số điện thoại không được trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'description.required' => "Mô tả không được trống!",
            'description.min' => "Mô tả ít nhất :min ký tự!"
        ];
    }
}
