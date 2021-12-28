<?php

use CardzApp\Api\Account\Presentation\Controllers\GetAuthUserController;
use CardzApp\Api\Account\Presentation\Controllers\RegisterUserController;
use CardzApp\Api\Account\Presentation\Controllers\UpdateAuthUserController;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/account/users')->group(function () {
        Route::post('/')
            ->name(Routes::ACCOUNT_REGISTER_USER_ACTION)->uses(RegisterUserController::class);
    });

    Route::prefix('/account/user')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::get('/')
            ->name(Routes::ACCOUNT_GET_AUTH_USER_ACTION)->uses(GetAuthUserController::class);
        Route::patch('/')
            ->name(Routes::ACCOUNT_UPDATE_AUTH_USER_ACTION)->uses(UpdateAuthUserController::class);
    });
});
