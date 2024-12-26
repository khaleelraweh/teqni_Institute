@extends('layouts.app')

@section('content')
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">

                @php
                    if ($siteSettings['site_img']->value != null) {
                        $site_img = asset('assets/site_settings/' . $siteSettings['site_img']->value);

                        if (!file_exists(public_path('assets/site_settings/' . $siteSettings['site_img']->value))) {
                            $site_img = asset('image/not_found/placeholder2.jpg');
                        }
                    } else {
                        $site_img = asset('image/not_found/placeholder2.jpg');
                    }
                @endphp


                <img style="height: 24em" src="{{ $site_img }}" alt="{{ $siteSettings['site_name']->value }}">

                {{-- <img src="{{ asset('frontend/images/breadcrumbs/2.jpg') }}" alt="Breadcrumbs Image"> --}}
            </div>
            <div class="breadcrumbs-text white-color">
                <h1 class="page-title">
                    @switch(true)
                        @case(Route::is('frontend.blog_single'))
                            {{ __('panel.blog_single') }}
                        @break

                        @case(Route::is('frontend.news_single'))
                            {{ __('panel.news_single') }}
                        @break

                        @case(Route::is('frontend.event_single'))
                            {{ __('panel.event_single') }}
                        @break

                        @case(Route::is('frontend.blog_index'))
                            Blog Index
                        @break

                        @case(Route::is('frontend.contact'))
                            Contact Us
                        @break

                        @default
                            Default Title
                    @endswitch
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        {{ $post->title }}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Blog Section Start -->
        <div class="rs-inner-blog  pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="blog-deatails">
                    <div class="bs-img">
                        @php
                            $defaultImg = asset('image/not_found/placeholder.jpg');
                            $post_img = $defaultImg; // Set a default image

                            switch (true) {
                                case Route::is('frontend.blog_single'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/posts/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                case Route::is('frontend.news_single'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/news/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                case Route::is('frontend.events'):
                                    $post_img =
                                        $post->photos->first() && $post->photos->first()->file_name
                                            ? asset('assets/events/' . $post->photos->first()->file_name)
                                            : $defaultImg;
                                    break;

                                // Add more cases as needed for other routes

                                default:
                                    $post_img = $defaultImg;
                                    break;
                            }

                            // Check if the file exists in public directory
                            if (!file_exists(public_path(parse_url($post_img, PHP_URL_PATH)))) {
                                $post_img = $defaultImg;
                            }
                        @endphp

                        <a href="#"><img style="width:100%;height:23em" src="{{ $post_img }}" alt=""></a>
                    </div>

                    <div class="blog-full">
                        <ul class="single-post-meta">
                            <li>

                                <?php
                                $date = $post->created_at;
                                $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                ?>

                                <span class="p-date">
                                    <i class="fa fa-calendar-check-o"></i>
                                    {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}

                                    <span>{{ __('panel.corresponding_to') }} </span>
                                    {{ $post->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}
                                </span>
                            </li>
                            <li>
                                <span class="p-date">
                                    <i class="fa fa-user-o"></i>
                                    {{ $post->users && $post->users->isNotEmpty() ? $post->users->first()->full_name : __('panel.admin') }}
                                </span>
                            </li>

                        </ul>
                        <div class="blog-desc">
                            <p>
                                {!! $post->content !!}
                            </p>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Section End -->

    </div>
    <!-- Main content End -->
@endsection
