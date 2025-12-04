<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan - UMKM Makanan</title>
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
        <h1>Riwayat Pesanan</h1>
        
        @if($orders->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span style="padding: 5px 10px; border-radius: 4px; 
                                    background: {{ $order->status == 'delivered' ? '#E91E63' : ($order->status == 'cancelled' ? '#f44336' : '#FFB74D') }}; 
                                    color: white;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td><a href="{{ route('user.orders.show', $order->id) }}" class="btn btn-primary">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Anda belum memiliki pesanan.</p>
        @endif

        <a href="{{ route('user.orders.create') }}" class="btn btn-primary" style="display: inline-block; margin-top: 20px;">Buat Pesanan Baru</a>
    </div>
</body>
</html>
