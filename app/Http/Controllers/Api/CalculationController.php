<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculationRequest;
use App\Http\Resources\CalculationResource;
use App\Models\Calculation;
use App\Services\CalculatorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CalculationController extends Controller
{
    public function index(): JsonResponse
    {
        // Only return the latest 10 calculations to avoid overwhelming the client
        return response()->json(
            CalculationResource::collection(Calculation::latest()->take(10)->get())
        );
    }

    public function store(CalculationRequest $request, CalculatorService $calculator): JsonResponse
    {
        try {
            $result = $calculator->calculate($request->expression);

            $calc = Calculation::create([
                'expression' => $request->expression,
                'result' => $result,
            ]);

            return response()->json($calc, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(Calculation $calculation): Response
    {
        $calculation->delete();

        return response()->noContent();
    }

    public function clear(): Response
    {
        Calculation::truncate();

        return response()->noContent();
    }
}
