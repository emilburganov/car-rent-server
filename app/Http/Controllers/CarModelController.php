<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use Illuminate\Http\JsonResponse;

class CarModelController extends Controller
{
    public function index(): JsonResponse
    {
        $car_models = CarModel::all();

        return response()->json(
            CarModelResource::collection($car_models),
        );
    }
}
