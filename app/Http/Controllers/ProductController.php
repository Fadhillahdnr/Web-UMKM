<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Untuk User: Lihat daftar produk
    public function index()
    {
        $products = Product::where('status', 'active')->get();
        return view('user.products.index', ['products' => $products]);
    }

    // Untuk User: Lihat detail produk
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('user.products.show', ['product' => $product]);
    }

    // Untuk Admin: Lihat daftar semua produk
    public function adminIndex()
    {
        $products = Product::all();
        return view('admin.products.index', ['products' => $products]);
    }

    // Untuk Admin: Form tambah produk
    public function create()
    {
        return view('admin.products.create');
    }

    // Untuk Admin: Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Untuk Admin: Form edit produk
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product]);
    }

    // Untuk Admin: Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Untuk Admin: Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
