<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\ReserveBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post("login", [UserController::class, 'login']);
Route::resource("users", UserController::class);

Route::middleware("auth:api")->group(function() {

    Route::resources([
        'books' => BookController::class,
        'categories' => CategoryController::class,
        'publishers' => PublisherController::class,
        'reserves' => ReserveController::class,
        'userTypes' => UserTypeController::class,
        'reservesBooks' => ReserveBookController::class
    ]);

    Route::post('logout', [UserController::class, 'logout']);

    Route::get('auth', function(){
        return auth()->user();
    });

    
});