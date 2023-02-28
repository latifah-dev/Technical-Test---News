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
    <button type="submit" class="btn btn-primary">Reset Password</button>
  </form>
</div>
  @endsection
