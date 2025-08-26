<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TasksController;

Route::get('/helloworld', [TestController::class, 'testHelloWorld']);

//Users Controller
Route::post('/signup',[UserController::class,'signingUp']);
Route::post('/login',[UserController::class,'loggingIn']);

//Category Controller
Route::post('/addCategory',[CategoryController::class,'add']);
Route::get('/categories', [CategoryController::class, 'getCategory']);

//Task Controller
Route::post('/addTask',[TasksController::class,'addTask']);
Route::get('/getTasks',[TasksController::class,'getByUser']);
Route::patch('/task/{id}/complete', [TasksController::class, 'updateIsCompleted']);
Route::get('/fetchTask/{id}',[TasksController::class, 'fetchTask']);
Route::put('/editTask/{id}',[TasksController::class, 'editTask']);
Route::delete('deleteTask/{id}',[TasksController::class, 'delete']);