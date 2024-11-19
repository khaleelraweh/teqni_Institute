<?php
function getPostImage($post, $currentRoute, $defaultImage)
{
    $basePaths = [
        'frontend.blog_list' => 'assets/posts/',
        'frontend.news_list' => 'assets/news/',
        'frontend.events_list' => 'assets/events/',
    ];

    $path = $basePaths[$currentRoute] ?? null;

    if ($path && $post->photos->first() && $post->photos->first()->file_name) {
        $imagePath = public_path("{$path}{$post->photos->first()->file_name}");
        return file_exists($imagePath) ? asset("{$path}{$post->photos->first()->file_name}") : $defaultImage;
    }

    return $defaultImage;
}
