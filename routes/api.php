<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Calendar\CalendarController;
use \App\Http\Controllers\Api\V1\Events\CreateController;
use \App\Http\Controllers\Api\V1\Events\UpdateController;
use \App\Http\Controllers\Api\V1\Events\DeleteController;
//use \App\Http\Controllers\Api\V1\Events\EventController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
    'as' => 'api.',
    'namespace' => '\App\Http\Controllers\Api\V1\Auth',
], function () {
    Route::post('register', 'RegisterController')->name('register');
    Route::post('login', 'LoginController')->name('login');
    Route::post('logout', 'LogoutController')
        ->middleware('auth:api')
        ->name('logout');
}
);

Route::group([
    'middleware' => 'auth:api',
    'prefix' => '/v1',
    'as' => 'api.'
], function () {
    Route::group([
        'prefix' => '/event',
        'as' => 'event.',
    ], function () {
//        Route::resource('/', EventController::class);
        Route::post('/create', CreateController::class)->name('create');
        Route::post('/update', UpdateController::class)->name('update');
        Route::post('/delete', DeleteController::class)->name('delete');
    });
    Route::group([
        'prefix' => '/calendar',
        'as' => 'calendar.',
    ], function () {
        Route::get('/', CalendarController::class);
    });
}
);

