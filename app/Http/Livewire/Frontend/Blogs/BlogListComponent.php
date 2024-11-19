<?php

namespace App\Http\Livewire\Frontend\Blogs;

use App\Models\Event;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Route;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class BlogListComponent extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $paginationLimit = 4;

    public $slug;

    public $searchQuery = '';

    protected $queryString = ['searchQuery'];

    // Define a property to store the route name
    public $currentRoute;

    public function __construct($id = null)
    {
        parent::__construct($id);
        // Set the current route name once in the constructor
        $this->currentRoute = Route::currentRouteName();
    }


    public function resetFilters()
    {
        $this->searchQuery = '';
    }

    public function render()
    {


        // Get common tags
        $tags = Tag::query()->whereStatus(1)->where('section', 3)->get();

        if ($this->currentRoute === 'frontend.blog_list' || $this->currentRoute === 'frontend.news_list') {
            $postsQuery = Post::with('photos');

            // Apply specific scope based on the route
            if ($this->currentRoute === 'frontend.blog_list') {
                $postsQuery = $postsQuery->Blog();
                $total_Posts = Post::query()->Blog()->count();
                $recent_posts = Post::with('photos')->Blog()->orderBy('created_at', 'DESC')->take(3)->get();
            } else {
                $postsQuery = $postsQuery->News();
                $total_Posts = Post::query()->News()->count();
                $recent_posts = Post::with('photos')->News()->orderBy('created_at', 'DESC')->take(3)->get();
            }

            // Apply search and pagination
            $posts = $postsQuery
                ->when($this->searchQuery, function ($query) {
                    $query->where('title', 'LIKE', '%' . $this->searchQuery . '%');
                })
                ->active()
                ->paginate($this->paginationLimit);
        } elseif ($this->currentRoute === 'frontend.events_list') {
            // Events-specific setup
            $postsQuery = Event::with('photos');

            $posts = $postsQuery
                ->when($this->searchQuery, function ($query) {
                    $query->where('title', 'LIKE', '%' . $this->searchQuery . '%');
                })
                ->active()
                ->paginate($this->paginationLimit);

            $total_Posts = Event::query()->count();
            $recent_posts = Event::with('photos')->orderBy('created_at', 'DESC')->take(3)->get();
        } else {
            abort(404); // Handle unsupported routes
        }


        return view(
            'livewire.frontend.blogs.blog-list-component',
            [
                'posts'             =>  $posts,
                'total_Posts'       =>  $total_Posts,
                'recent_posts'      =>  $recent_posts,
                'tags'              =>  $tags,
            ]
        );
    }
}
