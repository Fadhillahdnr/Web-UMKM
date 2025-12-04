<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Admin UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        th { background: #E91E63; color: white; padding: 15px; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f9f9f9; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 14px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #AD1457; }
        .btn-danger { background: #f44336; color: white; }
        .btn-danger:hover { background: #da190b; }
        .btn-success { background: #E91E63; color: white; }
        .btn-success:hover { background: #AD1457; }
        .logout-btn { background: #f44336; padding: 8px 15px; border-radius: 4px; color: white; cursor: pointer; border: none; }
        .success { color: green; padding: 10px; background: #e8f5e9; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="navbar">
        <div>
            <h2>UMKM Makanan - Admin</h2>
        </div>
        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('admin.products.index') }}">Produk</a>
            <a href="{{ route('admin.orders.index') }}">Pesanan</a>
            <span>{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h1>Kelola Produk</h1>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <a href="{{ route('admin.products.create') }}" class="btn btn-success" style="margin-bottom: 20px;">+ Tambah Produk</a>

        @if($products->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span style="padding: 3px 8px; border-radius: 4px; background: {{ $product->status == 'active' ? '#E91E63' : '#f44336' }}; color: white;">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada produk.</p>
        @endif
    </div>
</body>
</html>
