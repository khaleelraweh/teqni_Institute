@extends('layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('Login') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('Login') }}</h2>

                <form method="POST" action="{{ route('login') }}" class="pt-5">

                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="username" class="text-small text-uppercase">{{ __('UserName') }}</label>
                                <input id="username" type="text"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    name="username" placeholder="Enter Your Name" value="{{ old('username') }}" required
                                    autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <label for="password" class="text-small text-uppercase">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" placeholder="Enter Your Password" required
                                    autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6 form-group mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label  text-small text-uppercase" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-item-center justify-content-between flex-wrap">

                                <div class="mb-2">
                                    <button type="submit" class="btn btn-dark">
                                        {{ __('Login') }}
                                    </button>
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link  " href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>

                                @if (Route::has('register'))
                                    <a class="btn btn-secondary mb-2 " href="{{ route('register') }}">
                                        {{ __('Have\'t an account?') }}
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
@endsection
