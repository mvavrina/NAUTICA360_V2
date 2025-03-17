<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\SailingAreaResource\Pages;
use App\Filament\Resources\Api\SailingAreaResource\RelationManagers;
use App\Models\Api\SailingArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SailingAreaResource extends Resource
{
    protected static ?string $model = SailingArea::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Sailing areas';
    

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
                Tables\Columns\TextColumn::make('id')->label('id'),
                Tables\Columns\TextColumn::make('name')->label('Sailing area name')->searchable(),
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
            'index' => Pages\ListSailingAreas::route('/'),
            'create' => Pages\CreateSailingArea::route('/create'),
            'edit' => Pages\EditSailingArea::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
