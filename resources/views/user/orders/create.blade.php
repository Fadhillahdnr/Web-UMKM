<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pesanan - UMKM Makanan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #E91E63; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; }
        .navbar a { color: white; text-decoration: none; margin-right: 20px; }
        .navbar a:hover { text-decoration: underline; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        h1 { color: #333; margin-bottom: 30px; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #E91E63; }
        textarea { resize: vertical; min-height: 80px; }
        .items-section { margin-top: 20px; padding: 20px; background: #f9f9f9; border-radius: 4px; }
        .item-row { display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 10px; margin-bottom: 15px; padding: 10px; background: white; border-radius: 4px; }
        .btn { padding: 10px 20px; border-radius: 4px; text-decoration: none; cursor: pointer; border: none; font-size: 16px; }
        .btn-primary { background: #E91E63; color: white; }
        .btn-primary:hover { background: #AD1457; }
        .btn-secondary { background: #666; color: white; }
        .btn-secondary:hover { background: #555; }
        .btn-danger { background: #f44336; color: white; }
        .btn-danger:hover { background: #da190b; }
        .btn-add-item { background: #E91E63; color: white; padding: 8px 15px; font-size: 14px; }
        .btn-add-item:hover { background: #AD1457; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
        .back-link { color: #E91E63; text-decoration: none; display: inline-block; margin-bottom: 20px; }
        .back-link:hover { text-decoration: underline; }
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
        <a href="{{ route('user.orders.index') }}" class="back-link">← Kembali ke Pesanan</a>
        
        <div class="form-container">
            <h1>Buat Pesanan Baru</h1>
            
            <form method="POST" action="{{ route('user.orders.store') }}" id="orderForm">
                @csrf

                <div class="items-section">
                    <h3>Item Pesanan</h3>
                    <div id="itemsContainer">
                        <div class="item-row" data-item-index="0">
                            <div>
                                <label>Produk</label>
                                <select name="items[0][product_id]" class="product-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                            {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label>Kuantitas</label>
                                <input type="number" name="items[0][quantity]" class="quantity-input" value="1" min="1" required>
                            </div>
                            <div>
                                <label>Subtotal</label>
                                <input type="text" class="subtotal-display" readonly disabled>
                            </div>
                            <div style="display: flex; align-items: flex-end;">
                                <button type="button" class="btn btn-danger btn-remove-item" style="padding: 8px 12px; font-size: 14px;">Hapus</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-add-item" id="addItemBtn">+ Tambah Item</button>
                </div>

                <div class="form-group">
                    <label for="notes">Catatan (opsional)</label>
                    <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
                </div>

                <div style="background: #f0f0f0; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
                    <h3>Total Pesanan: <span id="totalAmount">Rp 0</span></h3>
                </div>

                <button type="submit" class="btn btn-primary">Buat Pesanan</button>
                <a href="{{ route('user.orders.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Batal</a>
            </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        function updateSubtotals() {
            let total = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                const productSelect = row.querySelector('.product-select');
                const quantityInput = row.querySelector('.quantity-input');
                const subtotalDisplay = row.querySelector('.subtotal-display');
                
                const price = productSelect.selectedOptions[0]?.dataset.price || 0;
                const quantity = quantityInput.value || 0;
                const subtotal = price * quantity;
                
                subtotalDisplay.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
                total += parseFloat(subtotal);
            });
            
            document.getElementById('totalAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        document.getElementById('addItemBtn').addEventListener('click', () => {
            const container = document.getElementById('itemsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'item-row';
            newRow.dataset.itemIndex = itemIndex;
            newRow.innerHTML = `
                <div>
                    <label>Produk</label>
                    <select name="items[${itemIndex}][product_id]" class="product-select" required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                {{ $product->name }} (Rp {{ number_format($product->price, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Kuantitas</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="quantity-input" value="1" min="1" required>
                </div>
                <div>
                    <label>Subtotal</label>
                    <input type="text" class="subtotal-display" readonly disabled>
                </div>
                <div style="display: flex; align-items: flex-end;">
                    <button type="button" class="btn btn-danger btn-remove-item" style="padding: 8px 12px; font-size: 14px;">Hapus</button>
                </div>
            `;
            container.appendChild(newRow);
            
            newRow.querySelector('.product-select').addEventListener('change', updateSubtotals);
            newRow.querySelector('.quantity-input').addEventListener('input', updateSubtotals);
            newRow.querySelector('.btn-remove-item').addEventListener('click', () => {
                newRow.remove();
                updateSubtotals();
            });
            
            itemIndex++;
            updateSubtotals();
        });

        document.querySelectorAll('.product-select').forEach(select => {
            select.addEventListener('change', updateSubtotals);
        });

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('input', updateSubtotals);
        });

        document.querySelectorAll('.btn-remove-item').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.target.closest('.item-row').remove();
                updateSubtotals();
            });
        });

        updateSubtotals();
    </script>
</body>
</html>
