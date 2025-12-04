<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Untuk User: Lihat pesanan mereka
    public function index()
    {
        $orders = Auth::user()->orders()->with('orderItems.product')->get();
        return view('user.orders.index', ['orders' => $orders]);
    }

    // Untuk User: Lihat detail pesanan
    public function show($id)
    {
        $order = Order::findOrFail($id);
        
        // Pastikan user hanya bisa lihat pesanan mereka sendiri
        if ($order->user_id != Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');
        return view('user.orders.show', ['order' => $order]);
    }

    // Untuk User: Form pemesanan
    public function create()
    {
        $products = Product::where('status', 'active')->get();
        return view('user.orders.create', ['products' => $products]);
    }

    // Untuk User: Simpan pesanan
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $totalAmount = 0;
        $orderItems = [];

        // Validasi dan hitung total
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $quantity = $item['quantity'];

            if ($product->stock < $quantity) {
                return back()->withErrors(['stock' => "Stok produk {$product->name} tidak cukup."]);
            }

            $totalAmount += $product->price * $quantity;
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }

        // Buat order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        // Buat order items
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            // Kurangi stok produk
            $product = Product::find($item['product_id']);
            $product->update(['stock' => $product->stock - $item['quantity']]);
        }

        return redirect()->route('user.orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }

    // Untuk Admin: Lihat semua pesanan
    public function adminIndex()
    {
        $orders = Order::with('user', 'orderItems.product')->get();
        return view('admin.orders.index', ['orders' => $orders]);
    }

    // Untuk Admin: Lihat detail pesanan
    public function adminShow($id)
    {
        $order = Order::findOrFail($id);
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', ['order' => $order]);
    }

    // Untuk Admin: Update status pesanan
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
