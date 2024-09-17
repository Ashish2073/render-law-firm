<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class UserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$permission): Response
    {
        if (Auth::check() ) {
            
            $userrole=json_decode(auth()->user()->getRoleNames(),true);

          
            

            if (hasPermissionForRoles($permission,$userrole) || in_array("admin",json_decode(auth()->user()->getRoleNames()))) {
                return $next($request);
            }
        } 
        
       
        
        return redirect()->back()->with('permissionerror', 'Unauthorized. You do not have permission to access this resource.');
    }
}
