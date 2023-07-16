<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use DB;
use Uploader;


class ProfileController extends Controller
{
    public function __construct(){
		
		//$this->middleware('user', ['except' => 'resumedownload']);
    }

    public function profile(Request $request){
       if($request->isMethod('post')){
           

            $data = $request->all();
			

			$validated = array();
			$validated['name'] = 'required|max:50';	
			$validated['email'] = 'required|email|max:50';	
			$validated['phonenumber'] = 'required';

            $validator = Validator::make($request->all(), $validated);
		
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			} else {
                unset($data['_token']);
                unset($data['name']);
                unset($data['checkemail']);

                $userData = DB::table('users')->where('id',auth()->guard('user')->id())->get()->first();

                $email = trim($data['email']);
                if(!empty(trim($data['email']))){

                    $checkEmail = DB::table('users')->where([['email',$data['email']]])->where('id','!=',auth()->guard('user')->id())->get()->first();

                    if(!empty($checkEmail)){
                        return redirect()->back()->with('error','Email already exist in our database.');
                    }
                }
                if($email != $userData->email){
                    if(!empty($data['password_gchng'])){
                        if(!Hash::check($data['password_gchng'], $userData->password)){
                            return redirect()->back()->with('error','Invalid Password.')->withInput();
                        }
                    }else{
                        return redirect()->back()->with('error','Please enter password to change your email.');
                    }
                }
                if(!empty($data['old_password'])){
					if(Hash::check($data['old_password'], $userData->password)){
						if($data['password'] != $data['confirm_password']){
							unset($data['old_password']);
							return redirect()->back()->with('error','Password should be same .')->withInput();
						}else{
							if($data['old_password'] === $data['password']){
								$sMsg = 'Your password is same as previously.';
								return redirect()->back()->with('warning',$sMsg)->withInput();
								
							}else{
								$data['password'] = Hash::make($data['password']);
								$sMsg = 'Your password is changed successfully';
							}
						}
					}else{
						return redirect()->back()->with('error','Your Current Password is not correct.')->withInput();
					}
				}else{
					unset($data['password']);
				}
                unset($data['password_gchng']);
				unset($data['confirm_password']);
				unset($data['old_password']);
                try{
                    if(array_key_exists('chngPass',$data)){
                        unset($data['chngPass']);
                    }
					$isUpdated = DB::table('users')->where('id',$userData->id)->update($data);
				}
				catch(\Exception $ex){
					return redirect()->back()->with('error','Something went wrong.');
				}

                if($isUpdated){
                    if($email != $userData->email){
                        $mailData = array(
                            'user_name' =>  $userData->name,
                            'user_email' => $userData->email,
                            'share_email'=>$email,
                        );
                        $email = $userData->email;
                        Mail::send('emails.changeEmail',$mailData,function($message) use ($email){
                            $message->to($email,'Change Email')->subject('Change Email');
                        });
                        $UserData = DB::table('users')->where('id',$userData->id)->first();					
                        Session::put('UserData', $UserData);
                        return redirect(route('frontend.register'))->with('success','Profile successfully updated.');
                    }else{
                        $UserData = DB::table('users')->where('id',$userData->id)->first();					
                        Session::put('UserData', $UserData);
                        return redirect(route('frontend.register'))->with('success','Profile successfully updated.');

                    }
				}
				else{
					return redirect(route('frontend.register'))->with('warning','Your submitted information same as previous information.');
				}

            }

       }
    }
    public function logout(Request $request){
        auth()->guard('user')->logout();
        Session::forget('UserData');
        return redirect()->intended(route('frontend.register'));
    }

}