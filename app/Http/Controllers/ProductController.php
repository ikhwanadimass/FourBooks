<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('user_id', auth()->id())->get();
        return view('pages.product.index', [
            'products' => $products,
            'title' => 'Produk',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.product.create', [
            'title' => 'Tambah Produk',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.product.edit', [
            'product' => $product,
            'title' => 'Edit Produk',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
