<?php

use App\Http\Controllers\PublishController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('subscribe/{topic}',[SubscriptionController::class,'store']);
Route::post('publish/{topic}',[PublishController::class,'store']);
