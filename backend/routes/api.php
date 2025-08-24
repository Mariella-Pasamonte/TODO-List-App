<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;

Route::get('/helloworld', [TestController::class, 'testHelloWorld']);

Route::post('/signup',[UserController::class,'signingUp']);
Route::post('/login',[UserController::class,'loggingIn']);