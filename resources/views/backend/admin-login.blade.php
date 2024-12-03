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
                                            {{ __('panel.welcome_back_login_to_your_account') }}</h5>
                                        <form class="forms-sample" action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="userEmail" class="form-label">{{ __('panel.user_name') }}
                                                    {{ __('panel.or') }} {{ __('panel.f_email') }}</label>

                                                <input class="form-control" type="text" name='username' id="userEmail"
                                                    value="{{ old('username') }}"
                                                    placeholder="{{ __('panel.f_user_email') }}">
                                                @error('username')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="mb-3">
                                                <label for="userPassword"
                                                    class="form-label">{{ __('panel.f_password') }}</label>
                                                <input type="password" class="form-control" id="userPassword"
                                                    name="password" autocomplete="current-password"
                                                    placeholder="{{ __('panel.f_password') }}">
                                                @error('userPassword')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>
                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="authCheck">
                                                <label class="form-check-label" for="authCheck">
                                                    {{ __('panel.remember_me') }}
                                                </label>
                                            </div>
                                            <div>
                                                <button class="btn w-100 btn-primary me-2 mb-2 mb-md-0 text-white"
                                                    type="submit">{{ __('panel.f_login') }}
                                                </button>
                                            </div>
                                            <a href="{{ route('admin.recover-password') }}"
                                                class="d-block mt-3 text-muted">{{ __('panel.f_forgot_password') }}</a>
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
