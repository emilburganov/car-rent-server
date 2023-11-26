<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string|min:3|max:40|unique:users,login',
            'surname' => 'required|string|min:3|max:60',
            'name' => 'required|string|min:3|max:60',
            'patronymic' => 'required|string|min:3|max:60',
            'password' => 'required|string|min:8|max:100',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $token = Str::random();

        $credentials = $request->except(['password', 'password_confirmation']);
        $credentials['password'] = Hash::make($request->password);

        $user = User::query()->create($credentials);
        $user->update([
            'token' => $token,
        ]);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->validationError($validator->errors());
        }

        $credentials = $request->only(['login', 'password']);

        if (!Auth::attempt($credentials)) {
            return $this->message('Invalid login or password.', 401);
        }

        $user = User::query()->firstWhere('login', $request->login);

        $token = Str::random();

        $user->update([
            'token' => $token,
        ]);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        $user = User::query()->firstWhere('token', $token);

        $user->update([
            'token' => '',
        ]);

        return $this->message('Successful logout.');
    }

    public function me(Request $request): JsonResponse
    {
        $token = $request->bearerToken();

        $user = User::query()->firstWhere('token', $token);

        return response()->json(
            new UserResource($user),
        );
    }
}
