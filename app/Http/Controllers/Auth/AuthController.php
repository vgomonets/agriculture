<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DateTime;
use App\Models\Role;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|min:18',
                'password' => 'required|min:8|confirmed',
                'isAgreement' => 'required',
            ]
        );
    }

    /**
     * Inherit
     */
    public function register(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'success' => false,
            ]);
        }
        $validator = $this->validator(Input::all());

        if ($validator->fails()) {
            return response()->json(
                [
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray(),
                ]
            );
        }

        $this->create(Input::all());
        Auth::guard($this->getGuard());

        return response()->json(
            [
                'success' => true,
                'redirect' => '/registerSuccess',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->unguard();
        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'new_email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'api_key' => str_random(40),
        ]);
        $user->save();
        $user->roles()->associate(Role::find(4)); // manager

        $data['link'] = $user->linkConfirmMail();
        $this->successfulReg($data);
        return $user;
    }

    /**
     * @param array $data
     * Отправка почты после  удачной регистрации
     */
    private function successfulReg(array $data)
    {
        Mail::send(
            'auth.emails.registration',
            [
                'name' => $data['name'],
                'link' => $data['link'],
                'projectName' => config('app.projectName'),
            ],
            function ($message) use ($data) {
                $message->to($data['email'], $data['name'])->subject('Регистрация');
            }
        );
    }

    /**
     * Inherit
     */
    protected function validateLogin(Request $request)
    {
        $user = (new User())
            ->where(['email' => $request->email])
            ->first();

        Validator::extend(
            'wrongPassword',
            function ($attribute, $value, $parameters, $validator) use ($user) {
                if (empty($user)) {
                    return response()->json([
                        'success' => false,
                    ]);
                }

                return Hash::check($value, $user->password);
            }
        );
        Validator::replacer(
            'wrongPassword',
            function ($message, $attribute, $rule, $parameters) {
                return "Неправильный пароль";
            }
        );

        Validator::extend(
            'emailIsConfirmed',
            function ($attribute, $value, $parameters, $validator) use ($user) {
                if (!empty($user->new_email) && $user->email == $user->new_email) {
                    return response()->json([
                        'success' => false,
                    ]);
                }

                return true;
            }
        );
        Validator::replacer(
            'emailIsConfirmed',
            function ($message, $attribute, $rule, $parameters) {
                return "Перед авторизацией необходимо подтвердить email.";
            }
        );

        $this->validate(
            $request,
            [
                $this->loginUsername() => 'required|emailIsConfirmed',
                'password' => 'required|min:8|wrongPassword',
            ]
        );
    }

    public function showRegistrationForm()
    {
        return redirect('login');
    }
}
