<?php
namespace App\Api\V1\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Api\V1\Controllers\Controller;
use App\libraries\tgMdk\Lib\tgMdkDto\CardAuthorizeRequestDto;
use App\libraries\tgMdk\Lib\TGMDK_Transaction;
use App\Order;
use App\Product;
use App\Setting;
class OrderController extends Controller
{
    public function execute(Request $request)
    {
        $product = Product::find($request->product_id);
        $request_data = new CardAuthorizeRequestDto();
        $order_id = "dummy".time();
        $is_with_capture = 1;
        $request_data->setOrderId($order_id);
        $request_data->setAmount($product->price);
        $request_data->setToken($request->card_token);
        $request_data->setWithCapture($is_with_capture);
        $transaction = new TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        //handle Order
        // $product = Product::find($request->product_id);
        // //get order ID
        // $order_id = Setting::where('key','order_id')->first();
        // $order_id_prefix = Setting::where('key','order_id_prefix')->first()->value;
        // $order = new Order;
        // $order->user_id = auth()->user()->id;
        // $order->product_id = $request->product_id;
        // $order->order_id = $order_id->value;
        // $order->qty = 1;
        // $order->price = $product->price;
        // $order->evaluation = -1;
        // $order->address_id = $request->address_id;
        // $order->status_id = 0;
        // $order->save();

        // $order_id->increment('value');
        // $order_id->save();

        // $response = [];

        // $response['id'] = $order->id;
        // $response['product'] = [];
        // $response['product']['label']   = $product->label;
        // $response['product']['number']  = $product->number;
        // $response['price']              = $order->price;
        // $response['order_id']           = $order_id_prefix.sprintf("%010d", $order->order_id);
        // $response['date']               = $order->created_at->format('Y/m/d H:i');
        // $response['address'] = $order->rDAddress;
        // $response['store'] = $product->StoreInfo;
        // $response['evaluation'] = $order->evaluation;

        // return response()->json($response);
    }

    public function show($id)
    {

    }
}
