<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarClassResource;
use App\Models\CarClass;
use Illuminate\Http\JsonResponse;

class CarClassController extends Controller
{
    public function index(): JsonResponse
    {
        $car_classes = CarClass::all();

        return response()->json(
            CarClassResource::collection($car_classes),
        );
    }
}
