<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Traits\JsonResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminAccessMiddleware {

    use JsonResponseTrait;

    public const IS_ADMIN = 'is-admin';

    public function handle($request, Closure $next): mixed {
        if (Auth::check() && Gate::allows(self::IS_ADMIN)) {
            return $next($request);
        }

        return $this->jsonResponse(null, Response::HTTP_FORBIDDEN, __('messages.forbidden_access'));
    }
}
