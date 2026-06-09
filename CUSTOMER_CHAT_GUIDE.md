# Hướng dẫn Chức năng Chat Hỗ trợ Khách hàng

## 📱 Giao diện Chat Thực tế

Chức năng chat hỗ trợ khách hàng đã được thiết kế theo phong cách ứng dụng nhắn tin modern:

### ✨ Tính Năng Giao Diện:

1. **Layout Chat Hiện Đại**
   - Sidebar hiển thị thông tin chi tiết yêu cầu
   - Khu vực chat chính giữa màn hình (responsive)
   - Input area cho phản hồi
   - Cuộn tự động đến tin nhắn mới nhất

2. **Phân Biệt Người Gửi**
   - Phản hồi từ khách hàng (bên trái, nền trắng)
   - Phản hồi từ Admin (bên phải, nền xanh nhạt)
   - Avatar với chữ cái đầu tiên của tên
   - Badge "Admin" trên phản hồi từ quản trị viên

3. **Auto-Refresh Tin Nhắn**
   - Tự động kiểm tra tin nhắn mới mỗi 5 giây
   - Không cần refresh trang thủ công
   - Cuộn tự động đến phản hồi mới nhất

## 🎯 Quy Trình Sử Dụng

### Cho Khách Hàng:

#### 1. Tạo Yêu Cầu Hỗ Trợ
```
Nhấp vào icon hỗ trợ (biểu tượng tai nghe) ở thanh công cụ
→ Chọn "Tạo yêu cầu mới"
→ Điền thông tin:
   - Danh mục: Sản phẩm, Đơn hàng, Thanh toán, v.v.
   - Tiêu đề: Mô tả ngắn gọn vấn đề
   - Mô tả: Chi tiết vấn đề (tối thiểu 10 ký tự)
   - Độ ưu tiên: Chọn mức độ khẩn cấp
→ Nhấp "Gửi yêu cầu"
```

#### 2. Xem Danh Sách Yêu Cầu
```
Nhấp icon hỗ trợ → "Xem danh sách"
Hoặc truy cập: /support

Hiển thị tất cả yêu cầu của bạn dưới dạng card:
- Thông tin tiêu đề, mô tả tóm tắt
- Trạng thái, độ ưu tiên, danh mục
- Số phản hồi đã nhận
- Ngày tạo
```

#### 3. Chat Với Admin
```
Nhấp vào yêu cầu → Vào giao diện chat
- Xem yêu cầu ban đầu của bạn
- Xem toàn bộ cuộc trò chuyện
- Nhập phản hồi ở phần input dưới
- Nhấp nút gửi (paper-plane icon)

Giao diện sẽ:
- Tự động cuộn đến tin nhắn mới
- Làm mới mỗi 5 giây để lấy phản hồi mới từ admin
```

#### 4. Đóng Yêu Cầu
```
Khi vấn đề đã giải quyết:
- Nhấp "Đóng yêu cầu" ở góc dưới trái
- Yêu cầu sẽ chuyển thành trạng thái "Đã đóng"
- Không thể thêm phản hồi nữa
```

### Cho Admin:

#### 1. Xem Tất Cả Yêu Cầu
```
Đăng nhập Admin → /admin/support

Hiển thị bảng danh sách tất cả yêu cầu với:
- Mã yêu cầu
- Tên, email khách hàng
- Tiêu đề
- Danh mục
- Độ ưu tiên
- Trạng thái
- Ngày tạo
```

#### 2. Bộ Lọc & Tìm Kiếm
```
Tìm kiếm:
- Theo tiêu đề yêu cầu
- Theo nội dung mô tả
- Theo email/tên khách hàng

Lọc:
- Theo trạng thái: Mở, Đang xử lý, Đã giải quyết, Đã đóng
- Theo độ ưu tiên: Thấp, Trung bình, Cao, Khẩn cấp
```

#### 3. Xem & Phản Hồi Yêu Cầu
```
Nhấp "Xem chi tiết" → Vào giao diện quản lý
- Xem đầy đủ thông tin khách hàng
- Xem toàn bộ cuộc trò chuyện
- Nhập phản hồi Admin
- Phản hồi sẽ hiển thị với nền xanh và badge "Admin"
```

