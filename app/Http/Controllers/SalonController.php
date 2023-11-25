<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalonResource;
use App\Models\Salon;
use Illuminate\Http\JsonResponse;

class SalonController extends Controller
{
    public function index(): JsonResponse
    {
        $salons = Salon::all();

        return response()->json(
            SalonResource::collection($salons),
        );
    }
}
