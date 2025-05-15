@extends('front.layouts.app')

@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ url('/') }}">Home</a>
                    <a class="breadcrumb-item text-dark" href="{{ route('shop.index') }}">Shop</a>
                    <span class="breadcrumb-item active">Shop List</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Filter -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Filter by price</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        @for ($i = 0; $i <= 5; $i++)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="price-{{ $i }}"
                                    {{ $i == 0 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="price-{{ $i }}">
                                    @switch($i)
                                        @case(0)
                                            All Price
                                        @break

                                        @case(1)
                                            $0 - $100
                                        @break

                                        @case(2)
                                            $100 - $200
                                        @break

                                        @case(3)
                                            $200 - $300
                                        @break

                                        @case(4)
                                            $300 - $400
                                        @break

                                        @case(5)
                                            $400 - $500
                                        @break
                                    @endswitch
                                </label>
                                <span class="badge border font-weight-normal">{{ rand(100, 500) }}</span>
                            </div>
                        @endfor
                    </form>
                </div>

                <!-- Color Filter -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Filter by color</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        @php $colors = ['All Color', 'Black', 'White', 'Red', 'Blue', 'Green']; @endphp
                        @foreach ($colors as $index => $color)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="color-{{ $index }}"
                                    {{ $index == 0 ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                    for="color-{{ $index }}">{{ $color }}</label>
                                <span class="badge border font-weight-normal">{{ rand(100, 500) }}</span>
                            </div>
                        @endforeach
                    </form>
                </div>

                <!-- Size Filter -->
                <h5 class="section-title position-relative text-uppercase mb-3">
                    <span class="bg-secondary pr-3">Filter by size</span>
                </h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        @php $sizes = ['All Size', 'XS', 'S', 'M', 'L', 'XL']; @endphp
                        @foreach ($sizes as $index => $size)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                <input type="checkbox" class="custom-control-input" id="size-{{ $index }}"
                                    {{ $index == 0 ? 'checked' : '' }}>
                                <label class="custom-control-label"
                                    for="size-{{ $index }}">{{ $size }}</label>
                                <span class="badge border font-weight-normal">{{ rand(100, 500) }}</span>
                            </div>
                        @endforeach
                    </form>
                </div>
            </div>
            <!-- Sidebar End -->

            <!-- Product Section Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fas fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fas fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div>
                                <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                        data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach ($produits as $produit)
                        <div class="col-md-6 mb-4">
                            <div class="bg-light p-3 rounded shadow-sm h-100 text-center d-flex flex-column">
                                <div class="product-img mb-3" style="width: 100%; height: 350px; overflow: hidden; background-color: #fff;">
                                    <img src="{{ asset('storage/' . $produit->image) }}" class="img-fluid"
                                        alt="{{ $produit->nom }}" style="object-fit: contain; height: 100%; width: 100%;">
                                </div>
                                <h5 class="mb-2 flex-grow-0">
                                    <a href="{{ route('produit.detail', ['id' => $produit->id]) }}"
                                        class="text-dark text-decoration-none">{{ $produit->nom }}</a>
                                </h5>
                                <p class="mb-1 text-muted" style="font-size: 14px;">
                                    {{ Str::limit($produit->description, 100, '...') }}
                                </p>
                                <h6 class="text-primary">${{ number_format($produit->prix_unitaire, 2) }}</h6>
                                <div class="mb-2">
                                    @for ($i = 0; $i < 5; $i++)
                                        <small
                                            class="fa{{ $i < $produit->rating ? 's' : 'r' }} fa-star text-warning mr-1"></small>
                                    @endfor
                                </div>
                                <div class="d-flex justify-content-center gap-2 mt-auto">
                                    <a class="btn btn-outline-dark btn-square ajouter-au-panier"
                                        data-id="{{ $produit->id }}" href="javascript:void(0)"
                                        style="width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;"
                                        title="Add to cart">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                    <a class="btn btn-outline-dark btn-square" href="javascript:void(0)"
                                        style="width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;"
                                        title="Add to wishlist">
                                        <i class="far fa-heart"></i>
                                    </a>
                                    <a class="btn btn-outline-dark btn-square" href="javascript:void(0)"
                                        style="width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;"
                                        title="Refresh">
                                        <i class="fas fa-sync-alt"></i>
                                    </a>
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('produit.detail', ['id' => $produit->id]) }}"
                                        style="width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;"
                                        title="View details">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    <div class="col-12 mt-4">
                        <nav>
                            {{ $produits->links('vendor.pagination.bootstrap-4') }}
                        </nav>
                    </div>
                </div>
            </div>
            <!-- Product Section End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection
