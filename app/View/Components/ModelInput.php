<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModelInput extends Component
{
    public string $model;      // Atribut pro model
    public string $name;      // Atribut pro model
    public string $label;      // Atribut pro label
    public string $placeholder; // Atribut pro placeholder

    /**
     * Create a new component instance.
     */
    public function __construct(string $model, string $label, string $placeholder, string $name)
    {
        $this->model = $model;
        $this->label = $label;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.model-input');
    }
}
