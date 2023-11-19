<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin;
use Hash;

class create_admins_table extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = new admin;
        $admin->name = "viết Thành";
        $admin->avatar = null;
        $admin->email = "admin@123";
        $admin->password = Hash::make("123123");
        $admin->role = 1;
        $admin->save();
    }
}
