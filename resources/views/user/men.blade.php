@extends('layouts.user')

@section('title', 'Sản phẩm nam')

@section('content')
  <div class="py-5 px-4">
    <div class="container-fluid">
      <h1 class="mb-5 fw-bold text-uppercase">Giày nam</h1>
      
      <div class="product-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-4 g-4">
          @php
            $prices = [499000, 599000, 699000, 799000, 899000];
            $names = ['Nike Dunk Low Blue', 'Nike Air Force 1', 'Nike Free RN', 'Nike Revolution', 'Nike Court Borough', 'Adidas Stan Smith', 'Adidas NMD R1', 'New Balance 990', 'Puma RS-X'];
          @endphp
          
          @for($i = 1; $i <= 9; $i++)
            @php
              $price = $prices[($i - 1) % 5];
              $name = $names[$i - 1] ?? "Sản phẩm nam " . $i;
            @endphp
            <div class="col">
              <div class="product-card position-relative h-100">
                <div class="card-img rounded-4 overflow-hidden position-relative">
                  <a href="{{ route('product.show', 'men-'.$i) }}">
                    <img src="{{ asset('user/images/card-item'.(($i%10)+1).'.jpg') }}" alt="{{ $name }}" class="product-image img-fluid w-100" style="object-fit: cover; height: 280px;">
                  </a>
                  <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                    <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                      <a href="#" data-url="{{ route('product.show', 'men-'.$i) }}" data-sku="men-{{ $i }}" data-name="{{ $name }}" data-price="{{ $price }}" data-image="{{ asset('user/images/card-item'.(($i%10)+1).'.jpg') }}" class="btn btn-light ajax-add-cart rounded-circle">
                        <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
                      </a>
                      <a href="{{ route('product.show', 'men-'.$i) }}" class="btn btn-light rounded-circle">
                        <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                  <h3 class="card-title fs-6 fw-normal m-0">
                    <a href="{{ route('product.show', 'men-'.$i) }}" class="text-dark text-decoration-none">{{ $name }}</a>
                  </h3>
                  <span class="card-price fw-bold mt-2">{{ number_format($price, 0, ',', '.') }} ₫</span>
                </div>
              </div>
            </div>
          @endfor
        </div>
      </div>
    </div>
  </div>

  @include('partials.add_toast')

@endsection
