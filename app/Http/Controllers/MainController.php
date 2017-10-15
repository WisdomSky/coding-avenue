<?php

namespace App\Http\Controllers;

use App\Libraries\Crypto\Crypto;
use App\Libraries\Ingenuiti\Adobo\Adobo;
use App\Libraries\Ingenuiti\Aktibo\Facades\Aktibo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function index()
    {
        $data = ['auth_user' => null];


        if (Auth::user()) {
            $data['auth_user'] = Crypto::cryptoJsAesEncrypt(csrf_token(), Auth::user());
        }

        return view('index', $data);
    }


}
