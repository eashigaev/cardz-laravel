<?php

use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Collect\Presentation\Controllers\Program\AddProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramsController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramAvailableController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\AddProgramTaskController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Codderz\YokoLite\Application\Authorization\Middleware\Authorize;

Route::prefix(Routes::URL_PREFIX)->middleware([Routes::API_MIDDLEWARE,])->group(function () {

    Route::prefix('/collect/programs')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/company/id/{company}')
            ->name(Routes::COLLECT_ADD_PROGRAM)->uses(AddProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_PROGRAM, ['company' => Company::class]));
        Route::get('/company/id/{company}')
            ->name(Routes::COLLECT_GET_PROGRAMS)->uses(GetProgramsController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAMS, ['company' => Company::class]));
    });

    Route::prefix('/collect/program')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/id/{program}')
            ->name(Routes::COLLECT_UPDATE_PROGRAM)->uses(UpdateProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM, ['program' => Program::class]));
        Route::get('/id/{program}')
            ->name(Routes::COLLECT_GET_PROGRAM)->uses(GetProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM, ['program' => Program::class]));
        Route::patch('/id/{program}/available')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_AVAILABLE)->uses(UpdateProgramAvailableController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_AVAILABLE, ['program' => Program::class]));
    });

    Route::prefix('/collect/program')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/id/{program}')
            ->name(Routes::COLLECT_UPDATE_PROGRAM)->uses(UpdateProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM, ['program' => Program::class]));
        Route::get('/id/{program}')
            ->name(Routes::COLLECT_GET_PROGRAM)->uses(GetProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM, ['program' => Program::class]));
        Route::patch('/id/{program}/available')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_AVAILABLE)->uses(UpdateProgramAvailableController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_AVAILABLE, ['program' => Program::class]));
        Route::post('/id/{program}/tasks')
            ->name(Routes::COLLECT_ADD_PROGRAM_TASK)->uses(AddProgramTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_PROGRAM_TASK, ['program' => Program::class]));
    });
});
