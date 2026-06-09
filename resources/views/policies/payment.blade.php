`@extends('layouts.user')

@section('title', 'Chính Sách Thanh Toán - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">💳 Chính Sách Thanh Toán</h1>
                    
                    <div class="accordion" id="paymentAccordion">
                        <!-- 1. Phương thức thanh toán -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#payment1">
                                    1. Phương Thức Thanh Toán
                                </button>
                            </h2>
                            <div id="payment1" class="accordion-collapse collapse show" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <h6>Chúng tôi hỗ trợ các phương thức thanh toán sau:</h6>
                                    <ul>
                                        <li>💳 <strong>Thẻ tín dụng/ghi nợ</strong> - Visa, Mastercard, JCB</li>
                                        <li>🏦 <strong>Chuyển khoản ngân hàng</strong> - VietinBank, BIDV, Vietcombank, Agribank, MB Bank...</li>
                                        <li>📱 <strong>Ví điện tử</strong> - Momo, ZaloPay, ShopeePay</li>
                                        <li>💰 <strong>COD (Thanh toán khi nhận hàng)</strong> - Tiền mặt hoặc chuyển khoản</li>
                                        <li>🏧 <strong>ATM</strong> - Thanh toán qua cổng ATM online</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Quy trình thanh toán -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment2">
                                    2. Quy Trình Thanh Toán
                                </button>
                            </h2>
                            <div id="payment2" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <ol>
                                        <li><strong>Chọn sản phẩm</strong> - Thêm vào giỏ hàng</li>
                                        <li><strong>Kiểm tra giỏ</strong> - Xem lại số lượng, giá tiền</li>
                                        <li><strong>Điền địa chỉ</strong> - Nhập địa chỉ giao hàng chính xác</li>
                                        <li><strong>Chọn thanh toán</strong> - Chọn phương thức thanh toán phù hợp</li>
                                        <li><strong>Xác nhận đơn</strong> - Kiểm tra tất cả chi tiết trước khi thanh toán</li>
                                        <li><strong>Hoàn tất thanh toán</strong> - Tiến hành thanh toán</li>
                                        <li><strong>Nhận xác nhận</strong> - Kiểm tra email để nhận hóa đơn & mã vận đơn</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <!-- 3. An toàn thanh toán -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment3">
                                    3. An Toàn Thanh Toán
                                </button>
                            </h2>
                            <div id="payment3" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p><strong>Chúng tôi sử dụng các tiêu chuẩn bảo mật cao nhất:</strong></p>
                                    <ul>
                                        <li>🔒 <strong>SSL Encryption</strong> - Mã hóa toàn bộ dữ liệu giao dịch</li>
                                        <li>🔐 <strong>PCI DSS</strong> - Tuân thủ tiêu chuẩn bảo mật thanh toán quốc tế</li>
                                        <li>🛡️ <strong>Fraud Detection</strong> - Hệ thống phát hiện gian lận 24/7</li>
                                        <li>📲 <strong>OTP Verification</strong> - Xác minh mã OTP trên điện thoại của bạn</li>
                                        <li>🏦 <strong>Hợp tác với ngân hàng uy tín</strong> - Kết nối với các ngân hàng hàng đầu</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-success">✅ Thông tin thẻ của bạn sẽ KHÔNG được lưu lại trên hệ thống</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Xử lý thanh toán không thành công -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment4">
                                    4. Thanh Toán Thất Bại
                                </button>
                            </h2>
                            <div id="payment4" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p><strong>Nếu thanh toán không thành công:</strong></p>
                                    <ul>
                                        <li>⚠️ Kiểm tra số dư / hạn mức thẻ</li>
                                        <li>⚠️ Kiểm tra thông tin thẻ (số, tên, ngày hết hạn, CVV)</li>
                                        <li>⚠️ Liên hệ với ngân hàng phát hành thẻ</li>
                                        <li>⚠️ Thử lại sau 1-2 phút</li>
                                        <li>⚠️ Nếu lỗi vẫn tiếp tục, <a href="/support">liên hệ hỗ trợ</a> với mã lỗi</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-danger">Lưu ý: Tiền sẽ tự động hoàn lại trong 1-3 ngày làm việc nếu giao dịch thất bại</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Hoàn lại tiền -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment5">
                                    5. Chính Sách Hoàn Tiền
                                </button>
                            </h2>
                            <div id="payment5" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <p><strong>Tiền sẽ được hoàn lại trong các trường hợp:</strong></p>
                                    <ul>
                                        <li>💰 Hủy đơn hàng trước khi lấy từ kho</li>
                                        <li>💰 Thực hiện trả lại sản phẩm (xem chính sách trả hàng)</li>
                                        <li>💰 Lỗi hệ thống (thanh toán 2 lần sẽ hoàn 1 lần)</li>
                                        <li>💰 Sản phẩm hết hàng (hoàn tiền 100%)</li>
                                    </ul>
                                    <p class="mt-3"><strong>Thời gian hoàn tiền: 1-5 ngày làm việc tùy theo ngân hàng</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Hóa đơn điện tử -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#payment6">
                                    6. Hóa Đơn Điện Tử
                                </button>
                            </h2>
                            <div id="payment6" class="accordion-collapse collapse" data-bs-parent="#paymentAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>📄 Hóa đơn sẽ được gửi qua email sau khi thanh toán thành công</li>
                                        <li>📄 Có thể tải xuống từ mục "Đơn hàng của tôi" → "Tài liệu"</li>
                                        <li>📄 Hóa đơn có giá trị pháp lý và có thể dùng để khấu trừ thuế</li>
                                        <li>📄 Nếu cần bản in, vui lòng <a href="/support">liên hệ hỗ trợ</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>❓ Liên hệ hỗ trợ:</strong> Có thắc mắc về thanh toán? Liên hệ <a href="/support">mục hỗ trợ</a> hoặc email payment@stylish.vn
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
