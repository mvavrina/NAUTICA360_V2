<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\BaseResource\Pages;
use App\Filament\Resources\Api\BaseResource\RelationManagers;
use App\Models\Api\Base;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BaseResource extends Resource
{
    protected static ?string $model = Base::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Bases';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('ID')->disabled(),
                TextInput::make('name')->label('Name')->disabled(),
                TextInput::make('city')->label('City')->disabled(),
                TextInput::make('country')->label('Country')->disabled(),
                TextInput::make('address')->label('Address')->columnSpan('full')
                ->rows(5)->disabled(),
                TextInput::make('latitude')->label('Latitude')->disabled(),
                TextInput::make('longitude')->label('Longitude')->disabled(),
                TextInput::make('countryId')->label('Country ID')->disabled(),
                TextInput::make('sailingAreas')->label('Sailing Areas')->disabled(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Company Name')->sortable(),
                Tables\Columns\TextColumn::make('country')->label('Country Name')->sortable(),
                Tables\Columns\TextColumn::make('city')->label('City Name')->sortable(),
                Tables\Columns\TextColumn::make('address')->label('Address')->sortable()->limit(20),
                Tables\Columns\TextColumn::make('latitude')->label('latitude')->sortable(),
                Tables\Columns\TextColumn::make('longitude')->label('longitude')->sortable(),
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
            'index' => Pages\ListBases::route('/'),
            'create' => Pages\CreateBase::route('/create'),
            'edit' => Pages\EditBase::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
