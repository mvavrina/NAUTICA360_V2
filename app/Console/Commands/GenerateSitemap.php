<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Api\Yacht;
use App\Models\Page;
use Carbon\Carbon;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.xml file';

    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/vyhledat-lod'))
            ->add(Url::create('/prispevky'))
            ->add(Url::create('/oblibene-destinace'))
            ->add(Url::create('/faqs'));

        // Přidání příspěvků do sitemap
        $posts = Post::all();
        foreach ($posts as $post) {
            $sitemap->add(Url::create(route('prehled-prispevku-detail', $post->slug))
                ->setLastModificationDate($post->updated_at ?? Carbon::now())
                ->setChangeFrequency('weekly')
                ->setPriority(0.8));
        }

        // Přidání lodí (yachts) do sitemap
        $yachts = Yacht::all();
        /*foreach ($yachts as $yacht) {
            $sitemap->add(Url::create(route('yacht.detail', ['id' => $yacht->id]))
                ->setChangeFrequency('weekly')
                ->setPriority(0.7));
        }
                */

        // Přidání stránek (pages) do sitemap
        $pages = Page::all();
        foreach ($pages as $page) {
            $sitemap->add(Url::create(url('/' . $page->slug))
                ->setLastModificationDate($page->updated_at ?? Carbon::now())
                ->setChangeFrequency('monthly')
                ->setPriority(0.6));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap was generated successfully!');
    }
}
