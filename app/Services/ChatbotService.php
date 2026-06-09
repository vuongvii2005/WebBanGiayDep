<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Order;

class ChatbotService
{
    /**
     * Các chủ đề chatbot có thể hỗ trợ
     */
    private static $supportedTopics = [
        'sản phẩm', 'giá', 'khuyến mãi', 'đơn hàng', 'thanh toán', 
        'vận chuyển', 'tài khoản', 'nike', 'adidas', 'puma', 
        'new balance', 'converse', 'giày', 'size', 'kích cỡ', 'cỡ giày'
    ];

    /**
     * Bảng size giày nam (US, EU, UK, CM)
     */
    private static $menSizeChart = [
        ['us' => '6', 'eu' => '38.5', 'uk' => '5.5', 'cm' => '24'],
        ['us' => '6.5', 'eu' => '39', 'uk' => '6', 'cm' => '24.5'],
        ['us' => '7', 'eu' => '40', 'uk' => '6.5', 'cm' => '25'],
        ['us' => '7.5', 'eu' => '40.5', 'uk' => '7', 'cm' => '25.5'],
        ['us' => '8', 'eu' => '41', 'uk' => '7.5', 'cm' => '26'],
        ['us' => '8.5', 'eu' => '42', 'uk' => '8', 'cm' => '26.5'],
        ['us' => '9', 'eu' => '42.5', 'uk' => '8.5', 'cm' => '27'],
        ['us' => '9.5', 'eu' => '43', 'uk' => '9', 'cm' => '27.5'],
        ['us' => '10', 'eu' => '44', 'uk' => '9.5', 'cm' => '28'],
        ['us' => '10.5', 'eu' => '44.5', 'uk' => '10', 'cm' => '28.5'],
        ['us' => '11', 'eu' => '45', 'uk' => '10.5', 'cm' => '29'],
        ['us' => '12', 'eu' => '46', 'uk' => '11.5', 'cm' => '30'],
    ];

    /**
     * Bảng size giày nữ (US, EU, UK, CM)
     */
    private static $womenSizeChart = [
        ['us' => '5', 'eu' => '35.5', 'uk' => '2.5', 'cm' => '22'],
        ['us' => '5.5', 'eu' => '36', 'uk' => '3', 'cm' => '22.5'],
        ['us' => '6', 'eu' => '36.5', 'uk' => '3.5', 'cm' => '23'],
        ['us' => '6.5', 'eu' => '37.5', 'uk' => '4', 'cm' => '23.5'],
        ['us' => '7', 'eu' => '38', 'uk' => '4.5', 'cm' => '24'],
        ['us' => '7.5', 'eu' => '38.5', 'uk' => '5', 'cm' => '24.5'],
        ['us' => '8', 'eu' => '39', 'uk' => '5.5', 'cm' => '25'],
        ['us' => '8.5', 'eu' => '40', 'uk' => '6', 'cm' => '25.5'],
        ['us' => '9', 'eu' => '40.5', 'uk' => '6.5', 'cm' => '26'],
        ['us' => '9.5', 'eu' => '41', 'uk' => '7', 'cm' => '26.5'],
        ['us' => '10', 'eu' => '42', 'uk' => '7.5', 'cm' => '27'],
    ];

