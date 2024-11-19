<!-- Section Gray bg Wrap start -->
@if (count($news))
    <div class="gray-bg">
        <!-- Blog Section Start -->
        <div id="rs-blog" class="rs-blog style2 pt-94 pb-100 md-pt-64 md-pb-70">
            {{-- <div id="rs-blog" class="rs-blogs style2 "> --}}

            <div class="container">
                <div class="sec-title mb-60 text-center">
                    <h2 class="title mb-0">{{ __('panel.institute_news') }}</h2>
                </div>
                <div class="rs-carousel owl-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true"
                    data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false"
                    data-nav="false" data-nav-speed="false" data-center-mode="false" data-mobile-device="1"
                    data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="2"
                    data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="1"
                    data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="3"
                    data-md-device-nav="false" data-md-device-dots="false">
                    @foreach ($news as $item)
                        <div class="blog-item">
                            <div class="image-part">
                                @php
                                    if ($item->photos->first() != null && $item->photos->first()->file_name != null) {
                                        $item_img = asset('assets/news/' . $item->photos->first()->file_name);

                                        if (
                                            !file_exists(
                                                public_path('assets/news/' . $item->photos->first()->file_name),
                                            )
                                        ) {
                                            $item_img = asset('image/not_found/placeholder.jpg');
                                        }
                                    } else {
                                        $item_img = asset('image/not_found/placeholder.jpg');
                                    }
                                @endphp
                                <img style="height:12.25em " src="{{ $item_img }}" alt="">
                            </div>
                            <div class="blog-content new-style">
                                <ul class="blog-meta">
                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        {{ formatPostDateDash($item->created_at) }}
                                    </li>
                                </ul>
                                <h3 class="title">
                                    <a href="{{ route('frontend.news_single', $item->slug) }}">
                                        {!! \Illuminate\Support\Str::limit($item->title, 50, '...') !!}
                                    </a>
                                </h3>
                                <div class="desc">
                                    {!! \Illuminate\Support\Str::limit($item->content, 50, '...') !!}
                                    <br>
                                </div>
                                <ul class="blog-bottom">
                                    <li class="cmnt-part"></li>
                                    <li class="btn-part">
                                        <a class="readon-arrow" href="{{ route('frontend.news_single', $item->slug) }}">
                                            {{ __('panel.read_more') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Blog Section End -->


    </div>
@endif
<!-- Section bg Wrap 2 End -->
