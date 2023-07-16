<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\HttpException $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => $e->getMessage()
                ], 404);
            }   
            
            $errorMessage = (!empty($e->getMessage()))?$e->getMessage():'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });

        $this->renderable(function (\Illuminate\Auth\Access\AuthorizationException\AuthorizationException $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => $e->getMessage()
                ], 404);
            }   
            
            $errorMessage = (!empty($e->getMessage()))?$e->getMessage():'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });

        $this->renderable(function (\Illuminate\Foundation\ValidationException\ValidationException $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => $e->getMessage()
                ], 404);
            }   
            
            $errorMessage = (!empty($e->getMessage()))?$e->getMessage():'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });
        
        $this->renderable(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e,$request) {
            return response()->json([
                'message' => $e->getMessage(),
                'server_exception'=> true
            ], 404);
        });

        $this->renderable(function (\Illuminate\Session\TokenMismatchException $e,$request) {
            $errorMessage = 'Your Token is Mismatched';
            if($request->ajax()){
                return response()->json([
                    'message' => $errorMessage,
                    'server_exception'=> true
                ], 404);
            }  
            return redirect()->back()->with('error',$errorMessage);
        });

        $this->renderable(function (\Illuminate\Database\QueryException $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => end($e->errorInfo)
                ], 404);
            }   
            
            $errorMessage = (!empty(end($e->errorInfo)))?end($e->errorInfo):'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });

        $this->renderable(function (\Illuminate\Contracts\Encryption\DecryptException $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => 'Invalid Id'
                ], 404);
            }   
            
            $errorMessage = 'Something went wrong with your requested id, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });

        
        $this->renderable(function (\Throwable $e,$request) {
            //
            if($request->ajax()){
                return response()->json([
                    'message' => end($e->getMessage())
                ], 404);
            }
            print_r($e->getMessage());
            die;
            

            $errorMessage = (!empty($e->getMessage()))?$e->getMessage():'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });

        $this->renderable(function (\Exception $e,$request) {
            if($request->ajax()){
                return response()->json([
                    'message' => end($e->getMessage())
                ], 404);
            }

            $errorMessage = (!empty($e->getMessage()))?$e->getMessage():'Something went wrong, Please try again.';
            return redirect()->back()->with('error',$errorMessage);
        });
        
    }
}
