@extends('welcome')
@section('content')
<div class="container">
<form action="{{route('reset-password')}}" method="post" class="">
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Reset Password</h2>
    <div class="form-group">
      <label for="token">Code</label>
      <input type="text" class="form-control" name="token" id="token" placeholder="masukkan token">
    </div>
    <div class="form-group">
      <label for="token">New Password</label>
      <input type="password" class="form-control" name="password" id="password" placeholder="masukkan password baru">
    </div>
    <div class="form-group">
      <label for="token">Verify New Password</label>
      <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="masukkan password baru">
    </div>
    <button type="submit" class="btn btn-primary">Reset Password</button>
  </form>
</div>
  @endsection
