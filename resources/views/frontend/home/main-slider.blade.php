<!-- Slider Section Start -->
<div class="rs-slider style1 text-center gray-bg">
    <div class="rs-carousel owl-carousel" data-loop="true" data-items="1" data-margin="0" data-autoplay="true"
        data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false"
        data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false"
        data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="false" data-ipad-device-dots="false"
        data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="1"
        data-md-device-nav="true" data-md-device-dots="false">

        @forelse ($main_sliders->where('section' ,1) as $main_slider)
            @php
                if ($main_slider->firstMedia != null && $main_slider->firstMedia->file_name != null) {
                    $main_slider_img = asset('assets/main_sliders/' . $main_slider->firstMedia->file_name);

                    if (!file_exists(public_path('assets/main_sliders/' . $main_slider->firstMedia->file_name))) {
                        $main_slider_img = asset('image/not_found/placeholder.jpg');
                        // $main_slider_img = asset('frontend/images/slider/main-home/1.jpg');
                    }
                } else {
                    $main_slider_img = asset('image/not_found/placeholder.jpg');
                    // $main_slider_img = asset('frontend/images/slider/main-home/1.jpg');
                }
            @endphp

            <div class="slider-content slide1" style="background-image: url({{ $main_slider_img }})">
                {{-- <div class="container" style="height: 150vh;"> --}}
                <div class="container">
                    @if ($main_slider->show_info)
                        <div class="content-part">
                            <div class="sl-sub-title white-color wow bounceInLeft" data-wow-delay="300ms"
                                data-wow-duration="2000ms">
                                {{ $main_slider->subtitle }}
                            </div>
                            <h1 class="sl-title white-color wow fadeInRight" data-wow-delay="600ms"
                                data-wow-duration="2000ms">
                                {{ $main_slider->title }}
                            </h1>
                            @if ($main_slider->show_btn_title)
                                <div class="sl-btn wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                                    <a class="readon2 banner-style"
                                        href="{{ url($main_slider->btn_title) }}">{{ $main_slider->btn_title }}
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>

            </div>
        @empty
        @endforelse
    </div>

</div>
<!-- Slider Section End -->
