<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckAdmin
{
    public function handle($request, Closure $next)
    {   
        if(!empty(auth()->guard('admin')->id()))
        {
            $data = DB::table('admins')
                    ->select('admins.id')
                    ->where('admins.id',auth()->guard('admin')->id())
                    ->first();
            if (empty($data->id))
            {
                auth()->guard('admins')->logout();
                return redirect()->intended(route('backend.login'))->with('error', 'You do not have access to admin side');
            }
            return $next($request);
        }
        else 
        {
            if($request->ajax()){
                return response('Unauthenticated', 401);
            }
            return redirect()->intended(route('backend.login'))->with('info', 'Please Login to access admin area');
        }
    }

}

