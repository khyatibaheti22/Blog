<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSenders;

use DB;
use Hash;
use Validator;

class LoginController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function __construct()
    {
        $this->EmailModel = new MailSenders();
        $this->middleware('guest');
    }
    public function register(Request $request){

        if($request->isMethod('post')){
            if(!empty(auth()->guard('user')->id())){
                return redirect()->intended(route('frontend.profile'));
            }

            $data = $request->all();
            $passregx ="/^(?=.*\d)(?=.)(?=.*[a-zA-Z]).{8,30}$/";
            $validated = array();
			$validated['name'] = 'required|max:25';
            $validated['email'] = 'required|email:rfc,dns|max:250';
            $validated['phonenumber'] ='regex:/(?=[0-9+()][0-9 \–\-+()]+[0-9]$)^(?=.*[ \–\-+()])?(?=.*[0-9]).*$/';
			$validated['password'] = ['required','regex:'.$passregx];
			$validated['confirm_password'] = 'required';
           
			$validator = Validator::make($data, $validated);
            if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
              
			} else {
                if($data['password'] != $data['confirm_password']){
                    return redirect()->back()->with('error','Confirm password should be same as password.')->withInput();
                }
            
                $checkEmail = DB::table('users')->where('email',$data['email'])->get()->first();
                if(!empty($checkEmail)){
                    return redirect()->back()->with('error','Your email is already registered in our database.')->withInput();
                }
               $insertArr = array();
               $insertArr['name'] = $data['name'];
               $insertArr['email'] = $data['email'];
               $insertArr['phonenumber'] = $data['phonenumber'];
               $hashPassword = Hash::make($data['password']);
                    /** email vetifiction code */
                    $activation_link = md5(generateRandomString(10));
                $verificationUrl = route('frontend.emailverification',['token'=>$activation_link]);
               $insertArr['password'] = $hashPassword;
               $insertArr['activation_link'] = $activation_link;
               $insertArr['added_on'] = date('Y-m-d H:i:s');

               try{
                   $insert = DB::table('users')->insert($insertArr);
               }catch(\Exception $e){
                    return redirect()->back()->with('error',$e->getMessage())->withInput();
               }
               if($insert){
               $mailData = array(
                        'user_name' =>  $insertArr['name'],
                        'user_email' => $insertArr['email'],
                        'share_email'=>$insertArr['email'],
                        'share_password'=>$data['password'],
                        'login_link' => $verificationUrl,
                    );

                Mail::send('emails.loginDetails',$mailData,function($message) use ($email){
                    $message->to($email,'Login Details')->subject('Login Details');
                });
                   
               }else{
                return redirect()->back()->with('error','Something went wrong.');
               }
              
               return redirect()->back()->with('success','User Successfully registerred.');
            }
        }
       
        $userData = (object)NULL;
        if(!empty(auth()->guard('user')->id())){
            $userData = DB::table('users')->where('id',auth()->guard('user')->id())->get()->first();
        }
        return view('login',compact('userData'));
    }

     /** Account email verification*/
     public function emailverification(Request $request, $token){
        if(!empty($token)){
          
            $getUser = DB::table('users')->where('activation_link',$token)->get()->first();

            if(!empty($getUser)){

                $updateData['activation_link'] = NULL;
                $updateData['verify_status'] = '1';

                $isUpdated = DB::table('users')->where('id',$getUser->id)->update($updateData);
       
                if($isUpdated){
                    return redirect(route('frontend.register'))->with('success','Your email address successfully verified.');
                }
                else{
                    return redirect(route('frontend.register'))->with('error','Some error occurred.');
                }

            }
            else{
                return redirect(route('frontend.register'))->with('error','Invalid Request!');
            }
        }
        else{
            return redirect(route('frontend.register'))->with('error','Invalid Request!');
        }
    }

    public function login(Request $request){
        if($request->isMethod('post')){

            if(!empty(auth()->guard('user')->id())){
                return redirect()->intended(route('frontend.profile'));
            }
            $data = $request->all();
            $validated = array();
			$validated['email_username'] = 'required|max:25';
			$validated['password'] =  'required';
           
			$validator = Validator::make($data, $validated);
            if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
              
			}else {
             
                
                    $email = $data['email_username'];
                    $password = $data['password'];
                    // prd("ddd");
                    try{
                        $userData = DB::table('users')->where('email',trim(strtolower($email)))->orWhere('name',$email)->get()->first();
                    }catch(\Exception $e){
                        prd($e->getMessage());
                    }
                    
                    if(!empty($userData)){
                        
                        
                      
        
                        if($userData->verify_status == '0'){
                            return redirect()->intended(route('frontend.login'))->with('error','Your email is not verified. Please verify your email address to access account.');
                        }   
                        
        
                        if (auth()->guard('user')->attempt(['email' => $email, 'password' => $password])) 
                        {
                           
                            $users = DB::table('users')
                                    ->where('id', '=', auth()->guard('user')->id())
                                    ->first();
        
                            Session::put('UserData', $users);
                            prd(Session::all());
        
                        }else if(auth()->guard('user')->attempt(['name' => $email, 'password' => $password])){
                          
                            $users = DB::table('users')
                                    ->where('id', '=', auth()->guard('user')->id())
                                    ->first();
        
                            Session::put('UserData', $users);
        
                          
                            return redirect()->intended(route('frontend.register'));
                        }
                        else
                        {
                            
                            return redirect()->back()->with('error','Invalid Login Credentials!');
                        }
                    }else{
                      
                       return redirect()->back()->with('error','User not exist');
                    }
            }
        
        }
    }
}
