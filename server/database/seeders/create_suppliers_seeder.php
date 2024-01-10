<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;
class create_suppliers_seeder extends Seeder
{

    public function run(): void
    {
        $supplier1 = new Supplier;
        $supplier1->name = "Kim Đồng";
        $supplier1->address = "Trung tâm sách Kim Đồng - 248 Cống Quỳnh, Q.1, TP HCM";
        $supplier1->phone = "(028) 39 250 170";
        $supplier1->description = "Thông tin NCC Kim Đồng";
        $supplier1->slug = Str::slug($supplier1->name);
        $supplier1->save();

        $supplier2 = new Supplier;
        $supplier2->name = "NXB Tổng hợp TPHCM";
        $supplier2->address = "62 Nguyễn Thị Minh Khai, Phường Đa Kao, Quận 1, TP.HCM ";
        $supplier2->phone = "(028) 38 256 804";
        $supplier2->description = "Thông tin NCC NXB Tổng hợp TPHCM";
        $supplier2->slug = Str::slug($supplier2->name);
        $supplier2->save();

        $supplier3 = new Supplier;
        $supplier3->name = "Nhà sách Phương Nam";
        $supplier3->address = "Lầu 1, số 940 Đường 3/2, P.15, Q.11, TP. Hồ Chí Minh";
        $supplier3->phone = "(hotline) 1900 6656";
        $supplier3->description = "Thông tin NCC ";
        $supplier3->slug = Str::slug($supplier3->name);
        $supplier3->save();

        $supplier4 = new Supplier;
        $supplier4->name = "NXB Phụ Nữ";
        $supplier4->address = "16 Alexandre De Rhodes, Q.1, TP. Hồ Chí Minh";
        $supplier4->phone = "(028) 38 294 459";
        $supplier4->description = "Thông tin NCC NXB Phụ Nữ";
        $supplier4->slug = Str::slug($supplier4->name);
        $supplier4->save();

        $supplier5 = new Supplier;
        $supplier5->name = "Alpha books";
        $supplier5->address = "138C, Nguyễn Đình Chiểu, Quận 3";
        $supplier5->phone = "(84-8)38 220 334";
        $supplier5->description = "Thông tin NCC Alpha books";
        $supplier5->slug = Str::slug($supplier5->name);
        $supplier5->save();

        $supplier6 = new Supplier;
        $supplier6->name = "Panda books";
        $supplier6->address = "Nhà Số 20, Đường Số 4, Khu Biệt Thự Cao Cấp Sông Ông Lớn - Đại Lộ Nguyễn Văn Linh, Xã Bình Hưng, Huyện Bình Chánh, TP. Hồ Chí Minh";
        $supplier6->phone = "024 7308 6066";
        $supplier6->description = "Thông tin NCC Panda books";
        $supplier6->slug = Str::slug($supplier6->name);
        $supplier6->save();

        $supplier7 = new Supplier;
        $supplier7->name = "Gác xếp bookstore";
        $supplier7->address = "Tong Dan, Hoan Kiem, Hanoi Opening time: 1:30pm - 6pm (Mon - Fri), 9am - 6pm (Sat - Sun), Hà Nội";
        $supplier7->phone = "0392115222";
        $supplier7->description = "Thông tin NCC Gác xếp bookstore";
        $supplier7->slug = Str::slug($supplier7->name);
        $supplier7->save();

        $supplier8 = new Supplier;
        $supplier8->name = "Fahasa";
        $supplier8->address = "Số 387 – 389 đường Hai Bà Trưng, Phường 8, Quận 3, Thành phố Hồ Chí Minh.";
        $supplier8->phone = "1900 636467 ";
        $supplier8->description = "Thông tin NCC Fahasa";
        $supplier8->slug = Str::slug($supplier8->name);
        $supplier8->save();

        $supplier9 = new Supplier;
        $supplier9->name = "E.book";
        $supplier9->address = "Số 86A đường Nguyễn Thái Sơn, Phường 3, Quận Gò Vấp, Thành phố Hồ Chí Minh.";
        $supplier9->phone = " 083 899 6622 ";
        $supplier9->description = "Thông tin NCC E.book";
        $supplier9->slug = Str::slug($supplier9->name);
        $supplier9->save();

        $supplier10 = new Supplier;
        $supplier10->name = "Artbook";
        $supplier10->address = "1B1 NGUYỄN ĐÌNH CHIỂU, Q.1, P. Đakao, Tp.HCM";
        $supplier10->phone = "012345678 ";
        $supplier10->description = "Thông tin NCC Artbook";
        $supplier10->slug = Str::slug($supplier10->name);
        $supplier10->save();

        $supplier10 = new Supplier;
        $supplier10->name = "Nhà sách cá chép";
        $supplier10->address = " 223 Nguyễn Thị Minh Khai, Phường Nguyễn Cư Trinh, Quận 1, Tp. Hồ Chí Minh";
        $supplier10->phone = "(+8428) 3925 0069";
        $supplier10->description = "Thông tin NCC Nhà sách cá chép";
        $supplier10->slug = Str::slug($supplier10->name);
        $supplier10->save();
    }
}
