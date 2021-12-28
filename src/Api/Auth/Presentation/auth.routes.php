<?php

use CardzApp\Api\Auth\Presentation\Controllers\LoginController;
use CardzApp\Api\Auth\Presentation\Controllers\LogoutAllController;
use CardzApp\Api\Auth\Presentation\Controllers\LogoutController;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/auth/tokens')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::AUTH_LOGIN_ACTION)->uses(LoginController::class)
            ->withoutMiddleware(Routes::AUTHENTICATE_MIDDLEWARE);
        Route::delete('/')
            ->name(Routes::AUTH_LOGOUT_ALL_ACTION)->uses(LogoutAllController::class);
    });

    Route::prefix('/auth/token')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::delete('/')
            ->name(Routes::AUTH_LOGOUT_ACTION)->uses(LogoutController::class);
    });
});
