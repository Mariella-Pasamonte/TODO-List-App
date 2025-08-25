<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/helloworld', [TestController::class, 'testHelloWorld']);

//Users Controller
Route::post('/signup',[UserController::class,'signingUp']);
Route::post('/login',[UserController::class,'loggingIn']);

//Category Controller
Route::post('/addCategory',[CategoryController::class,'add']);
Route::get('/categories', [CategoryController::class, 'getCategory']);