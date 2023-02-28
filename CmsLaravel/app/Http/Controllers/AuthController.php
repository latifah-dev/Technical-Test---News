<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    //
    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Kirim permintaan ke API
    $response = Http::post('http://localhost:5138/api/Auth/login', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    // Ambil status code dari respons API
    $statusCode = $response->status();

    if ($statusCode == 200) {
        // Jika login berhasil, simpan data pengguna ke sesi
        session(['user' => $response->json()]);

        // Redirect ke halaman dashboard
        return redirect('/create-news');
    } else {
        // Jika login gagal, tampilkan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }
}

}
