<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class create_categories_seeder extends Seeder
{
    public function run(): void
    {
        $category1 = new Category;
        $category1->name = "Lịch sử, truyền thống";
        $category1->description = "Thông tin danh mục Lịch sử, truyền thống";
        $category1->slug = Str::slug($category1->name);
        $category1->save();

        $category2 = new Category;
        $category2->name = "Văn học Việt Nam";
        $category2->description = "Thông tin danh mục Văn học Việt Nam";
        $category2->slug = Str::slug($category2->name);
        $category2->save();

        $category3 = new Category;
        $category3->name = "Văn học nước ngoài";
        $category3->description = "Thông tin danh mục Văn học nước ngoài";
        $category3->slug = Str::slug($category3->name);
        $category3->save();

        $category4 = new Category;
        $category4->name = "Kiến thức khoa học";
        $category4->description = "Thông tin danh mục Kiến thức khoa học";
        $category4->slug = Str::slug($category4->name);
        $category4->save();

        $category5 = new Category;
        $category5->name = "Manga-comic";
        $category5->description = "Thông tin danh mục Manga-comic";
        $category5->slug = Str::slug($category5->name);
        $category5->save();

        $category6 = new Category;
        $category6->name = "Tiểu sử, hồi ký";
        $category6->description = "Thông tin danh mục Tiểu sử, hồi ký";
        $category6->slug = Str::slug($category6->name);
        $category6->save();

        $category7 = new Category;
        $category7->name = "Sách học ngoại ngữ";
        $category7->description = "Thông tin danh mục Sách học ngoại ngữ";
        $category7->slug = Str::slug($category7->name);
        $category7->save();

        $category8 = new Category;
        $category8->name = "Ebook";
        $category8->description = "Thông tin danh mục Ebook";
        $category8->slug = Str::slug($category8->name);
        $category8->save();

        $category9 = new Category;
        $category9->name = "Nuôi dạy trẻ";
        $category9->description = "Thông tin danh mục Nuôi dạy trẻ";
        $category9->slug = Str::slug($category9->name);
        $category9->save();

        $category10 = new Category;
        $category10->name = "Giải mã bản thân";
        $category10->description = "Thông tin danh mục Giải mã bản thân";
        $category10->slug = Str::slug($category10->name);
        $category10->save();

        $category11 = new Category;
        $category11->name = "Combo sách";
        $category11->description = "Thông tin danh mục Combo sách";
        $category11->slug = Str::slug($category11->name);
        $category11->save();
    }
}
