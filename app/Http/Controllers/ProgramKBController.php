<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramKB\StoreProgramKBRequest;
use App\Models\ProgramKB;
use App\Services\ProgramKBService;
use Illuminate\Http\Request;

class ProgramKBController extends Controller
{
    public function __construct(
        protected ProgramKBService $service
    ) {}

    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->service->list(
                $request->all()
            ),
        ]);
    }

    public function store(StoreProgramKBRequest $request)
    {

        try {
            $data = $request->validated();

            $programKB = $this->service->create($data);

            return response()->json([
                'success' => true,
                'data' => $programKB,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update( StoreProgramKBRequest $request, ProgramKB $programKB) {

        try {
            $data = $request->validated();

            $programKB = $this->service->update(
                $programKB,
                $data
            );

            return response()->json([
                'success' => true,
                'data' => $programKB,
            ], 201);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy( ProgramKB $programKB ) {

        $this->service->delete(
            $programKB
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
