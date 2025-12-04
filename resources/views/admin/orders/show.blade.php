<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .back-link { color: #E91E63; text-decoration: none; margin-bottom: 20px; display: inline-block; }
        .back-link:hover { text-decoration: underline; }
        .detail-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #f5f5f5; padding: 10px; text-align: left; border-bottom: 2px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #ddd; }
        .total { font-weight: bold; font-size: 18px; text-align: right; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 14px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #AD1457; }
        .success { color: green; padding: 10px; background: #e8f5e9; border-radius: 4px; margin-bottom: 20px; }
        .logout-btn { background: #f44336; padding: 8px 15px; border-radius: 4px; color: white; cursor: pointer; border: none; }
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
        <a href="{{ route('admin.orders.index') }}" class="back-link">← Kembali ke Pesanan</a>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        
        <div class="detail-box">
            <h1>Detail Pesanan #{{ $order->id }}</h1>
            <p><strong>Pelanggan:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Status:</strong> 
                <span style="padding: 5px 10px; border-radius: 4px; 
                    background: {{ $order->status == 'delivered' ? '#E91E63' : ($order->status == 'cancelled' ? '#f44336' : '#FFB74D') }}; 
                    color: white;">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
            @if($order->notes)
                <p><strong>Catatan:</strong> {{ $order->notes }}</p>
            @endif

            <div style="margin-top: 20px;">
                <h3>Ubah Status Pesanan</h3>
                <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <select name="status" required>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Terima</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Perbarui Status</button>
                </form>
            </div>
        </div>

        <div class="detail-box">
            <h2>Item Pesanan</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
