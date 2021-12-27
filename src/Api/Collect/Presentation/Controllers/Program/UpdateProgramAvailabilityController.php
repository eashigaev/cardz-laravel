<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class UpdateProgramAvailabilityController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function __invoke(Request $request)
    {
        $program = Program::query()
            ->whereNotIn('available', [$request->value])
            ->findOrFail($request->program);

        $program->available = true;
        $program->save();

        return $this->successResponse();
    }
}
