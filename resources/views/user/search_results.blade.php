@extends('layouts.user')

@section('title', 'Kết quả tìm kiếm')

@section('content')

<div class="container-lg py-5">
  <div class="mb-4">
    <h1 class="mb-2">Kết quả tìm kiếm</h1>
    <p class="text-muted">Từ khóa: <strong>{{ e($q) }}</strong>
      @if($selectedCategory)
        | Danh mục: <strong>{{ $categories->find($selectedCategory)?->name }}</strong>
      @endif
    </p>
  </div>

  <!-- Filter Section -->
  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ url('/search') }}" method="get" class="row g-3 align-items-end">
        <div class="col-md-6">
          <label for="searchKeyword" class="form-label">Từ khóa</label>
          <input type="text" class="form-control" id="searchKeyword" name="q" value="{{ e($q) }}" placeholder="Tìm kiếm...">
        </div>
        <div class="col-md-4">
          <label for="categorySelect" class="form-label">Danh mục</label>
          <select class="form-select" id="categorySelect" name="category_id">
            <option value="">-- Tất cả danh mục --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
      </form>
    </div>
  </div>

  @if(empty($q))
    <div class="alert alert-info" role="alert">
      Vui lòng nhập từ khóa tìm kiếm.
    </div>
  @else
    @if($results->isEmpty())
      <div class="alert alert-warning" role="alert">
        Không tìm thấy sản phẩm nào cho <strong>{{ e($q) }}</strong>
        @if($selectedCategory)
          trong danh mục <strong>{{ $categories->find($selectedCategory)?->name }}</strong>
        @endif
        . Vui lòng thử tìm kiếm với từ khóa khác.
      </div>
    @else
      <p class="text-muted mb-4">Tìm thấy <strong>{{ $results->total() }}</strong> sản phẩm</p>

      <!-- Products Grid -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @forelse($results as $product)
          <div class="col">
            <div class="product-card position-relative h-100">
              <div class="card-img rounded-4 overflow-hidden position-relative">
                <a href="{{ route('product.show', $product->sku ?? $product->id) }}">
                  @php
                    $imageIndex = 1;
                    if ($product->sku && preg_match('/^(men|women)-(\d+)$/', $product->sku, $m)) {
                      $num = (int)$m[2];
                      $imageIndex = ($num % 10) + 1;
                    } else {
                      $imageIndex = (($product->id % 10) + 1);
                    }
                    $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                  @endphp
                  <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="product-image img-fluid w-100" style="object-fit: cover; height: 180px;">
                </a>

                <div class="cart-concern position-absolute d-flex justify-content-center w-100 h-100">
                  <div class="cart-button d-flex gap-2 justify-content-center align-items-center">
                    <a href="#" data-url="{{ route('product.show', $product->sku ?? $product->id) }}" data-sku="{{ $product->sku ?? $product->id }}" data-name="{{ e($product->name) }}" data-price="{{ $product->price }}" data-image="{{ $imageUrl }}" class="btn btn-light ajax-add-cart rounded-circle">
                      <svg class="shopping-carriage"><use xlink:href="#shopping-carriage"></use></svg>
                    </a>
                    <a href="{{ route('product.show', $product->sku ?? $product->id) }}" class="btn btn-light rounded-circle">
                      <svg class="quick-view"><use xlink:href="#quick-view"></use></svg>
                    </a>
                  </div>
                </div>
              </div>

              <div class="card-detail d-flex flex-column justify-content-between align-items-start mt-3">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="{{ route('product.show', $product->sku ?? $product->id) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                </h3>
                <span class="card-price fw-bold mt-2">
                  {{ number_format(($product->sale_price && $product->sale_price < $product->price) ? $product->sale_price : $product->price, 0, ',', '.') }} ₫
                </span>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center text-muted">Không có sản phẩm</p>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($results->hasPages())
        <div class="d-flex justify-content-center mt-5">
          {{ $results->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      @endif
    @endif
  @endif
</div>

@endsection
