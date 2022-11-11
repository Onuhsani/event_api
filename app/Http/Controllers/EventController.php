<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $user = JWTAuth::user()->id;
        return EventResource::collection(Event::where('user_id', $user)->paginate());
    }


    public function store(StoreEventRequest $request)
    {
        $event = Event::create([
            'user_id' =>JWTAuth::user()->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'date'=>$request->date,
            'payment_status' => $request->payment_status,
        ]);

        return response()->json([
            'status' => 'success',
            'user' => $event,
        ]);
    }

    public function show(Event $event)
    {
        $user = JWTAuth::user()->id;
        if($user !== $event->user_id){
            return abort(403, 'Un-Authorized');
        }
        return new EventResource($event);
    }
    public function update(UpdateEventRequest $request, Event $event)
    {
        $user = JWTAuth::user()->id;
        if($user !== $event->user_id){
            return abort(403, 'Un-Authorized');
        }

        $event->update($request->all());

        return new EventResource($event);
    }

    public function destroy(Event $event)
    {
        $user = JWTAuth::user()->id;
        if($user !== $event->user_id){
            return abort(403, 'Un-Authorized');
        }

        $event->delete();

        return response('', 203);
    }


    public function past()
    {
        $events = Event::whereDate('date', '<', Carbon::today())->get();
        return EventResource::collection($events);
    }


    public function today()
    {
        $events = Event::whereDate('date', '=', Carbon::today())->get();
        return EventResource::collection($events);
    }


    public function future()
    {
        $events = Event::whereDate('date', '>', Carbon::today())->get();
        return EventResource::collection($events);
    }
}
