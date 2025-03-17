<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtExtraResource\Pages;
use App\Filament\Resources\Api\YachtExtraResource\RelationManagers;
use App\Models\Api\YachtExtra;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtExtraResource extends Resource
{
    protected static ?string $model = YachtExtra::class;
    protected static bool $shouldRegisterNavigation = false;

    //protected static ?string $navigationParentItem = 'Yachts';
    
    //protected static ?string $navigationGroup = 'Přehled';
    
    //protected static ?int $navigationSort = 2;
    //protected static ?string $navigationLabel = 'Extras';

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
            'index' => Pages\ListYachtExtras::route('/'),
            'create' => Pages\CreateYachtExtra::route('/create'),
            'edit' => Pages\EditYachtExtra::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
