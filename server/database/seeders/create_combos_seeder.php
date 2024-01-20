<?php

namespace Database\Seeders;

use App\Models\Combo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class create_combos_seeder extends Seeder
{

    public function run(): void
    {
        $combo1 = new Combo;
        $combo1->name = "Bộ sách giáo khoa lớp 12";
        $combo1->supplier_id = 3;
        $combo1->price = 180000;
        $combo1->quantity = 10;
        $combo1->image = null;
        $combo1->overrate = 0;
        $combo1->save();
        $combo1->books()->sync([]);

        $combo2 = new Combo;
        $combo2->name = "Combo Sách Ghi Chép Pháp Y (Bộ 3 Cuốn)";
        $combo2->supplier_id = 5;
        $combo2->price = 280868;
        $combo2->quantity = 10;
        $combo2->image = null;
        $combo2->overrate = 0;
        $combo2->save();
        $combo2->books()->sync([]);

        $combo3 = new Combo;
        $combo3->name = "Combo Dragon Ball (Trọn Bộ 42 Tập)";
        $combo3->supplier_id = 1;
        $combo3->price = 1050000;
        $combo3->quantity = 10;
        $combo3->image = null;
        $combo3->overrate = 0;
        $combo3->save();
        $combo3->books()->sync([]);

        $combo4 = new Combo;
        $combo4->name = "Combo Conan Trọn bộ 100 tập";
        $combo4->supplier_id = 1;
        $combo4->price = 2400000;
        $combo4->quantity = 10;
        $combo4->image = null;
        $combo4->overrate = 0;
        $combo4->save();
        $combo4->books()->sync([]);

        $combo5 = new Combo;
        $combo5->name = "Combo One piece ( từ tập 1 đến tập 101)";
        $combo5->supplier_id = 1;
        $combo5->price = 2525000;
        $combo5->quantity = 10;
        $combo5->image = null;
        $combo5->overrate = 0;
        $combo5->save();
        $combo5->books()->sync([]);

        $combo6 = new Combo;
        $combo6->name = "Combo Sách Tâm Lý Kẻ Phạm Tội: 8 Vụ Án Hoàn Hảo + Tâm Lý Học Tội Pham (Bộ 2 Cuốn)";
        $combo6->supplier_id = 8;
        $combo6->price = 217500;
        $combo6->quantity = 10;
        $combo6->image = null;
        $combo6->overrate = 0;
        $combo6->save();
        $combo6->books()->sync([]);

        $combo7 = new Combo;
        $combo7->name = "Combo 2Q: Giáo Trình Kỹ Thuật Lập Trình C Căn Bản Và Nâng Cao + Clean Code - Mã Sạch Và Con Đường Trở Thành Lập Trình Viên Giỏi";
        $combo7->supplier_id = 6;
        $combo7->price = 510500;
        $combo7->quantity = 10;
        $combo7->image = null;
        $combo7->overrate = 0;
        $combo7->save();
        $combo7->books()->sync([]);

        $combo8 = new Combo;
        $combo8->name = "Combo Sách Nguyễn Nhật Ánh (Bộ 10 Cuốn)";
        $combo8->supplier_id = 10;
        $combo8->price = 742500;
        $combo8->quantity = 10;
        $combo8->image = null;
        $combo8->overrate = 0;
        $combo8->save();
        $combo8->books()->sync([]);

        $combo9 = new Combo;
        $combo9->name = "Combo Sách Kinh Tế: 7 Thói Quen Của Bạn Trẻ Thành Đạt + Dám Nghĩ Lớn ";
        $combo9->supplier_id = 2;
        $combo9->price = 216000;
        $combo9->quantity = 10;
        $combo9->image = null;
        $combo9->overrate = 0;
        $combo9->save();
        $combo9->books()->sync([]);

        $combo10 = new Combo;
        $combo10->name = "Combo Sherlock Holmes Toàn Tập (Trọn Bộ 3 Tập)";
        $combo10->supplier_id = 3;
        $combo10->price = 156000;
        $combo10->quantity = 10;
        $combo10->image = null;
        $combo10->overrate = 0;
        $combo10->save();
        $combo10->books()->sync([]);

        $combo11 = new Combo;
        $combo11->name = "Combo Sách Tâm Linh Best-Seller: Muôn Kiếp Nhân Sinh + Sự Sống Bất Tử";
        $combo11->supplier_id = 3;
        $combo11->price = 180000;
        $combo11->quantity = 10;
        $combo11->image = null;
        $combo11->overrate = 0;
        $combo11->save();
        $combo11->books()->sync([]);
    }
}
