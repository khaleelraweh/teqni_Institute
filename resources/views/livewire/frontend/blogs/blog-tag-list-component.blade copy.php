<div>
    <!-- Main content Start -->
    <div class="main-content">
        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
                {{-- <img src="{{ asset('frontend/images/breadcrumbs/2.jpg') }}" alt="Breadcrumbs Image"> --}}
                <img src="{{ $siteSettings['site_img']->value ? asset('assets/site_settings/' . $siteSettings['site_img']->value) : asset('frontend/images/breadcrumbs/2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}">
            </div>
            <div class="breadcrumbs-text white-color">
                <h1 class="page-title">
                    @switch(true)
                    @case($currentRoute === 'frontend.blog_tag_list')
                    {{ __('panel.blog_list') }}
                    @break

                    @case($currentRoute === 'frontend.news_tag_list')
                    {{ __('panel.news_list') }}
                    @break

                    @case($currentRoute === 'frontend.events_tag_list')
                    {{ __('panel.events_list') }}
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
                        @switch(true)
                        @case($currentRoute === 'frontend.blog_tag_list')
                        {{ __('panel.blog_list') }}
                        @break

                        @case($currentRoute === 'frontend.news_tag_list')
                        {{ __('panel.news_list') }}
                        @break

                        @case($currentRoute === 'frontend.events_tag_list')
                        {{ __('panel.events_list') }}
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
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->


        <!-- Blog Section Start -->
        <div class="rs-inner-blog orange-color pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 order-last">
                        <div class="widget-area">
                            <div class="search-widget mb-50">
                                <div class="search-wrap">
                                    <input type="search" wire:model="searchQuery"
                                        placeholder="{{ __('transf.search') }}..." name="s" class="search-input"
                                        value="">

                                    {{-- <button type="submit" value="Search"><i class=" flaticon-search"></i></button> --}}
                                </div>
                            </div>
                            <div class="recent-posts-widget mb-50">


                                @switch(true)
                                @case($currentRoute === 'frontend.blog_tag_list')
                                <h3 class="widget-title recent_post_title">{{ __('panel.recent_posts') }}</h3>
                                @break

                                @case($currentRoute === 'frontend.news_tag_list')
                                <h3 class="widget-title recent_post_title">{{ __('panel.recent_news') }}</h3>
                                @break

                                @case($currentRoute === 'frontend.events_tag_list')
                                <h3 class="widget-title recent_post_title">{{ __('panel.recent_events') }}</h3>
                                @break

                                @default
                                <h3 class="widget-title recent_post_title">{{ __('panel.recent_posts') }}</h3>
                                @endswitch



                                @foreach ($recent_posts as $recent_post)
                                <div class="show-featured ">
                                    <div class="post-img">

                                        @php
                                        $recentDefaultImg = asset('image/not_found/placeholder.jpg');
                                        $recent_post_img = $recentDefaultImg; // Set a default image

                                        switch (true) {
                                        case $currentRoute === 'frontend.blog_tag_list':
                                        $recent_post_img =
                                        $recent_post->photos->first() &&
                                        $recent_post->photos->first()->file_name
                                        ? asset(
                                        'assets/posts/' .
                                        $recent_post->photos->first()->file_name,
                                        )
                                        : $recentDefaultImg;
                                        break;

                                        case $currentRoute === 'frontend.news_tag_list':
                                        $recent_post_img =
                                        $recent_post->photos->first() &&
                                        $recent_post->photos->first()->file_name
                                        ? asset(
                                        'assets/news/' .
                                        $recent_post->photos->first()->file_name,
                                        )
                                        : $recentDefaultImg;
                                        break;

                                        case $currentRoute === 'frontend.events_tag_list':
                                        $recent_post_img =
                                        $recent_post->photos->first() &&
                                        $recent_post->photos->first()->file_name
                                        ? asset(
                                        'assets/events/' .
                                        $recent_post->photos->first()->file_name,
                                        )
                                        : $recentDefaultImg;
                                        break;

                                        // Add more cases as needed for other routes

                                        default:
                                        $recent_post_img = $recentDefaultImg;
                                        break;
                                        }

                                        // Check if the file exists in public directory
                                        if (
                                        !file_exists(public_path(parse_url($recent_post_img, PHP_URL_PATH)))
                                        ) {
                                        $recent_post_img = $recentDefaultImg;
                                        }
                                        @endphp

                                        @switch(true)
                                        @case($currentRoute === 'frontend.blog_tag_list')
                                        <a href="{{ route('frontend.blog_single', $recent_post->slug) }}">
                                            <img src="{{ $recent_post_img }}" alt="">
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.news_tag_list')
                                        <a href="{{ route('frontend.news_single', $recent_post->slug) }}">
                                            <img src="{{ $recent_post_img }}" alt="">
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.events_tag_list')
                                        <a href="{{ route('frontend.event_single', $recent_post->slug) }}">
                                            <img src="{{ $recent_post_img }}" alt="">
                                        </a>
                                        @break

                                        @default
                                        <a href="{{ route('frontend.blog_single', $recent_post->slug) }}">
                                            <img src="{{ $recent_post_img }}" alt="">
                                        </a>
                                        @endswitch


                                    </div>
                                    <div class="post-desc">


                                        @switch(true)
                                        @case($currentRoute === 'frontend.blog_tag_list')
                                        <a href="{{ route('frontend.blog_single', $recent_post->slug) }}">
                                            {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.news_tag_list')
                                        <a href="{{ route('frontend.news_single', $recent_post->slug) }}">
                                            {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.events_tag_list')
                                        <a href="{{ route('frontend.event_single', $recent_post->slug) }}">
                                            {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                        </a>
                                        @break

                                        @default
                                        <a href="{{ route('frontend.blog_single', $recent_post->slug) }}">
                                            {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                        </a>
                                        @endswitch

                                        <span class="date">
                                            <?php
                                            $date = $recent_post->created_at;
                                            $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                            ?>
                                            <i class="fa fa-calendar"></i>
                                            {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}

                                            <span> | </span>

                                            {{ $recent_post->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}


                                        </span>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                            <div class="recent-posts mb-50">
                                <h3 class="widget-title tags_title">{{ __('panel.tags') }}</h3>
                                <ul>
                                    @foreach ($tags as $tag)
                                    <li>
                                        @switch(true)
                                        @case($currentRoute === 'frontend.blog_tag_list')
                                        <a href="{{ route('frontend.blog_tag_list', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.news_tag_list')
                                        <a href="{{ route('frontend.news_tag_list', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                        @break

                                        @case($currentRoute === 'frontend.events_tag_list')
                                        <a href="{{ route('frontend.events_tag_list', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                        @break

                                        @default
                                        <a href="{{ route('frontend.blog_tag_list', $tag->slug) }}">
                                            {{ $tag->name }}
                                        </a>
                                        @endswitch


                                    </li>
                                    @endforeach


                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 pr-50 md-pr-15">
                        <div class="row">
                            @foreach ($posts as $post)
                            <div class="col-lg-12 mb-70">
                                <div class="blog-item">
                                    <div class="blog-img">

                                        @switch(true)
                                        @case($currentRoute === 'frontend.blog_tag_list')
                                        <a href="{{ route('frontend.blog_single', $post->slug) }}">
                                            @break

                                            @case($currentRoute === 'frontend.news_tag_list')
                                            <a href="{{ route('frontend.news_single', $post->slug) }}">
                                                @break

                                                @case($currentRoute === 'frontend.events_tag_list')
                                                <a href="{{ route('frontend.event_single', $post->slug) }}">
                                                    @break

                                                    @default
                                                    <a href="{{ route('frontend.blog_single', $post->slug) }}">
                                                        @break
                                                        @endswitch



                                                        @php
                                                        $postDefaultImg = asset(
                                                        'image/not_found/placeholder.jpg',
                                                        );
                                                        $post_img = $postDefaultImg; // Set a default image

                                                        switch (true) {
                                                        case $currentRoute === 'frontend.blog_tag_list':
                                                        $post_img =
                                                        $post->photos->first() &&
                                                        $post->photos->first()->file_name
                                                        ? asset(
                                                        'assets/posts/' .
                                                        $post->photos->first()
                                                        ->file_name,
                                                        )
                                                        : $postDefaultImg;
                                                        break;

                                                        case $currentRoute === 'frontend.news_tag_list':
                                                        $post_img =
                                                        $post->photos->first() &&
                                                        $post->photos->first()->file_name
                                                        ? asset(
                                                        'assets/news/' .
                                                        $post->photos->first()
                                                        ->file_name,
                                                        )
                                                        : $postDefaultImg;
                                                        break;

                                                        case $currentRoute === 'frontend.events_tag_list':
                                                        $post_img =
                                                        $post->photos->first() &&
                                                        $post->photos->first()->file_name
                                                        ? asset(
                                                        'assets/events/' .
                                                        $post->photos->first()
                                                        ->file_name,
                                                        )
                                                        : $postDefaultImg;
                                                        break;

                                                        // Add more cases as needed for other routes

                                                        default:
                                                        $post_img = $postDefaultImg;
                                                        break;
                                                        }

                                                        // Check if the file exists in public directory
                                                        if (
                                                        !file_exists(
                                                        public_path(parse_url($post_img, PHP_URL_PATH)),
                                                        )
                                                        ) {
                                                        $post_img = $postDefaultImg;
                                                        }
                                                        @endphp

                                                        <img src="{{ $post_img }}" alt="">
                                                    </a>
                                    </div>
                                    <div class="blog-content">
                                        <h3 class="blog-title">
                                            @switch(true)
                                            @case($currentRoute === 'frontend.blog_tag_list')
                                            <a href="{{ route('frontend.blog_single', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                            @break

                                            @case($currentRoute === 'frontend.news_tag_list')
                                            <a href="{{ route('frontend.news_single', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                            @break

                                            @case($currentRoute === 'frontend.events_tag_list')
                                            <a href="{{ route('frontend.event_single', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                            @break

                                            @default
                                            <a href="{{ route('frontend.blog_single', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                            @endswitch

                                        </h3>
                                        <div class="blog-meta">
                                            <ul class="btm-cate">
                                                <li>
                                                    <?php
                                                    $date = $post->created_at;
                                                    $higriShortDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date); // With optional Timestamp It will return Hijri Date of [$date] => Results "1442/05/12"
                                                    ?>

                                                    <div class="blog-date">
                                                        <i class="fa fa-calendar-check-o"></i>

                                                        {{ $higriShortDate . ' ' . __('panel.calendar_hijri') }}

                                                        <span>{{ __('panel.corresponding_to') }} </span>

                                                        {{ $post->created_at->isoFormat('YYYY/MM/DD') . ' ' . __('panel.calendar_gregorian') }}


                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="author">
                                                        <i class="fa fa-user-o"></i>
                                                        {{ $post->users && $post->users->isNotEmpty() ? $post->users->first()->full_name : __('panel.admin') }}

                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                        <div class="blog-desc">
                                            {!! \Illuminate\Support\Str::words($post->content, 30, '...') !!}
                                        </div>
                                        <div class="blog-button">

                                            @switch(true)
                                            @case($currentRoute === 'frontend.blog_tag_list')
                                            <a class="blog-btn"
                                                href="{{ route('frontend.blog_single', $post->slug) }}">
                                                {{ __('panel.continue_reading') }}
                                            </a>
                                            @break

                                            @case($currentRoute === 'frontend.news_tag_list')
                                            <a class="blog-btn"
                                                href="{{ route('frontend.news_single', $post->slug) }}">
                                                {{ __('panel.continue_reading') }}
                                            </a>
                                            @break

                                            @case($currentRoute === 'frontend.events_tag_list')
                                            <a class="blog-btn"
                                                href="{{ route('frontend.event_single', $post->slug) }}">
                                                {{ __('panel.continue_reading') }}
                                            </a>
                                            @break

                                            @default
                                            <a class="blog-btn"
                                                href="{{ route('frontend.blog_single', $post->slug) }}">
                                                {{ __('panel.continue_reading') }}
                                            </a>
                                            @endswitch


                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Section End -->

    </div>
    <!-- Main content End -->
</div>