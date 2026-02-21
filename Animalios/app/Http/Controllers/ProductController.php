<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand','subcategory'])
            ->orderByDesc('id_producto')
            ->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::orderBy('nombre')->get();
        $subcategories = Subcategory::orderBy('nombre')->get();

        return view('admin.products.create', compact('brands','subcategories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
            'precio' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'id_marca' => ['required','integer'],
            'id_subcategoria' => ['required','integer'],
        ]);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success','Producto creado.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('nombre')->get();
        $subcategories = Subcategory::orderBy('nombre')->get();

        return view('admin.products.edit', compact('product','brands','subcategories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'descripcion' => ['nullable','string'],
            'precio' => ['required','numeric','min:0'],
            'stock' => ['required','integer','min:0'],
            'id_marca' => ['required','integer'],
            'id_subcategoria' => ['required','integer'],
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success','Producto actualizado.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success','Producto eliminado.');
    }
}