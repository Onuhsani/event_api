<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class SubscriptionController extends Controller
{
    public function subscribe(StoreSubscriptionRequest $request)
    {
        $sub = Subscription::create([
            'user_id' => JWTAuth::user()->id,
            'event_id' => $request->event_id,
        ]);

        return response()->json([
            'status' => 'success',
            'subscription' => $sub,
        ]);
    }

    public function unSubscribe(Subscription $subscription)
    {
        //
    }

    public function subscriptions(Request $request)
    {  
       return SubscriptionResource::collection(Subscription::where('event_id', $request->event_id)->paginate());
    }
}
