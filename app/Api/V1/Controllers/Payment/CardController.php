<?php

namespace App\Api\V1\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Api\V1\Controllers\Controller;
use App;
//Load Lib Classes;
use App\Libraries\MDK\Lib\TGMDK_Transaction;
//use App\Libraries\MDK\Lib\tgMdkDto\CardAuthorizeRequestDto;

class CardController extends Controller
{
    public function index()
    {
        new TGMDK_Transaction();
        //define order ID
        $response = [];
        $response['order_id'] = "dummy".time();
        $response['token_api_key'] = env('token.api.key');
        $response['token_api_url'] = env('token.api.url');
        return $response;
    }

    public function execOrder(Request $request)
    {
        $order_id = $request->order_id;
        $payment_amount = $request->payment_amount;

    }
}
