<?php

namespace App\Http\Controllers;

use App\Helpers\HttpClient;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $getKelas = HttpClient::fetch("GET", HttpClient::apiUrl()."kelas");
        // $kelas = $getKelas['data'];
        dd($getKelas);
        return view('admin.kelas.index', compact('kelas'));
    }
}