    /**
     * Generate a bot response using database and mock data
     */
    public static function generateResponse($userMessage, $userId = null)
    {
        $messageLower = mb_strtolower($userMessage, 'UTF-8');

        // Kiểm tra hỏi về size giày
        if (self::isSizeQuery($messageLower)) {
            return self::handleSizeQuery($messageLower);
        }

        // Kiểm tra xem tìm kiếm sản phẩm không
        $products = self::searchProducts($messageLower);

        if (!empty($products)) {
            if (count($products) === 1) {
                // Nếu chỉ 1 sản phẩm - hiển thị chi tiết
                return self::formatProductResponse($products[0]);
            } else {
                // Nếu nhiều sản phẩm - hiển thị danh sách
                return self::formatProductsList($products);
            }
        }

        // Kiểm tra tra cứu đơn hàng
        if (self::isOrderQuery($messageLower)) {
            return self::handleOrderQuery($messageLower, $userId);
        }

        // Kiểm tra các câu hỏi thông thường
        $responses = [
            'xin chào' => 'Xin chào! 👋 Tôi là chatbot hỗ trợ khách hàng. Tôi có thể giúp bạn về:\n• Tìm kiếm sản phẩm (Nike, Adidas, Puma...)\n• Tra cứu đơn hàng\n• Hỗ trợ chọn size giày\n• Thông tin thanh toán, vận chuyển\n\nHãy hỏi tôi nhé!',
            'hello' => 'Hello! 👋 Tôi là chatbot hỗ trợ. Bạn cần giúp gì?',
            'hi' => 'Hi! 👋 Tôi có thể giúp gì cho bạn?',
            'sản phẩm' => 'Chúng tôi có ' . Product::count() . ' loại giày thể thao từ các thương hiệu nổi tiếng. Hãy hỏi về Nike, Adidas, Puma, New Balance, hoặc Converse!',
            'giá' => 'Giá sản phẩm của chúng tôi dao động từ 499,000 VND đến 899,000 VND. Hiện tại có sản phẩm đang khuyến mãi!',
            'khuyến mãi' => '🎉 Adidas NMD R1 đang giảm từ 599,000 VND xuống 100,000 VND. Đó là một ưu đãi tuyệt vời! Bạn có quan tâm không?',
            'thanh toán' => '💳 Chúng tôi hỗ trợ:\n• COD (Thanh toán khi nhận hàng)\n• Thẻ tín dụng/ghi nợ\n• Chuyển khoản ngân hàng',
            'vận chuyển' => '🚚 Thông tin vận chuyển:\n• Giao hàng toàn quốc\n• Thời gian: 2-5 ngày làm việc\n• Miễn phí ship đơn từ 500,000 VND',
            'tài khoản' => '👤 Quản lý tài khoản tại cài đặt trong trang cá nhân của bạn.',
            'danh sách sản phẩm' => self::getProductsList(),
            'cảm ơn' => 'Không có gì! 😊 Nếu cần hỗ trợ thêm, hãy nhắn lại nhé!',
            'thanks' => 'You\'re welcome! 😊',
        ];

        foreach ($responses as $key => $response) {
            if (mb_strpos($messageLower, $key, 0, 'UTF-8') !== false) {
                return $response;
            }
        }

        // Response mặc định - hướng dẫn user hỏi đúng phạm vi
        return self::getOutOfScopeResponse();
    }

    /**
     * Tìm kiếm sản phẩm từ database (nhiều kết quả)
     */
    private static function searchProducts($query)
    {
        if (strlen($query) < 2) {
            return [];
        }

        $query_pattern = '%' . $query . '%';

        // Tìm sản phẩm theo tên, thương hiệu, hoặc mô tả
        $products = Product::where('is_active', true)
            ->where(function ($q) use ($query_pattern) {
                $q->whereRaw('LOWER(name) LIKE ?', [$query_pattern])
                  ->orWhereRaw('LOWER(description) LIKE ?', [$query_pattern])
                  ->orWhereRaw('LOWER(brand) LIKE ?', [$query_pattern]);
            })
            ->limit(10)
            ->get();

        return $products->toArray();
    }

    /**
     * Format 1 sản phẩm thành response chi tiết
     */
    private static function formatProductResponse($product)
    {
        $price = number_format($product['price'], 0, ',', '.');
        $category = $product['category']['name'] ?? 'Chưa phân loại';
        $stock = $product['stock'] > 0 ? "✅ Còn {$product['stock']} sản phẩm" : "❌ Hết hàng";

        $response = "🛍️ {$product['name']}\n\n";
        $response .= "📝 Mô tả:\n{$product['description']}\n\n";
        $response .= "💰 Giá: {$price} VND\n";

        if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']) {
            $salePrice = number_format($product['sale_price'], 0, ',', '.');
            $discount = round((1 - $product['sale_price'] / $product['price']) * 100);
            $response .= "🎉 Giá sale: {$salePrice} VND (Giảm {$discount}%)\n";
        }

        $response .= "📦 {$stock}\n";
        $response .= "🏷️ Danh mục: {$category}\n";
        
        if (!empty($product['brand'])) {
            $response .= "🏢 Thương hiệu: {$product['brand']}\n";
        }

        $response .= "🔗 Chi tiết: /product/{$product['id']}";

