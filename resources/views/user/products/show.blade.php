<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .back-link { color: #E91E63; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .back-link:hover { text-decoration: underline; }
        .detail-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .product-image { width: 100%; height: 400px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999; }
        .product-image img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
        .product-details h1 { color: #333; margin-bottom: 20px; }
        .product-price { font-size: 24px; color: #E91E63; font-weight: bold; margin-bottom: 10px; }
        .product-stock { color: #666; margin-bottom: 20px; }
        .product-description { color: #666; line-height: 1.6; margin-bottom: 20px; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 16px; }
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
        <a href="{{ route('user.products.index') }}" class="back-link">← Kembali ke Produk</a>
        
        <div class="detail-container">
            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                    <span>No Image</span>
                @endif
            </div>
            
            <div class="product-details">
                <h1>{{ $product->name }}</h1>
                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="product-stock">Stok tersedia: <strong>{{ $product->stock }}</strong></div>
                <div class="product-description">
                    <h3 style="margin-bottom: 10px;">Deskripsi</h3>
                    {{ $product->description ?? 'Tidak ada deskripsi.' }}
                </div>
                
                <a href="{{ route('user.orders.create') }}" class="btn btn-primary">Pesan Sekarang</a>
            </div>
        </div>
    </div>
</body>
</html>
