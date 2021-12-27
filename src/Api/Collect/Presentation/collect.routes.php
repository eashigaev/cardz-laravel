<?php

use CardzApp\Api\Collect\Presentation\Controllers\Program\AddProgramController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/collect/programs')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/company/id/{company}')
            ->name(Actions::COLLECT_ADD_PROGRAM)->uses(AddProgramController::class);
    });
});
