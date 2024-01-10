<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class create_authors_seeder extends Seeder
{
    public function run(): void
    {
        $author1 = new Author;
        $author1->name = "Ngô Gia Văn Phái";
        $author1->description = "Thông tin tác giả Ngô Gia Văn Phái";
        $author1->slug = Str::slug($author1->name);
        $author1->image = null;
        $author1->save();

        $author2 = new Author;
        $author2->name = "Goso Aoyama";
        $author2->description = "Thông tin tác giả Goso Aoyama";
        $author2->slug = Str::slug($author2->name);
        $author2->image = null;
        $author2->save();

        $author3 = new Author;
        $author3->name = "Gege Akutami";
        $author3->description = "Thông tin tác giả Gege Akutami";
        $author3->slug = Str::slug($author3->name);
        $author3->image = null;
        $author3->save();

        $author4 = new Author;
        $author4->name = "Kohei Horikoshi";
        $author4->description = "Thông tin tác giả Kohei Horikoshi";
        $author4->slug = Str::slug($author4->name);
        $author4->image = null;
        $author4->save();

        $author5 = new Author;
        $author5->name = "Yoko Akiyama";
        $author5->description = "Thông tin tác giả  Yoko Akiyama";
        $author5->slug = Str::slug($author5->name);
        $author5->image = null;
        $author5->save();

        $author6 = new Author;
        $author6->name = "Fujiko F Fujio";
        $author6->description = "Thông tin tác giả  Fujiko F Fujio ";
        $author6->slug = Str::slug($author6->name);
        $author6->image = null;
        $author6->save();

        $author7 = new Author;
        $author7->name = "AidaIro";
        $author7->description = "Thông tin tác giả AidaIro";
        $author7->slug = Str::slug($author7->name);
        $author7->image = null;
        $author7->save();

        $author8 = new Author;
        $author8->name = "Masashi Kishimoto";
        $author8->description = "Thông tin tác giả Masashi Kishimoto";
        $author8->slug = Str::slug($author8->name);
        $author8->image = null;
        $author8->save();

        $author9 = new Author;
        $author9->name = "Takehiko Inoue";
        $author9->description = "Thông tin tác giả Takehiko Inoue";
        $author9->slug = Str::slug($author9->name);
        $author9->image = null;
        $author9->save();

        $author10 = new Author;
        $author10->name = "Tomohito Oda";
        $author10->description = "Thông tin tác giả Tomohito Oda";
        $author10->slug = Str::slug($author10->name);
        $author10->image = null;
        $author10->save();

        $author11 = new Author;
        $author11->name = "Yoshito Usui";
        $author11->description = "Thông tin tác giả Yoshito Usui";
        $author11->slug = Str::slug($author11->name);
        $author11->image = null;
        $author11->save();

        $author12 = new Author;
        $author12->name = "Tô Hoài";
        $author12->description = "Thông tin tác giả Tô Hoài";
        $author12->slug = Str::slug($author12->name);
        $author12->image = null;
        $author12->save();

        $author13 = new Author;
        $author13->name = "Nam Cao";
        $author13->description = "Thông tin tác giả Nam Cao";
        $author13->slug = Str::slug($author13->name);
        $author13->image = null;
        $author13->save();

        $author14 = new Author;
        $author14->name = "Vũ Trọng Phụng";
        $author14->description = "Thông tin tác giả Vũ Trọng Phụng";
        $author14->slug = Str::slug($author14->name);
        $author14->image = null;
        $author14->save();

        $author15 = new Author;
        $author15->name = "Hàn Mạc Tử";
        $author15->description = "Thông tin tác giả Ngô Gia Văn Phái";
        $author15->slug = Str::slug($author15->name);
        $author15->image = null;
        $author15->save();

        $author16 = new Author;
        $author16->name = "Quang Dũng";
        $author16->description = "Thông tin tác giả Quang Dũng";
        $author16->slug = Str::slug($author16->name);
        $author16->image = null;
        $author16->save();

        $author17 = new Author;
        $author17->name = "Xuân Quỳnh";
        $author17->description = "Thông tin tác giả Xuân Quỳnh";
        $author17->slug = Str::slug($author17->name);
        $author17->image = null;
        $author17->save();

        $author18 = new Author;
        $author18->name = "Nguyễn Du";
        $author18->description = "Thông tin tác giả Nguyễn Du";
        $author18->slug = Str::slug($author18->name);
        $author18->image = null;
        $author18->save();

        $author19 = new Author;
        $author19->name = "Walter Isaacson";
        $author19->description = "Thông tin tác giả Walter Isaacson";
        $author19->slug = Str::slug($author19->name);
        $author19->image = null;
        $author19->save();

        $author20 = new Author;
        $author20->name = "Paul Kalanithi";
        $author20->description = "Thông tin tác giả Paul Kalanithi";
        $author20->slug = Str::slug($author20->name);
        $author20->image = null;
        $author20->save();

        $author21 = new Author;
        $author21->name = "José Mauro de Vasconcelos";
        $author21->description = "Thông tin tác giả José Mauro de Vasconcelos";
        $author21->slug = Str::slug($author21->name);
        $author21->image = null;
        $author21->save();

        $author22 = new Author;
        $author22->name = "Paulo Coelho";
        $author22->description = "Thông tin tác giả Paulo Coelho";
        $author22->slug = Str::slug($author22->name);
        $author22->image = null;
        $author22->save();

        $author23 = new Author;
        $author23->name = "Uketsu";
        $author23->description = "Thông tin tác giả Uketsu";
        $author23->slug = Str::slug($author23->name);
        $author23->image = null;
        $author23->save();

        $author24 = new Author;
        $author24->name = "Lê Lựu";
        $author24->description = "Thông tin tác giả Lê Lựu";
        $author24->slug = Str::slug($author24->name);
        $author24->image = null;
        $author24->save();

        $author25 = new Author;
        $author25->name = "Nikola Tesla";
        $author25->description = "Thông tin tác giả 	Nikola Tesla";
        $author25->slug = Str::slug($author25->name);
        $author25->image = null;
        $author25->save();

        $author26 = new Author;
        $author26->name = "Khương lệ Bình";
        $author26->description = "Thông tin tác giả Khương lệ Bình";
        $author26->slug = Str::slug($author26->name);
        $author26->image = null;
        $author26->save();

        $author27 = new Author;
        $author27->name = "Hà Minh";
        $author27->description = "Thông tin tác giả Hà Minh";
        $author27->slug = Str::slug($author27->name);
        $author27->image = null;
        $author27->save();

        $author28 = new Author;
        $author28->name = "Hồ Chí Minh";
        $author28->description = "Thông tin tác giả Hồ Chí Minh";
        $author28->slug = Str::slug($author28->name);
        $author28->image = null;
        $author28->save();

        $author29 = new Author;
        $author29->name = "Lưu Bát Bách";
        $author29->description = "Thông tin tác giả Lưu Bát Bách";
        $author29->slug = Str::slug($author29->name);
        $author29->image = null;
        $author29->save();

        $author30 = new Author;
        $author30->name = "Châu Sa Đáy Mắt";
        $author30->description = "Thông tin tác giả Châu Sa Đáy Mắt";
        $author30->slug = Str::slug($author30->name);
        $author30->image = null;
        $author30->save();

        $author31 = new Author;
        $author31->name = "Akira Toriyama";
        $author31->description = "Thông tin tác giả Akira Toriyama";
        $author31->slug = Str::slug($author31->name);
        $author31->image = null;
        $author31->save();

        $author32 = new Author;
        $author32->name = "Lưu Đạt Bách";
        $author32->description = "Thông tin tác giả Lưu Đạt Bách";
        $author32->slug = Str::slug($author32->name);
        $author32->image = null;
        $author32->save();

        $author33 = new Author;
        $author33->name = "Hà Minh";
        $author33->description = "Thông tin tác giả Hà Minh";
        $author33->slug = Str::slug($author33->name);
        $author33->image = null;
        $author33->save();

        $author34 = new Author;
        $author34->name = "J.K.Rowling";
        $author34->description = "Thông tin tác giả J.K.Rowling";
        $author34->slug = Str::slug($author34->name);
        $author34->image = null;
        $author34->save();

        $author35 = new Author;
        $author35->name = "George R R Martin";
        $author35->description = "George RR Martin là tác giả khoa học viễn tưởng và nhà biên kịch thành công ở Hollywood. Tuy nhiên, chính việc thường xuyên phải cắt giảm nhân vật và những cảnh chiến đấu trong các kịch bản của mình vì những hạn chế liên quan  đến ngân sách và độ dài các tập phim; đã khiến ông quyết định quay lại với niềm đam mê viết lách, nơi trí tưởng tượng phong phú của ông không bị hạn chế bởi bất cứ điều gì và tạo nên bộ tiểu thuyết giả tưởng bán chạy nổi tiếng Trò chơi vương quyền.";
        $author35->slug = Str::slug($author35->name);
        $author35->image = null;
        $author35->save();
    }
}
