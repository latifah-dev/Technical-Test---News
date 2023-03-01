@extends('welcome')
@section('content')
<div class="container">
  <form action="{{route('update-news', $news['id'])}}" method="post" enctype="multipart/form-data">
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Update News</h2>
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" class="form-control" name="Title" id="Title" value="{{$news['title']}}" placeholder="masukkan judul">
    </div>
    <div class="form-group">
      <label for="banner">Banner</label> <br/>
      <img src="{{$news['url']}}" alt="" width="200">
      <input type="file" class="form-control" name="FileImage" id="FileImage" placeholder="masukkan banner">
    </div>
    <div class="form-group">
        <label for="banner">Content</label>
        <input type="text" class="form-control" name="Content" id="Content" value="{{$news['content']}}" placeholder="masukkan content">
    </div>
    <input type="hidden" name="Url" id="Url" value="{{$news['url']}}">
    <input type="hidden" name="FileName" id="FileName" value="{{$news['fileName']}}">
    
    <button type="submit" class="btn btn-primary">Create</button>
  </form>
</div>
  @endsection
