@extends('layouts.app')

@section('content')
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row px-4 px-lg-4 py-lg-4 align-items-center">
                <div class="col-lg-6">
                    <h1 class="h2 text-uppercase mb-0">{{ __('panel.f_reset_password') }}</h1>
                </div>
                <div class="col-lg-6 text-lg-end">
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="h5 text-uppercase mb-3">{{ __('panel.f_reset_password') }}</h2>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('panel.f_email') }}</label>

                        <div class="col-md-6">
                            <input id="email" name="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-dark">
                                {{ __('panel.f_send_reset_link') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
