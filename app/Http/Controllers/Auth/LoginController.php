<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
//        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $data = $request->all();

        $email = $data['w3']['U3'];

        $res = json_decode(file_get_contents("https://www.googleapis.com/plus/v1/people/me?fields=emails&access_token={$data['Zi']['access_token']}"));

        if (isset($res->emails)
        && is_array($res->emails)
        && count(array_filter($res->emails, function($e) use ($email) { return $e->value == $email; }))
        && Role::where('email', $email)->count()
        ) {

            $user = User::firstOrNew(compact('email'));

            $user->first_name = $data['w3']['ofa'];
            $user->last_name = $data['w3']['wea'];
            $user->avatar_url = $data['w3']['Paa'];

            $user->save();

            Auth::login($user);

            return response()->json([
                'code' => 'ok',
                'message' => 'Login successful.',
                'user' => $user
            ]);

        }

        return response()->json([
            'code' => 'failed',
            'message' => 'Login failed.'
        ], 500);

    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'code' => 'ok',
            'message' => 'Logout successful.'
        ]);
    }

}