#### 4. Cập Nhật Trạng Thái & Độ Ưu Tiên
```
Ở sidebar bên phải:

Cập nhật trạng thái:
- Mở (tạo mới)
- Đang xử lý (đã tiếp nhận)
- Đã giải quyết (vấn đề xong)
- Đã đóng (hoàn thành)

Cập nhật độ ưu tiên:
- Thấp → Trung bình → Cao → Khẩn cấp
- Dựa trên tình huống thực tế
```

#### 5. Xóa Yêu Cầu
```
Nhấp "Xóa yêu cầu" ở phần "Hành động khác"
- Xóa yêu cầu và toàn bộ phản hồi
- Không thể khôi phục
```

## 📊 Trạng Thái Yêu Cầu

| Trạng Thái | Mô Tả | Màu |
|-----------|-------|-----|
| Mở | Yêu cầu vừa được tạo, chờ admin xử lý | 🔵 Xanh |
| Đang xử lý | Admin đã tiếp nhận và đang giải quyết | 🟡 Vàng |
| Đã giải quyết | Vấn đề đã được xử lý xong | 🟢 Xanh lá |
| Đã đóng | Yêu cầu đã hoàn thành hoặc bị hủy | ⚫ Xám |

## ⚡ Độ Ưu Tiên

| Mức | Mô Tả | Thời Gian Hỗ Trợ |
|-----|-------|-----------------|
| Thấp | Vấn đề không gấp gáp | 48-72 giờ |
| Trung bình | Vấn đề bình thường | 24-48 giờ |
| Cao | Vấn đề cần giải quyết sớm | 12-24 giờ |
| Khẩn cấp | Vấn đề rất cấp bách | < 12 giờ |

## 🔄 Auto-Refresh Mechanism

Chức năng chat tích hợp:
```javascript
// Kiểm tra tin nhắn mới mỗi 5 giây (5000ms)
setInterval(function() {
    // Fetch trang hiện tại
    // So sánh nội dung tin nhắn
    // Cập nhật giao diện nếu có tin mới
    // Cuộn xuống tin nhắn mới nhất
}, 5000);
```

## 💡 Mẹo & Thủ Thuật

### Cho Khách Hàng:
1. **Cung cấp thông tin chi tiết** - Giúp admin hiểu nhanh hơn
2. **Ghi mã đơn hàng** - Nếu liên quan đến đơn hàng
3. **Chọn đúng danh mục** - Xác định loại vấn đề
4. **Chọn độ ưu tiên hợp lý** - Không lạm dụng "Khẩn cấp"
5. **Kiên nhẫn chờ đợi** - Admin sẽ trả lời trong thời gian quy định

### Cho Admin:
1. **Trả lời nhanh** - Tăng sự hài lòng khách hàng
2. **Phản hồi chuyên nghiệp** - Giữ hình ảnh công ty
3. **Cập nhật trạng thái** - Cho khách hàng biết tiến trình
4. **Ghi chú rõ ràng** - Để đồng nghiệp hiểu được
5. **Đóng yêu cầu** - Khi vấn đề hoàn toàn giải quyết

## 📱 Responsive Design

### Desktop:
- Sidebar chi tiết bên trái (20%)
- Khu vực chat chính (80%)
- Hiển thị đầy đủ thông tin

### Tablet & Mobile:
- Sidebar ẩn, có nút "Mở thông tin"
- Khu vực chat chiếm toàn bộ chiều rộng
- Input area dạng textarea đầy đủ
- Tối ưu hóa touch interaction

## 🔐 Bảo Mật

- Khách hàng chỉ xem được yêu cầu của chính họ
- Admin xem được tất cả yêu cầu
- Không thể sửa phản hồi sau khi gửi (ghi chép)
- Xóa yêu cầu không khôi phục được

## 🚀 Tương Lai Có Thể Mở Rộng

- [ ] Tệp đính kèm (upload hình ảnh)
- [ ] Email thông báo khi có phản hồi mới
- [ ] Đánh giá hỗ trợ sau khi giải quyết
- [ ] Báo cáo thống kê
- [ ] Live chat real-time (WebSocket)
- [ ] Mẫu phản hồi nhanh
- [ ] Tích hợp Telegram/Zalo thông báo

---

**Phiên bản:** 1.0  
**Cập nhật lần cuối:** 28/01/2026
