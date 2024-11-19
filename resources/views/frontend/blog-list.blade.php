@extends('layouts.app')

@section('content')
    @livewire('frontend.blogs.blog-list-component', ['slug' => $slug])
@endsection
