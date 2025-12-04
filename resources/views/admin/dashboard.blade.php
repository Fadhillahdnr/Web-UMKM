<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-box { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-box h3 { color: #E91E63; font-size: 14px; margin-bottom: 10px; }
        .stat-box .value { font-size: 32px; font-weight: bold; color: #333; }
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
            <h2>UMKM Makanan - Admin</h2>
        </div>
        <div>
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
        <h1>Dashboard Admin</h1>
        
        <div class="stats">
            <div class="stat-box">
                <h3>Total Produk</h3>
                <div class="value">{{ $productsCount }}</div>
            </div>
            <div class="stat-box">
                <h3>Total Pesanan</h3>
                <div class="value">{{ $ordersCount }}</div>
            </div>
            <div class="stat-box">
                <h3>Total Revenue</h3>
                <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
        </div>

        <h2>Pesanan Terbaru</h2>
        @if($recentOrders->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span style="padding: 5px 10px; border-radius: 4px; 
                                    background: {{ $order->status == 'delivered' ? '#E91E63' : ($order->status == 'cancelled' ? '#f44336' : '#FFB74D') }}; 
                                    color: white;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-primary">Lihat</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada pesanan.</p>
        @endif
    </div>
</body>
</html>
