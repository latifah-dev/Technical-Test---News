@extends('welcome')
@section('content')
<div class="container">
  <h2 class="d-flex justify-content-center mt-5">Detail NEWS</h2>
        <img src="{{$news['url']}}" alt="">
        <h4>{{$news['title']}}</h4>
        <h5>{{$news['publishDate']}}</h5>
        <h5>{{$news['content']}}</h5>

        <a href="{{route('updatenews', $news['id'])}}"><button>Edit</button></a>
        <a href="{{route('deletenews', $news['id'])}}"><button>Delete</button></a>
</div>
  @endsection
