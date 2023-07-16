<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckUser
{
    public function handle($request, Closure $next)
    {        
       
        if(!empty(auth()->guard('user')->id()))
        {   
            $data = DB::table('users')
                    ->select('users.*')
                    ->where([['users.id',auth()->guard('user')->id()],['verify_status','1']])
                    ->get()->first();
            if (empty($data->id))
            {
                auth()->guard('user')->logout();
                Session::forget('UserData');
                return redirect()->intended(route('frontend.login'))->with('error', 'Please Login to access user area.');
            }else{
                Session::put('UserData',$data);
            }
    
            return $next($request);
        }
        else 
        {
            if($request->ajax()){
                return response('Unauthenticated', 401);
            }
            return redirect()->intended(route('frontend.login'))->with('error', 'Please Login to access user area');
        }
    }

}

