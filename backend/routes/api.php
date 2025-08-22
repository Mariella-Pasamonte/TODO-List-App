<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;

Route::get('/helloworld', [TestController::class, 'testHelloWorld']);