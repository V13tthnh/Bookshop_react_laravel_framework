<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class create_books_seeder extends Seeder
{
    public function run(): void
    {
        $book1 = new Book();
        $book1->name = "Dragon Ball - Tập 1";
        $book1->code = "6232214620001";
        $book1->description = "Sau Đại hội võ thuật lần thứ 23, Đại Ma Vương Piccolo không còn quấy rối dân lành nữa. Goku và các bạn quay trở về cuộc sống bình thường. Anh đã kết hôn với Chichi, con gái của Ngưu Ma Vương và có một cậu con trai tên là Gohan. Trong một lần Goku đưa Gohan đến đảo Rùa chơi thì bỗng có một kẻ ăn vận kì lạ, tự xưng là anh trai ruột của Son Goku xuất hiện. Hắn đã tiết lộ một điều khủng khiếp về thân thế thật của Goku rồi bắt cóc Gohan đem đi mất... Xin mời các bạn tiếp tục theo dõi phần truyện màu đầy kịch tính tiếp theo của 7 Viên Ngọc Rồng: Dragon Ball Full Color: Cuộc đổ bộ của người Saiya.";
        $book1->weight = 280;
        $book1->format = "Bìa mềm";
        $book1->year = 2023;
        $book1->language = "Tiếng Việt";
        $book1->size = "11.3x17.6 cm";
        $book1->num_pages = 248;
        $book1->slug = Str::slug($book1->name);
        $book1->translator = "Nhiều Người Dịch";
        $book1->publisher_id = 1;
        $book1->supplier_id = 1;
        $book1->book_type = 0;
        $book1->overrate = 0;
        $book1->e_book_price = null;
        $book1->link_pdf = null;
        $book1->save();
        $book1->authors()->sync([31]);
        $book1->categories()->sync([5]);

        $book2 = new Book();
        $book2->name = "Slam dunk - Tập 1";
        $book2->code = "8935244852486";
        $book2->description = "Cậu có thích bóng rổ không?". "Người nói vô tình, người nghe hữu ý. Chỉ với một câu hỏi đó, Haruko Akagi đã lôi kéo cậu học sinh cấp ba bất hảo Hanamichi Sakuragi đến với môn bóng rổ.
        Bước sang năm thứ hai-mươi-mốt,". "Huyền thoại Manga bóng rổ SLAM DUNK". "của chúng ta vẫn được các độc giả ở khắp nơi trên thế giới hào hứng đón nhận! Nhất là khi vài ngày trước, tác giả TAKEHIKO INOUE vừa công bố dự án Anime Movie mới về Slam Dunk. Và thật tuyệt vời khi trong dịp đầu xuân 2021, sau thời gian dài đón đợi, các Fan Việt Nam sẽ được tái ngộ Hanamichi và đồng đội trong Manga SLAM DUNK - Tác phẩm một lần nữa trở lại với hình thức Đặc biệt nhất trước nay: PHIÊN BẢN DELUXE do NXB Kim Đồng phát hành!!
        24 cuốn truyện trong bản nâng cấp đặc biệt này có khuôn khổ 13x18cm, với tranh bìa hoàn toàn khác so với phiên bản đời đầu. Những tranh màu trên tạp chí được giữ nguyên, hẳn bạn sẽ phải xuýt xoa khi được thấy các nhân vật xuất hiện đầy sống động đấy nhé! Hình thức bên ngoài cũng rất được NXB chăm chút với phần tít phủ UV nổi trên mặt giấy mịn như sách gốc, chất giấy của bìa trong do Ekip đặt sản xuất riêng cho bộ truyện cũng sẽ khiến nhiều Fan sưu tập thích thú! Chưa kể tới trang giấy trong, trang lót đen trắng phủ nhũ chìm...";
        $book2->weight = 271;
        $book2->format = "Bìa mềm";
        $book2->year = 2020;
        $book2->language = "Tiếng Việt";
        $book2->size = "18x13x1.4cm";
        $book2->num_pages = 236;
        $book2->slug = Str::slug($book2->name);
        $book2->translator = "Danna, Leo";
        $book2->publisher_id = 1;
        $book2->supplier_id = 1;
        $book2->book_type = 0;
        $book2->overrate = 0;
        $book2->e_book_price = null;
        $book2->link_pdf = null;
        $book2->save();
        $book2->authors()->sync([9]);
        $book2->categories()->sync([5]);

        $book3 = new Book();
        $book3->name = "Học viện siêu anh hùng - Team up mission - Tập 1";
        $book3->code = "5232217120001";
        $book3->description = "Chào mừng đến với chương trình mới: Team Up Mission! Ở đây các học sinh sẽ được lập đội với những Siêu Anh hùng chuyên nghiệp và cùng thực hiện vô vàn các nhiệm vụ khác nhau! Để có thể tích lũy kinh nghiệm khi đứng chung sân khấu với dân chuyên, để có thể tiếnxa hơn nữa, ngoại truyện hoàn toàn mới về quá trình này của chúng tớ đã bắt đầu!";
        $book3->weight = 140 ;
        $book3->format = "Bìa mềm";
        $book3->year = 2023;
        $book3->language = "Tiếng Việt";
        $book3->size = "11.3x17.6 cm";
        $book3->num_pages = 200;
        $book3->slug = Str::slug($book3->name);
        $book3->translator = "Ruyuha Kyouka";
        $book3->publisher_id = 1;
        $book3->supplier_id = 1;
        $book3->book_type = 0;
        $book3->overrate = 0;
        $book3->e_book_price = null;
        $book3->link_pdf = null;
        $book3->save();
        $book3->authors()->sync([4, 5]);
        $book3->categories()->sync([5]);

        $book4 = new Book();
        $book4->name = "Cậu". "Ma Nhà Xí Hanako - Tập 17 ";
        $book4->code = "8935244894318";
        $book4->description = "Nene và Ko đã tiến vào “Căn nhà màu đỏ” bị nguyền rủa hòng tìm cách kết nối với cảnh giới nơi Hanako đang ở, nhưng lại gặp Tsukasa hồi nhỏở đó. Cả hai thử thoát khỏi căn nhà ấy cùng Tsukasa nhưng lối ra lại bị bịt kín… Cao trào của phần truyện về “Căn nhà màu đỏ” liên quan đến 7 bí ẩn trong học viện chính thức bắt đầu!";
        $book4->weight = 190;
        $book4->format = "Bìa mềm";
        $book4->year = 2023;
        $book4->language = "Tiếng Việt";
        $book4->size = "18 x 13 x 0.8 cm";
        $book4->num_pages = 178;
        $book4->slug = Str::slug($book4->name);
        $book4->translator = "Độc Giả";
        $book4->publisher_id = 1;
        $book4->supplier_id = 1;
        $book4->book_type = 0;
        $book4->overrate = 0;
        $book4->e_book_price = null;
        $book4->link_pdf = null;
        $book4->save();
        $book4->authors()->sync([7]);
        $book4->categories()->sync([5]);

        $book5 = new Book();
        $book5->name = "Chú Thuật Hồi Chiến - Tập 20: Kết Giới Sendai - Giữa Buổi Tiệc";
        $book5->code = "8935352602164";
        $book5->description = "Cả Fushiguro và Reggie đều rơi vào tình trạng nguy hiểm tới tính mạng do thuật thức của đối thủ. Reggie quyết định hành động để phá vỡ thế giằng co, cuộc tử chiến dần đi đến hồi kết!! Trong khi đó, Okkotsu đã đánh bại một trong bốn kẻ mạnh nhất ở kết giới Sendai, cuộc chiến với các thuật sư trong quá khứ và chú linh đặc cấp dần trở nên khốc liệt!!";
        $book5->weight = 210;
        $book5->format = "Bìa mềm";
        $book5->year = 2023;
        $book5->language = "Tiếng Việt";
        $book5->size = "11.3x17.6 cm";
        $book5->num_pages = 192;
        $book5->slug = Str::slug($book5->name);
        $book5->translator = "Vũ Trụ 19, Liên Vũ";
        $book5->publisher_id = 1;
        $book5->supplier_id = 1;
        $book5->book_type = 0;
        $book5->overrate = 0;
        $book5->e_book_price = null;
        $book5->link_pdf = null;
        $book5->save();
        $book5->authors()->sync([3]);
        $book5->categories()->sync([5]);

        $book6 = new Book();
        $book6->name = "Komi - Nữ Thần Sợ Giao Tiếp - Tập 25";
        $book6->code = "8935244890044";
        $book6->description = "Bước sang năm học lớp 12! Komi được chung lớp với Tadano và Komi ở lớp 12-A. Thế nhưng, bị tách khỏi cô bạn Manbagi thân thiết từ hồi cùng lớp 11-A, Komi bỗng cảm thấy hơi lo lắng?
        Cô nàng sẽ tham gia đại chiến sinh tồn giữa các khối với những người bạn cùng lớp cực kì “sợ giao tiếp”. Việc thấu hiểu nhau trong những tháng ngày không bình thường ấy lại chính là chương mở đầu cho năm cuối cùng thấy được ít nhiều quá trình trưởng thành suốt 2 năm qua.
        Mời các bạn đón đọc tập 25 câu chuyện hài hước về người đẹp sợ giao tiếp muốn suy ngẫm lại 1 năm cuối cùng!!";
        $book6->weight = 136;
        $book6->format = "Bìa mềm";
        $book6->year = 2023;
        $book6->language = "Tiếng Việt";
        $book6->size = "17.6 x 11.3 x 1.3 cm";
        $book6->num_pages = 192;
        $book6->slug = Str::slug($book6->name);
        $book6->translator = "Real";
        $book6->publisher_id = 1;
        $book6->supplier_id = 1;
        $book6->book_type = 0;
        $book6->overrate = 0;
        $book6->e_book_price = null;
        $book6->link_pdf = null;
        $book6->save();
        $book6->authors()->sync([10]);
        $book6->categories()->sync([5]);

        $book7 = new Book();
        $book7->name = "Shin - Cậu Bé Bút Chì - Tập 28";
        $book7->code = "8935244816556";
        $book7->description = "Được phát hành lần đầu vào năm 1992, bộ truyện sớm gây được tiếng vang đối với độc giả Nhật Bản và nhiều nước khác trên thế giới. Vài năm sau đó, loạt phim hoạt hình về cậu bé Shin cũng được sản xuất và phát sóng liên tục cho đến bây giờ.
        Về hình thức thể hiện, tác giả sử dụng bút pháp đơn giản, thậm chí có vẻ ngây ngô hơn so với các bộ manga khác. Nội dung truyện cũng đơn giản: tất cả xoay quanh nhân vật chính là cậu bé Shin 5 tuổi với những mối quan hệ thân sơ, bố mẹ, hàng xóm, thầy cô, bạn bè, người quen và... cả những người không quen.
        Mỗi tập truyện khoảng 120 trang, nhưng cứ thử cầm lên xem, bạn sẽ không thể rời mắt khỏi cuốn sách cho đến tận trang cuối cùng. Với tài năng kể chuyện hấp dẫn, tác giả đã biến các trang sách của mình thành những sân chơi ngập tràn tiếng cười của những cô bé, cậu bé hồn nhiên và một thế giới tuổi thơ đa sắc màu. Những bài học giáo dục nhẹ nhàng, thấm thía cũng được lồng ghép một cách khéo léo trong từng tình huống truyện. Có thể Shin là một cậu bé cá tính, hiếu động. Có thể những trò tinh nghịch của Shin đôi khi quá trớn, chẳng chừa một ai. Nhưng sau những sự cố do Shin gây ra, người lớn thấy mình cần quan tâm đến trẻ con nhiều hơn nữa, các bạn đọc nhỏ tuổi chắc hẳn cũng được dịp nhìn nhận lại bản thân, để phân biệt điều tốt điều xấu trong cuộc sống.";
        $book7->weight = 150;
        $book7->format = "Bìa mềm";
        $book7->year = 2023;
        $book7->language = "Tiếng Việt";
        $book7->size = "20.5 x 14.5 x 0.8 cm";
        $book7->num_pages = 128;
        $book7->slug = Str::slug($book7->name);
        $book7->translator = "Kim Đồng";
        $book7->publisher_id = 1;
        $book7->supplier_id = 1;
        $book7->book_type = 0;
        $book7->overrate = 0;
        $book7->e_book_price = null;
        $book7->link_pdf = null;
        $book7->save();
        $book7->authors()->sync([11]);
        $book7->categories()->sync([5]);

        $book8 = new Book();
        $book8->name = "Naruto - Tập 49: Hội Đàm Ngũ Kage, Bắt Đầu…!! ";
        $book8->code = "8935244866544";
        $book8->description = "Nhằm triệt hạ Akatsuki cùng mưu đồ thống trị của chúng, Hội đàm Ngũ Kage đã được tổ chức theo lời kêu gọi của Raikage. Đại diện các làng lần lượt tập trung ở Thiết Quốc! Trong lúc đó, trước chủ trương triệt hạ Sasuke của làng Mây, để thù hận không kéo theo thù hận, Naruto quyết định trực tiếp đứng ra đàm phán với Raikage…!?
        MASASHI KISHIMOTO
        “Dạo này làm việc một mình buồn quá, nên tôi thường mở phim lên coi. Định bụng vừa tập trung làm việc vừa lướt phim, nhưng khi nhận ra, tôi lại đang tập trung xem phim và vẽ qua loa đại khái mới chết. Kiểu này tới lúc xem trúng bộ ba phim liên hoàn thì không biết thế nào đây…” (Toát mồ hôi)";
        $book8->weight = 200;
        $book8->format = "Bìa mềm";
        $book8->year = 2022;
        $book8->language = "Tiếng Việt";
        $book8->size = "17.6 x 11.3 cm";
        $book8->num_pages = 188;
        $book8->slug = Str::slug($book8->name);
        $book8->translator = "Anh Việt";
        $book8->publisher_id = 1;
        $book8->supplier_id = 1;
        $book8->book_type = 0;
        $book8->overrate = 0;
        $book8->e_book_price = null;
        $book8->link_pdf = null;
        $book8->save();
        $book8->authors()->sync([8]);
        $book8->categories()->sync([5]);

        $book9 = new Book();
        $book9->name = "Thám Tử Lừng Danh Conan - Tập 102";
        $book9->code = "8935352602157";
        $book9->description = "Jugo Yokomizo tình cờ gặp Chihaya Hagiwara tại bữa tiệc mai mối!
        Điều gì hiện lên trong tâm trí Chihaya khi cô chăm chú nhìn Wataru Takagi!?
        Chí nguyện “hoa anh đào” được tiếp nối qua bao thế hệ...
        Và...
        Chẳng hề báo trước, tập truyện này sẽ mở ra những diễn biến đầy bất ngờ.";
        $book9->weight = 200;
        $book9->format = "Bìa mềm";
        $book9->year = 2023;
        $book9->language = "Tiếng Việt";
        $book9->size = "17.6 x 11.3 x 0.9 cm";
        $book9->num_pages = 180;
        $book9->slug = Str::slug($book9->name);
        $book9->translator = "Hương Giang";
        $book9->publisher_id = 1;
        $book9->supplier_id = 1;
        $book9->book_type = 0;
        $book9->overrate = 0;
        $book9->e_book_price = null;
        $book9->link_pdf = null;
        $book9->save();
        $book9->authors()->sync([2]);
        $book9->categories()->sync([5]);

        $book10 = new Book();
        $book10->name = "Doraemon Movie Story: Nobita Và Hòn Đảo Diệu Kì - Cuộc Phiêu Lưu Của Loài Thú";
        $book10->code = "8935244878226";
        $book10->description = "Nhóm Nobita đến thăm hòn đảo bí ẩn, nơi bảo vệ các loài động vật bị tuyệt chủng. Hòn đảo đó được bảo vệ bởi sức mạnh của con bọ hung sừng chữ Y hoàng kim có tên gọi “Golden Hercules”. Trên hòn đảo, nhóm bạn gặp Dakke, một cậu bé bí ẩn trông giống hệt Nobita. Nhưng một thương nhân xấu xa tên Sharman muốn cướp con bọ hung hoàng kim xuất hiện, gây ra cuộc đại chiến. Các cậu, chúng ta hãy dốc hết sức bảo vệ hòn đảo của ước mơ và hi vọng!";
        $book10->weight = 200;
        $book10->format = "Bìa mềm";
        $book10->year = 2023;
        $book10->language = "Tiếng Việt";
        $book10->size = "18 x 13 cm x 1";
        $book10->num_pages = 190;
        $book10->slug = Str::slug($book10->name);
        $book10->translator = "Nhiều Người Dịch";
        $book10->publisher_id = 1;
        $book10->supplier_id = 1;
        $book10->book_type = 0;
        $book10->overrate = 0;
        $book10->e_book_price = null;
        $book10->link_pdf = null;
        $book10->save();
        $book10->authors()->sync([6]);
        $book10->categories()->sync([5]);

        $book11 = new Book();
        $book11->name = "Dế Mèn Phiêu Lưu Ký - Đậu Đũa Minh Họa";
        $book11->code = "8935244848502";
        $book11->description = "
        Lần đầu tiên “Dế mèn phiêu lưu ký” được minh họa bởi một nữ họa sĩ - họa sĩ Đậu Đũa.
        
        Xuất phát từ đồ án tốt nghiệp, sau 7 năm theo đuổi và phát triển ý tưởng, họa sĩ Đậu Đũa “trình làng” hơn 100 bức tranh minh họa màu nước được vẽ tay thể hiện một cái nhìn hoàn toàn mới về “Dế Mèn phiêu lưu ký”.
        
        Là họa sĩ tuổi 9X - Đậu Đũa đã vẽ “Dế Mèn phiêu lưu ký” bằng con mắt của những cô bé cậu bé thời hiện đại. Cô hoàn toàn thoát khỏi tạo hình Dế mèn của các thế hệ họa sĩ đi trước.
        
        Các nhân vật “Dế Mèn phiêu lưu ký” lần đầu được vận lên người bộ âu phục thời trang lịch lãm. Tạo hình này không chỉ làm nên sự mới mẻ với những ai đã biết đến “Dế Mèn phiêu lưu ký” mà còn tạo sự gần gũi với độc giả đương đại chưa từng đọc “Dế Mèn phiêu lưu ký”
        
        Họa sĩ Đậu Đũa đã tạo nên một thế giới sắc màu ngọt ngào quyến rũ, vừa xa lạ bí ẩn vừa kích thích trí tưởng tượng và khát khao cất bước phiêu lưu
        
        Đậu Đũa đã bắt được cái tinh thần “Đi khắp thế giới kết anh em” của “Dế Mèn phiêu lưu ký”. Có thể nói “Dế Mèn phiêu lưu ký” minh họa Đậu Đũa là cái nhìn toàn cầu. Mọi hình ảnh đều vừa thực vừa thoát khỏi khuôn mẫu tả thực. Dế Mèn, Dế Trũi, Cào Cào, Bọ Muỗm… không còn là những côn trùng mà thực sự là những nhân vật hóa trang kể những câu chuyện của thế giới loài người. Đúng với tính chất của truyện đồng thoại.
        
         “Dế Mèn phiêu lưu ký” là tác phẩm Việt Nam được dịch ra nhiều thứ tiếng nhất, NXB Kim Đồng tin rằng với minh họa Đậu Đũa, “Dế Mèn phiêu lưu ký” sẽ phù hợp xu thế hội nhập.
        
        Họa sĩ ĐẬU ĐŨA
        
        Bén duyên với chú Dế Mèn của bác Tô Hoài năm 2014 trong đồ án tốt nghiệp (Khoa Mỹ thuật Công nghiệp, Đại học Kiến trúc Tp. Hồ Chí Minh). Đến năm 2020 thì việc minh họa cho cuốn sách này được hoàn thành. Một cuộc phiêu lưu khá dài và vô cùng thú vị, không kém gì chàng Dế trong truyện.
        
        * Giải Nhất cuộc thi Samsung KidsTime Authors’ Award 2015 cho tác phẩm: Trái tim của Mẹ.
        
        * Giải Bạc - Sách hay của Giải thưởng sách Việt Nam 2016 cho tác phẩm: Trái tim của Mẹ.";
        $book11->weight = 300;
        $book11->format = "Bìa mềm";
        $book11->year = 2023;
        $book11->language = "Tiếng Việt";
        $book11->size = "27 x 20 cm";
        $book11->num_pages = 176;
        $book11->slug = Str::slug($book11->name);
        $book11->translator = "Đậu Đũa";
        $book11->publisher_id = 6;
        $book11->supplier_id = 3;
        $book11->book_type = 0;
        $book11->overrate = 0;
        $book11->e_book_price = null;
        $book11->link_pdf = null;
        $book11->save();
        $book11->authors()->sync([12]);
        $book11->categories()->sync([2]);

        $book12 = new Book();
        $book12->name = "Văn Học Trong Nhà Trường: Truyện Kiều";
        $book12->code = "8935244822588";
        $book12->description = "“Truyện Kiều đã có cả một vận mệnh rất vẻ vang. Qua đó, ta có thể nhận thấy rằng: Dù từ xưa đến nay các thế hệ nhà văn, nhà thơ đều đồng thanh về giá trị văn nghệ của Truyện Kiều, thì mỗi thời đại, mỗi một giai tầng xã hội đều đã nhận xét tác phẩm của Nguyễn Du theo một quan điểm riêng biệt.”
        Giáo sư ĐẶNG THAI MAI
        “Một nước không thể không có quốc hoa, Truyện Kiều là quốc hoa của ta; một nước không thể không có quốc túy, Truyện Kiều là quốc túy của ta; một nước không thể không có quốc hồn, Truyện Kiều là quốc hồn của ta.”";
        $book12->weight = 220;
        $book12->format = "Bìa mềm";
        $book12->year = 2019;
        $book12->language = "Tiếng Việt";
        $book12->size = "13 x 19cm";
        $book12->num_pages = 208;
        $book12->slug = Str::slug($book12->name);
        $book12->translator = "Nguyễn Du";
        $book12->publisher_id = 2;
        $book12->supplier_id = 4;
        $book12->book_type = 0;
        $book12->overrate = 0;
        $book12->e_book_price = null;
        $book12->link_pdf = null;
        $book12->save();
        $book12->authors()->sync([18]);
        $book12->categories()->sync([2]);

        $book13 = new Book();
        $book13->name = "Văn Học Trong Nhà Trường: Truyện Ngắn Nam Cao";
        $book13->code = "8935244822564";
        $book13->description = "“Viết về những con người dưới đáy xã hội, Nam Cao đã bộc lộ sự cảm thông lạ lùng của một trái tim nhân đạo lớn.”
        
        TS TRẦN ĐĂNG SUYỀN
        
        “Qua những truyện ngắn, con mắt nhìn Nam Cao đặt cho chúng ta, những ý nghĩ Nam Cao gợi dậy trong tâm trí chúng ta, và tinh thần trách nhiệm Nam Cao đề ra với chúng ta, càng ngày ta càng thấy rõ hơn.”
        
        NHÀ VĂN NGUYÊN HỒNG
        
        “Ngày nay, chúng ta thường hay quan tâm và luận bàn về tính hiện đại của tác phẩm văn học, về cái mới và khả năng thử thách với thời gian của chúng. Thế mà những tác phẩm của chúng ta vẫn bị cũ đi, bị người đọc lãng quên rất nhanh, không chịu được thử thách của thời gian như những cái Nam Cao đã viết ra. Vậy thì ở những tác phẩm của Nam Cao có cái gì khiến nó vẫn cứ mới mãi, được người đọc đọc mãi…”";
        $book13->weight = 220;
        $book13->format = "Bìa mềm";
        $book13->year = 2019;
        $book13->language = "Tiếng Việt";
        $book13->size = "11.3x17.6 cm";
        $book13->num_pages = 208;
        $book13->slug = Str::slug($book13->name);
        $book13->translator = "Nam Cao";
        $book13->publisher_id = 4;
        $book13->supplier_id = 4;
        $book13->book_type = 0;
        $book13->overrate = 0;
        $book13->e_book_price = null;
        $book13->link_pdf = null;
        $book13->save();
        $book13->authors()->sync([13]);
        $book13->categories()->sync([2]);

        $book14 = new Book();
        $book14->name = "Khi Hơi Thở Hóa Thinh Không (Tái Bản 2020)";
        $book14->code = "8935270702335";
        $book14->description = "Khi hơi thở hóa thinh không là tự truyện của một bác sĩ bị mắc bệnh ung thư phổi. Trong cuốn sách này, tác giả đã chia sẻ những trải nghiệm từ khi mới bắt đầu học ngành y, tiếp xúc với bệnh nhân cho tới khi phát hiện ra mình bị ung thư và phải điều trị lâu dài.
        
        Kalanithi rất yêu thích văn chương nên câu chuyện của anh đã được thuật lại theo một phong cách mượt mà, dung dị và đầy cảm xúc. Độc giả cũng được hiểu thêm về triết lý sống, triết lý nghề y của Kalanithi, thông qua ký ức về những ngày anh còn là sinh viên, rồi thực tập, cho đến khi chính thức hành nghề phẫu thuật thần kinh. “Đối với bệnh nhân và gia đình, phẫu thuật não là sự kiện bi thảm nhất mà họ từng phải đối mặt và nó có tác động như bất kỳ một biến cố lớn lao trong đời. Trong những thời điểm nguy cấp đó, câu hỏi không chỉ đơn thuần là sống hay chết mà còn là cuộc sống nào đáng sống.” – Kalanithi luôn biết cách đưa vào câu chuyện những suy nghĩ sâu sắc và đầy sự đồng cảm như thế.
        
        Bạn bè và gia đình đã dành tặng những lời trìu mến nhất cho con người đáng kính trọng cả về tài năng lẫn nhân cách này. Dù không thể vượt qua cơn bệnh nan y, nhưng thông điệp của tác giả sẽ còn khiến người đọc nhớ mãi.";
        $book14->weight = 250;
        $book14->format = "Bìa mềm";
        $book14->year = 2020;
        $book14->language = "Tiếng Việt";
        $book14->size = "	20.5 x 14 cm";
        $book14->num_pages = 236;
        $book14->slug = Str::slug($book14->name);
        $book14->translator = "Nhiều Người Dịch";
        $book14->publisher_id = 3;
        $book14->supplier_id = 5;
        $book14->book_type = 0;
        $book14->overrate = 0;
        $book14->e_book_price = null;
        $book14->link_pdf = null;
        $book14->save();
        $book14->authors()->sync([20]);
        $book14->categories()->sync([6]);

        $book15 = new Book();
        $book15->name = "Ghi Chép Pháp Y - Những Thi Thể Không Hoàn Chỉnh";
        $book15->code = "8935325017797";
        $book15->description = "Ghi Chép Pháp Y - Những Thi Thể Không Hoàn Chỉnh
        
        “Ghi chép pháp y - Những thi thể không hoàn chỉnh” là phần thứ 3, tiếp nối series đình đám “Ghi chép pháp y” được tác giả Pháp y Tần Minh và Phó giám đốc Hiệp hội pháp y Trung Quốc - Châu Diệc Vũ đặc biệt giới thiệu. Cuốn sách bao gồm 7 vụ án có thật, được viết bởi bác sĩ pháp y Lưu Bát Bách với 18 năm kinh nghiệm giải phẫu cho hơn 800 thi thể. 
        
        Nếu phần 1 đi sâu vào việc phá án bằng nghiệp vụ chuyên môn, phần 2 là sự đồng cảm với những xác chết không thể lên tiếng thì ở phần 3, tác giả sẽ tập trung miêu tả những hiện trường tội ác man rợ, phân tích động cơ gây án cũng như tâm lý biến thái ẩn sau bộ mặt bình thản của hung thủ. 
        
        Sự độc ác của nhân tính có thể khiến đứa con trai tự tay giết mẹ, ăn trộm tiền cho bạn. Sự độc ác của nhân tính có thể khiến người thầy giáo cởi bỏ lớp ngụy trang mẫu mực, phân xác học sinh dưới sự bao che của nhà trường. Sự độc ác của nhân tính có thể khiến vị bác sĩ thảm sát cả gia đình đồng nghiệp chỉ vì ghen tị.
        
        Bằng kỹ năng toàn diện và sự hỗ trợ của công nghệ siêu việt như: đối chiếu DNA, xác minh dấu giày, giám định mỏm xương thái dương… tác giả đã từng bước tìm ra chứng cứ then chốt, đập tan mọi ảo tưởng về “một tội ác hoàn hảo’ và đưa kẻ thủ ác ra trước ánh sáng pháp luật để chịu sự trừng phạt. 
        
        “Thật ra pháp y chính là nghề như vậy, thân thể ở trong nơi tối, trái tim hướng về phía ánh sáng mặt trời.” - Lưu Bát Bách. 
        
        Hy vọng trong phần 3 của series “Ghi chép pháp y”, bạn đọc sẽ tiếp tục đồng hành cùng tác giả trải nghiệm quá trình phá án, truy tìm hung thủ để đòi quyền cho người sống - lên tiếng cho người chết.";
        $book15->weight = 290;
        $book15->format = "Bìa mềm";
        $book15->year = 2023;
        $book15->language = "Tiếng Việt";
        $book15->size = "24 x 15.7 x 1.3 cm";
        $book15->num_pages = 	272;
        $book15->slug = Str::slug($book15->name);
        $book15->translator = "Linh Tử";
        $book15->publisher_id = 9;
        $book15->supplier_id = 8;
        $book15->book_type = 0;
        $book15->overrate = 0;
        $book15->e_book_price = null;
        $book15->link_pdf = null;
        $book15->save();
        $book15->authors()->sync([32]);
        $book15->categories()->sync([6]);

        $book16 = new Book();
        $book16->name = "Phương Pháp Giáo Dục Con Của Người Do Thái - Giúp Trẻ Tự Tin Bước Vào Cuộc Sống";
        $book16->code = "8936067605211";
        $book16->description = "
        Phương Pháp Giáo Dục Con Của Người Do Thái - Giúp Trẻ Tự Tin Bước Vào Cuộc Sống
        
        Xem trọng giáo dục của cha mẹ với con cái là truyền thống tốt đẹp nổi bật nhất của dân tộc Do Thái. Mặc dù phải trải qua rất nhiều khó khăn và luôn phải phiêu bạt khắp nơi nhưng người Do Thái vẫn không quên dành cho con nền giáo dục tốt nhất. Và, họ còn tìm ra những phương pháp giáo dục con đặc biệt.
        
        Trí tuệ là tài sản lớn nhất của con
        
        Người Do Thái sùng bái trí tuệ, trân trọng kiến thức, họ không chỉ có ý thức bồi dưỡng cho con cái khả năng tự học mà còn thường xuyên cổ vũ trẻ thu nhận kiến thức qua nhiều con đường khác nhau. Khi trẻ còn nhỏ, đại đa số bố mẹ Do Thái dùng những vật dụng hằng ngày để giúp trẻ học ngoại ngữ. Ví dụ, họ thường sử dụng cốc, chậu rửa mặt, khăn mặt,… để đặt câu hỏi, giúp trẻ học những từ mới đơn giản. Ngoài ra, lúc dẫn con cái đi mua đồ, cha mẹ Do Thái thường chú ý đến ánh mắt của trẻ, chọn những đồ mà trẻ thích, nhân cơ hội đó dạy trẻ ngoại ngữ.
        
        Có thể thấy, cha mẹ Do Thái giống như người làm vườn chăm chỉ chăm chồi cây non, họ sẽ phân loại tri thức theo hứng thú và sở thích của con ở từng giai đoạn rồi mới truyền thụ cho trẻ, giúp trẻ tiếp thu nhẹ nhàng và hiệu quả.
        
        Tự lập tự cường là kĩ năng sinh tồn của con
        
        Cha mẹ Do Thái thường không nuông chiều con cái. Tình yêu của họ dành cho con đều có nguyên tắc, có mức độ. Nếu hành vi của trẻ vi phạm nguyên tắc, vượt quá giới hạn, cha mẹ sẽ không nương tay mà nghiêm khắc phê bình khuyên bảo. Những việc làm này khiến trẻ sống trẻ sống độc lập và có nguyên tắc, để khi trưởng thành là một người độc lập.
        
        Kỹ năng sống độc lập có vai trò rất quan trọng đối với sự trưởng thành và phát triển của trẻ. Từ nhỏ, cha mẹ Do Thái đã hướng dẫn con làm các công việc trong gia đình như đổ rác, gấp quần áo, lau nhà,… để rèn luyện khả năng sống độc lập cho trẻ. Dù đôi lúc việc dạy những kĩ năng này mất nhiều thời gian hơn so với việc bố mẹ tự làm nhưng họ vẫn kiên trì chỉ bảo cho trẻ đến cùng. Vì họ hiểu rằng: Chỉ khi để trẻ học kĩ năng sống, trẻ mới có thể thực sự tách khỏi bố mẹ, thích nghi với cuộc sống, với xã hội. Cho nên trong quá trình dạy con, các bậc cha mẹ cần học theo phương pháp này, hết sức kiên nhẫn để chỉ bảo cho trẻ.
        
        Quản lí tài chính là kĩ năng cơ bản của con
        
        Người Do Thái ngoài việc hiểu giá trị của đồng tiền còn truyền dạy những kiến thức đó cho con cái để thế hệ sau hiểu được giá trị của nó. Khi trẻ được 3 tuổi, cha mẹ bắt đầu giảng giải cho trẻ hiểu giá trị và công dụng của đồng tiền. Họ thường cùng trẻ chơi trò chơi đoán giá trị tiền tệ để nâng cao khả năng nhận biết đồng tiền cho con. Khi đi mua sắm, cha mẹ Do Thái thường để trẻ so sánh giá cả của các loại sản phẩm khác nhau nhằm bồi dưỡng khả năng chi tiêu của trẻ.
        
        Người Do Thái cho rằng dạy trẻ những kiến thức tài chính này là rất quan trọng vì người có khả năng quản lí tài chính và ý thức đầu tư giỏi sẽ biết kiếm tiền và nắm giữ tiền bạc. Các bậc cha mẹ nên học tập cách làm của người Do Thái, bồi dưỡng khả năng đầu tư, quản lí cho trẻ từ nhỏ để trẻ có một nền tảng vững chắc trong tương lai.
        
        Cuốn sách chia sẻ với các bậc cha mẹ bí quyết giáo dục trẻ của một trong những dân tộc thông minh nhất Thế giới. Còn chần chừ gì mà không mở cuốn sách này ra và chào đón tương lai thành công của con bạn!
        ";
        $book16->weight = 270;
        $book16->format = "Bìa mềm";
        $book16->year = 2022;
        $book16->language = "Tiếng Việt";
        $book16->size = "20.5 x 15 x 1.1 cm";
        $book16->num_pages = 244;
        $book16->slug = Str::slug($book16->name);
        $book16->translator = "Thanh Nhã";
        $book16->publisher_id = 7;
        $book16->supplier_id = 4;
        $book16->book_type = 0;
        $book16->overrate = 0;
        $book16->e_book_price = null;
        $book16->link_pdf = null;
        $book16->save();
        $book16->authors()->sync([33]);
        $book16->categories()->sync([9]);

        $book17 = new Book();
        $book17->name = "Harry potter và hòn đá phù thủy";
        $book17->code = "8934974179672";
        $book17->description = "Khi một lá thư được gởi đến cho cậu bé Harry Potter bình thường và bất hạnh, cậu khám phá ra một bí mật đã được che giấu suốt cả một thập kỉ. Cha mẹ cậu chính là phù thủy và cả hai đã bị lời nguyền của Chúa tể Hắc ám giết hại khi Harry mới chỉ là một đứa trẻ, và bằng cách nào đó, cậu đã giữ được mạng sống của mình. Thoát khỏi những người giám hộ Muggle không thể chịu đựng nổi để nhập học vào trường Hogwarts, một trường đào tạo phù thủy với những bóng ma và phép thuật, Harry tình cờ dấn thân vào một cuộc phiêu lưu đầy gai góc khi cậu phát hiện ra một con chó ba đầu đang canh giữ một căn phòng trên tầng ba. Rồi Harry nghe nói đến một viên đá bị mất tích sở hữu những sức mạnh lạ kì, rất quí giá, vô cùng nguy hiểm, mà cũng có thể là mang cả hai đặc điểm trên.";
        $book17->weight = 0;
        $book17->format = "Ebook";
        $book17->year = 0;
        $book17->language = "Tiếng Việt";
        $book17->size = "0";
        $book17->num_pages = 366;
        $book17->slug = Str::slug($book17->name);
        $book17->translator = "Lý Lan";
        $book17->publisher_id = 9;
        $book17->supplier_id = 7;
        $book17->book_type = 1;
        $book17->overrate = 0;
        $book17->e_book_price = 25000;
        $book17->link_pdf = null;
        $book17->save();
        $book17->authors()->sync([34]);
        $book17->categories()->sync([8]);

        $book18 = new Book();
        $book18->name = "Harry Potter Và Đứa Trẻ Bị Nguyền Rủa";
        $book18->code = "8934974177777";
        $book18->description = "Kịch bản Harry Potter và Đứa trẻ bị nguyền rủa được viết dựa trên câu chuyện của J.K. Rowling, Jack Thorne và John Tiffany.
        Từ những nhân vật quen thuộc trong bộ Harry Potter, kịch bản nói về cuộc phiêu lưu của những hậu duệ, sự can thiệp vào dòng thời gian đã gây ra những thay đổi không ngờ cho tương lai tưởng chừng đã yên ổn sau khi vắng bóng chúa tể Voldermort";
        $book18->weight = 0;
        $book18->format = "Ebook";
        $book18->year = 0;
        $book18->language = "Tiếng Việt";
        $book18->size = "0";
        $book18->num_pages = 248;
        $book18->slug = Str::slug($book18->name);
        $book18->translator = "Như Mai";
        $book18->publisher_id = 7;
        $book18->supplier_id = 9;
        $book18->book_type = 1;
        $book18->overrate = 0;
        $book18->e_book_price = 25000;
        $book18->link_pdf = null;
        $book18->save();
        $book18->authors()->sync([34]);
        $book18->categories()->sync([8]);

        $book19 = new Book();
        $book19->name = "Trò chơi vương quyền - Sói tuyết thành Winterfell";
        $book19->code = "6232214620001";
        $book19->description = "Tại một vùng đất xa xưa, nơi mùa hè dường như kéo dài vô tận và mùa đông trải qua cả đời người, cuộc chiến giành Ngai Sắt đã bắt đầu. Cuộc chiến kéo dài suốt từ phương nam, vùng đất của giống loài tham lam, hung hãn và đầy mưu toan, đến miền đất phía đông bao la hoang dã; và trải dọc con đường lên phương bắc lạnh giá, nơi có bức tường băng bảo vệ vương quốc khỏi những thế lực đen tối bên ngoài. Các âm mưu chính trị đan xen những hấp lực của tình yêu, tình dục len lỏi khắp nơi. Ngay cả quá khứ, dù đã chôn vùi, cũng chẳng được ngủ yên.

        Khi những vị vua và hoàng hậu, những lãnh chúa và hiệp sĩ, cả người trung thành lẫn kẻ phản trắc tham gia Trò chơi Vương quyền, chỉ có duy nhất một con đường: Sống hoặc Chết.
        
        Những người chơi chính là Nhà Stark, Lannister và Baratheon. Robert Baratheon, Vua trị vì Westeros mời người bạn cũ là Eddard Stark, Lãnh chúa thành Winterfell, về Vương Đô làm quân sư. Eddard, nghi ngờ rằng người tiền nhiệm của ông, Lãnh chúa Jon Arryn đã bị sát hại, buộc lòng phải đồng ý để có thể điều tra thêm về vụ việc. Càng dấn sâu vào cuộc chơi, càng nhiều bí mật đen tối được tiết lộ. Gia đình hoàng hậu Cersei – nhà Lannister, dường như đang ngầm thực hiện âm mưu tiếm ngôi của mình.
        
        Tại Thành Phố Tự trị Pentos, Viserys Targaryen - người thừa kế duy nhất còn sống sót của vua Aerys II nhà Targaryen, Vua Điên, người đã bị Robert Baratheon lật đổ trong cuộc chiến của Phản Vương. Nhà Targaryen đã trị vì Westeros với cương vị chúa rồng trong gần 300 năm, nhưng giờ những con rồng và quyền lực của họ đã biến mất. Viserys thỏa thuận để em gái Daenerys, kết hôn cùng Khal Drogo, một chúa ngựa của tộc Dothraki, nhằm đổi lấy quyền sử dụng đội quân của Drogo để chiếm lại Ngai Sắt.
        
        Trong khi đó, ở miền cực bắc giá lạnh, một thế lực hắc ám được gọi là Ngoại Nhân đang âm thầm trỗi dậy. Tại Tường Thành – bức tường băng kiên cố và vững chãi bảo vệ Bảy Phụ Quốc, có một tổ chức duy nhất gồm các thành viên bị đào thải của xã hội, Đội Tuần Đêm, thề nguyện sống chết với Tường Thành, không gia đình, không hôn nhân, con cái.
        
        Xung đột giữa các Lãnh chúa quyền lực nhất, cùng với những người chơi khác như Nhà Greyjoy, Tully, Arryn, và Nhà Tyrell, mỗi lúc một căng thẳng, một kết cục hiển nhiên không tránh khỏi: đó là Chiến Tranh.";
        $book19->weight = 0;
        $book19->format = "Ebook";
        $book19->year = 0;
        $book19->language = "Tiếng Việt";
        $book19->size = "0";
        $book19->num_pages = 672;
        $book19->slug = Str::slug($book19->name);
        $book19->translator = "Cẩm Chi";
        $book19->publisher_id = 6;
        $book19->supplier_id = 4;
        $book19->book_type = 1;
        $book19->overrate = 0;
        $book19->e_book_price = 25000;
        $book19->link_pdf = null;
        $book19->save();
        $book19->authors()->sync([35]);
        $book19->categories()->sync([8]);

        $book20 = new Book();
        $book20->name = "Trò chơi vương quyền - Vũ điệu rồng thiêng";
        $book20->code = "6232214620001";
        $book20->description = "Bộ sách đồ sộ và đình đám Trò chơi vương quyền là một series tiểu thuyết sử thi viễn tưởng của tiểu thuyết gia nổi tiếng người Mỹ George R. R. Martin. Lấy cảm hứng từ tiểu thuyết "."Cuộc chiến hoa hồng"." và "."Ivanhoe"." Martin bắt đầu viết bộ sách vào năm 1991 và năm 1996 ông cho ra mắt ấn phẩm đầu tiên. Cuốn tiểu thuyết cũng như cả bộ sách nhanh chóng nhận được sự đón chào nhiệt liệt của một lượng fan hâm mộ khổng lồ, trở thành các tác phẩm best seller của nhiều bảng xếp hạng uy tín. Từ dự định viết một bộ ba tập lúc ban đầu, đến nay Martin đã đẩy kế hoạch đó lên thành bảy tập; và tập năm của bộ sách đã được phát hành vào 12/07/2011 vừa qua.
        
        Ngoài việc đoạt được hàng loạt các giải thưởng danh giá như giải khoa học viễn tưởng Hugo Award, bộ tiểu thuyết". "Trò chơi vương quyền". "đã được bán bản quyền cho hơn 20 nước và dịch ra hơn 20 ngôn ngữ trên thế giới. Tại quê hương của mình, tập thứ tư và thứ năm của bộ sách liên tục đứng ở vị trí số một trong Danh sách bán chạy nhất New York Times vào năm 2005 và 2011. Về số lượng, series tiểu thuyết này đã bán được hơn 7 triệu bản tại Mỹ và hơn 22 triệu bản trên toàn thế giới. Kênh truyền hình HBO đã chuyển thể series tiểu thuyết này sang series phim truyền hình chất lượng cao, đậm chất Holywood khiến danh tiếng của bộ sách cũng như tên tuổi của tác giả ngày càng vang xa.
        
        Bộ sách viết về cuộc tranh giành quyền lực của bảy lãnh chúa vùng đất Weterlos và Essos, gồm những khu vực do các dòng họ lớn cai trị, trong bối cảnh nhiều thế lực đen tối có sức mạnh siêu nhiên như người Ngoại nhân, quỷ bóng trắng... luôn đe dọa xâm chiếm Weterlos.
        
        Lấy cảm hứng từ các sự kiện lịch sử như lịch sử nước Anh thời kỳ". "Cuộc chiến hoa hồng". ", nhưng Martin cố tình bất chấp các quy ước về thể loại giả tượng để viết nên bộ tiểu thuyết này. Bạo lực, tình dục và sự mơ hồ về đạo đức thường xuyên hiển thị trong tác phẩm của ông. Nhân vật chính thường xuyên bị giết, các sự kiện được nhìn nhận dưới nhiều góc nhìn khác nhau, kể cả qua cái nhìn của các nhân vật phản diện, điều này khiến độc giả không thể nghiêng về các nhân vật". "anh hùng". " như các cuốn tiểu thuyết thông thường khác; đồng thời cũng khẳng định thêm sự thật rằng những nhân vật anh hùng không thể đi qua các biến cố mà không bị tổn thương, mất mát giống như trong đời thực. Chính vì vậy, Trò chơi vương quyền nhận được vô số những lời khen ngợi về chủ nghĩa hiện thực. Đồng thời bộ tiểu thuyết cũng nhận được những bình luận quan trọng về vai trò của phụ nữ và tôn giáo được thể hiện trong tác phẩm.";
        $book20->weight = 0;
        $book20->format = "Ebook";
        $book20->year = 0;
        $book20->language = "Tiếng Việt";
        $book20->size = "0";
        $book20->num_pages = 	672;
        $book20->slug = Str::slug($book20->name);
        $book20->translator = "Cẩm Chi";
        $book20->publisher_id = 2;
        $book20->supplier_id = 7;
        $book20->book_type = 0;
        $book20->overrate = 0;
        $book20->e_book_price = 25000;
        $book20->link_pdf = null;
        $book20->save();
        $book20->authors()->sync([35]);
        $book20->categories()->sync([8]);
    }
}
