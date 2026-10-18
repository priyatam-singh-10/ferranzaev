<?php
namespace App\Http\Middleware;

use Auth;
use Closure;

class Permission
{
    public function handle($request, Closure $next, $data)
    {
        $admin = Auth::guard('admin')->user();

        // If admin not logged in → prevent error
        if (!$admin) {
            return redirect()->route('admin.login')
                ->with('error', 'Please login first.');
        }

        // Super Admin (ID = 1) → full access
        if ($admin->id == 1) {
            return $next($request);
        }

        // role_id = 0 → no permissions
        if ($admin->role_id == 0) {
            return redirect()->route('back.dashboard')
                ->with('success', "You don't have access to that section");
        }

        // -----------------------------
        // Permission check
        // -----------------------------

        $permissionList = explode('|', $data);

        foreach ($permissionList as $perm) {
            if ($admin->sectionCheck($perm)) {
                return $next($request);
            }
        }

        // If none matched → deny
        return redirect()->route('back.dashboard')
            ->with('success', "You don't have access to that section");
    }
}

// namespace App\Http\Middleware;
// use Auth;
// use Closure;

// class Permission
// {

//     public function handle($request, Closure $next,$data)
//     {
//         if (Auth::guard('admin')->check()) {
//             if(Auth::guard('admin')->user()->id == 1){
//                 return $next($request);
//             }
//             if(Auth::guard('admin')->user()->role_id == 0){
//                 return redirect()->route('back.dashboard')->with('success',"You don't have access to that section"); 
//             }
//             Auth::guard('admin')->user()->sectionCheck($data);
//             if (Auth::guard('admin')->user()->sectionCheck($data)){
//                 return $next($request);
//             }
//         }

//          $permissionList = explode('|', $data);

//             // If user has any of these permissions, allow access
//             foreach ($permissionList as $perm) {
//                 if (Auth::guard('admin')->user()->sectionCheck($perm)) {
//                     return $next($request);
//                 }
//             }
        
//         return redirect()->route('back.dashboard')->with('success',"You don't have access to that section"); 
//     }
// }
