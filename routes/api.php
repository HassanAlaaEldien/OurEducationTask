<?php

use App\Http\Controllers\API\V1\TransactionsController;
use App\Http\Controllers\API\V1\MembersController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::resource('transactions', TransactionsController::class)->only(['index', 'store']);
    Route::resource('members', MembersController::class)->only(['index']);
});
