@extends('welcome')
@section('content')
<div class="container">
  <h2 class="d-flex justify-content-center mt-5">List NEWS</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Banner</th>
        <th scope="col">Title</th>
        <th scope="col">Publish Date</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($news as $n)
      <tr>
        <th scope="row">{{$loop->iteration}}</th>
        <td><img src="{{$n['url']}}" alt="" width="300"></td>
        <td>{{$n['title']}}</td>
        <td>{{$n['publishDate']}}</td>
        <td>
          <a href="{{route('detailnews', $n['id'])}}"><button>Detail</button></a>
          <a href="{{route('updatenews', $n['id'])}}"><button>Edit</button></a>
          <a href="{{route('deletenews', $n['id'])}}"><button>Delete</button></a>
        </td>
      </tr>
      @endforeach
    </tbody>    
  </table>
</div>
  @endsection
