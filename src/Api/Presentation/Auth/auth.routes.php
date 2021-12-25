<?php

use CardzApp\Api\Application\Actions;
use CardzApp\Api\Presentation\Auth\Controllers\LoginController;
use CardzApp\Api\Presentation\Auth\Controllers\LogoutAllController;
use CardzApp\Api\Presentation\Auth\Controllers\LogoutController;
use CardzApp\Api\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/auth/tokens')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Actions::AUTH_LOGIN_ACTION)->uses(LoginController::class)
            ->withoutMiddleware(Routes::AUTHENTICATE_MIDDLEWARE);
        Route::delete('/')
            ->name(Actions::AUTH_LOGOUT_ALL_ACTION)->uses(LogoutAllController::class);
    });

    Route::prefix('/auth/token')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::delete('/')
            ->name(Actions::AUTH_LOGOUT_ACTION)->uses(LogoutController::class);
    });
});
