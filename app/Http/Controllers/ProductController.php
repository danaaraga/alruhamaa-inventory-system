<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Dummy data untuk testing
        $products = [
            [
                'id' => 1,
                'nama' => 'Beras Premium',
                'deskripsi' => 'Beras berkualitas tinggi untuk konsumsi sehari-hari',
                'harga' => 15000,
                'stok' => 100,
                'gambar' => 'https://via.placeholder.com/300x200?text=Beras+Premium'
            ],
            [
                'id' => 2,
                'nama' => 'Minyak Goreng',
                'deskripsi' => 'Minyak goreng untuk keperluan dapur',
                'harga' => 25000,
                'stok' => 50,
                'gambar' => 'https://via.placeholder.com/300x200?text=Minyak+Goreng'
            ]
        ];

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Validation dan store logic akan ditambahkan nanti
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        // Show product detail
        return view('products.show');
    }

    public function edit($id)
    {
        // Edit product
        return view('products.edit');
    }

    public function update(Request $request, $id)
    {
        // Update product logic
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Delete product logic
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}