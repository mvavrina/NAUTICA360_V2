<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Api\Company;

class CompanyList extends Component
{
    public $companies;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->companies = Company::orderBy('country')->paginate(100); // Fetch companies with pagination
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.company-list', [
            'companies' => $this->companies
        ]);
    }
}
