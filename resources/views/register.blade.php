@extends('welcome')
@section('content')
<div class="container">

<form action="{{route('register')}}" method="post" >
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Register</h2>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" name="email" id="email" placeholder="masukkan email">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="masukkan password">
      </div>
      <div>
        <label for="login">Sudah memiliki akun ? <a href="/login">Login</a></label> <br>
        </div>
    <button type="submit" class="btn btn-primary">Register</button>
  </form>
</div>
  @endsection
