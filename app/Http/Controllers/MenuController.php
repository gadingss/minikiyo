<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        // Mapping image URL
        $products = $products->map(function ($product) {
            $product->image = $product->image_url
                ? asset('storage/' . $product->image_url)
                : asset('images/default.png');
            return $product;
        });

        // Group by category
        $menuData = $products->groupBy(function ($item) {
            return $item->category ? strtolower($item->category->name) : 'tanpa_kategori';
        });

        // --- Ambil rekomendasi produk user ---
        $userId = Auth::id();

        $recommendedProductIds = DB::table('order_items')
            ->select('product_id', DB::raw('COUNT(*) as total'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', $userId)
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->take(5) // ambil 5 produk teratas
            ->pluck('product_id');

        $recommendedProducts = Product::whereIn('id', $recommendedProductIds)
            ->get()
            ->map(function ($product) {
                $product->image = $product->image_url
                    ? asset('storage/' . $product->image_url)
                    : asset('images/default.png');
                return $product;
            });

        return view('menu', compact('menuData', 'recommendedProducts'));
    }
}
