@extends('layouts.app')

@section('content')
    @livewire('frontend.blogs.blog-tag-list-component', ['slug' => $slug])
@endsection
