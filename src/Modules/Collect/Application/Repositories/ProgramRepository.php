<?php

namespace CardzApp\Modules\Collect\Application\Repositories;

use App\Models\Collect\Program;
use CardzApp\Modules\Collect\Domain\ProgramAggregate;
use Codderz\YokoLite\Domain\Uuid\Uuid;

interface ProgramRepository
{
    public function ofIdOrFail(Uuid $programId);

    public function ofTaskIdOrFail(Uuid $taskId);

    public function of(Program $program): ProgramAggregate;

    public function save(ProgramAggregate $aggregate);
}
