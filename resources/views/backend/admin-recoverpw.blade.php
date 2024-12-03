@extends('layouts.admin-auth')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            <div class="page-content d-flex align-items-center justify-content-center">

                <div class="row w-100 mx-0 auth-page">
                    <div class="col-md-8 col-xl-6 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-4 pe-md-0">
                                    <div class="auth-side-wrapper">

                                    </div>
                                </div>
                                <div class="col-md-8 ps-md-0">
                                    <div class="auth-form-wrapper px-4 py-5">
                                        <a href="#"
                                            class="noble-ui-logo d-block mb-2">{{ __('panel.university') }}<span>{{ __('panel.ibb') }}</span></a>
                                        <h5 class="text-muted fw-normal mb-4">
                                            {{ __('panel.f_reset_password') }}</h5>
                                        <form class="form-horizontal mt-3" action="{{ route('password.email') }}"
                                            method="POST" class="user">
                                            @csrf
                                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                                {{ __('panel.enter_your') }} <strong>{{ __('panel.email') }}</strong>
                                                {{ __('panel.and_instructions_will_be_sent_to_you') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">
                                                    {{ __('panel.f_email') }}
                                                </label>

                                                <input class="form-control" type="email" name="email" id="email"
                                                    value="{{ old('email') }}" placeholder="{{ __('panel.f_email') }}">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>

                                            <div>
                                                <button class="btn w-100 btn-primary me-2 mb-2 mb-md-0 text-white"
                                                    type="submit" name="submit">
                                                    {{ __('panel.send_email') }}
                                                </button>
                                            </div>

                                            <a href="{{ route('admin.login') }}"
                                                class="d-block mt-3 text-muted">{{ __('panel.already_have_an_account') }}</a>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
