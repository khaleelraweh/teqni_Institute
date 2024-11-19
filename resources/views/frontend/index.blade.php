@extends('layouts.app')

@section('content')
    @include('frontend.home.main-slider')

    @include('frontend.home.partners')

    @include('frontend.home.news')

    @include('frontend.home.president_speech')

    @include('frontend.home.departments')

    @include('frontend.home.statistics')

    {{-- @include('frontend.home.common-questions') --}}

    @include('frontend.home.playlists')

    @include('frontend.home.testimonials')

    @include('frontend.home.albums')
@endsection
