<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // “Más vendidos”: si no tenés campo de ventas, mostramos últimos productos
        $featured = Product::with('brand', 'subcategory')
            ->orderByDesc('id_producto')
            ->take(8)
            ->get();

        $brands = Brand::orderBy('nombre')->get();

        return view('home', compact('featured', 'brands'));
    }

    public function about()
    {
        return view('about');
    }
}