<?php

namespace App\Imports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Hash;

class AdminImport implements ToModel
{
    public function model(array $row)
    {
        return new Admin([
            'name' => $row[0],
            'email' => $row[1],
            'address' => $row[2],
            'phone' => $row[3],
            'password' => Hash::make($row[4]),
            'role' => $row[5],
        ]);
    }
}
