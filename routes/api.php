<?php

use App\Http\Controllers\ApiUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('register', [ApiUserController::class, 'register']);
Route::post('login', [ApiUserController::class, 'login']);
Route::post('logout',[ApiUserController::class,'logout']);







Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
