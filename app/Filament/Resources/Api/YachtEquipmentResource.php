<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtEquipmentResource\Pages;
use App\Filament\Resources\Api\YachtEquipmentResource\RelationManagers;
use App\Models\Api\YachtEquipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtEquipmentResource extends Resource
{
    protected static ?string $model = YachtEquipment::class;
    protected static bool $shouldRegisterNavigation = false;
    //protected static ?string $navigationParentItem = 'Yachts';
    
    //protected static ?string $navigationGroup = 'Přehled';
    
    //protected static ?int $navigationSort = 2;
    //protected static ?string $navigationLabel = 'Equipments';

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
                Tables\Columns\TextColumn::make('yacht.name')->sortable()->searchable()->limit(30)->searchable(),
                Tables\Columns\TextColumn::make('equipment.name')->sortable()->searchable()->limit(30),
                Tables\Columns\TextColumn::make('value')->sortable()->searchable()->limit(30),
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
            'index' => Pages\ListYachtEquipment::route('/'),
            'create' => Pages\CreateYachtEquipment::route('/create'),
            'edit' => Pages\EditYachtEquipment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
