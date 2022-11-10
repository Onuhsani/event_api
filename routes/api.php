<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

});

//Route::get('events', [EventController::class, 'index'])->name('events.index');

Route::prefix('v1')->group(function(){
    Route::post('user', [UserController::class, 'store'])->name('user.store');
});



Route::prefix('v1')->group(function(){
    Route::apiResource('events', EventController::class);
    Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');

    Route::get('subscriptions/{event}', [SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
    //Route::get('subscriptions/{event}', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::delete('subscription/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
});


