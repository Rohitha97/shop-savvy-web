<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::getData()->get();
        $products = Product::getData()->get();
        return view('pages.stocks', compact(['products', 'stocks']));
    }

    public function add(Request $request)
    {

        try {
            DB::beginTransaction();
            $request->validate([
                'product' => 'required|exists:products,id',
                'rfid' => 'required|string',
                'isnew' => 'required|numeric',
                'record' => 'nullable|numeric',
            ]);

            $data = [
                'product' => $request->product,
                'rfid' => $request->rfid,
                'status' => $request->status ?? 1,
            ];

            if ($request->isnew == 1) {
                Product::find($request->product)->increment('qty');
                Stock::create($data);
            } else {
                Stock::where('id', $request->record)->update($data);
            }
            DB::commit();
            return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Registered' : 'Updated')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with(['code' => 0, 'color' => 'danger', 'msg' => $th->getMessage()]);
        }
    }

    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stocks,id'
        ]);
        $data = Stock::where('id', $request->id)->first();
        if ($data->status == 1) {
            Product::find($request->id)->decrement('qty');
        }
        $data->update(['status' => 3]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stocks,id'
        ]);
        $data = Stock::where('id', $request->id)->first();
        return $data;
    }
}
