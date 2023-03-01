<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $payload = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $auth = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/"."login",
            $payload,
        );

        if (!session()->isStarted()) {
            session()->start();
        }

        if ($auth['status'] == false) {
            return redirect('/login')->with('error', $auth['message']);
        }

        $token = $auth['data']['auth']['token'];
        $idUser = $auth['data']['user']['id'];

        session()->put("token", "$token");
        session()->put("idUser", $idUser);

        return redirect('/')->with('success', $auth['message']);
    }

    public function logout()
    {
        if (!session()->isStarted()) {
            session()->start();
        }
        session()->flush();
        return redirect('/login')->with('success',"terima kasih telah berkunjung, silahkan kembali lagi");
    }
    public function register(Request $request)
    {
        $payload = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $register = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/"."register",
            $payload,
        );

        if ($register['status'] == false) {
            return redirect('/register')->with('error', $register['message']);
        }

        return redirect('/verify-email')->with('success', $register['message']);
    }

    public function verify(Request $request)
{
        $token = $request->input('token');
        
        $verify = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/verify?token=".$token,
        );

        if ($verify['status'] == false) {
            return redirect('/')->with('error', $verify['message']);
        }

        return redirect('/login')->with('success', $verify['message']);
    }

    public function forgotPassword(Request $request)
    {
        $email = $request->input('email');
        $forgot = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/"."forgot-password?email=".$email,
        
        );

        if ($forgot['status'] == false) {
            return redirect('/forgot-password')->with('error', $forgot['message']);
        }

        return redirect('/reset-password')->with('success', $forgot['message']);
    }
    public function resetPassword(Request $request)
    {
        $payload = [
            'token' => $request->token,
            'password' => $request->password,
            'verifyPassword' => $request->verifyPassword,
        ];

        $reset = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/"."reset-password",
            $payload,
        );

        if ($reset['status'] == false) {
            return redirect('/register')->with('error', $reset['message']);
        }

        return redirect('/verify-email')->with('success', $reset['message']);
    }
    public function changePassword(Request $request)
    {
        $payload = [
            'oldPassword' => $request->oldPassword,
            'passwordNew' => $request->passwordNew,
            'verifyPassword' => $request->verifyPassword,
        ];
        $change = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."Auth/change-password",
            $payload,
        );
        if ($change['status'] == false) {
            return redirect('/change-password')->with('error', $change['message']);
        }

        return redirect('/')->with('success', $change['message']);
    }
}
