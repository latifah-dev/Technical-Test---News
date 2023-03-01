@extends('welcome')
@section('content')
<div class="container">
  <form action="{{route('create-news')}}" method="post" enctype="multipart/form-data">
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Create News</h2>
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" class="form-control" name="Title" id="Title" placeholder="masukkan judul">
    </div>
    <div class="form-group">
        <label for="banner">Banner</label>
        <input type="file" class="form-control" name="FileImage" id="FileImage" placeholder="masukkan banner">
    </div>
    <div class="form-group">
        <label for="banner">Content</label>
        <input type="text" class="form-control" name="Content" id="Content" placeholder="masukkan content">
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
  </form>
</div>
  @endsection
