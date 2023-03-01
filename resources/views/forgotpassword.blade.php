@extends('welcome')
@section('content')
<div class="container">
<form action="{{route('forgot-password')}}" method="post" class="">
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Forgot Password</h2>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="masukkan email">
    </div>
    <button type="submit" class="btn btn-primary">Reset Password</button>
  </form>
</div>
  @endsection
