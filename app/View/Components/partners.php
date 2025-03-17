<?php

namespace App\View\Components;

use App\Models\Partner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class partners extends Component
{

    public $records;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
        $this->records = Partner::get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.partners',[
            'partners' => $this->records
        ]);
    }
}
