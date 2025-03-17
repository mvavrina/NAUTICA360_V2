<?php
namespace App\View\Components;

use App\Models\Api\Base;
use App\Models\Api\SailingArea;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BaseList extends Component
{
    public $bases;
    public $sailingAreas;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->bases = Base::orderBy('country')->paginate(100);
        $this->sailingAreas = SailingArea::pluck('name', 'id')->toArray();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|string
    {
        return view('components.base-list', [
            'bases' => $this->bases,
            'sailingAreas' => $this->sailingAreas
        ]);
    }
}
