<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Mpesa\LNMOController;
use App\Http\Controllers\UnstructuredSupplementaryServiceDataController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

// ussd services
Route::apiResource('/ussd', UnstructuredSupplementaryServiceDataController::class);

// payments gateway - instant payment network.
Route::group(['prefix' => '/ipn'], function () {
    Route::group(['prefix' => '/ke'], function () {
        Route::post('/mpesa/lnmo/transact', [LNMOController::class, 'transact'])->name('mpesa.lnmo.transact');
        Route::post('/mpesa/lnmo/query', [LNMOController::class, 'query'])->name('mpesa.lnmo.query');
        Route::post('/mpesa/lnmo/callback', [LNMOController::class, 'callback'])->name('mpesa.lnmo.callback');
    });
});
