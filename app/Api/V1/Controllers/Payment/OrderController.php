<?php
namespace App\Api\V1\Controllers\Payment;

use Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Api\V1\Controllers\Controller;
use App\Libraries\tgMdk\Lib\CardAuthorizeRequestDto;
use App\Libraries\tgMdk\Lib\TGMDK_Transaction;
use App\Order;
use App\Product;
use App\Setting;
class OrderController extends Controller
{
    public function execute(Request $request)
    {
        $product = Product::find($request->product_id);
        $request_data = new CardAuthorizeRequestDto();
        $order_id = "RO".time();
        $is_with_capture = 1;
        $request_data->setOrderId($order_id);
        $request_data->setAmount($product->price);
        $request_data->setCardNumber($request->cardNumber);
        $request_data->setCardExpire($request->expire);
        $request_data->setSecurityCode($request->securityCode);
        $request_data->setToken($request->card_token);
        $request_data->setWithCapture($is_with_capture);
        $transaction = new TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        if ($response_data->getMstatus() == 'failure') {
            $response = [];
            $response['success']            = $response_data->getMstatus();
            $response['msessage']           = $response_data->getMerrMsg();
            return response()->json($response);
        }

        // handle Order
        $product = Product::find($request->product_id);
        //get order ID
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->product_id = $request->product_id;
        $order->order_id = $order_id;
        $order->qty = 1;
        $order->price = $product->price;
        $order->evaluation = -1;
        $order->address_id = $request->address_id;
        $order->status_id = 0;
        $order->save();

        $response = [];

        $response['id'] = $order->id;
        $response['product'] = [];
        $response['product']['label']   = $product->label;
        $response['product']['number']  = $product->number;
        $response['price']              = $order->price;
        $response['order_id']           = $order_id;
        $response['date']               = $order->created_at->format('Y/m/d H:i');
        $response['address']            = $order->rDAddress;
        $response['store']              = $product->StoreInfo;
        $response['evaluation']         = $order->evaluation;
        $response['success']            = $response_data->getMstatus();
        $response['msessage']           = $response_data->getMerrMsg();
        $response['tranxid']            = $response_data->getCustTxn();

        return response()->json($response);
    }

    public function show($id)
    {

    }

    public function getTransactions() {
        $user = auth()->user();
        $store = $user->rStore;
        $response = [];
        
        $products = $store->rProduct;
        
        foreach($products as $product) {
            $transactions = $product->rOrder;

            foreach($transactions as $transaction) {
                $data = [];
                $data["id"] = $transaction->id;
                $data["number"] = $transaction->order_id;
                $data["quantity"] = $transaction->qty;
                $data["price"] = $transaction->price;
                $data["status"] = $transaction->status_id;
                $data["deliveryFee"] = $transaction->delivery_fee;
                $data["orderDate"] = $transaction->created_at;
                $data["product"] = [
                    "id" => $transaction->rProduct->id,
                    "title" => $transaction->rProduct->label,
                    "number" => $transaction->rProduct->number,
                    "thumbnail" => asset(Storage::url('ProductPortfolio')).'/'.$transaction->rProduct->Thumbnail(),
                ];

                $data["user"] = [
                    "id" => $transaction->rUser->id,
                    "nickname" => $transaction->rUser->nickname,
                ];

                $data["address"] = [
                    "id" => $transaction->rDAddress->id,
                    "postalCode" => $transaction->rDAddress->postal_code,
                    "houseNo" => $transaction->rDAddress->houst_number,
                    "street" => $transaction->rDAddress->street,
                    "state" => $transaction->rDAddress->rState->name,
                    "county" => $transaction->rDAddress->county,
                    "company" => $transaction->rDAddress->company,
                    "firstname" => $transaction->rDAddress->firstname_1,
                    "lastname" => $transaction->rDAddress->lastname_1,
                ];

                $response[] = $data;
            }
        }

        return response()->json($response);
    }

    public function getSellHistory() {
        $user = auth()->user();
        $store = $user->rStore;
        $products = $store->rProduct;
        $response = [];
        $dataPerDate = [];
        $dataPerMonth = [];
        foreach($products as $product) {
            $transactions = $product->rOrder()->orderBy("created_at", "desc")->get()->groupBy(function($item) {
                return $item->created_at->format('yy-m-d');
            });

            foreach ($transactions as $dateStr => $values) {
                $ordersPerDate = [];
                $price = 0;
                if (array_key_exists($dateStr, $dataPerDate)) {
                    $ordersPerDate = $dataPerDate[$dateStr];
                    $price = $ordersPerDate["price"];
                }

                foreach ($values as $value) {
                    $data = [];
                    $data["id"] = $value["id"];
                    $data["number"] = $value["order_id"];
                    $data["quantity"] = $value["qty"];
                    $data["price"] = $value["price"];
                    $data["status"] = $value["status_id"];
                    $data["deliveryFee"] = $value["delivery_fee"];
                    $data["orderDate"] = $value["created_at"];
                    $data["product"] = [
                        "id" => $product->id,
                        "title" => $product->label,
                        "number" => $product->number,
                        "thumbnail" => asset(Storage::url('ProductPortfolio')).'/'.$product->Thumbnail(),
                    ];

                    $ordersPerDate["price"] = $price + $value["price"];
                    $ordersPerDate["order"][] = $data;
                }
                

                $dataPerDate[$dateStr] = $ordersPerDate;
            }
        }

        
        foreach ($dataPerDate as $dateStr => $values ) {

            $dateMonth = substr($dateStr, 0, 7);

            $datas = [];
            $price = 0;
            if (array_key_exists($dateMonth, $dataPerMonth)) {
                $datas = $dataPerMonth[$dateMonth];
                $price = $datas["totalPrice"];
            }

            $datas[$dateStr] = $values;
            $datas["totalPrice"] = $price + $values["price"];
            $dataPerMonth[$dateMonth] = $datas;
        }

        $response = $dataPerMonth;

        return response()->json($response);
    }
}
