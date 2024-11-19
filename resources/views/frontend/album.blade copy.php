@extends('layouts.app')

@section('content')
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">

                {{-- <img src="{{ $siteSettings['site_img']->value ? asset('assets/site_settings/' . $siteSettings['site_img']->value) : asset('frontend/images/lite-logo.png') }}"
                    alt="{{ $siteSettings['site_name']->value }}"> --}}

                <img src="{{ asset('frontend/images/breadcrumbs/2.jpg') }}" alt="Breadcrumbs Image">
            </div>
            <div class="breadcrumbs-text white-color">
                <h1 class="page-title">
                    album title
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        album title
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Events Section Start -->
        <div class="rs-gallery style2">
            <div class="row margin-0">
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/1.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/1.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/2.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/2.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/3.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/3.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/4.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/4.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/5.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/5.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 padding-0 mb-0 col-md-4 col-sm-6">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <a class="image-popup" href="{{ asset('frontend/images/gallery/home8/6.jpg') }}"><img
                                    src="{{ asset('frontend/images/gallery/home8/6.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Events Section End -->
    </div>
    <!-- Main content End -->
@endsection
