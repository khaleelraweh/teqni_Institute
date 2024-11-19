@extends('layouts.app')

@section('content')
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">

                <img src="{{ $siteSettings['site_img']->value ? asset('assets/site_settings/' . $siteSettings['site_img']->value) : asset('frontend/images/lite-logo.png') }}"
                    alt="{{ $siteSettings['site_name']->value }}">

                {{-- <img src="{{ asset('frontend/images/breadcrumbs/2.jpg') }}" alt="Breadcrumbs Image"> --}}
            </div>
            <div class="breadcrumbs-text white-color">
                <h1 class="page-title">
                    {{ $page->title }}
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        {{ $page->title }}
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Blog Section Start -->
        <div class="rs-inner-blog orange-color pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="blog-deatails">
                    <div class="bs-img">
                        @php
                            if ($page->photos->last() != null && $page->photos->last()->file_name != null) {
                                $page_img = asset('assets/pages/' . $page->photos->last()->file_name);

                                if (!file_exists(public_path('assets/pages/' . $page->photos->last()->file_name))) {
                                    $page_img = asset('image/not_found/item_image_not_found.webp');
                                }
                            } else {
                                $page_img = asset('image/not_found/item_image_not_found.webp');
                            }
                        @endphp

                        <a href="#"><img src="{{ $page_img }}" alt=""></a>
                    </div>

                    <div class="blog-full">
                        <ul class="single-post-meta">
                            <li>

                                <?php
                                $date = $page->created_at;
                                $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                ?>

                                <span class="p-date">
                                    <i class="fa fa-calendar-check-o"></i>
                                    {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}

                                    <span>{{ __('panel.corresponding_to') }} </span>
                                    {{ $page->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}
                                </span>
                            </li>
                            <li>
                                <span class="p-date">
                                    <i class="fa fa-user-o"></i>
                                    {{ $page->users && $page->users->isNotEmpty() ? $page->users->first()->full_name : __('panel.admin') }}
                                </span>
                            </li>

                        </ul>
                        <div class="blog-desc">
                            <p>
                                {!! $page->content !!}
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
