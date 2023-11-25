<?php

namespace App\Http\Controllers;


use App\Models\Salon;
use Illuminate\Http\JsonResponse;

class SalonController extends Controller
{
    public function index(): JsonResponse
    {
        $car_models = Salon::all();

        return response()->json(
            CarModelResource::collection($car_models),
        );
    }
}
