<?php

namespace App\View\Components;

use App\Models\CardRegion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardRegions extends Component
{
    /**
     * The list of card regions where show_hp is true.
     *
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $cardRegions;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        // Retrieve records where show_hp is true
        $this->cardRegions = CardRegion::where('show_hp', true)->get();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-regions', [
            'cardRegions' => $this->cardRegions,
        ]);
    }
}
