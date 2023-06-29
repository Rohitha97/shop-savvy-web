<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usersCount = User::getData(true)->where('usertype', 3)->count();
        $todaySales = Cart::whereIn('status', [1, 4])->whereDate('created_at', Carbon::now())->sum('total');
        $totalSales = Cart::whereIn('status', [1, 4])->sum('total');
        $productsCount = Product::getData(true)->count();


        $data = [];

        foreach (Cart::whereIn('status', [1, 4])->where('created_at', '>=', Carbon::now()->subDays(10))->get() as $key => $value) {

            $date = Carbon::parse($value->created_at)->format('Y-m-d');

            if (array_key_exists($date, $data)) {
                $data[$date] = $data[$date] + (float)$value->total;
            } else {
                $data[$date] = (float)$value->total;
            }
        }

        $x = array_keys($data);
        $y = array_values($data);
        $thisMonth = Cart::whereIn('status', [1, 4])->whereMonth('created_at', Carbon::now())->sum('total');
        $lastMonth = Cart::whereIn('status', [1, 4])->whereMonth('created_at', Carbon::now()->subMonth())->sum('total');

        return view('home', compact(['usersCount', 'todaySales', 'totalSales', 'x', 'y', 'productsCount', 'thisMonth', 'lastMonth']));
    }
}
