<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\Responsible;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    use Responsible;

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
