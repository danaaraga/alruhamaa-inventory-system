<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;

class InventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query data dengan kondisi search
        $products = Produk::with('category') // ambil data kategori juga
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
        })
        ->paginate(10);
        $category = Kategori::all();
        return view('inventory.index', compact(['products','category']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $produkData = $request->input('produk', []);

        foreach ($produkData as $data) {
            $produk = Produk::find($data['id']);
            if ($produk) {
                $produk->update([
                    'name'           => $data['name'],
                    'price'          => $data['price'],
                    'sku'            => $data['sku'],
                    'stock_quantity' => $data['stock_quantity'],
                    'category_id'    => $data['category_id'],
                    'description'    => $data['description'],
                    'satuan'        => $data['satuan']
                ]);
            }
        }
    
        return back()->with('success', 'Semua data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Produk::findOrFail($id);
        $data->delete();
    
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
