<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtTypeResource\Pages;
use App\Filament\Resources\Api\YachtTypeResource\RelationManagers;
use App\Models\Api\YachtType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtTypeResource extends Resource
{
    protected static ?string $model = YachtType::class;

    //protected static ?string $navigationParentItem = 'Yachts';
    
    //protected static ?string $navigationGroup = 'Přehled';
    
    //protected static ?int $navigationSort = 2;
    //protected static ?string $navigationLabel = 'Resources';
    protected static bool $shouldRegisterNavigation = false;
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
                //
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
            'index' => Pages\ListYachtTypes::route('/'),
            'create' => Pages\CreateYachtType::route('/create'),
            'edit' => Pages\EditYachtType::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
