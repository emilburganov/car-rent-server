<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next, int $role_id): Response
    {
        $token = $request->bearerToken();
        $user = User::query()->firstWhere('token', $token);

        if ($role_id === (int)$user->role_id) {
            return $next($request);
        }

        return $this->message('Unauthorized.', 403);
    }
}
