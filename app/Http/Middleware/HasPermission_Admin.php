<?php

namespace App\Http\Middleware;
use App\Http\Controllers\AdminController;

use Closure;

class HasPermission_Admin
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
        if($adminController->verifylogin()){
          if(!$adminController->hasPermission([3,4])){
            if(isset($_SESSION["redirectLoopPrevent"])){
              if($_SESSION["redirectLoopPrevent"] == 0){
                $_SESSION["redirectLoopPrevent"] = 1;
                return redirect()->back();
              }else{
                $_SESSION["redirectLoopPrevent"] = 0;
                return redirect("/");
              }
            }else{
              $_SESSION["redirectLoopPrevent"] = 1;
              return redirect()->back();
            }
          }
        }else{
          return redirect("/");
        }
        return $next($request);
    }
}
