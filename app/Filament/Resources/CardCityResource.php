<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardCityResource\Pages;
use App\Filament\Resources\CardCityResource\RelationManagers;
use App\Models\CardCity;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CardCityResource extends Resource
{
    protected static ?string $model = CardCity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Heading field
                TextInput::make('heading')
                    ->label('Heading')
                    ->required()
                    ->maxLength(255),

                // Text field
                Textarea::make('text')
                    ->label('Text')
                    ->required()
                    ->maxLength(1000),

                // Show in homepage (boolean)
                Toggle::make('show_hp')
                    ->label('Show on Homepage')
                    ->required(),

                // Image field
                FileUpload::make('img')
                    ->label('Image')
                    ->disk('public')
                    ->directory('card-city')
                    ->visibility('public')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(fn($file) => time() . '_' . $file->getClientOriginalName())
                    ->saveRelationshipsUsing(function ($state, $record) {
                        if (!empty($state)) {
                            $filePath = is_array($state) ? reset($state) : $state;
                            if (!is_string($filePath) || empty($filePath)) {
                                return;
                            }
                            $record->img = 'card-city/' . basename($filePath);
                            $record->save();
                        }
                    })
                    ->nullable(),

                // Link field
                TextInput::make('link')
                    ->label('Link')
                    ->url(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Heading column
                TextColumn::make('heading')
                    ->label('Heading')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                // Text column (with truncation for preview)
                TextColumn::make('text')
                    ->label('Text')
                    ->limit(100)
                    ->sortable()
                    ->searchable(),

                // Show on Homepage (Boolean)
                BooleanColumn::make('show_hp')
                    ->label('Show on Homepage')
                    ->sortable(),

                // Image preview
                ImageColumn::make('img')
                    ->label('Image')
                    ->sortable()
                    ->size(50),

                // Flag preview
                ImageColumn::make('flag')
                    ->label('Flag')
                    ->sortable()
                    ->size(50),
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
            'index' => Pages\ListCardCities::route('/'),
            'create' => Pages\CreateCardCity::route('/create'),
            'edit' => Pages\EditCardCity::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string { return static::getModel()::count(); }
}
