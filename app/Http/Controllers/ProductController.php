<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCart;
use App\Http\Resources\ProductsCollection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {



        $products = Product::get();

                  return Inertia::render('Products/index', [
                    'products' => $products,
                ]);



        //return view("products.index");
        /*$products = Product::paginate(15);  //traigo todos los productos

        if($request->wantsJson()){ //devuelve falso o verdadero
          return new ProductsCollection($products); //si devuelve verdadero regresa info en tipo json
        } */




        //return view('products.index',['products' => $products]); //mando los productos en
        //una variable $products a la vista

    }

    public function products_get(Request $request)
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function save_product(Request $request)
    {

        $product = new Product();
        $product->title = $request->title;
        $product->categoria = $request->categoria;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('/images', 'public');
            $product->image_url = '/storage/'.$path;
        }

        $product->save();
        return true;
    }

    public function update_product(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->title = $request->title;
        $product->categoria = $request->categoria;
        $product->description = $request->description;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($product->image_url) {
                Storage::disk('public')->delete($product->image_url);
            }

            $path = $request->file('image')->store('/images', 'public');
            $product->image_url = '/storage/'.$path;
        }

        $product->update();

        return response()->json($product, 200);
    }
}
