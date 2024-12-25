 <!-- Footer Start -->
 <style>
     .rs-footer .footer-top {
         padding: 70px 0 93px;
     }
 </style>
 {{-- <footer id="rs-footer" class="rs-footer home9-style main-home"> --}}
 <footer id="rs-footer" class="rs-footer ">
     <div class="footer-top">
         <div class="container">
             <div class="row">
                 <div class="col-lg-3 col-md-12 col-sm-12 footer-widget md-mb-50">

                     <h4 class="widget-title">{{ __('panel.f_address') }}</h4>

                     <ul class="address-widget">
                         <li>
                             <i class="flaticon-location text-white"></i>
                             <div class="desc">{{ $siteSettings['site_address']->value ?? '' }}</div>
                         </li>
                         <li>
                             <i class="flaticon-call"></i>
                             <div class="desc">
                                 <a
                                     href="tel:(+04){{ $siteSettings['site_mobile']->value ?? '' }}">(+04){{ $siteSettings['site_mobile']->value ?? '' }}</a>
                             </div>
                         </li>
                         <li>
                             <i class="flaticon-email"></i>
                             <div class="desc">
                                 <?php
                                 $parsedUrl = parse_url($siteSettings['site_email1']->value, PHP_URL_HOST);
                                 
                                 // Remove 'www.' if it exists
                                 $domain = preg_replace('/^www\./', '', $parsedUrl);
                                 
                                 ?>
                                 <a
                                     href="mailto:{{ $siteSettings['site_email1']->value ?? '' }}">contact&#64;{{ $domain ?? '' }}</a>
                             </div>
                         </li>
                     </ul>
                 </div>
                 <div class="col-lg-2 col-md-12 col-sm-12 footer-widget md-mb-50">
                     <h3 class="widget-title">{{ __('panel.website_shortcuts') }}</h3>
                     <ul class="site-map">
                         @foreach ($web_menus->where('section', 4) as $tracks_menu)
                             <li><a href="{{ $tracks_menu->link }}">{{ $tracks_menu->title }}</a></li>
                         @endforeach
                     </ul>
                 </div>
                 <div class="col-lg-4 col-md-12 col-sm-12 pl-50 md-pl-15 footer-widget md-mb-50">
                     <h3 class="widget-title">{{ __('panel.links_that_interest_you') }}</h3>
                     <ul class="site-map">

                         @foreach ($web_menus->where('section', 5) as $support_menu)
                             <li><a href="{{ $support_menu->link }}">{{ $support_menu->title }}</a></li>
                         @endforeach

                     </ul>
                 </div>
                 <div class="col-lg-3 col-md-12 col-sm-12 ">
                     <h3 class="widget-title">{{ __('panel.applications') }} </h3>
                     <div class="row mb-4">
                         <div class="col-lg-6 col-md-6 col-sm-6 footer-widget">
                             <div class="counter-item text-center">
                                 <img class="image" src="{{ asset('frontend/images/waleed/google.png') }}"
                                     alt="">

                             </div>
                         </div>
                         <div class="col-lg-6 col-md-6 col-sm-6 footer-widget">
                             <div class="counter-item text-center">
                                 <img class="image" src="{{ asset('frontend/images/waleed/apple.png') }}"
                                     alt="">

                             </div>
                         </div>
                     </div>

                 </div>
             </div>
         </div>
     </div>


     <div class="footer-bottom">
         <div class="container">
             <div class="row y-middle">
                 <div class="col-lg-4 md-mb-20">
                     <div class="footer-logo md-text-center">

                         @php
                             if ($siteSettings['site_logo_large_light']->value != null) {
                                 $site_logo_large_light = asset(
                                     'assets/site_settings/' . $siteSettings['site_logo_large_light']->value,
                                 );

                                 if (
                                     !file_exists(
                                         public_path(
                                             'assets/site_settings/' . $siteSettings['site_logo_large_light']->value,
                                         ),
                                     )
                                 ) {
                                     $site_logo_large_light = asset('frontend/images/logo.png');
                                 }
                             } else {
                                 $site_logo_large_light = asset('frontend/images/logo.png');
                             }
                         @endphp

                         <a href="index.html"><img src="{{ $site_logo_large_light }}"
                                 alt="{{ $siteSettings['site_name']->value }}"></a>


                     </div>
                 </div>
                 <div class="col-lg-4 md-mb-20">
                     <div class="copyright text-center md-text-left">
                         <p>
                             <a href="http://rstheme.com/">{{ $siteSettings['site_name']->value }}</a> , &copy;
                             {{ date('Y') }}
                             {{ __('panel.all_rights_reserved') }}.
                         </p>
                     </div>
                 </div>
                 <div class="col-lg-4 text-right md-text-left">
                     <ul class="footer-social">
                         @if ($siteSettings['site_facebook']->value)
                             <li>
                                 <a href="{{ $siteSettings['site_facebook']->value }}" target="_blank">
                                     <i class="fa fa-facebook"></i>
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
                     </ul>
                 </div>
             </div>
         </div>
     </div>

 </footer>
 <!-- Footer End -->
