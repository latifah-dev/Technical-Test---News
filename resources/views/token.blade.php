@extends('welcome')
@section('content')
<div class="container">

<form action="{{route('verify')}}" method="post">
    @csrf
    <h2 class="d-flex justify-content-center mt-5">Verify Email</h2>
    <div class="form-group">
      <label for="email">Code</label>
      <input type="nama" class="form-control" name="token" id="token" placeholder="masukkan code">
    </div>
    <button type="submit" class="btn btn-primary">Verify</button>
  </form>
</div>
  @endsection
