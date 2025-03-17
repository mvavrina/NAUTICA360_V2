<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Api\Company;

class CompanyDetail extends Component
{
    public $company;

    /**
     * Create a new component instance.
     */
    public function __construct($companyId)
    {
        $this->company = Company::find($companyId);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.company-detail', [
            'company' => $this->company
        ]);
    }
}
