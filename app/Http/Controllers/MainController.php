<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Product;


class MainController extends Controller
{
    public function home(Request $request){
        $title = $request->get('title');

        $products = Product::all();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => $products,
        ]);
    }
}
