    <!-- Testimonial Section Start -->
    @if (count($testimonials))
        <div class="rs-testimonial home-style1 pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="sec-title mb-50 md-mb-30 text-center">
                    <div class="sub-title primary">{{ __('panel.testimonial') }}</div>
                    <h2 class="title mb-0">{{ __('panel.what_students_saying') }}</h2>
                </div>
                <div class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="true"
                    data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="true"
                    data-nav="false" data-nav-speed="false" data-md-device="2" data-md-device-nav="false"
                    data-md-device-dots="true" data-center-mode="false" data-ipad-device2="1"
                    data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-ipad-device="2"
                    data-ipad-device-nav="false" data-ipad-device-dots="true" data-mobile-device="1"
                    data-mobile-device-nav="false" data-mobile-device-dots="false">

                    @foreach ($testimonials as $testimonial)
                        <div class="testi-item">
                            <div class="author-desc">
                                <div class="desc">
                                    <img class="quote"
                                        src="{{ asset('frontend/images/testimonial/style5/quote2.png') }}"
                                        alt="">
                                    {!! $testimonial->content !!}
                                </div>

                                @php
                                    if ($testimonial && $testimonial->image != null) {
                                        $testimonial_img = asset('assets/testimonials/' . $testimonial->image);

                                        if (!file_exists(public_path('assets/testimonials/' . $testimonial->image))) {
                                            $testimonial_img = asset('image/not_found/placeholder.jpg');
                                        }
                                    } else {
                                        $testimonial_img = asset('image/not_found/placeholder.jpg');
                                    }
                                @endphp

                                <div class="author-img">
                                    <img style="width:4.37em;height:4.37em;" src="{{ $testimonial_img }}"
                                        alt="">
                                </div>
                            </div>
                            <div class="author-part">
                                <a class="name" href="#">{{ $testimonial->name }}</a>
                                <span class="designation">{{ $testimonial->title }}</span>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @endif
    <!-- Testimonial Section End -->
