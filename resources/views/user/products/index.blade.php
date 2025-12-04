<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .product-card:hover { transform: translateY(-5px); }
        .product-image { width: 100%; height: 200px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #999; }
        .product-info { padding: 15px; }
        .product-name { font-size: 16px; font-weight: bold; color: #333; margin-bottom: 10px; }
        .product-price { font-size: 18px; color: #E91E63; font-weight: bold; margin-bottom: 10px; }
        .product-stock { color: #666; font-size: 14px; margin-bottom: 10px; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 14px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #AD1457; }
        .logout-btn { background: #f44336; padding: 8px 15px; border-radius: 4px; color: white; cursor: pointer; border: none; }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h2>UMKM Makanan</h2>
        </div>
        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('user.products.index') }}">Produk</a>
            <a href="{{ route('user.orders.index') }}">Pesanan</a>
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h1>Daftar Produk</h1>
        
        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span>No Image</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="product-stock">Stok: {{ $product->stock }}</div>
                        <a href="{{ route('user.products.show', $product->id) }}" class="btn btn-primary" style="display: block; text-align: center; margin-top: 10px;">Lihat Detail</a>
                    </div>
                </div>
            @endforeach
        </div>

        @if($products->count() == 0)
            <p style="text-align: center; margin-top: 40px; color: #666;">Tidak ada produk yang tersedia.</p>
        @endif
    </div>
</body>
</html>
