<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Api\Base;
use App\Models\Api\SailingArea;

class BaseDetail extends Component
{
    public $base, $areas;

    /**
     * Create a new component instance.
     */
    public function __construct($baseId)
    {
        $this->areas = SailingArea::get();
        $this->base = Base::find($baseId);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.base-detail', [
            'base' => $this->base,
            'areas' => $this->areas
        ]);
    }
}
