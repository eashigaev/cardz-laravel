<?php

use CardzApp\Api\Auth\Controllers\LoginController;
use CardzApp\Api\Auth\Controllers\LogoutAllController;
use CardzApp\Api\Auth\Controllers\LogoutController;
use CardzApp\Api\Shared\Routes;

Route::prefix(Routes::URL_PREFIX . '/auth')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/tokens')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::AUTH_LOGIN)->uses(LoginController::class)
            ->withoutMiddleware(Routes::AUTHENTICATE_MIDDLEWARE);
        Route::delete('/')
            ->name(Routes::AUTH_LOGOUT_ALL)->uses(LogoutAllController::class);
    });

    Route::prefix('/token')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::delete('/')
            ->name(Routes::AUTH_LOGOUT)->uses(LogoutController::class);
    });
});
