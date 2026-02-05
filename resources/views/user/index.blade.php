@extends('layouts.user')

@section('title', 'Trang chủ')

@section('content')
  <section id="intro" class="position-relative">
    <div class="container-lg">
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/banner1.png') }}" alt="Banner 1" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Banner 1</h2>
                <p class="light mb-3">Bộ sưu tập mới nhất với công nghệ tiên tiến</p>
                <a href="#" class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Khám phá ngay</a>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="card d-flex flex-row align-items-end border-0 large jarallax-keep-img">
              <img src="{{ asset('user/images/banner3.png') }}" alt="Banner 2" class="img-fluid jarallax-img">
              <div class="cart-concern p-3 m-3 p-lg-5 m-lg-5">
                <h2 class="card-title display-3 light">Banner 2</h2>
                <p class="light mb-3">Chất lượng tốt nhất, giá cả hợp lý</p>
                <a href="#" class="text-uppercase light mt-3 d-inline-block text-hover fw-bold light-border">Khám phá ngay</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <section class="discount-coupon py-3 px-4">
    <div class="container-fluid">
      <div class="bg-gray coupon position-relative p-5 rounded-4">
        <div class="bold-text position-absolute">Giảm 10%</div>
        <div class="row justify-content-between align-items-center">
          <div class="col-lg-7 col-md-12 mb-3">
            <div class="coupon-header">
              <h2 class="display-7 fw-bold mb-2">Mã giảm 10%</h2>
              <p class="m-0 text-muted">Đăng ký để nhận mã giảm 10% cho mọi đơn hàng</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="btn-wrap">
              <a href="#" class="btn btn-black btn-medium text-uppercase hvr-sweep-to-right">Gửi Email</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="featured-products" class="product-store py-3 px-4">
    <div class="container-fluid">
      <div class="display-header d-flex align-items-center justify-content-between mb-5">
        <h2 class="section-title text-uppercase fw-bold">Sản phẩm nổi bật</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả →</a>
        </div>
      </div>
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
          @if(!empty($products) && count($products))
            @foreach($products->take(5) as $product)
              @php
                $id = $product->sku ?? $product->id;
                $title = $product->name ?? 'Sản phẩm';
                $price = $product->price ?? 0;
                // Always use demo images based on product SKU or ID
                $imageIndex = 1;
                if ($id && preg_match('/^(men|women)-(\d+)$/', (string)$id, $m)) {
                  $num = (int)$m[2];
                  $imageIndex = ($num % 10) + 1;
                } else {
                  $imageIndex = (($product->id % 10) + 1);
                }
                $image = asset("user/images/card-item{$imageIndex}.jpg");
              @endphp
              <div class="col">
                <div class="product-card position-relative h-100">
                  <div class="card-img rounded-4 overflow-hidden position-relative">
                    <a href="{{ route('product.show', $id) }}">
                      <img src="{{ $image }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                    </a>
                    <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                      <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                        <a href="#" data-url="{{ route('product.show', $id) }}" data-sku="{{ $id }}" data-name="{{ e($title) }}" data-price="{{ $price }}" data-image="{{ $image }}" class="btn btn-light ajax-add-cart rounded-circle">
                          <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
                        </a>
                        <a href="{{ route('product.show', $id) }}" class="btn btn-light rounded-circle">
                          <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                    <h3 class="card-title fs-6 fw-normal m-0">
                      <a href="{{ route('product.show', $id) }}" class="text-dark text-decoration-none">{{ $title }}</a>
                    </h3>
                    <span class="card-price fw-bold mt-2">{{ number_format($price, 0, ',', '.') }} ₫</span>
                  </div>
                </div>
              </div>
            @endforeach
          @else
            <div class="col">No products available.</div>
          @endif
        </div>
      </div>
    </div>
  </section>

  <section id="latest-products" class="product-store py-3 px-4">
    <div class="container-fluid">
      <div class="display-header d-flex align-items-center justify-content-between mb-5">
        <h2 class="section-title text-uppercase fw-bold">Sản phẩm mới</h2>
        <div class="btn-right">
          <a href="index.html" class="d-inline-block text-uppercase text-hover fw-bold">Xem tất cả →</a>
        </div>
      </div>
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p6') }}">
                  <img src="{{ asset('user/images/card-item6.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ url('/product/p6') }}" data-sku="p6" data-name="Adidas Stan Smith" data-price="499000" data-image="{{ asset('user/images/card-item6.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p6') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p6') }}" class="text-dark text-decoration-none">Adidas Stan Smith</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(499000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p7') }}">
                  <img src="{{ asset('user/images/card-item7.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ url('/product/p7') }}" data-sku="p7" data-name="Adidas NMD R1" data-price="599000" data-image="{{ asset('user/images/card-item7.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p7') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p7') }}" class="text-dark text-decoration-none">Adidas NMD R1</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(599000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p8') }}">
                  <img src="{{ asset('user/images/card-item8.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ url('/product/p8') }}" data-sku="p8" data-name="New Balance 990" data-price="699000" data-image="{{ asset('user/images/card-item8.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p8') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p8') }}" class="text-dark text-decoration-none">New Balance 990</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(699000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p9') }}">
                  <img src="{{ asset('user/images/card-item9.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ url('/product/p9') }}" data-sku="p9" data-name="Puma RS-X Reinvention" data-price="799000" data-image="{{ asset('user/images/card-item9.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p9') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p9') }}" class="text-dark text-decoration-none">Puma RS-X Reinvention</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(799000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ url('/product/p10') }}">
                  <img src="{{ asset('user/images/card-item10.jpg') }}" alt="product-item" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                </a>
                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ url('/product/p10') }}" data-sku="p10" data-name="New Balance 574" data-price="599000" data-image="{{ asset('user/images/card-item10.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage">
                        <use xlink:href="#shopping-carriage"></use>
                      </svg>
                    </a>
                    <a href="{{ url('/product/p10') }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view">
                        <use xlink:href="#quick-view"></use>
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ url('/product/p10') }}" class="text-dark text-decoration-none">New Balance 574</a>
                </h3>
                <span class="card-price fw-bold mt-2">{{ number_format(599000, 0, ',', '.') }} ₫</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('partials.add_toast')

@endsection
            <ul class="menu-list list-unstyled">
