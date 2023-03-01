@extends('welcome')
@section('content')
<div class="container">
  <form action="{{route('change-password')}}" method="post" >
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Change Password</h2>
    <div class="form-group">
      <label for="oldPassword">Password Lama</label>
      <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="masukkan password lama">
    </div>
    <div class="form-group">
        <label for="passwordNew">Password Baru</label>
        <input type="password" class="form-control" name="passwordNew" id="passwordNew" placeholder="masukkan password baru">
    </div>
    <div class="form-group">
      <label for="verifyPassword">Verify Password Baru</label>
      <input type="password" class="form-control" name="verifyPassword" id="verifyPassword" placeholder="masukkan verify password">
  </div>
    <button type="submit" class="btn btn-primary">Change Password</button>
  </form>
</div>
  @endsection
