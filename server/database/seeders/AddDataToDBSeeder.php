<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin;
use App\Models\author;
use App\Models\book;
use App\Models\book_categorie;
use App\Models\categorie;
use App\Models\discount;
use App\Models\image;
use App\Models\review;
use App\Models\slider;
use App\Models\supplier;
use App\Models\User;
use Hash;
class AddDataToDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //thêm admin 1
        $admin1=new admin();
        $admin1->name='Viết Thành';
        $admin1->email='admin@123';
        $admin1->email_verified_at=null;
        $admin1->password=Hash::make('123123');
        $admin1->role = 1;
        $admin1->remember_token='';
        $admin1->save();

        $admin2 = new admin();
        $admin2->name = 'Thành Nghĩa';
        $admin2->email = 'admin@456';
        $admin2->email_verified_at =null;
        $admin2->password = Hash::make('123123');
        $admin2->role = 2;
        $admin2->remember_token = '';
        $admin2->save(); // Save the admin1 object to the database

        $admin3 = new admin();
        $admin3->name = 'Thanh Tuấn';
        $admin3->email = 'admin@789';
        $admin3->email_verified_at =null;
        $admin3->password = Hash::make('123123');
        $admin3->role = 3;
        $admin3->remember_token = '';
        $admin3->save(); // Save the admin2 object to the database

        

        //categories
        $categories1=new categorie();
        $categories1->name='Văn học';
        $categories1->description=' Sách văn học là một dạng văn bản dưới hình thức nghệ thuật, có giá trị nghệ thuật hoặc trí tuệ, thường sẽ có những cách thức triển khai ngôn ngữ khác với cách sử dụng thông thường. Sách văn học là một trong những loại sách mà chúng ta tiếp xúc khá nhiều trong cuộc sống, đó là một loại hình sáng tác đặc biệt. Chúng có khả năng tái hiện lại bình diện cuộc sống và xã hội, những sự kiện, diễn biến và con người,… dưới ngòi bút văn hoa, trào phúng.';
        $categories1->slug='Van-hoc';
        $categories1->save();

        $categories2=new categorie();
        $categories2->name='Sách thiếu nhi';
        $categories2->description='Sách thiếu nhi là loại sách được viết và thiết kế đặc biệt để dành cho độc giả trẻ em và thiếu nhi. Đây là những tác phẩm văn học, hình ảnh hoặc sách học tập được tạo ra để phù hợp với lứa tuổi, sự phát triển, sở thích của trẻ em, giúp họ phát triển khả năng đọc, tư duy, hiểu biết.';
        $categories2->slug='Sach-thieu-nhi';
        $categories2->save();
        
        $categories3=new categorie();
        $categories3->name='Kinh tế';
        $categories3->description='Sách kinh tế là tài liệu về lĩnh vực kinh tế, bao gồm các chủ đề như tài chính, kinh doanh, tiền tệ, thương mại, chính sách kinh tế, quản lý kinh doanh, và các vấn đề kinh tế khác.';
        $categories3->slug='Kinh-te';
        $categories3->save();

        $categories4=new categorie();
        $categories4->name='Giáo khoa - Tham khảo';
        $categories4->description='Sách giáo khoa là loại sách cung cấp kiến thức, được biên soạn với mục đích dạy và học tại trường học[1][2]. Thuật ngữ sách giáo khoa còn có nghĩa mở rộng là một loại sách chuẩn cho một ngành học. Sách giáo khoa được phân loại dựa theo đối tượng sử dụng hoặc chủ đề của sách.';
        $categories4->slug='Giao-khoa-tham-khao';
        $categories4->save();
        
        $categories5=new categorie();
        $categories5->name='Sách học ngoại ngữ';
        $categories5->description='Sách học ngoại ngữ là một loại sách được thiết kế để giúp người học ngoại ngữ cải thiện khả năng của họ. Sách học ngoại ngữ có thể tập trung vào một hoặc nhiều kỹ năng ngoại ngữ, chẳng hạn như nghe, nói, đọc, viết, hoặc ngữ pháp. Chúng có thể được viết cho người học ở mọi trình độ, từ người mới bắt đầu đến người cao cấp.';
        $categories5->slug='Sach-hoc-ngoai-ngu';
        $categories5->save();

        //suppliers
        $supplier1=new supplier();
        $supplier1->name='An Lộc Việt';
        $supplier1->addresss='30 Kha Vạn Cân, Hiệp Bình Chánh, Thủ Đức, Hồ Chí Minh.';
        $supplier1->phone='0899 189 499';
        $supplier1->description='Công ty TNHH MTV An Lộc Việt được thành lập từ tháng 04/2013 ngành nghề kinh doanh chính là phân phối sỉ và lẻ ngành hàng Văn phòng phẩm - Giấy in văn phòng.
                                Đến tháng 06/2020, An Lộc Việt đã mạnh dạn phát triển thêm một số sản phẩm dịch vụ mới và đã được nhiều khách hàng đón nhận và tin dùng';
        $supplier1->slug='An-Loc-Viet';
        $supplier1->save();

        $supplier2=new supplier();
        $supplier2->name='Nhà xuất bản văn học';
        $supplier2->addresss='18 Nguyễn Trường Tộ - Ba Đình - Hà Nội';
        $supplier2->phone=' 0243 7161 518';
        $supplier2->description='NHÀ XUẤT BẢN VĂN HỌC chuyên cung cấp: Sách mới, Văn học trong nước, Tiểu thuyết, Truyện ngắn, Tản văn – Hồi ký, Thơ, Lý luận phê bình, Sách thiếu nhi, ...';
        $supplier2->slug='Nha-xuat-ban-van-hoc';
        $supplier2->save();

        $supplier3 = new supplier();
        $supplier3->name = 'Nhà xuất bản Trẻ';
        $supplier3->address = '35B Nguyễn Thị Minh Khai, Bến Nghé, Quận 1, Thành phố Hồ Chí Minh';
        $supplier3->phone = '0283 8229 999';
        $supplier3->description = 'NHÀ XUẤT BẢN TRẺ chuyên cung cấp: Sách mới, Văn học trong nước, Văn học nước ngoài, Tiểu thuyết, Truyện ngắn, Thơ, Truyện tranh, Sách thiếu nhi, ...';
        $supplier3->slug = 'Nha-xuat-ban-tre';
        $supplier3->save();

        $supplier4 = new supplier();
        $supplier4->name = 'Nhà xuất bản Kim Đồng';
        $supplier4->address = '161 Bà Triệu, Hai Bà Trưng, Hà Nội';
        $supplier4->phone = '0243 8257 288';
        $supplier4->description = 'NHÀ XUẤT BẢN KIM ĐỒNG chuyên cung cấp: Sách mới, Văn học thiếu nhi, Truyện tranh, Sách tranh, Sách thiếu nhi quốc tế, ...';
        $supplier4->slug = 'Nha-xuat-ban-kim-dong';
        $supplier4->save();

        $supplier5 = new supplier();
        $supplier5->name = 'Fahasa';
        $supplier5->address = '268 Lê Thánh Tôn, Quận 1, Thành phố Hồ Chí Minh';
        $supplier5->phone = '1900 6036';
        $supplier5->description = 'FAHASA là nhà bán lẻ sách lớn nhất Việt Nam, chuyên cung cấp: Sách mới, Văn học trong nước, Văn học nước ngoài, Tiểu thuyết, Truyện ngắn, Thơ, Truyện tranh, Sách thiếu nhi, ...';
        $supplier5->slug = 'Fahasa';
        $supplier5->save();

        //author
        $author1=new author();
        $author1->name='Ernest Miller Hemingway';
        $author1->description='Ernest Hemingway (1899 - 1961) là nhà văn, nhà báo người Mỹ. Ông từng tham gia chiến đấu trong Chiến tranh thế giới lần thứ I, sau đó được biết đến qua "Thế hệ đã mất". Ông nhận được giải thưởng báo chí Pulitzer năm 1953 và giải Nobel văn học năm 1954.';
        $author1->slug='Ernest-Miller-Hemingway';
        $author1->image='';
        $author1->save();

        $author2 = new author();
        $author2->name = 'Nguyễn Du';
        $author2->description = 'Nguyễn Du (1765-1820) là nhà thơ, nhà văn, nhà viết kịch, nhà nghiên cứu văn hóa, nhà nhân đạo chủ nghĩa lớn của Việt Nam, được mệnh danh là "Đại thi hào dân tộc", "Nhà thơ của dân tộc". Ông là tác giả của kiệt tác Truyện Kiều, được xem là "thiên trường ca của nền văn học Việt Nam".';
        $author2->slug = 'Nguyen-Du';
        $author2->image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/f4/Nguyễn_Du.jpg/1200px-Nguyễn_Du.jpg';
        $author2->save();

        $author3 = new author();
        $author3->name = 'Thạch Lam';
        $author3->description = 'Thạch Lam (1910-1942) là nhà văn, nhà báo, nhà viết truyện ngắn nổi tiếng của Việt Nam. Ông được đánh giá là một trong những cây bút xuất sắc nhất của dòng văn học lãng mạn Việt Nam. Các tác phẩm của ông thường viết về những mảnh đời nhỏ bé, những tâm hồn nhạy cảm trong xã hội đương thời.';
        $author3->slug = 'Thach-Lam';
        $author3->image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c9/Thạch_Lam.jpg/1200px-Thạch_Lam.jpg';
        $author3->save();

        $author4 = new author();
        $author4->name = 'Nam Cao';
        $author4->description = 'Nam Cao (1915-1951) là nhà văn, nhà báo nổi tiếng của Việt Nam. Ông được mệnh danh là "nhà văn của người cùng khổ". Các tác phẩm của ông thường viết về những người nông dân nghèo khổ, lam lũ trong xã hội Việt Nam trước Cách mạng tháng Tám.';
        $author4->slug = 'Nam-Cao';
        $author4->image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Nam_Cao_1951.jpg/1200px-Nam_Cao_1951.jpg';
        $author4->save();

        $author5 = new author();
        $author5->name = 'Nguyễn Ngọc Tư';
        $author5->description = 'Nguyễn Ngọc Tư (sinh năm 1976) là nhà văn, nhà báo nổi tiếng của Việt Nam. Bà được mệnh danh là "cây bút của những người vô danh". Các tác phẩm của bà thường viết về những mảnh đời nhỏ bé, những số phận bị bỏ quên trong xã hội.';
        $author5->slug = 'Nguyen-Ngoc-Tu';
        $author5->image = 'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Nguyễn_Ngọc_Tư.jpg/1200px-Nguyễn_Ngọc_Tư.jpg';
        $author5->save();
        
        //book_categorie
        $book_categorie1=new book_categorie();
        $book_categorie1->categories_id=1;
        $book_categorie1->books_id=1;
        $book_categorie1->save();

        $book_categorie2=new book_categorie();
        $book_categorie2->categories_id=2;
        $book_categorie2->books_id=2;
        $book_categorie2->save();

        $book_categorie3=new book_categorie();
        $book_categorie3->categories_id=3;
        $book_categorie3->books_id=3;
        $book_categorie3->save();
        
        $book_categorie4=new book_categorie();
        $book_categorie4->categories_id=4;
        $book_categorie4->books_id=4;
        $book_categorie4->save();

        $book_categorie5=new book_categorie();
        $book_categorie5->categories_id=5;
        $book_categorie5->books_id=5;
        $book_categorie5->save();
        
        //book
        $book1=new book();
        $book1->name='Ông Già Và Biển Cả';
        $book1->code='';
        $book1->description='Lấy bối cảnh một làng chài ở La Habana, tác phẩm kể về cuộc chiến đấu đơn độc của ông lão Santiago với con cá kiếm hùng dũng và đàn cá mập hung tợn giữa lòng đại dương. Bằng giọng văn tự sự và nghệ thuật xây dựng các chủ thể đối lập, Hemingway đã viết nên một bản anh hùng ca đa thanh, đa diện về ý chí, khát vọng chinh phục ước mơ của con người trước các cơn ba đào nghiệt ngã.';
        $book1->unit_price=200000;
        $book1->weight=400;
        $book1->format='In đen trắng';
        $book1->year=2022;
        $book1->language='Việt Nam';
        $book1->size='24 x 16 x 1.1 cm';
        $book1->num_pages=156;
        $book1->slug='Ong-Gia-Va-Bien-Ca';
        $book1->translator='Nguyễn Văn Huyền';
        $book1->authors_id=1;
        $book1->suppliers_id=5;
        $book1->save();

        $book2 = new Book();
        $book2->name = "Truyện Kiều";
        $book2->code = "";
        $book2->description = "Truyện Kiều là một tác phẩm văn học đồ sộ của nền văn học trung đại Việt Nam, được sáng tác bởi Nguyễn Du. Tác phẩm kể về cuộc đời đầy sóng gió của nàng Kiều, từ một tiểu thư khuê các đài các đến một kỹ nữ lầu xanh, rồi lại trở về làm vợ của một kẻ bạc tình. Bằng ngòi bút tài hoa và tấm lòng nhân đạo sâu sắc, Nguyễn Du đã khắc họa thành công hình tượng nhân vật Kiều, một người phụ nữ tài sắc vẹn toàn nhưng phải chịu nhiều đau khổ, bất hạnh. Truyện Kiều không chỉ là một tác phẩm văn học xuất sắc mà còn là một tác phẩm có giá trị nhân văn sâu sắc, thể hiện niềm cảm thương sâu sắc của nhà thơ đối với những người phụ nữ tài sắc nhưng bạc mệnh.";
        $book2->unit_price = 250000;
        $book2->weight = 450;
        $book2->format = "In đen trắng";
        $book2->year = 2023;
        $book2->language = "Việt Nam";
        $book2->size = "24 x 17 x 1.2 cm";
        $book2->num_pages = 700;
        $book2->slug = "Truyen-Kieu";
        $book2->translator = "";
        $book2->authors_id = 2;
        $book2->suppliers_id = 1;
        $book2->save();

        $book3 = new Book();
        $book3->name = "Số đỏ";
        $book3->code = "";
        $book3->description = "Số đỏ là một tiểu thuyết trào phúng của nhà văn Thạch Lam, được xuất bản lần đầu tiên vào năm 1936. Tác phẩm kể về cuộc sống của một gia đình tư sản thành thị trong những năm đầu thế kỷ 20. Bằng ngòi bút trào phúng sắc bén, Thạch Lam đã vạch trần bộ mặt giả dối, lố bịch của xã hội tư sản đương thời. Số đỏ không chỉ là một tác phẩm văn học xuất sắc mà còn là một bức tranh chân thực về xã hội Việt Nam trong những năm đầu thế kỷ 20.";
        $book3->unit_price = 220000;
        $book3->weight = 420;
        $book3->format = "In đen trắng";
        $book3->year = 2023;
        $book3->language = "Việt Nam";
        $book3->size = "23 x 16 x 1 cm";
        $book3->num_pages = 350;
        $book3->slug = "So-do";
        $book3->translator = "";
        $book3->authors_id = 3;
        $book3->suppliers_id = 2;
        $book3->save();

        $book4 = new Book();
        $book4->name = "Sống mòn";
        $book4->code = "";
        $book3->description = "Sống mòn là một tập truyện ngắn của nhà văn Nam Cao, được xuất bản lần đầu tiên vào năm 1942. Tác phẩm tập trung khai thác cuộc sống của những người nông dân nghèo khổ trong xã hội Việt Nam trước Cách mạng tháng Tám. Bằng ngòi bút hiện thực và tinh thần nhân đạo sâu sắc, Nam Cao đã khắc họa thành công hình tượng những người nông dân nghèo khổ, lam lũ, bị áp bức bóc lột đến mức sống mòn, sống sót. Sống mòn không chỉ là một tác phẩm văn học xuất sắc mà còn là một bức tranh chân thực về xã hội Việt Nam trước Cách mạng tháng Tám.";
        $book4->unit_price = 200000;
        $book4->weight = 400;
        $book4->format = "In đen trắng";
        $book4->year = 2023;
        $book4->language = "Việt Nam";
        $book4->size = "24 x 16 x 1.1 cm";
        $book4->num_pages = 250;
        $book4->slug = "Song-mon";
        $book4->translator = "";
        $book4->authors_id = 4;
        $book4->suppliers_id = 2;
        $book4->save();
        //too much
    }
}
