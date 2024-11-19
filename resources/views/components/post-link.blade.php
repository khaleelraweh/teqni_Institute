@props(['route', 'slug', 'class' => ''])


<a href="{{ route($route, $slug) }}" class="{{ $class }}">
    {{ $slot }}
</a>
