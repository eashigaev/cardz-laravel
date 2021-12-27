<?php

use CardzApp\Api\Collect\Presentation\Controllers\Program\AddProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramAvailabilityController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/collect/programs')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/company/id/{company}')
            ->name(Actions::COLLECT_ADD_PROGRAM)->uses(AddProgramController::class);
    });

    Route::prefix('/collect/program')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/id/{program}')
            ->name(Actions::COLLECT_UPDATE_PROGRAM)->uses(UpdateProgramController::class);
        Route::patch('/id/{program}/available')
            ->name(Actions::COLLECT_UPDATE_PROGRAM_AVAILABILITY)->uses(UpdateProgramAvailabilityController::class);
    });
});
