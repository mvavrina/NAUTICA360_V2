<?php

namespace App\View\Components;

use App\Models\Testimonial;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BannerBlueSecond extends Component
{

    public $records;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->records = Testimonial::where('show_hp', true)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner-blue-second',[
            'testimonials' => $this->records
        ]);
    }
}
