<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AboutInstatute;
use App\Models\Album;
use App\Models\CommonQuestion;
use App\Models\CommonQuestionVideo;
use App\Models\Event;
use App\Models\Page;
use App\Models\Partner;
use App\Models\Playlist;
use App\Models\Post;
use App\Models\PresidentSpeech;
use App\Models\Slider;
use App\Models\Statistic;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class FrontendController extends Controller
{
    public function index()
    {
        $main_sliders = Slider::with('firstMedia')->orderBy('published_on', 'desc')->Active()->take(8)->get();

        $posts = Post::with('photos')->where('section', 1)->orderBy('created_at', 'ASC')->get();
        $news = Post::with('photos')->where('section', 2)->orderBy('created_at', 'ASC')->get();
        $Advertisements = Post::with('photos')->where('section', 3)->orderBy('created_at', 'ASC')->get();

        $events = Event::with('photos')->orderBy('created_at', 'ASC')->get();
        $statistics = Statistic::Active()->orderBy('created_at', 'ASC')->get();
        $playlists = Playlist::Active()->orderBy('created_at', 'ASC')->get();
        $albums = Album::Active()->orderBy('created_at', 'ASC')->get();

        $partners = Partner::all();
        $president_speech = PresidentSpeech::get()->first();

        $common_questions = CommonQuestion::query()->active()->take(4)->get();
        $common_question_video = CommonQuestionVideo::query()->active()->first();

        $testimonials = Testimonial::query()->active()->get();


        // $statistics = Statistic::Active()->orderBy('created_at', 'ASC')->get();
        return view('frontend.index', compact('main_sliders',  'posts', 'news', 'Advertisements', 'events', 'statistics', 'playlists', 'albums', 'partners', 'president_speech', 'common_questions', 'common_question_video', 'testimonials'));
    }


    public function pages($slug)
    {
        $page = Page::where('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();

        // Retrieve the latest 3 posts from section 1, excluding the current post
        $latest_posts = Post::with('photos')
            ->where('section', 1)
            ->orderBy('created_at', 'ASC')
            ->take(3)
            ->get();

        return view('frontend.pages', compact('page', 'latest_posts'));
    }

    public function blog_list($slug = null)
    {
        return view('frontend.blog-list', compact('slug'));
    }

    public function blog_tag_list($slug = null)
    {
        return view('frontend.blog-tag-list', compact('slug'));
    }

    public function blog_single($slug)
    {
        // Determine the current route name
        $currentRoute = Route::currentRouteName();

        if ($currentRoute === 'frontend.blog_single' || $currentRoute === 'frontend.news_single') {
            $post = Post::with('photos', 'tags')
                ->where('slug->' . app()->getLocale(), $slug)
                ->firstOrFail();

            $latest_posts = Post::with('photos')
                ->where('section', $post->section)
                ->where('id', '!=', $post->id)
                ->orderBy('created_at', 'ASC')
                ->take(3)
                ->get();
        } elseif ($currentRoute === 'frontend.event_single') {
            $post = Event::with('photos', 'tags')
                ->where('slug->' . app()->getLocale(), $slug)
                ->firstOrFail();

            $latest_posts = Event::with('photos')
                ->where('section', $post->section)
                ->where('id', '!=', $post->id)
                ->orderBy('created_at', 'ASC')
                ->take(3)
                ->get();
        } else {
            abort(404); // Handle unsupported routes
        }

        // Set the correct share URL based on the route
        $shareRoute = $currentRoute === 'frontend.blog_single' ? 'frontend.blog_single' : ($currentRoute === 'frontend.news_single' ? 'frontend.news_single' : 'frontend.event_single');
        $whatsappShareUrl = 'https://api.whatsapp.com/send?text=' . urlencode($post->name . ': ' . route($shareRoute, $post->slug));

        return view('frontend.blog-single', compact('post', 'latest_posts', 'whatsappShareUrl'));
    }

    public function album_list()
    {
        $albums = Album::all();

        return view('frontend.album-list', compact('albums'));
    }


    public function album_single($slug)
    {
        $albums = Album::with('photos')->where('slug->' . app()->getLocale(), $slug)->firstOrFail();

        return view('frontend.album', compact('albums'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }
}
