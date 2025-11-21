<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class MenuApiController extends Controller
{
    public function index()
    {
        $products = Product::all(); 
        return response()->json($products);
    }

    public function sync(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|string', // firebase id
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'stok' => 'required|integer',
            'image_url' => 'nullable|string', // kalau sudah ada link Supabase
            'image' => 'nullable|file|image|max:2048', // kalau upload file
        ]);

        $imageUrl = $validated['image_url'] ?? null;

        // ✅ Kalau user kirim file gambar, upload ke Supabase
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Upload ke Supabase via API (gunakan token & project ID kamu)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_KEY'),
                'apikey' => env('SUPABASE_API_KEY'),
                'Content-Type' => 'application/octet-stream',
            ])->put(
                env('SUPABASE_URL') . "/storage/v1/object/product-images/{$filename}",
                file_get_contents($file)
            );

            if ($response->successful()) {
                $imageUrl = env('SUPABASE_URL') . "/storage/v1/object/public/product-images/{$filename}";
            }
        }

        // Simpan atau update produk
        Product::updateOrCreate(
            ['firebase_id' => $validated['id'] ?? null],
            [
                'name' => $validated['name'],
                'price' => $validated['price'],
                'description' => $validated['description'] ?? '',
                'stok' => $validated['stok'],
                'image_url' => $imageUrl, // dari Supabase
            ]
        );

        return response()->json([
            'message' => 'Produk tersinkron ke MySQL',
            'image_url' => $imageUrl
        ], 200);
    }
}
