<?php

namespace App\View\Components;

use App\Models\Question as ModelsQuestion;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Question extends Component
{

    public $records;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->records = ModelsQuestion::get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.question',[
            'questions' => $this->records,
        ]);
    }
}
