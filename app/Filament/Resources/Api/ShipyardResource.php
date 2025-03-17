<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\ShipyardResource\Pages;
use App\Filament\Resources\Api\ShipyardResource\RelationManagers;
use App\Models\Api\Shipyard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipyardResource extends Resource
{
    protected static ?string $model = Shipyard::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Shipyards';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('Shipyard Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('shortName')->label('Short Name')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Updated At')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListShipyards::route('/'),
            'create' => Pages\CreateShipyard::route('/create'),
            'edit' => Pages\EditShipyard::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
