@extends('welcome')
@section('content')
<script >
  // Alpine.data("auth", () => ({
  //   show: false,
  //   payload:{email: '',password: ''},
  //   users: [],
  //   toggle: '0',
  //   respon: '',
  //   login(){
  //       const data = new FormData()
  //       data.append('email', this.payload.email)
  //       data.append('password', this.payload.password)
  //       const respon = fetch('https://friendzone-bakery.fly.dev/api/login',{
  //       method: 'POST',
  //       body: data
  //       })
  //       .then(async (response) => {
  //       this.users = await response.json()
  //       const user = this.users.data
  //       let token = localStorage.setItem('token', user.auth.token)
  //       this.token = token
  //       if(user.user.roleid == '1' || user.user.roleid == '2' ){
  //           window.location.replace('https://fzbakery.fly.dev/dashboard')
  //       }
  //       if(user.user.roleid == '3'){
  //           window.location.replace('https://fzbakery.fly.dev/')
  //       }
  //       });
  //   },
  //   }))

    Alpine.data('login', () => ({
        payload: {
            email: '',
            password: '',
        },
        async masuk() {
            let login = await fetch('http://localhost:5138/api/Auth/login', {
                method: 'POST',
                body: this.payload,
                mode: 'no-cors',
                headers: {
                  'Content-Type': 'application/json'
                },
            })

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
