<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Models\User;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function getEmail()
    {
        return $this->showLinkRequestForm();
    }
    
    public function submitEmail(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        
        Validator::extend('userexists', function ($attribute, $value, $parameters, $validator) {
            $user = User::where([
                    'email' => $value,
                ])->first();
            return !empty($user);
        });
        Validator::replacer('userexists', function ($message, $attribute, $rule, $parameters) {
            return 'Пользователь с такой электронной почтой не найден';
        });
        
        $validator = Validator::make(Input::all(), [
            'email' => 'required|email|userexists',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        
        $this->sendResetLinkEmail($request);
        
        return response()->json([
            'success' => true,
            'redirect' => '/resetEmailSuccess',
        ]);
    }
    
    public function resetEmailSuccess()
    {
        return view('auth.emails.resetEmailSuccess');
    }
    
    public function changePassword(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $rules = $this->getResetValidationRules();
        $rules['password'] = 'required|confirmed|min:6';
        
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ]);
        }
        
        $this->reset($request);
        
        return response()->json([
            'success' => true,
            'redirect' => '/login',
        ]);
    }
    
    public function confirmEmail(Request $request)
    {
        $user = (new User())
                ->where(['new_email' => $request->mail])
                ->first();
        if(empty($user) || !$user->hashCheckNewMail($request->mail, $request->security) || empty($user->new_email)) {
            return view('errors.noacess');
        }
        
        $user->email = $user->new_email;
        $user->new_email = '';
        $user->save();
        return view('auth.confirmEmailSuccess');
    }
    
    public function registerSuccess(Request $request)
    {
        return view('auth.registerSuccess');
    }
    
}
