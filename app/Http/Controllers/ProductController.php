<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Produk;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Produk::with('category') // ambil data kategori juga
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->paginate(10);

        $category = Kategori::all();

        return view('products.index', compact(['products','category']));
    }

    public function create()
    {
        $category = Kategori::paginate(5);

        return view('products.create', compact('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'kategori_id' => 'required|int|max:255',
        ]);

                  $price = preg_replace('/[^0-9]/', '', $request->harga); // hapus semua selain angka

        // Kalau pakai DECIMAL dan mau simpan dalam format 1.200.000,00
                  $price = number_format($price, 2, '.', ''); 
                 // Ambil kode kategori (3 huruf pertama)
                $kodeKategori = strtoupper(Str::limit(preg_replace('/\s+/', '', $request->kategori_id), 3, ''));

                 // Ambil kode nama (3 huruf pertama)
                $kodeNama = strtoupper(Str::limit(preg_replace('/\s+/', '', $request->nama), 3, ''));

                // Ambil 4 digit harga terakhir
                $kodeHarga = str_pad(substr((int)$request->harga, -4), 4, '0', STR_PAD_LEFT);

                // SKU Final
                $sku = $kodeKategori . '-' . $kodeNama . '-' . $kodeHarga;

                // Cek apakah SKU ini sudah ada
                $produk = Produk::where('sku', $sku)->first();

                 if ($produk) {
                    // Kalau sudah ada → tambahkan stok
                   $produk->stok += $request->stok;
                    $produk->save();
                 } else {
                // Simpan gambar jika ada
                   $path = null;
                   //
                //  if ($request->hasFile('gambar')) {
                //    $path = $request->file('gambar')->store('foto_produk', 'public');

                 //} 
                 //
                }

     // Kalau belum ada → buat produk baru
     Produk::create([
         'name'      => $request->nama,
         'price'     => $price,
         'category_id'  => $request->kategori_id,
         'satuan'  => $request->satuan,
         'sku'       => $sku,
         'stock_quantity' => $request->stok,
         'description' => $request->deskripsi,
        // 'gambar'    => $path,
     ]);




        
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
    public function save(request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'kategori_id' => 'required|int|max:255',
        ]);

                  $price = preg_replace('/[^0-9]/', '', $request->harga); // hapus semua selain angka

        // Kalau pakai DECIMAL dan mau simpan dalam format 1.200.000,00
                  $price = number_format($price, 2, '.', ''); 
                 // Ambil kode kategori (3 huruf pertama)
                $kodeKategori = strtoupper(Str::limit(preg_replace('/\s+/', '', $request->kategori_id), 3, ''));

                 // Ambil kode nama (3 huruf pertama)
                $kodeNama = strtoupper(Str::limit(preg_replace('/\s+/', '', $request->nama), 3, ''));

                // Ambil 4 digit harga terakhir
                $kodeHarga = str_pad(substr((int)$request->harga, -4), 4, '0', STR_PAD_LEFT);

                // SKU Final
                $sku = $kodeKategori . '-' . $kodeNama . '-' . $kodeHarga;

                // Cek apakah SKU ini sudah ada
                $produk = Produk::where('sku', $sku)->first();

                 if ($produk) {
                    // Kalau sudah ada → tambahkan stok
                   $produk->stok += $request->stok;
                    $produk->save();
                 } else {
                // Simpan gambar jika ada
                   $path = null;
                   //
                //  if ($request->hasFile('gambar')) {
                //    $path = $request->file('gambar')->store('foto_produk', 'public');

                 //} 
                 //
                }

     // Kalau belum ada → buat produk baru
     Produk::create([
         'name'      => $request->nama,
         'price'     => $price,
         'category_id'  => $request->kategori_id,
         'satuan'  => $request->satuan,
         'sku'       => $sku,
         'stock_quantity' => $request->stok,
         'description' => $request->deskripsi,
        // 'gambar'    => $path,
     ]);



     return redirect()->route('products.create')->with('success', 'berhasil menambahkan produk');

    }
}