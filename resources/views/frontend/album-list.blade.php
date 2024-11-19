@extends('layouts.app')

@section('content')
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">

                <img src="{{ asset('frontend/images/breadcrumbs/2.jpg') }}" alt="Breadcrumbs Image">
            </div>
            <div class="breadcrumbs-text white-color">
                <h1 class="page-title">
                    {{ __('panel.photo_album') }}
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        {{ __('panel.all_photo_albums') }}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Degree Section Start -->
        <div class="rs-degree style1 modify gray-bg pt-100 pb-70 md-pt-70 md-pb-40">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-4 col-md-6 mb-30">
                        <div class="sec-title wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                            <div class="sub-title primary">{{ __('panel.photo_album') }}</div>
                            <h2 class="title mb-0">{{ __('panel.all_photo_albums') }} | {{ __('panel.browse_albums') }}
                            </h2>
                        </div>
                    </div>
                    @foreach ($albums as $album)
                        <div class="col-lg-4 col-md-6 mb-30">
                            <div class="degree-wrap">
                                @php
                                    if ($album->album_profile != null) {
                                        $album_img = asset('assets/albums/' . $album->album_profile);

                                        if (!file_exists(public_path('assets/albums/' . $album->album_profile))) {
                                            $album_img = asset('image/not_found/item_image_not_found.webp');
                                        }
                                    } else {
                                        $album_img = asset('image/not_found/item_image_not_found.webp');
                                    }
                                @endphp
                                <img src="{{ $album_img }}" alt="">

                                <div class="title-part">
                                    <h4 class="title">{{ $album->title }}</h4>
                                </div>
                                <div class="content-part">
                                    <h4 class="title">
                                        <a href="{{ route('frontend.album_single', $album->slug) }}">
                                            {{ $album->title }}
                                        </a>
                                    </h4>
                                    <p class="desc">
                                        {!! \Illuminate\Support\Str::words($album->description, 50, '...') !!}

                                    </p>
                                    <div class="btn-part">
                                        <a
                                            href="{{ route('frontend.album_single', $album->slug) }}">{{ __('panel.read_more') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Degree Section End -->

    </div>
    <!-- Main content End -->
@endsection
