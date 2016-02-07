## NEWS - Trang tin tức
 NEW là project được lập nên nhằm mục đích tìm hiểu [Laravel Framework](http://laravel.com).
## Trang chủ chính thức
 Thảo luận về project NEWS vui lòng tham gia nhóm facebook [NEWS Facebook Group](https://www.facebook.com/groups/1000070060031803/). Nếu nhóm facebook trong trạng thái ẩn vui lòng liên hệ [koutsuneka@facebook](https://www.facebook.com/messages/koutsuneka) hoặc [tsuneka.kou@gmail.com](mailto:tsuneka.kou@gmail.com?Subject=NEWS%20Group%20Invitation).
## Demo
 - Live demo on shared host: [NEWS](http://news.meongu.net) - Last update 07-Feb-2016
 - Demo user credential: yahishima@gmail.com | abc@123
 
### Giấy phép
 NEWS là phần mềm mã nguồn mở được cấp phép theo [giấy phép MIT](http://opensource.org/licenses/MIT)
 Lưu ý: phần giao diện inspina hay unify thì NEWS không có license chuyển nhượng, nếu bạn thích thì mua license của 2 theme này để ủng hộ họ nhé.
### Cài đặt phát triển (development)
 Lưu ý: NEWS yêu cầu `php 5.5.9` trở lên. Hướng dẫn cài đặt trên shared host sẽ được cập nhật sau.
##### Step 1: Clone repository
 Thực thi lệnh `git clone https://github.com/laravel-noobs/NEWS.git` tại thư mục mong muốn cài đặt.
##### Step 2: Khôi phục các gói phụ thuộc
|    pms   |      commands      |
|----------|--------------------|
| composer | `composer install` |
| npm      | `npm install`      |
| bower    | `bower install`    |
##### Step 3: Thu tập tài nguyên cho thư mục public
 Thực thi lệnh `gulp default` tại thư mục gốc.
##### Step 4: Thiết lập
 Đổi tên tập tin `.env.example` tại thư mục gốc thành `.env` và tùy chỉnh thiết lập cho phù hợp.
##### Step 5: Cài đặt cơ sở dữ liệu
 Thực thi lệnh `php artisan migrate` tại thư mục gốc.
##### Step 6: Seed dữ liệu mẫu
 Thực thi lệnh `php artisan db:seed` tại thư mục gốc.
 Lưu ý nếu xảy ra lỗi trùng khóa trong quá trình seed thì đó là lỗi lường trước. Trong trường hợp đó thực hiện
 `artisan migrate:refresh` để cài đặt lại cấu trúc bảng và chạy lại bước 6.
 
 