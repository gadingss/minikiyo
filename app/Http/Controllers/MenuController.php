<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        $products = $products->map(function ($product) {
            $product->image = $product->image_url 
                ? asset('storage/' . $product->image_url)  // ✅ gunakan storage link
                : asset('images/default.png');             // fallback gambar default
            return $product;
        });

        $menuData = $products->groupBy(function ($item) {
            return $item->category ? strtolower($item->category->name) : 'tanpa_kategori';
        });

        return view('menu', compact('menuData'));
    }

}
