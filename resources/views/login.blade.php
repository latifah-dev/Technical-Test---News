@extends('welcome')
@section('content')

<div class="container">
  <div>
    <form action="{{route('login')}}" method="post" class="">
      @csrf
      <h2 class="d-flex justify-content-center mt-5">Login</h2>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" placeholder="masukkan email">
      </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" placeholder="masukkan password">
    </div>
    <div>
      <label for="register">belum memiliki akun ? <a href="/register">Register</a></label> <br>
      <label for="forgotpassword">lupa kata sandi ? <a href="/forgot-password">Forgot Password</a></label> <br>
    </div>
      <button type="submit" class="btn btn-primary">LOGIN</button>
    </form>
  </div>
</div>



@endsection
