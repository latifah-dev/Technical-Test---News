@extends('welcome')
@section('content')
<div class="container">
    @if($errors->any())
    {{$errors->first()}}
    @endif
<form action="/login">
    @csrf
    <div class="form-group">
      <label for="email">Email</label>
      <input type="nama" class="form-control" name="email" id="email" placeholder="masukkan email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="text" class="form-control" name="password" id="password" placeholder="masukkan password">
      </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>
  @endsection
