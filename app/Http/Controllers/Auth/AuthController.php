<?php

namespace App\Http\Controllers\Auth;

use App\AppMailers\AppMailerFacade as AppMailer;
use App\User;
use Illuminate\Support\Facades\URL;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * Đường dẫn chuyển hướng khi đăng nhập thành công
     *
     * @var string
     */
    public $redirectTo = '/';

    /**
     * @var string
     */
    public $redirectPath = '/';

    /**
     * @var string
     */
    public $redirectAfterLogout = '/';


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tos' => 'required',
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'name' => 'required|max:255|unique:user',
            'email' => 'required|email|max:255|unique:user',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'verified' => 0,
            'verify_token' => str_random(10)
        ]);
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        AppMailer::send_email_confirmation_to($user);

        //Auth::guard($this->getGuard())->login();

        return redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        return view('auth.register');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout(Request $request)
    {
        $ret = $this->logout();
        $ref = $request->request->get('ref');
        $redirect = $request->request->get('redirect');

        if(!empty($redirect))
            return redirect($redirect);

        switch($ref) {
            case 'admin':
                return redirect()->action('AdminController@index');
            case 'home':
                return redirect()->action('HomeController@index');
            default:
                return $ret;
        }
    }
}
