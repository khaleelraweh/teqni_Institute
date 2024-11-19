@extends('layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-4 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('panel.f_login') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                </div>
            </div>
        </div>
    </section>

    <!-- banner section start -->
    <section class="py-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('panel.f_login') }}</h2>


                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <div class="sign-in-form clearfix">
                        <div class="form-group">
                            <div class="form-group">
                                <input id="username" type="text"
                                    class="form-control form-control-lg @error('username') is-invalid @enderror"
                                    name="username"
                                    placeholder="{{ __('panel.enter_your') }} {{ __('panel.f_email') }} {{ __('panel.or') }} {{ __('panel.f_user_name') }}"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus id="email">
                                @error('username')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    name="password" placeholder="{{ __('panel.enter_your') }} {{ __('panel.f_password') }}"
                                    required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        @if (Route::has('password.request'))
                            <p class="condition">
                                <a href="{{ route('password.request') }}">{{ __('panel.f_forgot_password') }}</a>
                            </p>
                        @endif
                        <div class="col-12 mb-3">
                            <div class="form-group d-flex align-item-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <button type="submit" class="btn btn-default btn-red" style="width: 100%">
                                        {{ __('panel.f_login') }}
                                    </button>

                                </div>



                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    </section>
    <!-- banner section end -->
@endsection
