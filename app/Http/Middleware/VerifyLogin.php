<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\AdminController;

class VerifyLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $adminController = new AdminController;
        if(!$adminController->verifyLogin()){
          return redirect("/login");
        }
        return $next($request);
    }
}
