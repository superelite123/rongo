<?php
namespace App\Api\V1\Controllers\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Api\V1\Controllers\Controller;

use App\UserCard;
class CardController extends Controller
{
    public function index()
    {
        $response = [];
        foreach(auth()->user()->rCard as $card)
        {
            $response[] = $card->card;
        }

        return response()->json($response);
    }

    public function execOrder(Request $request)
    {

    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $card = $user->rCard()->save(
            new UserCard([
                'card' => $request->card,
            ])
        );
        return response()->json($card);
    }
}
