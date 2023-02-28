@extends('welcome')
@section('content')
<script >
  Alpine.data('login', () => ({
      payload: {
          email: '',
          password: '',
      },
      async masuk() {
          const formData = new FormData();
          formData.append('email', this.payload.email)
          formData.append('password', this.payload.password)
          let login = await fetch('https://api-heatmap-farcapital.fly.dev/v1/api/login', {
              method: 'POST',
              body: formData,
              headers: {
                'Content-Type': 'application/json'
              },
          })

          let hasil = await login.json()
          console.log(login)
          //return window.location.replace('')
      },
  }));
</script>




<div class="container" x-data="login">
  @if($errors->any())
    {{$errors->first()}}
  @endif
    <form x-on:submit.prevent="masuk()">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="nama" class="form-control" x-model="payload.email" placeholder="masukkan email">
      </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" x-model="payload.password" placeholder="masukkan password">
    </div>
    <div>
      <a href="/register"><label for="register">Register</label></a> <br>
      <a href="/forgot-password"><label for="forgotpassword">Forgot Password</label></a>
    </div>
      <button type="submit" class="btn btn-primary">LOGIN</button>
    </form>
</div>



@endsection
