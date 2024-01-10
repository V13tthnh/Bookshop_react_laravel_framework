<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class create_publishers_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publisher1 = new Publisher;
        $publisher1->name = "NXB Kim Đồng";
        $publisher1->description = "Thông tin NXB Kim Đồng" ;
        $publisher1->save();

        $publisher2 = new Publisher;
        $publisher2->name = "NXB giáo dục Việt Nam";
        $publisher2->description = "Thông tin NXB Giáo dục Việt Nam" ;
        $publisher2->save();

        $publisher3 = new Publisher;
        $publisher3->name = "NXB Công Thương";
        $publisher3->description = "Thông tin NXB Công Thương " ;
        $publisher3->save();

        $publisher4 = new Publisher;
        $publisher4->name = "NXB Văn học";
        $publisher4->description = "Thông tin NXB Văn học " ;
        $publisher4->save();

        $publisher5 = new Publisher;
        $publisher5->name = "Bộ Giáo dục và đào tạo";
        $publisher5->description = "Thông tin Bộ Giáo dục và đào tạo " ;
        $publisher5->save();

        $publisher6 = new Publisher;
        $publisher6->name = "NXB Dân trí";
        $publisher6->description = "Thông tin NXB Dân tri" ;
        $publisher6->save();

        $publisher7 = new Publisher;
        $publisher7->name = "NXB Thanh niên";
        $publisher7->description = "Thông tin NXB Thanh niên " ;
        $publisher7->save();

        $publisher8 = new Publisher;
        $publisher8->name = "NXB Lao động";
        $publisher8->description = "Thông tin NXB Lao động " ;
        $publisher8->save();

        $publisher9 = new Publisher;
        $publisher9->name = "NXB Hà Nội";
        $publisher9->description = "Thông tin NXB Hà Nội " ;
        $publisher9->save();

        $publisher10 = new Publisher;
        $publisher10->name = "Đại học quốc gia Việt Nam";
        $publisher10->description = "Thông tin Đại học quốc gia Việt Nam " ;
        $publisher10->save();
    }
}
