<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtCrewResource\Pages;
use App\Filament\Resources\Api\YachtCrewResource\RelationManagers;
use App\Models\Api\YachtCrew;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtCrewResource extends Resource
{
    protected static ?string $model = YachtCrew::class;

    protected static ?string $navigationParentItem = 'Yachts';

    protected static ?string $navigationGroup = 'Přehled';

    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Crew';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name')->disabled(),
    TextInput::make('yacht')->label('Yacht Name')->disabled()->searchable(),
    TextInput::make('age')->label('Age')->disabled(),
    TextInput::make('nationality')->label('Nationality')->disabled(),
    Select::make('roles')
        ->label('Roles')
        ->disabled()
        ->multiple()
        ->options(function ($state) {
            // Check if $state is an array, otherwise decode the JSON
            $roles = is_array($state) ? $state : json_decode($state, true);
            return is_array($roles) ? array_combine($roles, $roles) : [];
        })
        ->placeholder('No roles available'),
    Select::make('languages')
        ->label('Languages')
        ->disabled()
        ->multiple()
        ->options(function ($state) {
            // Check if $state is an array, otherwise decode the JSON
            $languages = is_array($state) ? $state : json_decode($state, true);
            return is_array($languages) ? array_combine($languages, $languages) : [];
        })
        ->placeholder('No languages available'),
    Select::make('licenses')
        ->label('Licenses')
        ->disabled()
        ->multiple()
        ->options(function ($state) {
            // Check if $state is an array, otherwise decode the JSON
            $licenses = is_array($state) ? $state : json_decode($state, true);
            return is_array($licenses) ? array_combine($licenses, $licenses) : [];
        })
        ->placeholder('No licenses available'),
    TextInput::make('description')->label('Description')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('name')->label('Crew Name')->sortable(),
                TextColumn::make('yacht.name')->label('Yacht Name')->sortable(),
                TextColumn::make('nationality')->label('Nationality')->sortable(),
                TextColumn::make('roles')->label('Roles')->sortable()->formatStateUsing(function ($state) {
                    // Assuming $state is a JSON-encoded array or object
                    $roles = json_decode($state, true); // Decode JSON to an array if it's a string
                    if (is_array($roles)) {
                        return implode(', ', $roles); // Join array values with commas
                    }
                    return 'No roles available';
                }),
                TextColumn::make('languages')->label('Languages')->sortable()->formatStateUsing(function ($state) {
                    // Assuming $state is a JSON-encoded array or object
                    $roles = json_decode($state, true); // Decode JSON to an array if it's a string
                    if (is_array($roles)) {
                        return implode(', ', $roles); // Join array values with commas
                    }
                    return 'No lanugages available';
                }),
                TextColumn::make('licenses')
                    ->label('Licenses')
                    ->sortable()
                    ->limit(30)
                    ->formatStateUsing(function ($state) {
                        // Encode the licenses field as JSON and limit the string length
                        $jsonLicenses = json_decode($state);

                        // If the JSON string is longer than the limit, truncate it
                        if (strlen($jsonLicenses) > 30) {
                            return substr($jsonLicenses, 0, 30) . '...';
                        }

                        return $jsonLicenses;
                    }),

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
            'index' => Pages\ListYachtCrews::route('/'),
            'create' => Pages\CreateYachtCrew::route('/create'),
            'edit' => Pages\EditYachtCrew::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
