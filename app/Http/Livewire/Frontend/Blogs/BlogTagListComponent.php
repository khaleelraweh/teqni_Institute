<?php

namespace App\Http\Livewire\Frontend\Blogs;

use App\Models\Event;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BlogTagListComponent extends Component
{


    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 4;

    public $slug;
    public $searchQuery = '';
    public $currentRoute;

    protected $queryString = ['searchQuery'];

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->currentRoute = Route::currentRouteName();
    }

    public function resetFilters()
    {
        $this->searchQuery = '';
    }



    public function render()
    {

        $tag_title = Tag::query()
            ->whereStatus(1)
            ->where('slug', $this->slug)
            ->orWhere('slug->' . app()->getLocale(), $this->slug) // Ensure you're using the correct locale
            ->first()->name;


        // Get common tags
        $tags = Tag::query()->whereStatus(1)->where('section', 3)->get();

        if ($this->currentRoute === 'frontend.blog_tag_list' || $this->currentRoute === 'frontend.news_tag_list') {
            $postsQuery = Post::with('photos');

            // Apply specific scope based on the route
            if ($this->currentRoute === 'frontend.blog_tag_list') {
                $postsQuery = $postsQuery->Blog();
                $total_Posts = Post::query()->Blog()->count();
                $recent_posts = Post::with('photos')->Blog()->orderBy('created_at', 'DESC')->take(3)->get();
            } else {
                $postsQuery = $postsQuery->News();
                $total_Posts = Post::query()->News()->count();
                $recent_posts = Post::with('photos')->News()->orderBy('created_at', 'DESC')->take(3)->get();
            }

            // Apply tag filtering, search, and pagination
            $posts = $postsQuery
                ->whereHas('tags', function ($query) {
                    $query->where([
                        'slug->' . app()->getLocale() => $this->slug,
                        'status' => true
                    ]);
                })
                ->when($this->searchQuery, function ($query) {
                    $query->where('title', 'LIKE', '%' . $this->searchQuery . '%');
                })
                ->active()
                ->paginate($this->paginationLimit);
        } elseif ($this->currentRoute === 'frontend.events_tag_list') {
            // Events-specific setup
            $postsQuery = Event::with('photos');

            $posts = $postsQuery
                ->whereHas('tags', function ($query) {
                    $query->where([
                        'slug->' . app()->getLocale() => $this->slug,
                        'status' => true
                    ]);
                })
                ->when($this->searchQuery, function ($query) {
                    $query->where('title', 'LIKE', '%' . $this->searchQuery . '%');
                })
                ->active()
                ->paginate($this->paginationLimit);

            $total_Posts = Event::query()->count();
            $recent_posts = Event::with('photos')->orderBy('created_at', 'DESC')->take(3)->get();
        } else {
            // abort(404); // Handle unsupported routes
        }


        return view(
            'livewire.frontend.blogs.blog-tag-list-component',
            [
                'posts'         => $posts,
                'total_Posts'   => $total_Posts,
                'recent_posts'  => $recent_posts,
                'tags'          => $tags,
                'tag_title'     => $tag_title
            ]
        );
    }
}
