<?php

namespace App\View\Components;

use App\Models\CardCity;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardCities extends Component
{
    public $cardCities;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cardCities = CardCity::where('show_hp', true)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-cities', [
            'cardCities' => $this->cardCities
        ]);
    }
}
