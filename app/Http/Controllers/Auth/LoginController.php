<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $api = new ApiService;
        $response = $api->post('/user/login', $request->only('email', 'password'));

        //dd($response, session('authenticated'));

        if(!$response['success']) {
            return redirect(route('login'));
        }

        session(['authenticated' => $response]);

        return redirect(route('home'));

    }
}
