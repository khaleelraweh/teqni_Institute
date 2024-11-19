<?php

use Illuminate\Support\Facades\Cache;

function getParentShowOf($param)
{
    $route = str_replace('admin.', '', $param); // احذف كلمة admin. واستبدل بدالها بالفراغ من الراوت المرسل كبرامتر 
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['parent_show'] : null;
}

function getParentOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['parent'] : null;
}

function getParentIdOf($param)
{
    $route = str_replace('admin.', '', $param);
    $permission = collect(Cache::get('admin_side_menu')->pluck('children')->flatten())->where('as', $route)->flatten()->first();
    return $permission ? $permission['id'] : null;
}



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

function getPostTagImage($post, $currentRoute, $defaultImage)
{
    $basePaths = [
        'frontend.blog_tag_list' => 'assets/posts/',
        'frontend.news_tag_list' => 'assets/news/',
        'frontend.events_tag_list' => 'assets/events/',
    ];

    $path = $basePaths[$currentRoute] ?? null;

    if ($path && $post->photos->first() && $post->photos->first()->file_name) {
        $imagePath = public_path("{$path}{$post->photos->first()->file_name}");
        return file_exists($imagePath) ? asset("{$path}{$post->photos->first()->file_name}") : $defaultImage;
    }

    return $defaultImage;
}

function formatPostDate($date)
{
    $hijriDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date);
    $gregorianDate = $date->isoFormat('YYYY/MM/DD');

    return "$hijriDate " . __('panel.calendar_hijri') . " " . __('panel.corresponding_to') . " $gregorianDate " . __('panel.calendar_gregorian');
}

function formatPostDateDash($date)
{
    $hijriDate = Alkoumi\LaravelHijriDate\Hijri::ShortDate($date);
    $gregorianDate = $date->isoFormat('YYYY/MM/DD');

    return "$hijriDate " . __('panel.calendar_hijri') . " " . "|" . " $gregorianDate " . __('panel.calendar_gregorian');
}
