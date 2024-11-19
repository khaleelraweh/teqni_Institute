<?php
$parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);

// Remove 'www.' if it exists
$domain = preg_replace('/^www\./', '', $parsedUrl);

?>
<!--Full width header Start-->
<div class="full-width-header header-style2">
    <!--Header Start-->
    <header id="rs-header" class="rs-header">
        <!-- Topbar Area Start -->
        <div class="topbar-area ">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-md-8">
                        <ul class="topbar-contact">

                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <a
                                    href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                            </li>

                            <li>
                                <i class="fa fa-map"></i>
                                {{ $siteSettings['site_address']->value }}
                                {{-- -
                                <i class="fa fa-phone"></i>
                                <a href="tel:+088589-8745">{{ $siteSettings['site_mobile']->value ?? '' }}</a>
                                -
                                {{ __('panel.f_fax') }}
                                <a href="tel:+088589-8745">{{ $siteSettings['site_phone']->value ?? '' }}</a> --}}
                            </li>


                            <li>
                                <i class="fa fa-phone"></i>
                                <a href="tel:+088589-8745">{{ $siteSettings['site_mobile']->value ?? '' }}</a>
                            </li>
                            <li>
                                {{ __('panel.f_fax') }}
                                <a href="tel:+088589-8745">{{ $siteSettings['site_phone']->value ?? '' }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-right">
                        <ul class="topbar-right">

                            @if ($siteSettings['site_facebook']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_facebook']->value }}" target="_blank">
                                        <span><i class="fa fa-facebook-f topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_youtube']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_youtube']->value }}" target="_blank">
                                        <span><i class="fa fa-youtube topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_twitter']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_twitter']->value }}" target="_blank">
                                        <span><i class="fa fa-twitter topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            @if ($siteSettings['site_instagram']->value)
                                <li>
                                    <a href="{{ $siteSettings['site_instagram']->value }}" target="_blank">
                                        <span><i class="fa fa-instagram topbar-link-color"></i></span>
                                    </a>
                                </li>
                            @endif

                            <div class="text-white divider d-none d-inline-block">|</div>

                            <li>
                                <a class=" rs-search short-border" data-target=".search-modal" data-toggle="modal"
                                    href="#">
                                    <i class="fa fa-search topbar-link-color"></i>
                                </a>
                            </li>

                            @foreach (config('locales.languages') as $key => $val)
                                @if ($key != app()->getLocale())
                                    <li class="lang-item">

                                        <a href="{{ route('change.language', $key) }}" class="topbar-link-color">
                                            {{-- <span>
                                                <i class="flag-icon flag-icon-{{ $key == 'ar' ? 'ye' : 'us' }}"
                                                    title="{{ $key == 'ar' ? 'ye' : 'us' }}"
                                                    id="{{ $key == 'ar' ? 'ye' : 'us' }}"></i>
                                            </span> --}}
                                            {{ __('transf.lang_' . $val['lang']) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- <div class="text-white divider d-none d-inline-block">|</div> --}}

                            {{-- <li class="login-register">
                                <i class="fa fa-sign-in text-white"></i>
                                @if (auth()->check() && (auth()->user()->hasRole('admin') or auth()->user()->hasRole('supervisor')))
                                    <a href="{{ route('admin.index') }}">{{ __('panel.dashboard') }}</a>
                                @else
                                    <a href="{{ route('admin.login') }}">{{ __('panel.f_login') }}</a>
                                @endif

                            </li> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar Area End -->

        <!-- Menu Start -->
        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-2">
                        <div class="logo-cat-wrap">
                            {{-- <div class="logo-part pr-90"> --}}
                            <div class="logo-part ">
                                <a class="dark-logo" href="{{ route('frontend.index') }}">
                                    @php
                                        if ($siteSettings['site_logo_large_dark']->value != null) {
                                            $site_logo_large_dark = asset(
                                                'assets/site_settings/' . $siteSettings['site_logo_large_dark']->value,
                                            );

                                            if (
                                                !file_exists(
                                                    public_path(
                                                        'assets/site_settings/' .
                                                            $siteSettings['site_logo_large_dark']->value,
                                                    ),
                                                )
                                            ) {
                                                $site_logo_large_dark = asset('frontend/images/logo-dark.png');
                                            }
                                        } else {
                                            $site_logo_large_dark = asset('frontend/images/logo-dark.png');
                                        }
                                    @endphp

                                    <img src="{{ $site_logo_large_dark }}"
                                        alt="{{ $siteSettings['site_name']->value }}">

                                </a>


                                <a class="light-logo" href="{{ route('frontend.index') }}">
                                    @php
                                        if ($siteSettings['site_logo_large_light']->value != null) {
                                            $site_logo_large_light = asset(
                                                'assets/site_settings/' . $siteSettings['site_logo_large_light']->value,
                                            );

                                            if (
                                                !file_exists(
                                                    public_path(
                                                        'assets/site_settings/' .
                                                            $siteSettings['site_logo_large_light']->value,
                                                    ),
                                                )
                                            ) {
                                                $site_logo_large_light = asset('frontend/images/logo.png');
                                            }
                                        } else {
                                            $site_logo_large_light = asset('frontend/images/logo.png');
                                        }
                                    @endphp

                                    <img src="{{ $site_logo_large_light }}"
                                        alt="{{ $siteSettings['site_name']->value }}">
                                </a>
                            </div>


                        </div>
                    </div>
                    <div class="col-lg-10 text-center">
                        <div class="rs-menu-area">
                            <div class="main-menu ">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <nav class="rs-menu">
                                    <ul class="nav-menu">
                                        @foreach ($web_menus->where('section', 1) as $menu)
                                            <li
                                                class=" {{ count($menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                                <a
                                                    href="{{ count($menu->appearedChildren) > 0 ? 'javascript:void(0)' : $menu->link }}">{{ $menu->title }}</a>
                                                @if (count($menu->appearedChildren) > 0)
                                                    <ul class="sub-menu">
                                                        @foreach ($menu->appearedChildren as $sub_menu)
                                                            <li
                                                                class=" {{ count($sub_menu->appearedChildren) > 0 ? 'menu-item-has-children has-children' : '' }}">
                                                                <a
                                                                    href="{{ $sub_menu->link }}">{{ $sub_menu->title }}</a>
                                                                @if (count($sub_menu->appearedChildren) > 0)
                                                                    <ul class="sub-menu">
                                                                        @foreach ($sub_menu->appearedChildren as $sub_sub_menu)
                                                                            <li>
                                                                                <a
                                                                                    href="{{ $sub_sub_menu->link }}">{{ $sub_sub_menu->title }}</a>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul> <!-- //.nav-menu -->
                                </nav>
                            </div> <!-- //.main-menu -->


                        </div>
                    </div>
                    {{-- <div class="col-lg-2 text-right">
                        <div class="expand-btn-inner">
                            <ul>

                                <li>
                                    <a class="hidden-xs rs-search short-border" data-target=".search-modal"
                                        data-toggle="modal" href="#">
                                        <i class="flaticon-search"></i>
                                    </a>
                                </li>
                            </ul>
                            <span>
                                <a id="nav-expander" class="nav-expander style3">
                                    <span class="dot1"></span>
                                    <span class="dot2"></span>
                                    <span class="dot3"></span>
                                </a>
                            </span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Menu End -->

        <!-- Canvas Menu start -->
        <nav class="right_menu_togle hidden-md">
            <div class="close-btn">
                <div id="nav-close">
                    <div class="line">
                        <span class="line1"></span><span class="line2"></span>
                    </div>
                </div>
            </div>
            <div class="canvas-logo">
                <a href="{{ route('frontend.index') }}"><img src="{{ asset('frontend/images/logo-dark.png') }}"
                        alt="logo"></a>
            </div>
            <div class="offcanvas-text">
                <p>We denounce with righteous indige nationality and dislike men who are so beguiled and demo by the
                    charms of pleasure of the moment data com so blinded by desire.</p>
            </div>
            <div class="offcanvas-gallery">
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/1.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/1.jpg') }}" alt=""></a>
                </div>
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/2.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/2.jpg') }}" alt=""></a>
                </div>
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/3.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/3.jpg') }}" alt=""></a>
                </div>
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/4.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/4.jpg') }}" alt=""></a>
                </div>
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/5.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/5.jpg') }}" alt=""></a>
                </div>
                <div class="gallery-img">
                    <a class="image-popup" href="{{ asset('frontend/images/gallery/6.jpg') }}"><img
                            src="{{ asset('frontend/images/gallery/6.jpg') }}" alt=""></a>
                </div>
            </div>
            <div class="map-img">
                <img src="{{ asset('frontend/images/map.jpg') }}" alt="">
            </div>
            <div class="canvas-contact">
                <ul class="social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </nav>
        <!-- Canvas Menu end -->
    </header>
    <!--Header End-->
</div>
<!--Full width header End-->
