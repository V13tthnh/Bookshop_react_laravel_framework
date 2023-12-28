<?php

namespace App\Imports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Hash;

class AdminsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    public function model(array $row)
    {
        return new Admin([
            'name' => $row['name'],
            'address' => $row['address'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'role' => $row['role']
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|min:4|max:50|regex:/^[\pL\s]+$/u',
            'address' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9,10}$/',
            'email' => [
                'required', 
                'email', 
                'unique:admins,email'
            ],
            'password' => [
                'required',
                'min:4',
                'max:16',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[^A-Za-z0-9])/u',
            ],
            'role' => 'required|in:1,2,3'
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => "Tên admin không được trống!",
            'name.regex' => "Tên admin chỉ chứa ký tự hoa, thường!",
            'name.min' => "Tên admin tối thiểu :min ký tự!",
            'name.max' => "Tên admin tối đa :max ký tự!",

            'address.required' => "Địa chỉ không được bỏ trống!",
            'address.string' => "Địa chỉ phải là một chuỗi ký tự!",
            'address.max' => "Địa chỉ tối đa :max ký tự!",

            'phone.required' => "Số điện thoại không được bỏ trống!",
            'phone.regex' => "Số điện thoại có 10 chữ số và bắt đầu từ số 0!",

            'email.required' => "Email không được để trống!",
            'email.email' => "Email phải có ký tự @!",
            'email.unique' => "Email đã tồn tại!",

            'password.required' => "Mật khẩu không được để trống",
            'password.min' => "Mật khẩu tối đa :min ký tự",
            'password.max' => "Mật khẩu tối đa :max ký tự",
            'password.regex' => "Mật khẩu phải bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt!",

            'role.required' => "Vui lòng chọn quyền admin!",
            'role.in' => "Vui lòng chọn quyền admin hợp lệ!"
        ];
    }
}
