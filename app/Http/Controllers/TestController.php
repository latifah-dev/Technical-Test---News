<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function masuk(Request $request)
    {
        $payload = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $auth = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."login",
            $payload,
        );

        if($auth['status'] == false){
            dd($auth['message']);
        }

        return redirect('www.google.com');
    }
}
