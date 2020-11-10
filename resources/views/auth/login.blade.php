@extends('layouts.app_login')

@section('content')

<div class="login-box">
  <div class="login-logo">
    <a href=""><b>CG-VAK| OFFBOARDING</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in</p>

    <form action="{{ route('login') }}" method="post">
    @csrf
      <div class="form-group has-feedback">
        <label for="name">User name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required >        
      </div>
      @error('name')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
      <div class="form-group has-feedback">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
      </div>
      @error('password')
        <span class="invalid-feedback" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
