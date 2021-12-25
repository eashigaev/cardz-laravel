<?php

use CardzApp\Api\Application\Actions;
use CardzApp\Api\Presentation\Account\Controllers\GetAuthUserController;
use CardzApp\Api\Presentation\Account\Controllers\RegisterUserController;
use CardzApp\Api\Presentation\Account\Controllers\UpdateAuthUserController;
use CardzApp\Api\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/account/users')->group(function () {
        Route::post('/')
            ->name(Actions::ACCOUNT_REGISTER_USER_ACTION)->uses(RegisterUserController::class);
    });

    Route::prefix('/account/user')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::get('/')
            ->name(Actions::ACCOUNT_GET_AUTH_USER_ACTION)->uses(GetAuthUserController::class);
        Route::patch('/')
            ->name(Actions::ACCOUNT_UPDATE_AUTH_USER_ACTION)->uses(UpdateAuthUserController::class);
    });
});
