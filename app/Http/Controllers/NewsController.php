<?php

namespace App\Http\Controllers;
use App\Helpers\HttpClient;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    //
    public function showNews()
    {
        $getNews = HttpClient::fetch("GET", HttpClient::apiUrl()."News/"."show-news");
        $news = $getNews['data'];
        if ($getNews['status'] == false) {
            return redirect('/create-news')->with('error', $getNews['message']);
        }

        return view('shownews', compact('news'));
    }

    public function detailNews($id)
    {
        $getNews = HttpClient::fetch(
        "GET",
         HttpClient::apiUrl()."News/detail-news?id=".$id,
        );
        $news = $getNews['data'];
        if ($getNews['status']==false) {
        return redirect('/show-news')->with('error', $getNews['message']);
        }
        return view('detailnews', compact('news'));
    }

    public function createNews(Request $request)
    {
        //dd(Carbon::parse($request->PublishDate)->utc());
        $date = date('Y-m-d\TH:i:sp');
        $file = [
            'FileImage' => $request->file('FileImage')
        ];
        $payload = [
            'Title' => $request->Title,
            'Content' => $request->Content,
            'PublishDate' => $date,
        ];

        $create = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."News/"."create-news",
            $payload,
            $file,
        );

        if ($create['status'] == false) {
        return redirect('/create-news')->with('error', $create['message']);
        }

        return redirect('/show-news')->with('success', $create['message']);
    }

    public function editNews($id)
    {
        $getNews = HttpClient::fetch(
        "GET",
         HttpClient::apiUrl()."News/detail-news?id=".$id,
        );
        $news = $getNews['data'];
        if ($getNews['status']==false) {
        return redirect('/show-news')->with('error', $getNews['message']);
    }
    return view('updatenews', compact('news'));
    }
    
    public function updateNews(Request $request, $id)
{
    $date = date('Y-m-d\TH:i:sp');
    
    // Cek apakah input file kosong atau tidak
    if ($request->hasFile('FileImage')) {
        // Jika input file tidak kosong, gunakan data baru
        $file = [
            'FileImage' => $request->file('FileImage')
        ];
    } else {
        // Jika input file kosong, biarkan data kosong
        $file = [];
    }

    $payload = [
        'Title' => $request->Title,
        'Content' => $request->Content,
        'PublishDate' => $date,
    ];
    
    $create = HttpClient::fetch(
        "POST",
        HttpClient::apiUrl()."News/"."update-news?id=".$id,
        $payload,
        $file,
    );

    if ($create['status'] == false) {
        return redirect('/show-news')->with('error', $create['message']);
    }
    
    return redirect('/show-news')->with('success', $create['message']);
}


    public function destroy($id)
    {
        $delete = HttpClient::fetch(
            "POST",
            HttpClient::apiUrl()."News/delete-news?id=".$id,
        );
        if ($delete['status'] == false) {
            return redirect('/show-news')->with('error', $delete['message']);
        }
        return redirect('/show-news')->with('success', $delete['message']);
    }
}
