<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\WorldRegionResource\Pages;
use App\Filament\Resources\Api\WorldRegionResource\RelationManagers;
use App\Models\Api\WorldRegion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WorldRegionResource extends Resource
{
    protected static ?string $model = WorldRegion::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'World regions';

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
                Tables\Columns\TextColumn::make('name')->label('Region Name')->sortable()->searchable(),
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
            'index' => Pages\ListWorldRegions::route('/'),
            'create' => Pages\CreateWorldRegion::route('/create'),
            'edit' => Pages\EditWorldRegion::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
