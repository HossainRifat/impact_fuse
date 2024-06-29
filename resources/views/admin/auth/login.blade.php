@extends('layouts.guest')

@section('content')
<div id="auth-left">
    <div class="auth-logo mb-2 text-center">
        <a href="{{route('login.post')}}"><img src="{{asset('assets/compiled/svg/logo.svg')}}" alt="Logo"></a>
    </div>
    <h1 class="auth-title text-center">Log in</h1>

    <form action="{{route('login.post')}}" method="POST">
        @csrf
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="text" class="form-control form-control-xl" placeholder="Username" name="email">
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
            <x-validation-error :errors="$errors->first('email')"/>
        </div>
        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password">
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <x-validation-error :errors="$errors->first('password')"/>
        </div>
        <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                Keep me logged in
            </label>
        </div>
        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
    </form>
    <div class="text-center mt-4 text-lg fs-4">
        <p><a class="font-bold" href="auth-forgot-password.html">Forgot password ?</a></p>
    </div>
</div>
@endsection