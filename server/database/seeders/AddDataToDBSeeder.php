<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Image;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Publisher;
use Hash;

class AddDataToDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //them user 1
        $user=new User;
        $user->name='Tuan';
        $user->email='asd@123';
        $user->password=Hash::make('123123');
        $user->status=1;
        $user->save();
        //thêm admin 1
        $admin1=new Admin;
        $admin1->name='Viết Thành';
        $admin1->email='admin@123';
        $admin1->email_verified_at=null;
        $admin1->password=Hash::make('123123');

        $admin2 = new Admin;
        $admin2->name = 'Thành Nghĩa';
        $admin2->email = 'admin@456';
        $admin2->address = 'Tiền Giang';
        $admin2->phone = '0987321645';
        $admin2->email_verified_at = null;
        $admin2->password = Hash::make('Admin@123');
        $admin2->role = 2;
        $admin2->remember_token = '';
        $admin2->save();

        $admin3 = new Admin;
        $admin3->name = 'Thanh Tuấn';
        $admin3->email = 'admin@789';
        $admin3->address = 'TP.HCM';
        $admin3->phone = '0987654321';
        $admin3->email_verified_at = null;
        $admin3->password = Hash::make('Admin@123');
        $admin3->role = 3;
        $admin3->remember_token = '';
        $admin3->save(); 

        //categories
        for ($i = 0; $i < 10; $i++) {
            $categorys = new Category;
            $categorys->name = "Danh mục " .$i;
            $categorys->description = "Thông tin danh mục " .$i;
            $categorys->slug = Str::slug($categorys->name);
            $categorys->save();
        }

        //authors
        for ($i = 0; $i < 10; $i++) {
            $author = new Author;
            $author->name = "Tác giả " .$i;
            $author->description = "Thông tin tác giả " .$i;
            $author->slug = Str::slug($author->name);
            $author->image = null;
            $author->save();
        }

        //publishers
        for ($i = 0; $i < 10; $i++) {
            $publisher = new Publisher;
            $publisher->name = "NXB " .$i;
            $publisher->description = "Thông tin NXB " .$i;
            $publisher->save();
        }

         //suppliers
         for ($i = 0; $i < 10; $i++) {
            $supplier = new Supplier;
            $supplier->name = "Nhà cung cấp " .$i;
            $supplier->address = "Thông tin địa chỉ NCC " .$i;
            $supplier->phone = "012345678 " .$i;
            $supplier->description = "Thông tin NCC " .$i;
            $supplier->slug = Str::slug($supplier->name);
            $supplier->save();
        }
    }
}
