<?php

namespace App\Http\Controllers;

use App\Models\CardRegion;
use App\Models\Page;
use App\Models\Post;
use App\Models\Taxon;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function show(Page $page)
    {
        return view('pages.show', compact('page'));
    }
    
    public function destinations()
    {
        $destinations = CardRegion::get();
        return view('pages.destinations', [
            'destinations' => $destinations
        ]);
    }

    public function posts(Request $request, $taxonSlugSearch = null)
    {
        // Fetch taxon by slug
        $taxon = $taxonSlugSearch ? Taxon::where('slug', $taxonSlugSearch)->first() : null;
    
        // Fetch posts that belong to the taxon, or all posts if no taxon is selected
        $posts = Post::when($taxon, function ($query) use ($taxon) {
            $query->whereHas('taxons', function ($subQuery) use ($taxon) {
                $subQuery->where('taxon_id', $taxon->id);
            });
        })
        ->orderByRaw('CASE WHEN published IS NULL THEN 1 ELSE 0 END')
        ->orderBy('published', 'desc')
        ->orderBy('id')
        ->get();
    
        // Fetch all taxons for the filter dropdown
        $allTaxons = Taxon::all();
    
        return view('pages.posts', compact('posts', 'taxon', 'allTaxons'));
    }
    


    public function postsShow($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('pages.post-detail', compact('post'));
    }
}
