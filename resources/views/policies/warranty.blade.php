@extends('layouts.user')

@section('title', 'Chính Sách Bảo Hành - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">✅ Chính Sách Bảo Hành</h1>
                    
                    <div class="accordion" id="warrantyAccordion">
                        <!-- 1. Thời gian bảo hành -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#warranty1">
                                    1. Thời Gian Bảo Hành
                                </button>
                            </h2>
                            <div id="warranty1" class="accordion-collapse collapse show" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>⏱️ <strong>12 tháng</strong> - Bảo hành lỗi kỹ thuật (từ ngày mua)</li>
                                        <li>⏱️ <strong>6 tháng</strong> - Bảo hành cho phụ kiện (dây giày, đế...)</li>
                                        <li>⏱️ <strong>30 ngày</strong> - Bảo hành thay size/màu miễn phí</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-danger">Ngoài thời hạn sẽ tính phí sửa chữa theo giá bảo dưỡng</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Phạm vi bảo hành -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty2">
                                    2. Phạm Vi Bảo Hành
                                </button>
                            </h2>
                            <div id="warranty2" class="accordion-collapse collapse" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <p><strong>Chúng tôi bảo hành các lỗi sau:</strong></p>
                                    <ul>
                                        <li>✅ Đế bị tróc, sập hoặc nứt do lỗi sản xuất</li>
                                        <li>✅ Dây giày bị vỡ, tuột do chất lượng kém</li>
                                        <li>✅ Đệm giày bị móp, nén lún</li>
                                        <li>✅ Chỗ may bị tách rã, khâu hỏng</li>
                                        <li>✅ Màu bị ra, xanh đốm khi chưa sử dụng</li>
                                        <li>✅ Khóa, móc bị sứt mẻ, lơi lỏng</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Trường hợp không bảo hành -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty3">
                                    3. Trường Hợp Không Bảo Hành
                                </button>
                            </h2>
                            <div id="warranty3" class="accordion-collapse collapse" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <p><strong>Các trường hợp sau sẽ không được bảo hành:</strong></p>
                                    <ul>
                                        <li>❌ Hư hỏng do sử dụng sai cách (dùng quá tải, sử dụng trong môi trường không phù hợp...)</li>
                                        <li>❌ Bị rách, xước, bẩn do va chạm hoặc mài mòn bình thường</li>
                                        <li>❌ Bị ướt, biến dạng hoặc hư hỏng do yếu tố ngoại cảnh</li>
                                        <li>❌ Quá thời hạn bảo hành (xem hóa đơn mua hàng)</li>
                                        <li>❌ Không có hóa đơn, tag mác hoặc chứng minh mua hàng</li>
                                        <li>❌ Đã sửa chữa ở nơi khác trước đó</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Quy trình bảo hành -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty4">
                                    4. Quy Trình Bảo Hành
                                </button>
                            </h2>
                            <div id="warranty4" class="accordion-collapse collapse" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <ol>
                                        <li><strong>Liên hệ</strong> - <a href="/support">Tạo yêu cầu hỗ trợ</a> hoặc gọi hotline</li>
                                        <li><strong>Cung cấp thông tin</strong> - Mô tả lỗi, cung cấp hóa đơn, ảnh</li>
                                        <li><strong>Gửi giày</strong> - Gửi đến địa chỉ bảo hành (chi phí vận chuyển miễn phí)</li>
                                        <li><strong>Kiểm tra</strong> - Chúng tôi kiểm tra trong 2-3 ngày</li>
                                        <li><strong>Sửa chữa</strong> - Sửa trong 3-7 ngày (tùy mức độ hư hỏng)</li>
                                        <li><strong>Nhận lại</strong> - Gửi trở lại cho bạn (chi phí vận chuyển miễn phí)</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Chi phí bảo hành -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty5">
                                    5. Chi Phí Bảo Hành
                                </button>
                            </h2>
                            <div id="warranty5" class="accordion-collapse collapse" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>🆓 <strong>Miễn phí</strong> - Trong thời gian bảo hành</li>
                                        <li>💸 <strong>Tính phí</strong> - Ngoài thời gian bảo hành (25,000-100,000 VND/lần sửa)</li>
                                        <li>🆓 <strong>Miễn phí vận chuyển</strong> - Cả đi lẫn về trong bảo hành</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Bảo dưỡng tại nhà -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#warranty6">
                                    6. Hướng Dẫn Bảo Dưỡng Tại Nhà
                                </button>
                            </h2>
                            <div id="warranty6" class="accordion-collapse collapse" data-bs-parent="#warrantyAccordion">
                                <div class="accordion-body">
                                    <p><strong>Để giày bền lâu hơn, hãy:</strong></p>
                                    <ul>
                                        <li>🧹 Lau sạch bằng khăn ẩm mỗi tuần</li>
                                        <li>💨 Phơi giày ở nơi thoáng mát, tránh nắng trực tiếp</li>
                                        <li>🧴 Sử dụng chất tẩy rửa chuyên dụng cho giày</li>
                                        <li>📦 Bảo quản giày trong hộp kín, không ứ ẩm</li>
                                        <li>⚠️ Tránh sử dụng trong thời tiết xấu (mưa lớn, ngập nước...)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>❓ Liên hệ hỗ trợ:</strong> Vui lòng liên hệ qua <a href="/support">Mục hỗ trợ</a> hoặc hotline 1800-6789 để biết thêm chi tiết.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
