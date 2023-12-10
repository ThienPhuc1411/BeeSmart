Dự Án BeeSmart - PHÁT TRIỂN HỆ THỐNG QUẢN LÝ CỬA HÀNG TRỰC TUYẾN

MÔ TẢ: Dự án được tạo ra nhằm mục địch phục vụ các chủ cửa hàng, bán lẻ quản lý bán hàng, doanh thụ lợi nhuận
, hàng tồn kho 1 cách tiện lợi tiết kiệm chi phí và giảm thiểu rủi ro xuống mức thấp nhất. Mục tiêu của dự án
mong muốn giúp người sử dụng BeeSmart tiết kiệm thời gian, nâng cao hiệu suất kinh doanh và đảm bảo rằng luôn có đủ hàng hóa để phục vụ khách hàng của mình.

CÀI ĐẶT:
 Bước 1: Mở file mã nguồn.zip để giải nén 
 Bước 2: Import file .sql vào phpMyAdmin
 Bước 3: Kiểm tra file env database đã tương thích với phpMyAdmin

SỬ DỤNG TRANG ADMIN NHƯ THẾ NÀO? 
 Bước 1: Chạy terminal " php artisan serve " và bật phpMyAdmin và chạy đường link : "localhost:8000" để vào admin
 Bước 2: Đăng nhập vào admin( email: beesmart301@gmail.com / password: admin123)
 Bước 3: Trải nghiệm các tính năng của trang admin

SỬ DỤNG API NHƯ THẾ NÀO?
Vì tất cả dự liệu Dự Án BeeSmart đều được xử lý dưới dạng API nên mọi người có thể dễ dàng kiểm tra các tính năng
 Hướng dẫn :Chạy terminal " php artisan route:list " để xem các route khả thi và sử dụng thử trên postman dựa theo các request yêu cầu trong function


KHẮC PHỤC LỖI: 
1.Nếu trường hợp xảy ra sự cố do các vendor(required, missing,...) chỉ cần chạy lệnh terminal : "composer update"
2.Nếu chạy API route và gặp lỗi thiếu các request -> vào function API đó và xem các request cần thiết để hoạt động API

CÔNG NGHỆ SỬ DỤNG: BeeSmart Back-end được code chủ yếu bởi PHP và Framework LARAVEL phiên bản mới nhất 10.x hiện tại, kèm theo là CSDL MySQL,
Github là nơi để các thành viên lắp ráp tổng hợp lưu trữ code



