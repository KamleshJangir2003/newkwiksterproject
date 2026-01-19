<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AgentAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        return $request->expectsJson() ? null : route('ajent_login');
    }
    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('agent')->check()) {
            return $this->auth->shouldUse('agent');
        }

        $this->unauthenticated($request, ['agent']);
    }
}
