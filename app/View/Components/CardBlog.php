<?php

namespace App\View\Components;

use App\Models\Post;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardBlog extends Component
{

    public $posts;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->posts = Post::where('hp', true)->orderBy('published')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-blog',[
            'posts' => $this->posts,
        ]);
    }
}
