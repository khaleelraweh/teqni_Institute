@extends('layouts.app')

@section('content')

    <section class="py-5 bg-light">
        <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
            <h1 class="h2 text-uppercase mb-0">{{__('Register')}}</h1>
            </div>
            <div class="col-lg-6 text-lg-end">
            </div>
        </div>
        </div>
    </section>
    
    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{__('Register')}}</h2>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="first_name" class="text-small text-uppercase">{{ __('FirstName') }}</label>
                                <input id="first_name" name="first_name" type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror"  placeholder="Enter Your First Name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                @error('first_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="last_name" class="text-small text-uppercase">{{ __('LastName') }}</label>
                                <input id="last_name" name="last_name" type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror"  placeholder="Enter Your Last Name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="username" class="text-small text-uppercase">{{ __('UserName') }}</label>
                                <input id="username" name="username" type="text" class="form-control form-control-lg @error('username') is-invalid @enderror"  placeholder="Enter Your User Name" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="email" class="text-small text-uppercase">{{ __('E-mail Address') }}</label>
                                <input id="email" name="email" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror"  placeholder="Enter Your E-mail Address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="mobile" class="text-small text-uppercase">{{ __('Mobile Number') }}</label>
                                <input id="mobile" name="mobile" type="text" class="form-control form-control-lg @error('mobile') is-invalid @enderror"  placeholder="Enter Your Mobile Number" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
                                @error('mobile')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="password" class="text-small text-uppercase">{{ __('password Number') }}</label>
                                <input id="password" name="password" type="text" class="form-control form-control-lg @error('password') is-invalid @enderror"  placeholder="Enter Your Password Number" value="{{ old('password') }}" required autocomplete="password" autofocus>
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="password_confirmation" class="text-small text-uppercase">{{ __('Password Confirmation Number') }}</label>
                                <input id="password_confirmation" name="password_confirmation" type="text" class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"  placeholder="Enter Your Password Confirmation Number" value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation" autofocus>
                                @error('password_confirmation')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <div class="form-group ">
                                <button type="submit" class="btn btn-dark">
                                    {{ __('Register') }}
                                </button>
                                @if (Route::has('login'))
                                    <a class="btn btn-link  " href="{{ route('login') }}">
                                        {{ __('Have an account') }}
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
