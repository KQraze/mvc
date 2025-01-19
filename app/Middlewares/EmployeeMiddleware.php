<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class EmployeeMiddleware
{
    public function handle(Request $request): void
    {
        if (!Auth::isEmployee()) {
            app()->route->redirect('/');
        }
    }
}