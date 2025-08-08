<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

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
                'gambar' => 'https://www.rukita.co/stories/wp-content/uploads/2022/05/sack-rice-with-rice-wooden-spoon-scaled.jpg'
            ],
            [
                'id' => 2,
                'nama' => 'Minyak Goreng',
                'deskripsi' => 'Minyak goreng untuk keperluan dapur',
                'harga' => 25000,
                'stok' => 50,
                'gambar' => 'https://allofresh.id/blog/wp-content/uploads/2023/08/merek-minyak-goreng-4.jpg'
            ]
        ];
        $category = Kategori::paginate(5);

        return view('products.index', compact(['products','category']));
    }

    public function create()
    {
        $category = Kategori::paginate(5);

        return view('products.create', compact('category'));
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