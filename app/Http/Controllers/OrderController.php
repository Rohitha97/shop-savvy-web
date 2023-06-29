<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $query = Cart::whereIn('status',[1,4]);

        if ($request->has('start') && $request->filled('start')) {
            $query->where('created_at', '>=', $request->start);
        }

        if ($request->has('end') && $request->filled('end')) {
            $query->where('created_at', '<', $request->end);
        }

        $orders = $query->orderBy('created_at', 'DESC')->paginate(10);
        return view('pages.orders', compact(['orders']));
    }

    function statusUpdate($order, $orderStatus)
    {
        Cart::where('id', $order)->update(['status' => $orderStatus]);
        return Redirect::to(route('admin.orders'));
    }

    function get()
    {
        $data = [];
        $order = Cart::where('status', 2)->first();
        if ($order) {
            $order->update(['status' => 3]);
            foreach ($order->cartproducts as $key => $value) {
                $data[] = ['id' => $value->product, 'qty' => $value->qty];
            }
        }
        return $data;
    }

    function view(Request $request)
    {
        $data = CartProduct::where('cart', $request->id)->with('productdata')->get();
        return view('pages.orders-view', compact('data'));
    }
}
