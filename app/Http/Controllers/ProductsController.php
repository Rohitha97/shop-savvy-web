<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\Stock;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $products = Product::getData()->paginate(10);
        return view('pages.products', compact(['products']));
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'isnew' => 'required|numeric',
            'record' => 'nullable|numeric',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'status' => $request->status ?? 1,
        ];

        if ($request->has('image')) {
            $data['img'] = $this->uploadImage($request->file('image'), Carbon::now()->format('YmdHs'), $request->image);
        }

        if ($request->isnew == 1) {
            Product::create($data);
        } else {
            Product::where('id', $request->record)->update($data);
        }

        return redirect()->back()->with(['code' => 1, 'color' => 'success', 'msg' => 'Successfully ' . (($request->isnew == 1) ? 'Added' : 'Updated')]);
    }

    public function uploadImage($valid, $name, $file)
    {
        $ext = strtolower($file->getClientOriginalExtension());
        $name = $name . '.' . $ext;
        $upload_path = 'assets/img/products';
        $image_url = $upload_path . $name;
        $file->move($upload_path, $name);
        return $name;
    }


    public function deleteOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);

        Product::where('id', $request->id)->update(['status' => 3]);
        return redirect()->back()->with(['code' => 1, 'color' => 'danger', 'msg' => 'Successfully Removed']);
    }

    public function getOne(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id'
        ]);
        $data = Product::where('id', $request->id)->first();
        return $data;
    }

    //API

    public function get(Request $request)
    {
        $query = Product::getData(true)->where('qty', '>', 0);
        return $this->successResponse(code: 200, data: $query->get());
    }

    public function checkStock($rfid)
    {
        $checkData = Stock::where('rfid', $rfid)->first();
        return ($checkData && $checkData->status == 2) ? 1 : 2;
    }
}
