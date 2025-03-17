<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtDescriptionResource\Pages;
use App\Filament\Resources\Api\YachtDescriptionResource\RelationManagers;
use App\Models\Api\YachtDescription;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtDescriptionResource extends Resource
{
    protected static ?string $model = YachtDescription::class;

    protected static ?string $navigationParentItem = 'Yachts';
    
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Popis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('yacht.name')->searchable()
                ->label('Yacht Name')
                ->sortable(),
            TextColumn::make('text')
                ->label('Description')
                ->limit(50) // You can limit the description length here
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([

            ])
            ->bulkActions([
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
            'index' => Pages\ListYachtDescriptions::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
