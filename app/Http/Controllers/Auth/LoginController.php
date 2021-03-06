<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendFailedLoginResponse(Request $request)
    {

        return "This username and password wrong";
    }
    
    protected function authenticated(Request $request, $user)
{       
    $client = DB::table('oauth_clients')->where('id',2)->first();
    $http = new Client;
    $response = $http->post(url('/oauth/token'), [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => '2',
            'client_secret' => $client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'provider' => 'users'
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
}

}
