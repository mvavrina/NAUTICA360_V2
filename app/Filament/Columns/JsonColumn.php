<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\Column;

class JsonColumn extends Column
{
    protected string $view = 'filament.columns.json-column';

    public function formatStateUsing(callable $callback): static
    {
        $this->stateFormatter = $callback;
        return $this;
    }

    public function getState($record): mixed
    {
        $state = parent::getState($record);

        if ($this->stateFormatter) {
            return call_user_func($this->stateFormatter, $state);
        }

        return $state;
    }
}
