@extends('layouts.user')

@section('title', 'Chính Sách Bảo Mật Dữ Liệu - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">🔐 Chính Sách Bảo Mật Dữ Liệu</h1>
                    
                    <div class="accordion" id="privacyAccordion">
                        <!-- 1. Thu thập thông tin -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#privacy1">
                                    1. Thông Tin Chúng Tôi Thu Thập
                                </button>
                            </h2>
                            <div id="privacy1" class="accordion-collapse collapse show" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p><strong>Chúng tôi có thể thu thập các thông tin sau:</strong></p>
                                    <ul>
                                        <li>📝 <strong>Thông tin cá nhân:</strong> Tên, email, số điện thoại, địa chỉ</li>
                                        <li>💳 <strong>Thông tin thanh toán:</strong> Tài khoản ngân hàng, thẻ tín dụng (được mã hóa)</li>
                                        <li>🛍️ <strong>Thông tin mua sắm:</strong> Danh sách sản phẩm, giỏ hàng, đơn hàng</li>
                                        <li>📱 <strong>Thông tin kỹ thuật:</strong> IP address, trình duyệt, thiết bị, cookie</li>
                                        <li>💬 <strong>Thông tin tương tác:</strong> Tin nhắn, bình luận, review sản phẩm</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Sử dụng thông tin -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy2">
                                    2. Cách Chúng Tôi Sử Dụng Thông Tin
                                </button>
                            </h2>
                            <div id="privacy2" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>✅ Xử lý đơn hàng và giao hàng</li>
                                        <li>✅ Gửi hóa đơn, xác nhận đơn, cập nhật trạng thái</li>
                                        <li>✅ Cải thiện dịch vụ và trải nghiệm người dùng</li>
                                        <li>✅ Gửi email marketing (có thể hủy bất cứ lúc nào)</li>
                                        <li>✅ Phân tích hành vi người dùng để tối ưu hóa website</li>
                                        <li>✅ Cung cấp hỗ trợ khách hàng và xử lý khiếu nại</li>
                                        <li>✅ Tuân thủ các quy định pháp luật</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Bảo vệ thông tin -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy3">
                                    3. Cách Chúng Tôi Bảo Vệ Thông Tin
                                </button>
                            </h2>
                            <div id="privacy3" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>🔒 <strong>Mã hóa SSL/TLS</strong> - Tất cả dữ liệu được mã hóa khi truyền tải</li>
                                        <li>🔐 <strong>Tường lửa (Firewall)</strong> - Bảo vệ hệ thống khỏi tấn công</li>
                                        <li>🛡️ <strong>Xác thực hai lớp (2FA)</strong> - Bảo vệ tài khoản với mã OTP</li>
                                        <li>📊 <strong>Sao lưu dữ liệu</strong> - Sao lưu định kỳ để tránh mất dữ liệu</li>
                                        <li>👥 <strong>Hạn chế truy cập</strong> - Chỉ nhân viên được phép mới truy cập thông tin</li>
                                        <li>🕐 <strong>Giám sát 24/7</strong> - Theo dõi hoạt động bất thường</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Chia sẻ thông tin -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy4">
                                    4. Chia Sẻ Thông Tin
                                </button>
                            </h2>
                            <div id="privacy4" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <p><strong>Chúng tôi CHỈ chia sẻ thông tin với:</strong></p>
                                    <ul>
                                        <li>✅ <strong>Đối tác thanh toán</strong> - Để xử lý giao dịch</li>
                                        <li>✅ <strong>Đơn vị vận chuyển</strong> - Thông tin cần thiết để giao hàng (địa chỉ, số điện thoại)</li>
                                        <li>✅ <strong>Cơ quan thuế</strong> - Thực hiện quy định pháp luật</li>
                                        <li>✅ <strong>Các nhà cung cấp dịch vụ</strong> - Email marketing, phân tích dữ liệu</li>
                                    </ul>
                                    <p class="mt-3"><strong class="text-danger">❌ KHÔNG bao giờ chia sẻ thông tin cho bên thứ ba vì mục đích quảng cáo</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Quyền của bạn -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy5">
                                    5. Quyền Của Bạn
                                </button>
                            </h2>
                            <div id="privacy5" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>📄 <strong>Quyền truy cập</strong> - Yêu cầu xem dữ liệu của bạn</li>
                                        <li>✏️ <strong>Quyền sửa</strong> - Cập nhật thông tin cá nhân của bạn</li>
                                        <li>🗑️ <strong>Quyền xóa</strong> - Yêu cầu xóa dữ liệu của bạn (với các ngoại lệ pháp lý)</li>
                                        <li>🚫 <strong>Quyền từ chối</strong> - Từ chối email marketing bất cứ lúc nào</li>
                                        <li>📤 <strong>Quyền di động hóa</strong> - Nhận dữ liệu của bạn ở định dạng máy đọc</li>
                                        <li>💬 <strong>Quyền phản đối</strong> - Phản đối xử lý dữ liệu nếu cần</li>
                                    </ul>
                                    <p class="mt-3">Để thực hiện các quyền trên, <a href="/support">liên hệ hỗ trợ</a> với chứng minh thân phận.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Cookie và theo dõi -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#privacy6">
                                    6. Cookie Và Theo Dõi
                                </button>
                            </h2>
                            <div id="privacy6" class="accordion-collapse collapse" data-bs-parent="#privacyAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>🍪 <strong>Cookie</strong> - Được sử dụng để lưu trữ sở thích người dùng</li>
                                        <li>📊 <strong>Google Analytics</strong> - Để phân tích hành vi người dùng</li>
                                        <li>📱 <strong>Pixel Tracking</strong> - Để đo hiệu quả quảng cáo</li>
                                        <li>🔗 <strong>URL Tracking</strong> - Để theo dõi nguồn truy cập</li>
                                    </ul>
                                    <p class="mt-3">Bạn có thể tắt cookie trong cài đặt trình duyệt của mình bất cứ lúc nào.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>❓ Liên hệ:</strong> Có thắc mắc về bảo mật dữ liệu? Email privacy@stylish.vn hoặc liên hệ <a href="/support">mục hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
