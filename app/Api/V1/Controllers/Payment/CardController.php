<?php

namespace App\Api\V1\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Api\V1\Controllers\Controller;
use App\libraries\tgMdk\Lib\tgMdkDto\CardAuthorizeRequestDto;
use App\libraries\tgMdk\Lib\TGMDK_Transaction;
class CardController extends Controller
{
    public function index()
    {
        new TGMDK_Transaction();
    }

    public function execOrder(Request $request)
    {

    }
}
