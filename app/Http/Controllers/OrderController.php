<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

use Inertia\Inertia;

class OrderController extends Controller
{



public function show(Request $request)
    {

        dd($request->order);
                  return Inertia::render('Orders/Ticket', [
                    'order' => $order,
                ]);
    }

}