        return $response;
    }

    /**
     * Format nhiều sản phẩm thành danh sách
     */
    private static function formatProductsList($products)
    {
        $count = count($products);
        $response = "📋 Tìm thấy {$count} sản phẩm:\n\n";

        foreach ($products as $product) {
            $price = number_format($product['price'], 0, ',', '.');
            $response .= "🔹 {$product['name']}\n";
            $response .= "   💰 Giá: {$price} VND";
            
            if (!empty($product['sale_price']) && $product['sale_price'] < $product['price']) {
                $salePrice = number_format($product['sale_price'], 0, ',', '.');
                $discount = round((1 - $product['sale_price'] / $product['price']) * 100);
                $response .= " → Sale: {$salePrice} VND (-{$discount}%)";
            }
            
            $response .= "\n   📦 Tồn: {$product['stock']} | /product/{$product['id']}\n\n";
        }

        $response .= "💡 Click vào link /product/[ID] để xem chi tiết hoặc gõ tên sản phẩm để biết thêm!";

        return $response;
    }

    /**
     * Lấy danh sách tất cả sản phẩm
     */
    private static function getProductsList()
    {
        $products = Product::where('is_active', true)->limit(15)->get();

        if ($products->isEmpty()) {
            return 'Hiện tại chúng tôi chưa có sản phẩm nào.';
        }

        $response = "📋 Danh sách sản phẩm (" . $products->count() . " sản phẩm):\n\n";

        foreach ($products as $product) {
            $price = number_format($product->price, 0, ',', '.');
            $response .= "• {$product->name} - {$price} VND\n";
        }

        $response .= "\n💡 Hãy gõ tên sản phẩm để tôi giới thiệu chi tiết hơn!";

        return $response;
    }

    /**
     * Kiểm tra xem câu hỏi có liên quan đến đơn hàng không
     */
    private static function isOrderQuery($message)
    {
        $orderKeywords = [
            'đơn hàng', 'don hang', 'order', 'đơn của tôi', 'don cua toi',
            'tra cứu đơn', 'tra cuu don', 'kiểm tra đơn', 'kiem tra don',
            'trạng thái đơn', 'trang thai don', 'đơn đã đặt', 'don da dat',
            'xem đơn', 'xem don', 'đơn mua', 'don mua'
        ];

        foreach ($orderKeywords as $keyword) {
            if (mb_strpos($message, $keyword, 0, 'UTF-8') !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Xử lý tra cứu đơn hàng
     */
    private static function handleOrderQuery($message, $userId)
    {
        // Kiểm tra user đã đăng nhập chưa
        if (!$userId) {
            return "📦 Để tra cứu đơn hàng, bạn cần đăng nhập trước.\n\n" .
                   "👉 Vui lòng đăng nhập tại: /login\n" .
                   "👉 Sau đó quay lại đây để xem đơn hàng của bạn.";
        }

        // Lấy đơn hàng của user
        $orders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        if ($orders->isEmpty()) {
            return "📦 Bạn chưa có đơn hàng nào.\n\n" .
                   "👉 Hãy mua sắm tại: /shop\n" .
                   "💡 Gõ \"sản phẩm\" để xem danh sách sản phẩm!";
        }

        $statusLabels = [
            'pending' => '🕐 Chờ xử lý',
            'processing' => '⚙️ Đang xử lý',
            'shipped' => '🚚 Đang giao',
            'delivered' => '✅ Đã giao',
            'cancelled' => '❌ Đã hủy'
        ];

        $response = "📦 **Đơn hàng của bạn** (5 đơn gần nhất):\n\n";

        foreach ($orders as $order) {
            $total = number_format($order->total, 0, ',', '.');
            $status = $statusLabels[$order->status] ?? $order->status;
            $date = $order->created_at->format('d/m/Y H:i');

            $response .= "🔹 **Đơn #{$order->id}**\n";
            $response .= "   💰 Tổng: {$total} VND\n";
            $response .= "   📊 Trạng thái: {$status}\n";
            $response .= "   📅 Ngày đặt: {$date}\n\n";
        }

        $response .= "👉 Xem chi tiết tất cả đơn hàng: /orders";

        return $response;
    }

    /**
     * Response khi câu hỏi ngoài phạm vi hỗ trợ
     */
    private static function getOutOfScopeResponse()
    {
        return "❓ Xin lỗi, tôi không hiểu câu hỏi của bạn.\n\n" .
               "🤖 Tôi có thể hỗ trợ bạn về:\n" .
               "• **Sản phẩm**: Gõ tên thương hiệu (Nike, Adidas, Puma...)\n" .
               "• **Đơn hàng**: Gõ \"đơn hàng\" hoặc \"tra cứu đơn\"\n" .
               "• **Size giày**: Gõ \"size\" hoặc \"cỡ giày\"\n" .
               "• **Thanh toán**: Gõ \"thanh toán\"\n" .
               "• **Vận chuyển**: Gõ \"vận chuyển\"\n" .
               "• **Danh sách sản phẩm**: Gõ \"danh sách sản phẩm\"\n\n" .
               "💡 Hãy thử hỏi lại với các từ khóa trên nhé!";
    }

    /**
     * Kiểm tra xem câu hỏi có liên quan đến size giày không
     */
    private static function isSizeQuery($message)
    {
        $sizeKeywords = [
            'size', 'kích cỡ', 'kich co', 'cỡ giày', 'co giay',
            'bảng size', 'bang size', 'đo size', 'do size',
            'chọn size', 'chon size', 'size nào', 'size nao',
            'size bao nhiêu', 'size bao nhieu', 'đổi size', 'doi size',
            'quy đổi size', 'quy doi size', 'size nam', 'size nữ', 'size nu',
            'size giày', 'size giay', 'chiều dài chân', 'chieu dai chan',
            'cm sang size', 'eu sang us', 'us sang eu', 'uk sang eu'
        ];

        foreach ($sizeKeywords as $keyword) {
            if (mb_strpos($message, $keyword, 0, 'UTF-8') !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Xử lý câu hỏi về size giày
     */
    private static function handleSizeQuery($message)
    {
        // Kiểm tra xem có hỏi cụ thể size nam hay nữ không
        $isWomen = self::containsWomenKeyword($message);
        $isMen = self::containsMenKeyword($message);

        // Kiểm tra xem có số cm cụ thể không
        if (preg_match('/(\d+(?:[.,]\d+)?)\s*(?:cm|centimeter)/i', $message, $matches)) {
            $cm = floatval(str_replace(',', '.', $matches[1]));
            return self::convertCmToSize($cm, $isWomen);
        }

        // Kiểm tra xem có hỏi chuyển đổi size không
        if (preg_match('/(\d+(?:[.,]\d+)?)\s*(us|eu|uk)/i', $message, $matches)) {
            $size = floatval(str_replace(',', '.', $matches[1]));
            $type = strtolower($matches[2]);
            return self::convertSize($size, $type, $isWomen);
        }

        // Nếu hỏi size nữ cụ thể
        if ($isWomen && !$isMen) {
            return self::getWomenSizeChart();
        }

        // Nếu hỏi size nam cụ thể
        if ($isMen && !$isWomen) {
            return self::getMenSizeChart();
        }

        // Trả về hướng dẫn chung về size
        return self::getSizeGuide();
    }

    /**
     * Kiểm tra từ khóa liên quan đến nữ
     */
    private static function containsWomenKeyword($message)
    {
        $womenKeywords = ['nữ', 'nu', 'women', 'woman', 'female', 'girl', 'phụ nữ', 'phu nu', 'con gái', 'con gai'];
        foreach ($womenKeywords as $keyword) {
            if (mb_strpos($message, $keyword, 0, 'UTF-8') !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Kiểm tra từ khóa liên quan đến nam
     */
    private static function containsMenKeyword($message)
    {
        $menKeywords = ['nam', 'men', 'man', 'male', 'boy', 'đàn ông', 'dan ong', 'con trai'];
        foreach ($menKeywords as $keyword) {
            if (mb_strpos($message, $keyword, 0, 'UTF-8') !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Chuyển đổi cm sang size
     */
    private static function convertCmToSize($cm, $isWomen = false)
    {
        $chart = $isWomen ? self::$womenSizeChart : self::$menSizeChart;
        $gender = $isWomen ? 'nữ' : 'nam';

        // Tìm size gần nhất
        $closest = null;
        $minDiff = PHP_FLOAT_MAX;

        foreach ($chart as $row) {
            $diff = abs(floatval($row['cm']) - $cm);
            if ($diff < $minDiff) {
                $minDiff = $diff;
                $closest = $row;
            }
        }

        if ($closest) {
            $response = "👟 **Kết quả quy đổi size (Giày {$gender})**\n\n";
            $response .= "📏 Chiều dài chân: **{$cm} cm**\n\n";
            $response .= "✅ Size khuyến nghị:\n";
            $response .= "• US: **{$closest['us']}**\n";
            $response .= "• EU: **{$closest['eu']}**\n";
            $response .= "• UK: **{$closest['uk']}**\n";
            $response .= "• CM: **{$closest['cm']}**\n\n";
            $response .= "💡 **Mẹo**: Nên đo chân vào buổi chiều vì chân thường phình hơn. Thêm 0.5-1cm cho thoải mái!";
            return $response;
        }

        return "❌ Không tìm thấy size phù hợp cho {$cm}cm. Vui lòng đo lại chiều dài chân (thường từ 22-30cm).";
    }

    /**
     * Chuyển đổi giữa các chuẩn size
     */
    private static function convertSize($size, $type, $isWomen = false)
    {
        $chart = $isWomen ? self::$womenSizeChart : self::$menSizeChart;
        $gender = $isWomen ? 'nữ' : 'nam';
        $typeUpper = strtoupper($type);

        // Tìm row có size tương ứng
        foreach ($chart as $row) {
            if (floatval($row[$type]) == $size) {
                $response = "👟 **Quy đổi size {$typeUpper} {$size} (Giày {$gender})**\n\n";
                $response .= "• US: **{$row['us']}**\n";
                $response .= "• EU: **{$row['eu']}**\n";
                $response .= "• UK: **{$row['uk']}**\n";
                $response .= "• CM: **{$row['cm']}**\n\n";
                $response .= "💡 Gõ \"bảng size nam\" hoặc \"bảng size nữ\" để xem đầy đủ!";
                return $response;
            }
        }

        return "❌ Không tìm thấy size {$typeUpper} {$size} trong bảng. Gõ \"bảng size\" để xem các size có sẵn.";
    }

    /**
     * Bảng size giày nam đầy đủ
     */
    private static function getMenSizeChart()
    {
        $response = "👟 **BẢNG SIZE GIÀY NAM**\n\n";
        $response .= "┌────────┬────────┬────────┬────────┐\n";
        $response .= "│   US   │   EU   │   UK   │   CM   │\n";
        $response .= "├────────┼────────┼────────┼────────┤\n";

        foreach (self::$menSizeChart as $row) {
            $response .= sprintf("│  %-5s │  %-5s │  %-5s │  %-5s │\n", 
                $row['us'], $row['eu'], $row['uk'], $row['cm']);
        }

        $response .= "└────────┴────────┴────────┴────────┘\n\n";
        $response .= "📏 **Cách đo chân**: Đứng thẳng, đo từ gót đến ngón dài nhất.\n";
        $response .= "💡 Gõ \"25cm\" hoặc \"size 42 EU\" để quy đổi nhanh!";

        return $response;
    }

    /**
     * Bảng size giày nữ đầy đủ
     */
    private static function getWomenSizeChart()
    {
        $response = "👠 **BẢNG SIZE GIÀY NỮ**\n\n";
        $response .= "┌────────┬────────┬────────┬────────┐\n";
        $response .= "│   US   │   EU   │   UK   │   CM   │\n";
        $response .= "├────────┼────────┼────────┼────────┤\n";

        foreach (self::$womenSizeChart as $row) {
            $response .= sprintf("│  %-5s │  %-5s │  %-5s │  %-5s │\n", 
                $row['us'], $row['eu'], $row['uk'], $row['cm']);
        }

        $response .= "└────────┴────────┴────────┴────────┘\n\n";
        $response .= "📏 **Cách đo chân**: Đứng thẳng, đo từ gót đến ngón dài nhất.\n";
        $response .= "💡 Gõ \"24cm nữ\" hoặc \"size 38 EU nữ\" để quy đổi nhanh!";

        return $response;
    }

    /**
     * Hướng dẫn chung về size giày
     */
    private static function getSizeGuide()
    {
        $response = "👟 **HƯỚNG DẪN CHỌN SIZE GIÀY**\n\n";
        $response .= "📏 **Cách đo chân chính xác**:\n";
        $response .= "1. Đặt chân lên giấy trắng, đứng thẳng\n";
        $response .= "2. Dùng bút vẽ theo đường viền bàn chân\n";
        $response .= "3. Đo từ gót đến ngón chân dài nhất\n";
        $response .= "4. Cộng thêm 0.5-1cm để thoải mái\n\n";
        $response .= "🔄 **Quy đổi size nhanh**:\n";
        $response .= "• Gõ \"bảng size nam\" - xem bảng size nam\n";
        $response .= "• Gõ \"bảng size nữ\" - xem bảng size nữ\n";
        $response .= "• Gõ \"25cm\" - quy đổi từ cm sang size\n";
        $response .= "• Gõ \"size 42 EU\" - quy đổi EU sang các chuẩn khác\n\n";
        $response .= "⚠️ **Lưu ý**:\n";
        $response .= "• Size có thể khác nhau giữa các thương hiệu\n";
        $response .= "• Nên đo chân vào buổi chiều (chân phình hơn)\n";
        $response .= "• Nếu giữa 2 size, nên chọn size lớn hơn";

        return $response;
    }
}

