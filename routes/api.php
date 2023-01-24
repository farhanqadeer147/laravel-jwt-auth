<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\todolistController;

Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);


Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('send-verify-email/{email}', [ApiController::class, 'sendVerifyMail']);
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
    Route::get('todolists', [todolistController::class, 'index']);
    Route::get('todolists/{id}', [todolistController::class, 'show']);
    Route::post('create', [todolistController::class, 'store']);
    Route::put('update/{todolist}',  [todolistController::class, 'update']);
    Route::delete('delete/{todolist}',  [todolistController::class, 'destroy']);
});





