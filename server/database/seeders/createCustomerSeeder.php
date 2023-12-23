<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class createCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = new Customer;
        $customers->name = "Thành";
        $customers->email = "abc@123";
        $customers->password = Hash::make("abc@123");
        $customers->status = 1;
        $customers->save();

    }
}
