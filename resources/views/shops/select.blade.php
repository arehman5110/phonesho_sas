<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Shop — PhoneShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .shop-card {
            border: 2px solid #e9ecef;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            background: #fff;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .shop-card:hover {
            border-color: #0d6efd;
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(13,110,253,0.15);
            color: inherit;
        }
        .shop-icon {
            width: 64px;
            height: 64px;
            background: #e7f0ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            color: #0d6efd;
        }
        .shop-card.active-shop {
            border-color: #0d6efd;
            background: #f0f6ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                {{-- Header --}}
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Select a Shop</h3>
                    <p class="text-muted">Choose which shop you want to work in</p>
                </div>

                {{-- Alert --}}
                @if(session('error'))
                    <div class="alert alert-danger rounded-3">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Shop Cards --}}
                <div class="row g-3">
                    @forelse($shops as $shop)
                        <div class="col-md-6">
                            <form method="POST" action="{{ route('shop.switch') }}">
                                @csrf
                                <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                                <button type="submit" class="shop-card w-100 border-0
                                    {{ auth()->user()->active_shop_id == $shop->id ? 'active-shop' : '' }}">

                                    <div class="shop-icon">
                                        @if($shop->logo)
                                            <img src="{{ asset('storage/'.$shop->logo) }}"
                                                 alt="{{ $shop->name }}"
                                                 class="rounded-circle"
                                                 width="48" height="48"
                                                 style="object-fit:cover;">
                                        @else
                                            <i class="bi bi-shop"></i>
                                        @endif
                                    </div>

                                    <h5 class="fw-semibold mb-1">{{ $shop->name }}</h5>

                                    @if($shop->city)
                                        <small class="text-muted">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $shop->city }}
                                        </small>
                                    @endif

                                    @if(auth()->user()->active_shop_id == $shop->id)
                                        <div class="mt-2">
                                            <span class="badge bg-primary">
                                                <i class="bi bi-check-circle"></i> Active
                                            </span>
                                        </div>
                                    @endif

                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning text-center rounded-3">
                                <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                                You are not assigned to any shop yet.
                                <br>
                                <small>Please contact your administrator.</small>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Logout --}}
                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted">
                            <i class="bi bi-box-arrow-left"></i> Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
