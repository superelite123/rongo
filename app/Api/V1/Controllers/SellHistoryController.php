<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Address;
use App\State;
use App\Live;
use App\Product;
use App\Order;
use App\UserSetting;
use Storage;
use App\Traits\LoadList;
use DB;
class SellHistoryController extends Controller
{
    use LoadList;
    public function index()
    {
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

    public function getDetail(Request $request)
    {
        $response = ['date' => $request->date];
        $dbResult = DB::table('lives')
        ->select(
            DB::raw('lives.id as lid'),DB::raw('lives.photo as lPhoto'),DB::raw('products.id as pid'),
            DB::raw('products.label as pLabel'),DB::raw('products.number as pNumber'),
            DB::raw('orders.id as oid'),DB::raw('orders.price as oPrice'),

        )
        ->join('live_has_product','lives.id','=','live_has_product.live_id')
        ->join('products','live_has_product.product_id','=','products.id')
        ->join('orders','products.id','=','orders.product_id')
        ->where(DB::raw('CAST(lives.created_at AS DATE)'),'2020-07-25')
        ->orderBy(DB::raw('lives.id'),'desc')
        ->get();
        $result = [];
        $currentLive = -1;
        $live = [];
        $productThumbnailRootUrl = asset(Storage::url('ProductPortfolio')).'/';
        foreach($dbResult as $item)
        {
            if($currentLive != $item->lid)
            {
                if(count($live) > 1)
                    $result[] = $live;
                $liveObj = Live::find($item->lid);
                $liveThumbnail = asset(Storage::url('LivePhoto')).'/'.$liveObj->photo;
                $liveWatchData = $liveObj->nWatchers;
                $live = [
                            'id' => $liveObj->id,'title' => $liveObj->title,'tag' => $liveObj->TagLabel,
                            'thumbnail' => $liveThumbnail,'price' => 0,
                            'nLiveWatchers' => $liveWatchData['live'],
                            'nReplayWatchers' => $liveWatchData['replay'],
                            'orders' => [],
                            'expand' => true
                        ];
                $currentLive = $item->lid;
            }
            $product = Product::find($item->pid);
            $productThumnail = $productThumbnailRootUrl.$product->Thumbnail();
            $order = [
                        'id' => $item->oid,
                        'pid' => $product->id,
                        'label' => $product->label,
                        'number' => $product->number,
                        'thumbnail' => $productThumbnailRootUrl.$product->Thumbnail(),
                        'price' => $item->oPrice];
            $live['orders'][] = $order;
            $live['price'] += $order['price'];
        }
        if($result[count($result) - 1]['id'] != $live['id'])
        {
            $result[] = $live;
        }
        $response['lives'] = $result;
        return response()->json($response);
    }

}
