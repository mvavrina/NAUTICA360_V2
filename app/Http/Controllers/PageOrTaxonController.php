<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Taxon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageOrTaxonController extends Controller
{

    public function handleSlug($categorySlug, $postSlug = null)
    {
        // **Step 1: Check if the first slug is a Taxon**
        $taxon = Taxon::where('slug', $categorySlug)->first();

        if ($taxon) {
            // **Step 2: If there's a second slug, look for a Post inside the Taxon**
            if ($postSlug) {
                $post = Post::where('slug', $postSlug)
                    ->whereHas('taxons', function ($query) use ($taxon) {
                        $query->where('taxon_id', $taxon->id);
                    })
                    ->first();

                if ($post) {
                    return view('pages.post-detail', [
                        'post' => $post,
                        'taxon' => $taxon,
                    ]);
                }

                // If post is not found inside the taxon, return 404
                abort(404);
            }

            // **Step 3: If there's no second slug, return posts inside the Taxon**
            $postIds = DB::table('post_taxons')
                ->where('taxon_id', $taxon->id)
                ->pluck('post_id');

            $posts = Post::whereIn('id', $postIds)->orderByRaw('CASE WHEN published IS NULL THEN 1 ELSE 0 END')
            ->orderBy('published', 'desc')
            ->orderBy('id')
            ->get();
            
            return view('pages.posts', compact('posts', 'taxon'));
        }

        // **Step 4: If not a Taxon, check if it's a Page**
        $page = Page::where('slug', $categorySlug)->first();
        if ($page) {
            return view('pages.show', compact('page'));
        }

        // **Step 5: If nothing is found, return 404**
        abort(404);
    }

}
