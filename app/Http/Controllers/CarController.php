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
                ->orWhere('year','like', '%' . $search . '%')
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
            'car_model_id' => 'required|numeric|exists:car_models,id',
            'year' => 'required|year',
            'name' => 'required|string|min:3|max:40',
            'consumption' => 'required|numeric|min:1|max:200',
            'horsepower' => 'required|numeric|min:1|max:1000',
            'car_class_id' => 'required|numeric|exists:car_classes,id',
            'salon_id' => 'required|numeric|exists:salons,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $car = Car::query()->create($request->only(['name', 'description']));

        return response()->json(
            new CarResource($car),
        );
    }

    public function update(Car $car, Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'car_model_id' => 'required|number|exists:car_models,id',
            'year' => 'required|number',
            'name' => 'required|string|min:3|max:40',
            'consumption' => 'required|string|min:3|max:40',
            'horsepower' => 'required|number',
            'car_class_id' => 'required|number|exists:car_classes,id',
            'salon_id' => 'required|number|exists:salons,id',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $car->update($request->only(['name', 'description']));

        return $this->message('Car successful updated.', 202);
    }

    public function destroy(Car $car): JsonResponse
    {
        $car->delete();

        return $this->message('Car successful destroyed.');
    }
}
