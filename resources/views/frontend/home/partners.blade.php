    <!-- Partner Start -->
    @if (count($partners))
        <div class="rs-partner style2 pt-100 md-pt-70 gray-bg">
            <div class="container">
                <div class="sec-title mb-60 text-center">
                    <h2 class="title mb-0">{{ __('panel.our_partners') }}</h2>
                </div>
                <div class="rs-carousel owl-carousel" data-loop="true" data-items="5" data-margin="30" data-autoplay="true"
                    data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false"
                    data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
                    data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="3"
                    data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="2"
                    data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="5"
                    data-md-device-nav="false" data-md-device-dots="false">
                    @foreach ($partners as $partner)
                        @php
                            if ($partner->partner_image != null) {
                                $partner_img = asset('assets/partners/' . $partner->partner_image);

                                if (!file_exists(public_path('assets/partners/' . $partner->partner_image))) {
                                    // $partner_img = asset('frontend/images/partner/style3/1.png');
                                    $partner_img = asset('image/not_found/placeholder.jpg');
                                }
                            } else {
                                // $partner_img = asset('frontend/images/partner/style3/1.png');
                                $partner_img = asset('image/not_found/placeholder.jpg');
                            }
                        @endphp
                        <div class="partner-item">
                            <a href="{{ $partner->partner_link }}">
                                <img style="width:8.25em;height:8.26em;" src="{{ $partner_img }}"
                                    alt="{{ $partner->name }}">
                            </a>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    @endif
    <!-- Partner End -->
