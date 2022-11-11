<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('events', [EventController::class, 'index'])->name('events.index');

// Route::prefix('v1')->group(function(){
//     Route::post('register', [UserController::class, 'register'])->name('user.register');
//     Route::post('login', [UserController::class, 'login'])->name('user.login');
// });


Route::middleware('auth:api')->group(function(){
    Route::prefix('v1')->group(function(){
        Route::apiResource('events', EventController::class);
        Route::put('user/update/{user}', [UserController::class, 'update'])->name('user.update');
        Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
    
        Route::get('subscriptions/{event}', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('subscription', [SubscriptionController::class, 'store'])->name('subscription.store');
        //Route::get('subscriptions/{event}', [SubscriptionController::class, 'show'])->name('subscription.show');
        Route::delete('subscription/{subscription}', [SubscriptionController::class, 'destroy'])->name('subscription.destroy');
    
        Route::get('past', [EventController::class, 'past'])->name('past');
        Route::get('today', [EventController::class, 'today'])->name('today');
        Route::get('future', [EventController::class, 'future'])->name('future');
        
        Route::post('logout', [UserController::class, 'logout'])->name('user.logout');
        Route::post('register', [UserController::class, 'register'])->name('user.register')->withoutMiddleware('auth:api');
        Route::post('login', [UserController::class, 'login'])->name('user.login')->withoutMiddleware('auth:api');
    });
    
});


