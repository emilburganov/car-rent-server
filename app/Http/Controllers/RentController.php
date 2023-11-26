<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentResource;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $token = $request->bearerToken();
        $user = User::query()->firstWhere('token', $token);

        if ($user->role_id === 1) {
            $rentals = Rent::query()->where('user_id', $user->id)->get();
        } else {
            $rentals = Rent::all();
        }

        return response()->json(
            RentResource::collection($rentals),
        );
    }

    public function create(Request $request): JsonResponse
    {
        $request->merge(['start' => substr(str_replace('T', ' ', $request->start), 0, -5)]);
        $request->merge(['end' => substr(str_replace('T', ' ', $request->end), 0, -5)]);

        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer|exists:cars,id',
            'user_id' => 'required|integer|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $rent = Rent::query()->create($request->all());

        return response()->json(
            new RentResource($rent),
        );
    }

    public function show(Rent $rent): JsonResponse
    {
        return response()->json(
            $rent,
        );
    }

    public function update(Rent $rent, Request $request): JsonResponse
    {
        $request->merge(['start' => substr(str_replace('T', ' ', $request->start), 0, -5)]);
        $request->merge(['end' => substr(str_replace('T', ' ', $request->end), 0, -5)]);

        $validator = Validator::make($request->all(), [
            'car_id' => 'required|integer|exists:cars,id',
            'user_id' => 'required|integer|exists:users,id',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $rent->update($request->all());

        return $this->message('Rent successful updated.', 202);
    }

    public function destroy(Rent $rent): JsonResponse
    {
        $rent->delete();

        return $this->message('Rent successful destroyed.');
    }
}
