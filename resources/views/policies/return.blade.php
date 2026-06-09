@extends('layouts.user')

@section('title', 'Chính Sách Trả Lại & Hoàn Tiền - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">🔄 Chính Sách Trả Lại & Hoàn Tiền</h1>
                    
                    <div class="accordion" id="returnAccordion">
                        <!-- 1. Điều kiện trả lại -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#return1">
                                    1. Điều Kiện Trả Lại
                                </button>
                            </h2>
                            <div id="return1" class="accordion-collapse collapse show" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <p><strong>Bạn có quyền trả lại sản phẩm nếu:</strong></p>
                                    <ul>
                                        <li>✅ Sản phẩm bị lỗi/hoạt động không bình thường</li>
                                        <li>✅ Sản phẩm không giống hình ảnh, mô tả</li>
                                        <li>✅ Nhận được hàng sai loại, sai size, sai màu</li>
                                        <li>✅ Hàng bị hư hỏng, dập nát do đơn vị vận chuyển</li>
                                        <li>✅ Thiếu sản phẩm hoặc thiếu phụ kiện</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Thời hạn trả lại -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return2">
                                    2. Thời Hạn Trả Lại
                                </button>
                            </h2>
                            <div id="return2" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <p><strong>Thời gian trả lại được tính từ ngày nhận hàng:</strong></p>
                                    <ul>
                                        <li>⏰ <strong>30 ngày</strong> - Để yêu cầu trả lại/hoàn tiền</li>
                                        <li>⏰ <strong>7 ngày</strong> - Để trả lại nếu chưa sử dụng</li>
                                        <li>⏰ <strong>14 ngày</strong> - Để trả lại nếu có lỗi sản phẩm</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-danger">Ngoài thời hạn này sẽ không xử lý trả lại/hoàn tiền</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Quy trình trả lại -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return3">
                                    3. Quy Trình Trả Lại
                                </button>
                            </h2>
                            <div id="return3" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <ol>
                                        <li><strong>Tạo yêu cầu</strong> - Vào <a href="/account/orders">Đơn hàng của tôi</a> → Chọn "Yêu cầu trả lại"</li>
                                        <li><strong>Chọn lý do</strong> - Lý do trả lại rõ ràng (sai size, lỗi sản phẩm...)</li>
                                        <li><strong>Upload hình ảnh</strong> - Cung cấp ảnh sản phẩm, bao bì, hóa đơn</li>
                                        <li><strong>Chờ xác nhận</strong> - Chúng tôi xem xét trong 24-48 giờ</li>
                                        <li><strong>Trả hàng</strong> - Gửi hàng về theo hướng dẫn (miễn phí vận chuyển)</li>
                                        <li><strong>Hoàn tiền</strong> - Xử lý hoàn tiền sau khi nhận và kiểm tra hàng</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Điều kiện hoàn tiền -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return4">
                                    4. Điều Kiện Hoàn Tiền
                                </button>
                            </h2>
                            <div id="return4" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <p><strong>Hàng phải đáp ứng:</strong></p>
                                    <ul>
                                        <li>✅ Còn nguyên vẹn, chưa qua sử dụng nhiều</li>
                                        <li>✅ Còn tag/nhãn mác gốc</li>
                                        <li>✅ Không bẩn, xước, rách do sử dụng sai cách</li>
                                        <li>✅ Không có mùi lạ hoặc vết bẩn khó làm sạch</li>
                                        <li>✅ Đầy đủ bao bì, phụ kiện gốc</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-danger">Sản phẩm không đạt tiêu chuẩn sẽ từ chối hoàn tiền</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Phí trả lại -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return5">
                                    5. Chi Phí Trả Lại
                                </button>
                            </h2>
                            <div id="return5" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>🆓 <strong>Miễn phí vận chuyển trả</strong> nếu lỗi do shop hoặc vệ sinh giao vận</li>
                                        <li>💸 <strong>Khách hàng trả</strong> nếu là lý do cá nhân (thay đổi ý định, size không vừa...)</li>
                                        <li>💳 <strong>Phí hoàn tiền</strong> - 0% (hoàn 100% giá trị sản phẩm)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Thời gian hoàn tiền -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#return6">
                                    6. Thời Gian Hoàn Tiền
                                </button>
                            </h2>
                            <div id="return6" class="accordion-collapse collapse" data-bs-parent="#returnAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>⏱️ <strong>1-3 ngày</strong> - Chúng tôi xác nhận yêu cầu</li>
                                        <li>⏱️ <strong>3-5 ngày</strong> - Bạn gửi hàng trở lại</li>
                                        <li>⏱️ <strong>1-2 ngày</strong> - Chúng tôi nhận và kiểm tra</li>
                                        <li>⏱️ <strong>1-3 ngày</strong> - Hoàn tiền vào tài khoản</li>
                                    </ul>
                                    <p class="mt-3"><strong>Tổng cộng: 5-15 ngày làm việc</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>❓ Liên hệ hỗ trợ:</strong> Nếu bạn có thắc mắc, vui lòng liên hệ qua <a href="/support">Mục hỗ trợ</a> hoặc email support@stylish.vn
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
