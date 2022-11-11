<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = JWTAuth::user()->id;

        // echo '<pre>';
        //     var_dump($user);
        // echo '</pre>';
        // exit;

        return EventResource::collection(Event::where('user_id', $user)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        // dd($request);
        // $data = $request->all();
        // dd($request->user()->id);
        // $data['user_id'] = $request->user()->id;

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $user = JWTAuth::user()->id;
        if($user !== $event->user_id){
            return abort(403, 'Un-Authorized');
        }
        return new EventResource($event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $user = JWTAuth::user()->id;
        if($user !== $event->user_id){
            return abort(403, 'Un-Authorized');
        }

        $event->update($request->all());

        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
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
        //
    }



    public function today()
    {
        //
    }


    
    public function future()
    {
        //
    }
}
