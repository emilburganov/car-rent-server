<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentResource;
use App\Models\Rent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class RentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->search;

        if (!$search) {
            $cars = Rent::all();
        } else {
            $cars = Rent::query()
                ->where("start", "like", '%' . $search . '%')
                ->orWhere("end", "like", '%' . $search . '%')
                ->orWhereRelation('car', 'name', 'like', '%' . $search . '%')
                ->orWhereRelation('user', 'name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json(
            RentResource::collection($cars),
        );
    }

    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'car_model_id' => 'required|integer|exists:car_models,id',
            'year' => 'required|digits:4',
            'name' => 'required|string|min:3|max:40',
            'consumption' => 'required|integer|min:1|max:200',
            'horsepower' => 'required|integer|min:1|max:1000',
            'car_class_id' => 'required|integer|exists:car_classes,id',
            'salon_id' => 'required|integer|exists:salons,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $car = Car::query()->create($request->all());

        return response()->json(
            new CarResource($car),
        );
    }

    public function show(Car $car): JsonResponse
    {
        return response()->json(
            $car,
        );
    }

    public function update(Car $car, Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'car_model_id' => 'required|integer|exists:car_models,id',
            'year' => 'required|digits:4',
            'name' => 'required|string|min:3|max:40',
            'consumption' => 'required|integer|min:1|max:200',
            'horsepower' => 'required|integer|min:1|max:1000',
            'car_class_id' => 'required|integer|exists:car_classes,id',
            'salon_id' => 'required|integer|exists:salons,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $car->update($request->all());

        return $this->message('Car successful updated.', 202);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();

        return $this->message('Car successful destroyed.');
    }
}
