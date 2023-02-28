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
        <input type="password" class="form-control" name="password" id="password" placeholder="masukkan password">
      </div>
      <a href="/register"><label for="register">Register</label></a> <br>
      <a href="/forgot-password"><label for="forgotpassword">Forgot Password</label></a>
    <button type="button" class="btn btn-primary" id="login">LOGIN</button>
  </form>
</div>
<script>
$(document).ready(function(){
    $('#login').click(function(){
        var email = $('#email').val();
        var password = $('#password').val();
        $.ajax({
            type:'POST',
            url:'/login',
            data:{email:email, password:password, _token: '{{csrf_token()}}'},
            success:function(data){
                // code to handle success response from API
                // data adalah respons dari API
                if (data.status == 'success') {
                    // Jika status sukses, arahkan pengguna ke halaman dashboard
                    window.location.href = '/dashboard';
                } else {
                    // Jika status gagal, tampilkan pesan error
                    alert(data.message);
                }
            },
            error:function(xhr,status,error){
                // code to handle error response from API
                // xhr adalah objek XMLHttpRequest, status adalah string status error, error adalah objek error
              console.log(xhr.responseText);
              alert('Terjadi kesalahan saat memproses permintaan');
            }
        });
    });
});
</script>
@endsection