<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->search;

        if (!$search) {
            $users = User::query()->where('role_id', '!=', 2)->get();
        } else {
            $users = User::query()
                ->where("login", "like", '%' . $search . '%')
                ->orWhere("surname", "like", '%' . $search . '%')
                ->orWhere("name", "like", '%' . $search . '%')
                ->orWhere("patronymic", "like", '%' . $search . '%')
                ->get();
        }

        return response()->json(
            UserResource::collection($users),
        );
    }
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->message('User successful destroyed.');
    }

}
