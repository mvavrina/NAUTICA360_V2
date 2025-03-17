<?php

namespace App\Livewire;

use App\Models\Api\Yacht;
use Livewire\Component;
use Livewire\WithPagination;

class Test extends Component
{
    use WithPagination; // Použití trait pro paginaci

    public $perPage = 10; // Počet položek na stránku

    // Simulovaná data (můžete nahradit skutečnými daty z databáze nebo API)

    // Renderování šablony
    public function render()
    {
        // Ruční paginace pomocí kolekce
        $paginatedItems = Yacht::paginate($this->perPage);

        return view('livewire.test', [
            'items' => $paginatedItems, // Předání paginovaných položek do šablony
        ]);
    }
}