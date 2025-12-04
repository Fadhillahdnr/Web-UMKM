<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 600px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #E91E63; }
        textarea { resize: vertical; min-height: 100px; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 16px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #AD1457; }
        .btn-secondary { background: #666; color: white; }
        .btn-secondary:hover { background: #555; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
        .back-link { color: #E91E63; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .back-link:hover { text-decoration: underline; }
        .logout-btn { background: #f44336; padding: 8px 15px; border-radius: 4px; color: white; cursor: pointer; border: none; }
        .image-preview { width: 150px; height: 150px; background: #e0e0e0; border-radius: 4px; margin-top: 10px; display: flex; align-items: center; justify-content: center; color: #999; }
        .image-preview img { width: 100%; height: 100%; object-fit: cover; border-radius: 4px; }
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
        <a href="{{ route('admin.products.index') }}" class="back-link">← Kembali ke Produk</a>
        
        <div class="form-container">
            <h1>Edit Produk</h1>
            
            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea id="description" name="description">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
                    @error('stock')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Gambar</label>
                    @if($product->image)
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </div>
                    @endif
                    <input type="file" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>
