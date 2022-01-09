<?php

use App\Models\Collect\Program;
use App\Models\Collect\ProgramTask;
use App\Models\Company;
use CardzApp\Api\Collect\Presentation\Controllers\Program\AddProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\GetProgramsController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramActiveController;
use CardzApp\Api\Collect\Presentation\Controllers\Program\UpdateProgramController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\AddProgramTaskController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\GetProgramTaskController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\GetProgramTasksController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\UpdateProgramTaskActiveController;
use CardzApp\Api\Collect\Presentation\Controllers\ProgramTask\UpdateProgramTaskController;
use CardzApp\Api\Shared\Application\Actions;
use CardzApp\Api\Shared\Presentation\Routes;
use Codderz\YokoLite\Application\Authorization\Middleware\Authorize;

Route::prefix(Routes::URL_PREFIX . '/collect')->middleware([Routes::API_MIDDLEWARE])->group(function () {

    Route::prefix('/company/id/{company}/programs')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ADD_PROGRAM)->uses(AddProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_PROGRAM, ['company' => Company::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAMS)->uses(GetProgramsController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAMS, ['company' => Company::class]));
    });

    Route::prefix('/program/id/{program}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/')
            ->name(Routes::COLLECT_UPDATE_PROGRAM)->uses(UpdateProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM, ['program' => Program::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAM)->uses(GetProgramController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM, ['program' => Program::class]));
        Route::patch('/active')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_ACTIVE)->uses(UpdateProgramActiveController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_ACTIVE, ['program' => Program::class]));
    });

    Route::prefix('/program/id/{program}/tasks')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::post('/')
            ->name(Routes::COLLECT_ADD_PROGRAM_TASK)->uses(AddProgramTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_ADD_PROGRAM_TASK, ['program' => Program::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAM_TASKS)->uses(GetProgramTasksController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM_TASKS, ['program' => Program::class]));
    });

    Route::prefix('/program/task/id/{task}')->middleware([Routes::AUTHENTICATE_MIDDLEWARE])->group(function () {
        Route::patch('/')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_TASK)->uses(UpdateProgramTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_TASK, ['task' => ProgramTask::class]));
        Route::get('/')
            ->name(Routes::COLLECT_GET_PROGRAM_TASK)->uses(GetProgramTaskController::class)
            ->middleware(Authorize::for(Actions::COLLECT_GET_PROGRAM_TASK, ['task' => ProgramTask::class]));
        Route::patch('/active')
            ->name(Routes::COLLECT_UPDATE_PROGRAM_TASK_ACTIVE)->uses(UpdateProgramTaskActiveController::class)
            ->middleware(Authorize::for(Actions::COLLECT_UPDATE_PROGRAM_TASK_ACTIVE, ['task' => ProgramTask::class]));
    });
});
