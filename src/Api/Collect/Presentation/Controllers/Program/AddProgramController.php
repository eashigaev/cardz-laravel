<?php

namespace CardzApp\Api\Collect\Presentation\Controllers\Program;

use App\Http\Controllers\Controller;
use App\Models\Collect\Program;
use App\Models\Company;
use CardzApp\Api\Shared\Presentation\ControllerTrait;
use Codderz\YokoLite\Domain\Uuid\UuidGenerator;
use Illuminate\Http\Request;

class AddProgramController extends Controller
{
    use ControllerTrait;

    public function __construct(
        private UuidGenerator $uuidGenerator
    )
    {
    }

    public function __invoke(Request $request)
    {
        $attrs = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        $tenant = Company::query()->findOrFail($request->company);

        $program = new Program($attrs);
        $program->id = $this->uuidGenerator->getNextValue();
        $program->available = false;
        $program->tenant()->associate($tenant);
        $program->save();

        return $this->successResponse([
            'id' => $program->id
        ]);
    }
}
