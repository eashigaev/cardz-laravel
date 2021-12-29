<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use App\Models\Collect\Program;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class UpdateProgramController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function __invoke(Request $request)
    {
        $attrs = $request->only(['title', 'description']);

        $program = Program::query()->findOrFail($request->program);

        $program->fill($attrs)->save();

        return $this->successResponse();
    }
}
