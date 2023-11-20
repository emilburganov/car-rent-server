<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return $this->message('Unauthenticated.', 401);
        }

        $user = User::query()->firstWhere('token', $token);

        if (!$user) {
            return $this->message('Unauthenticated.', 401);
        }

        return $next($request);
    }
}
