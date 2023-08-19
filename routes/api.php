<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FruitItemController;
use App\Http\Controllers\InvoiceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//• Able to input customer name.
//• Able to input multiple fruits. -->
//• Able to Create, Edit and Delete Invoices.



Route::middleware(['api', /*'xxx'*/])->group(function () {
    # auth
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    # category management
    Route::prefix('category')->group(function () {
        Route::post('store', [CategoryController::class, 'store']);
    });

    # fruit item management
    Route::prefix('fruit-item')->group(function () {
        Route::post('store', [FruitItemController::class, 'store']);
    });

    # invoice management
    Route::prefix('invoice')->group(function () {
        Route::post('store', [InvoiceController::class, 'store']);
        Route::put('update', [InvoiceController::class, 'update']);
        Route::delete('destroy', [InvoiceController::class, 'destroy']);
    });

});
