<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\Stock;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ResponseTrait;

    public function addToCart(Request $request)
    {
        try {
            $rfid = $request->rfid;
            $qty = 1;

            $data = Cart::where('status', 2)->where('user', $request->user)->with('cartproducts')->latest()->first();
            $isRFIDProduct = Stock::where('status', 1)->where('rfid', $rfid)->with('productdata')->first();

            if ($isRFIDProduct && $isRFIDProduct->productdata) {
                $product = $isRFIDProduct->productdata;
                if (!$data) {
                    $data = Cart::create([
                        'user' => $request->user,
                        'total' => 0,
                    ]);
                }


                if ($data && $product && $product->qty >= $qty) {
                    $isNew = true;

                    if ($data->cartproducts) {
                        foreach ($data->cartproducts as $key => $value) {
                            if ($rfid  == $value->rfid) {
                                error_log('already added');
                                $isNew = false;
                                break;
                            }
                        }
                    }

                    if ($isNew) {
                        error_log('new added');
                        CartProduct::create([
                            'cart' => $data->id,
                            'product' => $product->id,
                            'qty' => $qty,
                            'rfid' => $rfid,
                            'total' =>  $product->price * $qty,
                        ]);
                    }
                }
            }
        } catch (Error $e) {
            error_log($e->getMessage());
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
        return $this->getProducts($request);
    }

    public function getProducts(Request $request)
    {
        $dataResp = [];
        $data = Cart::where('status', 2)->where('user', $request->user)->with('cartproducts')->latest()->first();
        if ($data && $data->cartproducts && count($data->cartproducts)) {
            $total = 0.0;
            foreach ($data->cartproducts as $key => $value) {
                $isNew = true;
                $index = 0;
                foreach ($dataResp as $keyD => $valueD) {
                    if ($value->product == $valueD->id) {
                        $dataResp[$index]->qty = $dataResp[$index]->qty + 1;
                        $dataResp[$index]->price = $dataResp[$index]->price * $dataResp[$index]->qty;
                        $isNew = false;
                        break;
                    }
                    $index++;
                }

                if ($isNew) {
                    $product = $value->productdata;
                    $product->cartid = $value->id;
                    $product->qty = $value->qty;
                    $product->price = $value->total;

                    $total += $value->total;

                    $dataResp[] = $product;
                }
            }
            $dataResp[0]['total_price'] = format_currency($total);
        }
        return $this->successResponse(code: 200, data: ['products' => $dataResp, 'orderNumber' => ($data) ? '#' . str_pad($data->id, 5, "0", STR_PAD_LEFT) : null]);
    }

    public function getPaidProducts(Request $request)
    {
        $dataResp = [];
        $data = Cart::where('status', 1)->where('id', $request->id)->with('cartproducts')->latest()->first();
        if ($data && $data->cartproducts && count($data->cartproducts)) {
            $total = 0.0;
            foreach ($data->cartproducts as $key => $value) {
                $isNew = true;
                $index = 0;
                foreach ($dataResp as $keyD => $valueD) {
                    if ($value->product == $valueD->id) {
                        $dataResp[$index]->qty = $dataResp[$index]->qty + 1;
                        $dataResp[$index]->price = $dataResp[$index]->price * $dataResp[$index]->qty;
                        $isNew = false;
                        break;
                    }
                    $index++;
                }

                if ($isNew) {
                    $product = $value->productdata;
                    $product->cartid = $value->id;
                    $product->qty = $value->qty;
                    $product->price = $value->total;

                    $total += $value->total;

                    $dataResp[] = $product;
                }
            }
            $dataResp[0]['total_price'] = format_currency($total);
        }
        return $this->successResponse(code: 200, data: ['products' => $dataResp, 'orderNumber' => ($data) ? '#' . str_pad($data->id, 5, "0", STR_PAD_LEFT) : null]);
    }

    public function removeCartProduct(Request $request)
    {
        CartProduct::where('id', $request->id)->delete();
        return $this->successResponse(code: 200);
    }

    public function paymentDone(Request $request)
    {
        $data = Cart::where('status', 2)->where('user', $request->user)->with('cartproducts')->latest()->first();
        if ($data && $data->cartproducts) {
            $total = 0.0;
            $rfIds = [];
            foreach ($data->cartproducts as $key => $value) {
                $total += $value->total;
                Product::where('id', $value->product)->decrement('qty', $value->qty);
                $rfIds[] = $value->rfid;
            }
            Cart::where('id', $data->id)->update(['total' => $total]);
            Stock::whereIn('rfid', $rfIds)->update(['status' => 2]);
            $data->update(['status' => 1]);
        }
        return $this->successResponse(code: 200, data: 2);
    }

    public function historyGet(Request $request)
    {
        return $this->successResponse(code: 200, data: Cart::whereIn('status', [1, 4])->where('user', $request->user)->with('cartproducts')->orderByDesc('id')->get());
    }

    public function verifyPayment(Request $request)
    {
        try {
            Cart::where('status', 1)->where('id', $request->id)->update(['status' => 4]);
            return $this->successResponse(code: 200, data: 2);
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}
