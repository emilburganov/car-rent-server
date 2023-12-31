<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->search;

        if (!$search) {
            $cars = Car::all();
        } else {
            $cars = Car::query()
                ->where("name", "like", '%' . $search . '%')
                ->orWhereRelation('car_model', 'name', 'like', '%' . $search . '%')
                ->orWhere('year', 'like', '%' . $search . '%')
                ->orWhereRelation('car_class', 'name', 'like', '%' . $search . '%')
                ->orWhereRelation('salon', 'name', 'like', '%' . $search . '%')
                ->get();
        }

        return response()->json(
            CarResource::collection($cars),
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
