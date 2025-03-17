<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Reservation;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Api\Yacht;
use Filament\Tables\Actions\Action;


class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // First Name, Last Name, Email, Tel - editable on create, disabled on edit
            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'done' => 'Done',
                ])
                ->label('Stav')
                ->required(), // Optional, depending on whether you want it to be required
            

            TextInput::make('first_name')->label('Jméno')->disabled(fn ($record) => $record !== null),
            TextInput::make('last_name')->label('Příjmení')->disabled(fn ($record) => $record !== null),
            TextInput::make('email')->label('E-mail')->email()->disabled(fn ($record) => $record !== null),
            TextInput::make('tel')->label('Telefón')->disabled(fn ($record) => $record !== null),

            // Date from and Date to - always editable
            DateTimePicker::make('date_from')->label('Datum od')->required(),
            DateTimePicker::make('date_to')->label('Datum do')->required(),

            // Reserved date - editable on create, disabled on edit
            DateTimePicker::make('reserved')->label('Čas rezervace')->disabled(fn ($record) => $record !== null),

            // Yacht selection - editable on create, disabled on edit
            Select::make('yacht_id')
            ->label('Název jachty')
            ->relationship('yacht', 'model')
            ->searchable()
            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->model} - {$record->name}")
            ->disabled(fn ($record) => $record !== null),

            // Price, Discount, Base price - always editable
            TextInput::make('base_price')->label('Základní cena')->numeric()->required(),
            TextInput::make('discount')->label('Sleva')->numeric(),
            TextInput::make('price')->label('Celková cena')->numeric()->required(),

            // Note - always editable
            Textarea::make('note')
                ->label('Poznámka')
                ->columnSpan('full')
                ->rows(5)
                ->nullable(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('status')->label('Stav')->sortable()->searchable(),
            TextColumn::make('reserved')->label('Čas rezervace')->sortable()->dateTime(),
            TextColumn::make('first_name')->label('Jméno')->sortable()->searchable(),
            TextColumn::make('last_name')->label('Příjmení')->sortable()->searchable(),
            TextColumn::make('email')->label('E-mail')->sortable()->searchable(),
            TextColumn::make('tel')->label('Telefón')->sortable(),
        
            TextColumn::make('yacht.model')
                ->label('Název jachty') // Optional label
                ->sortable()
                ->searchable()
                ->limit(30), 
            
            TextColumn::make('date_from')->label('Datum od')->sortable()->dateTime(),
            TextColumn::make('date_to')->label('Datum do')->sortable()->dateTime(),
        
            TextColumn::make('base_price')->label('Základní cena')->sortable(),
            TextColumn::make('discount')->label('Sleva')->sortable(),
            TextColumn::make('price')->label('Celková cena')->sortable(),
            TextColumn::make('note')->label('Poznámka')->limit(50),  // Optionally limit the note text
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('openLink')
                    ->label('Zobrazit jachtu')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->action(fn ($record) => null) // No server-side action needed
                    ->color('secondary')
                    ->url(fn ($record) => route('yacht.detail', ['id' => $record->yacht_id]))
                    ->openUrlInNewTab(), // This method will open the link in a new tab
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
