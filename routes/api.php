<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['sessions']], function () {
    $limiter = config('fortify.limiters.login');
    Route::get('/login', [UserController::class, 'authenticate'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]))->name('token.login');
});
getRoute(11, 'api');
getRoute(12, 'api');