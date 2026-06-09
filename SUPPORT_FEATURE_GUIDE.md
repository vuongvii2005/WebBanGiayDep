# Chức năng Hỗ trợ Khách hàng (Customer Support)

## Tổng quan
Chức năng hỗ trợ khách hàng cho phép khách hàng tạo các yêu cầu hỗ trợ và giao tiếp trực tiếp với nhóm hỗ trợ quản trị viên.

## Tính năng

### 1. **Cho Khách hàng**
- **Tạo yêu cầu hỗ trợ**: Khách hàng có thể tạo yêu cầu với:
  - Tiêu đề (bắt buộc)
  - Mô tả chi tiết (bắt buộc, tối thiểu 10 ký tự)
  - Danh mục (tùy chọn): Sản phẩm, Đơn hàng, Thanh toán, Vận chuyển, Tài khoản, Khác
  - Độ ưu tiên (tùy chọn): Thấp, Trung bình, Cao, Khẩn cấp (mặc định: Trung bình)

- **Xem danh sách yêu cầu**: 
  - Hiển thị toàn bộ yêu cầu của khách hàng
  - Sắp xếp theo ngày tạo (mới nhất trước)
  - Hiển thị trạng thái, độ ưu tiên, danh mục

- **Xem chi tiết yêu cầu**:
  - Xem nội dung yêu cầu đầy đủ
  - Xem tất cả phản hồi từ admin và khách hàng
  - Thêm phản hồi vào yêu cầu
  - Đóng yêu cầu

### 2. **Cho Quản trị viên**
- **Quản lý tất cả yêu cầu**:
  - Xem danh sách tất cả yêu cầu hỗ trợ
  - Bộ lọc theo:
    - Trạng thái (Mở, Đang xử lý, Đã giải quyết, Đã đóng)
    - Độ ưu tiên (Thấp, Trung bình, Cao, Khẩn cấp)
    - Tìm kiếm theo tiêu đề, mô tả, email khách hàng

- **Phản hồi yêu cầu**:
  - Thêm phản hồi từ admin vào bất kỳ yêu cầu nào

- **Cập nhật trạng thái**:
  - Thay đổi trạng thái: Mở → Đang xử lý → Đã giải quyết → Đã đóng

- **Cập nhật độ ưu tiên**:
  - Điều chỉnh độ ưu tiên dựa trên tình huống

- **Xóa yêu cầu**:
  - Xóa các yêu cầu không cần thiết

## Cấu trúc Database

### Bảng `support_tickets`
```
- id (Primary Key)
- user_id (Foreign Key → users.id)
- subject (string) - Tiêu đề yêu cầu
- description (longText) - Mô tả chi tiết
- status (enum: open, in_progress, resolved, closed) - Trạng thái
- priority (enum: low, medium, high, urgent) - Độ ưu tiên
- category (string, nullable) - Danh mục
- created_at - Ngày tạo
- updated_at - Ngày cập nhật
```

### Bảng `support_responses`
```
- id (Primary Key)
- support_ticket_id (Foreign Key → support_tickets.id)
- user_id (Foreign Key → users.id)
- response_text (longText) - Nội dung phản hồi
- is_admin_response (boolean) - Đánh dấu nếu là phản hồi từ admin
- created_at - Ngày tạo
- updated_at - Ngày cập nhật
```

## Các Routes

### Cho Khách hàng (Bảo vệ bằng auth)
- `GET /support` - Danh sách yêu cầu của khách hàng
- `GET /support/create` - Form tạo yêu cầu mới
- `POST /support` - Lưu yêu cầu mới
- `GET /support/{ticket}` - Xem chi tiết yêu cầu
- `POST /support/{ticket}/response` - Thêm phản hồi
- `POST /support/{ticket}/close` - Đóng yêu cầu

### Cho Quản trị viên (Bảo vệ bằng auth + is_admin)
- `GET /admin/support` - Danh sách tất cả yêu cầu
- `GET /admin/support/{ticket}` - Xem chi tiết yêu cầu
- `POST /admin/support/{ticket}/status` - Cập nhật trạng thái
- `POST /admin/support/{ticket}/priority` - Cập nhật độ ưu tiên
- `DELETE /admin/support/{ticket}` - Xóa yêu cầu

## Các Model

### SupportTicket
```php
- relationships:
  - user() - belongsTo User
  - responses() - hasMany SupportResponse
```

### SupportResponse
```php
- relationships:
  - supportTicket() - belongsTo SupportTicket
  - user() - belongsTo User
```

## Files Được Tạo

### Models
- `app/Models/SupportTicket.php`
- `app/Models/SupportResponse.php`

### Controllers
- `app/Http/Controllers/SupportController.php` - Quản lý yêu cầu cho khách hàng
- `app/Http/Controllers/Admin/SupportController.php` - Quản lý yêu cầu cho admin

### Migrations
- `database/migrations/2026_01_28_000001_create_support_tickets_table.php`
- `database/migrations/2026_01_28_000002_create_support_responses_table.php`

### Views - Khách hàng
- `resources/views/user/support/index.blade.php` - Danh sách yêu cầu
- `resources/views/user/support/create.blade.php` - Form tạo yêu cầu
- `resources/views/user/support/show.blade.php` - Chi tiết yêu cầu

### Views - Quản trị viên
- `resources/views/admin/support/index.blade.php` - Danh sách yêu cầu
- `resources/views/admin/support/show.blade.php` - Chi tiết yêu cầu

## Cách sử dụng

### Cho Khách hàng

1. **Tạo yêu cầu mới**:
   - Truy cập `/support/create`
   - Điền tiêu đề, mô tả, chọn danh mục và độ ưu tiên
   - Nhấn "Gửi yêu cầu"

2. **Xem danh sách yêu cầu**:
   - Truy cập `/support`
   - Xem tất cả yêu cầu của bạn

3. **Theo dõi yêu cầu**:
   - Nhấp vào một yêu cầu để xem chi tiết
   - Thêm phản hồi để cập nhật tình trạng
   - Xem tất cả phản hồi từ admin

### Cho Quản trị viên

1. **Quản lý yêu cầu**:
   - Truy cập `/admin/support`
   - Sử dụng các bộ lọc để tìm kiếm yêu cầu

2. **Phản hồi yêu cầu**:
   - Nhấp vào yêu cầu để xem chi tiết
   - Nhập phản hồi từ admin
   - Cập nhật trạng thái và độ ưu tiên

3. **Quản lý trạng thái**:
   - Đặt trạng thái từ "Mở" → "Đang xử lý" → "Đã giải quyết" → "Đã đóng"

## Lưu ý bảo mật

- Khách hàng chỉ có thể xem yêu cầu của họ
- Admin có thể xem tất cả yêu cầu
- Chỉ admin mới có thể cập nhật trạng thái và độ ưu tiên
- Khi khách hàng phản hồi, yêu cầu sẽ chuyển từ "Mở" sang "Đang xử lý"

## Tương lai có thể mở rộng

- Thêm tệp đính kèm cho yêu cầu
- Tự động gửi email thông báo khi có phản hồi mới
- Đánh giá chất lượng hỗ trợ sau khi giải quyết
- Báo cáo thống kê về thời gian giải quyết
- Cấu hình mẫu phản hồi nhanh
