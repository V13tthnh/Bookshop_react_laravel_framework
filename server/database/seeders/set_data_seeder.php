<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class set_data_seeder extends Seeder
{
    public function run(): void
    {
        $this->call(create_admins_seeder::class);
        $this->call(create_customers_seeder::class);
        $this->call(create_suppliers_seeder::class);
        $this->call(create_publishers_seeder::class);
        $this->call(create_authors_seeder::class);
        $this->call(create_categories_seeder::class);
        $this->call(create_books_seeder::class);
        $this->call(create_combos_seeder::class);
    }
}
