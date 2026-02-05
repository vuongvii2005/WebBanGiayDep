@extends('layouts.user')
@section('title', 'Chi tiết sản phẩm')

@section('content')
@php
  // Accept either an array (from controller->toArray()) or a model instance
  $prod = is_array($product) ? $product : (is_object($product) ? (method_exists($product, 'toArray') ? $product->toArray() : (array)$product) : (array)$product);
  $prodPrice = (float)($prod['price'] ?? ($product->price ?? 599000)); // Mặc định giá giày 599.000 ₫
  $salePrice = (float)($prod['sale_price'] ?? null); // Giá khuyến mãi nếu có
@endphp
<div class="container mt-4">
  <div class="row bg-white rounded shadow p-4 g-4 align-items-start">
    <div class="col-12 col-md-6">
      @php 
        // Always use demo images based on product SKU or ID
        $imageIndex = 1;
        $id = $prod['id'] ?? $prod['sku'] ?? null;
        if ($id && preg_match('/^(men|women)-(\d+)$/', (string)$id, $m)) {
          $num = (int)$m[2];
          $imageIndex = ($num % 10) + 1;
        } elseif ($id && is_numeric($id)) {
          $imageIndex = (($id % 10) + 1);
        }
        $prodImg = asset("user/images/card-item{$imageIndex}.jpg");
      @endphp
      <img src="{{ $prodImg }}" alt="{{ $prod['name'] ?? '' }}" class="img-fluid rounded w-100">
    </div>

    <div class="col-12 col-md-6">
      <div class="d-flex flex-column h-100">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
          <div>
            <h1 class="h4 mb-2">{{ $prod['name'] ?? '' }}</h1>
            
            <!-- Brand & Material Badges -->
            @if(($prod['brand'] ?? null) || ($prod['material'] ?? null))
              <div class="mb-2">
                @if($prod['brand'] ?? null)
                  <span class="badge bg-info">{{ $prod['brand'] }}</span>
                @endif
                @if($prod['material'] ?? null)
                  <span class="badge bg-light text-dark">{{ $prod['material'] }}</span>
                @endif
              </div>
            @endif
          </div>
          <div class="d-flex align-items-center gap-2">
            @if($salePrice)
              <p class="h5 text-danger fw-bold mb-0">{{ number_format($salePrice, 0, ',', '.') }} ₫</p>
              <p class="h6 text-muted mb-0"><del>{{ number_format($prodPrice, 0, ',', '.') }} ₫</del></p>
            @else
              <p class="h5 text-danger fw-bold mb-0">{{ number_format($prodPrice, 0, ',', '.') }} ₫</p>
            @endif
          </div>
        </div>

        <!-- Stock Status -->
        @if(($prod['stock'] ?? 0) > 0)
          <div class="alert alert-success py-2 mb-3">✓ Còn hàng ({{ $prod['stock'] }} sản phẩm)</div>
        @else
          <div class="alert alert-danger py-2 mb-3">✗ Hết hàng</div>
        @endif

        <p class="mb-4">{{ $prod['description'] ?? '' }}</p>

        <!-- Add to Cart Form - Color & Quantity -->
        <form method="POST" action="{{ url('/cart/add') }}" class="mb-4 p-3 bg-light rounded" id="productForm">
          @csrf
          <input type="hidden" name="id" value="{{ $prod['id'] ?? ($prod['sku'] ?? '') }}">
          <input type="hidden" name="name" value="{{ $prod['name'] ?? '' }}">
          <input type="hidden" name="price" value="{{ $prodPrice }}">
          <input type="hidden" name="image" value="{{ $prodImg }}">
          <input type="hidden" name="buy_now" id="buy_now_input" value="0">

          <h6 class="fw-bold mb-3">Chọn thông tin sản phẩm</h6>

          <!-- Size Selection -->
          <div class="mb-3">
            <label for="size" class="form-label">Kích cỡ</label>
            <select id="size" name="size" class="form-select">
              <option value="">-- Chọn kích cỡ --</option>
              <option value="35">35</option>
              <option value="36">36</option>
              <option value="37">37</option>
              <option value="38">38</option>
              <option value="39">39</option>
              <option value="40">40</option>
              <option value="41">41</option>
              <option value="42">42</option>
              <option value="43">43</option>
              <option value="44">44</option>
              <option value="45">45</option>
            </select>
            <div id="sizeError" class="text-danger small mt-1" style="display:none;">Vui lòng chọn kích cỡ</div>
          </div>

          <!-- Quantity Selection -->
          <div class="mb-3">
            <label for="qty" class="form-label">Số lượng</label>
            <input id="qty" name="qty" type="number" value="1" min="1" max="{{ $prod['stock'] ?? 1 }}" class="form-control" style="width:100px;">
          </div>

          <!-- Add to Cart / Buy Now Buttons -->
          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-warning fw-bold" @if(($prod['stock'] ?? 0) <= 0) disabled @endif>
              @if(($prod['stock'] ?? 0) > 0)
                Thêm vào giỏ
              @else
                Hết hàng
              @endif
            </button>
            <button type="button" id="buyNowBtn" class="btn btn-primary fw-bold" @if(($prod['stock'] ?? 0) <= 0) disabled @endif>
              Thanh toán ngay
            </button>
            <a href="{{ url('/') }}" class="btn btn-secondary">Tiếp tục mua hàng</a>
          </div>
        </form>

        <script>
          (function(){
            var buy = document.getElementById('buyNowBtn');
            var form = document.getElementById('productForm');
            var size = document.getElementById('size');
            var sizeError = document.getElementById('sizeError');

            function validateSize(){
              if(!size) return true;
              if(size.value === ''){
                if(sizeError) sizeError.style.display = '';
                size.focus();
                return false;
              }
              if(sizeError) sizeError.style.display = 'none';
              return true;
            }

            if(form){
              form.addEventListener('submit', function(e){
                if(!validateSize()){
                  e.preventDefault();
                  return false;
                }
                return true;
              });
            }

            if(buy){
              buy.addEventListener('click', function(){
                if(!validateSize()) return;
                var buyInput = document.getElementById('buy_now_input');
                var originalAction = form.action;
                buyInput.value = '1';
                form.action = "{{ route('cart.buyNow') }}";
                form.submit();
                setTimeout(function(){ form.action = originalAction; buyInput.value = '0'; }, 1000);
              });
            }
          })();
        </script> 

        <!-- Shoe Information -->
        <div class="mb-4 p-3 bg-light rounded">
          <h6 class="fw-bold"> Thông tin về giày</h6>
          <ul class="mb-0 small text-muted">
            <li>Chất liệu: Được làm từ các vật liệu cao cấp, bền bỉ</li>
            <li>Kiểu dáng: Thời trang, phù hợp cho cả nam và nữ</li>
            <li>Độ thoải mái: Lót êm, thiết kế ergonomic giúp giảm mệt mỏi</li>
            <li>Độ bền: Đế chống trơn trượt, tính năng chống mài mòn</li>
            <li>Quy cách: Có nhiều kích cỡ và màu sắc lựa chọn</li>
          </ul>
        </div>

        <!-- Specifications -->
        @if($prod['specifications'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Thông số kỹ thuật</h6>
            <p class="text-muted small mb-0">{{ $prod['specifications'] }}</p>
          </div>
        @endif

        <!-- Warranty -->
        @if($prod['warranty'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Bảo hành</h6>
            <p class="text-muted small mb-0">{{ $prod['warranty'] }}</p>
          </div>
        @endif

        <!-- Care Instructions -->
        @if($prod['care_instructions'] ?? null)
          <div class="mb-4 p-3 bg-light rounded">
            <h6 class="fw-bold">Hướng dẫn bảo quản</h6>
            <p class="text-muted small mb-0">{{ $prod['care_instructions'] }}</p>
          </div>
        @endif

        <!-- Rating & Reviews Section -->
        <div class="card p-4 mt-4 border-0">
          <h6 class="text-dark mb-3" style="word-spacing: 0.1em;">Đánh giá & Nhận xét</h6>
          @if($prod['rating'] ?? 0 > 0)
            <div class="mb-3">
              <div class="d-flex align-items-center gap-2 mb-2">
                @for($i = 1; $i <= 5; $i++)
                  <span class="text-warning" style="font-size: 20px;">
                    @if($i <= floor($prod['rating']))
                      ★
                    @elseif($i - 0.5 <= $prod['rating'])
                      ★
                    @else
                      ☆
                    @endif
                  </span>
                @endfor
                <span class="ms-2"><strong class="text-dark">{{ $prod['rating'] ?? 0 }}/5</strong> <span class="text-dark">({{ $prod['reviews_count'] ?? 0 }} đánh giá)</span></span>
              </div>
              <p class="text-dark small mb-0">Được đánh giá cao bởi khách hàng của chúng tôi</p>
            </div>
          @else
            <p class="text-dark mb-0">Chưa có đánh giá. Hãy là người đầu tiên đánh giá sản phẩm này!</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@endsection