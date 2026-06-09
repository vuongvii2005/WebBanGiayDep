@extends('layouts.user')

@section('title', 'Chính Sách Vận Chuyển - Stylish')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h1 class="mb-4">📦 Chính Sách Vận Chuyển</h1>
                    
                    <div class="accordion" id="shippingAccordion">
                        <!-- 1. Phạm vi vận chuyển -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#shipping1">
                                    1. Phạm Vi Vận Chuyển
                                </button>
                            </h2>
                            <div id="shipping1" class="accordion-collapse collapse show" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Chúng tôi hỗ trợ vận chuyển đến <strong>toàn bộ tỉnh/thành phố</strong> trên cả nước:</p>
                                    <ul>
                                        <li>✅ Nội thành (Hà Nội, TP.HCM, Đà Nẵng...)</li>
                                        <li>✅ Các tỉnh thành lân cận (Hải Phòng, Cần Thơ...)</li>
                                        <li>✅ Các tỉnh miền núi (Lào Cai, Điện Biên...)</li>
                                        <li>✅ Các huyện đảo (Phú Quốc, Cô Tô...)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Thời gian giao hàng -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping2">
                                    2. Thời Gian Giao Hàng
                                </button>
                            </h2>
                            <div id="shipping2" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Loại</th>
                                                <th>Phạm vi</th>
                                                <th>Thời gian</th>
                                                <th>Phí</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><strong>Giao nhanh</strong></td>
                                                <td>Nội thành</td>
                                                <td>1-2 ngày</td>
                                                <td>30,000 VND</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Giao tiêu chuẩn</strong></td>
                                                <td>Toàn quốc</td>
                                                <td>3-5 ngày</td>
                                                <td>50,000 VND</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Giao vùng xa</strong></td>
                                                <td>Miền núi, đảo</td>
                                                <td>7-10 ngày</td>
                                                <td>100,000 VND</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Miễn phí vận chuyển -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping3">
                                    3. Miễn Phí Vận Chuyển
                                </button>
                            </h2>
                            <div id="shipping3" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Miễn phí vận chuyển toàn quốc khi:</p>
                                    <ul>
                                        <li>💝 Đơn hàng ≥ 2.000.000 VND</li>
                                        <li>🎁 Khách hàng VIP (tích lũy đơn hàng ≥ 10.000.000 VND)</li>
                                        <li>🎉 Các dịp khuyến mãi đặc biệt (công bố trên website)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 4. Theo dõi đơn hàng -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping4">
                                    4. Theo Dõi Đơn Hàng
                                </button>
                            </h2>
                            <div id="shipping4" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <p>Bạn có thể theo dõi đơn hàng qua:</p>
                                    <ul>
                                        <li>📧 Email xác nhận với mã vận đơn</li>
                                        <li>📱 App hoặc website (vào mục "Đơn hàng của tôi")</li>
                                        <li>🔗 Website nhà vận chuyển (GHN, Viettel Post, J&T...)</li>
                                        <li>📞 Liên hệ hotline hỗ trợ 24/7</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Ghi chú về giao hàng -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#shipping5">
                                    5. Ghi Chú Quan Trọng
                                </button>
                            </h2>
                            <div id="shipping5" class="accordion-collapse collapse" data-bs-parent="#shippingAccordion">
                                <div class="accordion-body">
                                    <ul>
                                        <li>⚠️ Thời gian giao hàng được tính từ lúc đơn hàng được lấy từ kho</li>
                                        <li>⚠️ Không giao vào Chủ nhật và ngày lễ (sẽ được xử lý vào ngày làm việc tiếp theo)</li>
                                        <li>⚠️ Khách hàng cần có mặt tại địa chỉ nhận hàng trong khung giờ dự kiến</li>
                                        <li>⚠️ Giày được đóng gói cẩn thận tránh hư hỏng trong quá trình vận chuyển</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4">
                        <strong>❓ Liên hệ hỗ trợ:</strong> Nếu bạn có thắc mắc gì về vận chuyển, vui lòng liên hệ qua <a href="/support">Mục hỗ trợ</a> hoặc gọi hotline 1800-6789.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
