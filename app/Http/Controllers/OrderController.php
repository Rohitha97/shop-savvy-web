<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Models\Colors;
use Yajra\DataTables\DataTables;


class OrderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Cart::whereIn('status', [1, 4]);

            if ($request->has('startDate') && $request->filled('startDate')) {
                $startDate = Carbon::parse($request->startDate)->format('Y-m-d');
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($request->has('endDate') && $request->filled('endDate')) {
                $endDate = Carbon::parse($request->endDate)->format('Y-m-d');
                $query->whereDate('created_at', '<', $endDate);
            }



            $orders = $query->orderBy('created_at', 'DESC');

            return DataTables::of($orders)
                ->addColumn('order_number', function ($order) {
                    return '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                })
                ->addColumn('total', function ($order) {
                    return   $order->currency . ' ' . number_format($order->total, 2);
                })
                ->addColumn('created_at', function ($order) {
                    return   $order->created_at;
                })
                ->addColumn('status_label', function ($order) {
                    return '<span class="badge badge-sm bg-gradient-' . (new Colors())->getColor($order['status']) . '">' . Cart::$status[$order['status']] . '</span>';
                })
                ->addColumn('action', function ($order) {
                    return '<div class="d-flex justify-content-end"><button onclick="viewOrder(' . $order->id . ')" class="btn btn-sm btn-info">View</button></div>';
                })
                ->rawColumns(['order_number', 'status_label', 'action', 'total', 'created_at'])
                ->toJson();
        }

        return view('pages.orders');
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
