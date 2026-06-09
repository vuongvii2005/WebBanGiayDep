@extends('layouts.user')

@section('title', 'Điều Khoản & Điều Kiện - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">📋 Điều Khoản & Điều Kiện</h1>
                    
                    <div class="accordion" id="termsAccordion">
                        <!-- 1. Giới thiệu -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#terms1">
                                    1. Giới Thiệu
                                </button>
                            </h2>
                            <div id="terms1" class="accordion-collapse collapse show" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <p>Chào mừng đến với <strong>Stylish</strong>. Chúng tôi là cửa hàng giày thể thao trực tuyến chuyên cung cấp các sản phẩm chất lượng cao từ các thương hiệu hàng đầu thế giới.</p>
                                    <p>Khi sử dụng website và dịch vụ của chúng tôi, bạn đồng ý tuân thủ các điều khoản và điều kiện này. Nếu bạn không đồng ý, vui lòng không sử dụng dịch vụ.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Quyền lợi người dùng -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms2">
                                    2. Quyền Lợi Của Người Dùng
                                </button>
                            </h2>
                            <div id="terms2" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <p><strong>Bạn có quyền:</strong></p>
                                    <ul>
                                        <li>✅ Tạo tài khoản và sử dụng dịch vụ</li>
                                        <li>✅ Mua sắm sản phẩm với giá được công bố</li>
                                        <li>✅ Yêu cầu trả lại sản phẩm trong 30 ngày</li>
                                        <li>✅ Nhận bảo hành sản phẩm theo quy định</li>
                                        <li>✅ Truy cập lịch sử đơn hàng, hóa đơn</li>
                                        <li>✅ Liên hệ hỗ trợ với mọi câu hỏi/khiếu nại</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Trách nhiệm người dùng -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms3">
                                    3. Trách Nhiệm Của Người Dùng
                                </button>
                            </h2>
                            <div id="terms3" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <p><strong>Bạn đồng ý:</strong></p>
                                    <ul>
                                        <li>📌 Cung cấp thông tin chính xác, đầy đủ</li>
                                        <li>📌 Bảo mật mật khẩu tài khoản của mình</li>
                                        <li>📌 Không sử dụng website cho các hoạt động bất hợp pháp</li>
                                        <li>📌 Không phát tán phần mềm độc hại/virus</li>
                                        <li>📌 Không sao chép nội dung website không có phép</li>
                                        <li>📌 Tuân thủ tất cả pháp luật hiện hành</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Giá cả & thanh toán -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms4">
                                    4. Giá Cả & Thanh Toán
                                </button>
                            </h2>
                            <div id="terms4" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>💰 Giá sản phẩm được công bố rõ ràng trên website</li>
                                        <li>💰 Giá có thể thay đổi bất cứ lúc nào mà không cần thông báo</li>
                                        <li>💰 Thanh toán chỉ có hiệu lực khi bạn nhấp nút "Xác nhận thanh toán"</li>
                                        <li>💰 Chúng tôi có quyền từ chối đơn hàng nếu có dấu hiệu gian lận</li>
                                        <li>💰 VAT và các loại thuế khác sẽ được tính thêm nếu có</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Trách nhiệm hạn chế -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms5">
                                    5. Trách Nhiệm Hạn Chế
                                </button>
                            </h2>
                            <div id="terms5" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <p><strong>Chúng tôi KHÔNG chịu trách nhiệm:</strong></p>
                                    <ul>
                                        <li>❌ Mất dữ liệu do sự cố kỹ thuật không lường trước</li>
                                        <li>❌ Gây hại bởi virus hoặc phần mềm độc hại từ bên ngoài</li>
                                        <li>❌ Mất doanh thu, lợi nhuận do không sử dụng dịch vụ</li>
                                        <li>❌ Bất kỳ thiệt hại gián tiếp hoặc các hệ quả</li>
                                        <li>❌ Sử dụng website sai cách của người dùng</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Quyền sở hữu trí tuệ -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms6">
                                    6. Quyền Sở Hữu Trí Tuệ
                                </button>
                            </h2>
                            <div id="terms6" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>📝 Tất cả nội dung trên website (hình ảnh, văn bản, logo) thuộc quyền sở hữu của Stylish</li>
                                        <li>📝 Bạn được phép sử dụng cho mục đích cá nhân, không bán lại</li>
                                        <li>📝 Sao chép nội dung mà không có phép là vi phạm bản quyền</li>
                                        <li>📝 Các thương hiệu sản phẩm thuộc về chủ sở hữu ban đầu</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Thay đổi điều khoản -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#terms7">
                                    7. Thay Đổi Điều Khoản
                                </button>
                            </h2>
                            <div id="terms7" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>⚙️ Chúng tôi có quyền thay đổi điều khoản bất cứ lúc nào</li>
                                        <li>⚙️ Thay đổi sẽ được công bố trên website trong 7 ngày</li>
                                        <li>⚙️ Tiếp tục sử dụng website đồng ý với các thay đổi</li>
                                        <li>⚙️ Nếu không đồng ý, bạn có quyền ngừng sử dụng</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning mt-4">
                        <strong>⚠️ Lưu ý:</strong> Nếu bạn vi phạm bất kỳ điều khoản nào, chúng tôi có quyền khóa tài khoản, hủy đơn hàng mà không hoàn tiền.
                    </div>

                    <div class="alert alert-info">
                        <strong>📧 Liên hệ:</strong> Có câu hỏi về điều khoản? Email terms@stylish.vn hoặc <a href="/support">liên hệ hỗ trợ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
