<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()->with(['brand', 'subcategory.category']);

        // Filtros (si vienen)
        if ($request->filled('id_categoria')) {
            $query->whereHas('subcategory', function ($q) use ($request) {
                $q->where('id_categoria', $request->id_categoria);
            });
        }

        if ($request->filled('id_subcategoria')) {
            $query->where('id_subcategoria', $request->id_subcategoria);
        }

        if ($request->filled('id_marca')) {
            $query->where('id_marca', $request->id_marca);
        }

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where('nombre', 'like', "%{$q}%");
        }

        $products = $query->orderByDesc('id_producto')->paginate(12)->withQueryString();

        // Para armar filtros en la vista
        $categories = Category::orderBy('nombre')->get();
        $subcategories = Subcategory::orderBy('nombre')->get();
        $brands = Brand::orderBy('nombre')->get();

        return view('store.index', compact('products', 'categories', 'subcategories', 'brands'));
    }

    public function show(int $id)
    {
        $product = Product::with(['brand', 'subcategory.category'])->findOrFail($id);
        return view('store.show', compact('product'));
    }
}
