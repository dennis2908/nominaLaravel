<?php

use Illuminate\Http\Request;
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

use App\Http\Controllers\MroleController;

use App\Http\Controllers\MuserController;

use App\Http\Controllers\HobbyController;

Route::middleware(['cors'])->group(function () {

    Route::get('role/data', [MroleController::class, 'dataList']);
    Route::get('hobby/data', [HobbyController::class, 'dataList']);
    Route::post('user/login', [MuserController::class, 'doLogin']);
    Route::post('user/register', [MuserController::class, 'store']);
    
});

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::resource('role', MroleController::class);

    Route::resource('user', MuserController::class);

    Route::resource('hobby', HobbyController::class);

    Route::put('role/assign/{id}', [MroleController::class, 'updateAssign']);

});




