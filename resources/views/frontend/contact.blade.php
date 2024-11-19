@extends('layouts.app')

@section('content')
    <?php
    $parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);
    
    // Remove 'www.' if it exists
    $domain = preg_replace('/^www\./', '', $parsedUrl);
    
    ?>
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
                @php
                    if ($siteSettings['site_img']->value != null) {
                        $site_img = asset('assets/site_settings/' . $siteSettings['site_img']->value);

                        if (!file_exists(public_path('assets/site_settings/' . $siteSettings['site_img']->value))) {
                            $site_img = asset('image/not_found/placeholder.jpg');
                        }
                    } else {
                        $site_img = asset('image/not_found/placeholder.jpg');
                    }
                @endphp

                <img style="height: 24em" src="{{ $site_img }}" alt="{{ $siteSettings['site_name']->value }}">

            </div>
            <div class="breadcrumbs-text white-color padding">
                <h1 class="page-title">{{ __('panel.contact') }}</h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>{{ __('panel.contact') }}</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Contact Section Start -->
        <div class="contact-page-section  pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row align-items-center pb-50">
                    <div class="col-lg-5 md-mb-50">
                        <div class="contact-address-section style2">
                            <div class="contact-info mb-15 md-mb-30">
                                <div class="icon-part">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="content-part">
                                    <h5 class="info-subtitle">{{ __('panel.f_address') }}</h5>
                                    <h4 class="info-title">{{ $siteSettings['site_address']->value }}</h4>
                                </div>
                            </div>
                            <div class="contact-info mb-15 md-mb-30">
                                <div class="icon-part">
                                    <i class="fa fa-envelope-open-o"></i>
                                </div>
                                <div class="content-part">
                                    <h5 class="info-subtitle">{{ __('panel.f_email') }}</h5>
                                    <h4 class="info-title"><a
                                            href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                                    </h4>
                                </div>
                            </div>
                            <div class="contact-info">
                                <div class="icon-part">
                                    <i class="fa fa-headphones"></i>
                                </div>
                                <div class="content-part">
                                    <h5 class="info-subtitle">{{ __('panel.f_phone') }}</h5>
                                    <h4 class="info-title"><a
                                            href="tel%2b0885898745.html">{{ $siteSettings['site_phone']->value ?? '' }}</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <!-- Map Section Start -->
                        <div class="contact-map">
                            <iframe
                                src="https://maps.google.com/maps?q=%D8%A7%D9%84%D9%85%D8%B9%D9%87%D8%AF%20%D8%A7%D9%84%D8%AA%D9%82%D9%86%D9%8A%20%D8%A7%D9%84%D8%B9%D8%A7%D9%84%D9%8A%20%D8%AC%D8%A7%D9%88%D8%A8%20%D9%84%D9%85%D8%B3%D8%AA%D8%B4%D9%81%D9%89%20%D8%A7%D9%84%D8%AB%D9%88%D8%B1%D8%A9%2C%20%D8%A5%D8%A8%2C%20%D9%8A%D9%85%D9%86&amp;t=&amp;z=15&amp;ie=UTF8&amp;iwloc=&amp;output=embed"
                                width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0"></iframe>

                        </div>
                        <!-- Map Section End -->
                    </div>
                </div>

                <div class="row align-items-end contact-bg1">
                    <div class="col-lg-4 md-pt-50 lg-pr-0">
                        <div class="contact-image">
                            <img src="{{ asset('frontend/images/contact/2.png') }}" alt="Contact Images">
                        </div>
                    </div>
                    <div class="col-lg-8 lg-pl-0">
                        <div class="rs-quick-contact new-style">
                            <div class="inner-part mb-35">
                                <h2 class="title mb-15">{{ __('panel.get_in_touch') }}</h2>
                                <p>
                                    {{ __('panel.get_in_touch_message') }}
                                </p>
                            </div>
                            {{-- <div id="form-messages"></div> --}}

                            @if (session('success'))
                                <div id="form-messages" class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if (session('error'))
                                <div id="form-messages" class="alert alert-danger">{{ session('error') }}</div>
                            @endif


                            {{-- <form id="contact-form" method="POST" action="{{ route('contact.submit') }}"> --}}
                            <form method="POST" action="{{ route('contact.submit') }}">
                                @csrf <!-- This is the CSRF token to protect against cross-site request forgery -->
                                <div class="row">
                                    <div class="col-lg-6 mb-30 col-md-6 col-sm-6">
                                        <input class="from-control" type="text" id="name" name="name"
                                            placeholder="Name" required="">
                                    </div>
                                    <div class="col-lg-6 mb-30 col-md-6 col-sm-6">
                                        <input class="from-control" type="email" id="email" name="email"
                                            placeholder="Email" required="">
                                    </div>
                                    <div class="col-lg-6 mb-30 col-md-6 col-sm-6">
                                        <input class="from-control" type="text" id="phone" name="phone"
                                            placeholder="Phone" required="">
                                    </div>
                                    <div class="col-lg-6 mb-30 col-md-6 col-sm-6">
                                        <input class="from-control" type="text" id="subject" name="subject"
                                            placeholder="Subject" required="">
                                    </div>

                                    <div class="col-lg-12 mb-40">
                                        <textarea class="from-control" id="message" name="message" placeholder=" Message" required=""></textarea>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <input class="btn-send" type="submit" value="Submit Now">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact Section End -->

    </div>
    <!-- Main content End -->
@endsection
