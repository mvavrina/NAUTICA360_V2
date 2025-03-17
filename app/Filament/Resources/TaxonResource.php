<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonResource\Pages;
use App\Filament\Resources\TaxonResource\RelationManagers;
use App\Models\Taxon;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxonResource extends Resource
{
    protected static ?string $model = Taxon::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    
    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $slug = 'categories';
    protected static ?string $breadcrumb = 'Categories';
    protected static ?string $pluralModelLabel = 'Categories';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Název')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('description')
                    ->label('Popis')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(Taxon::class, 'slug', fn ($record) => $record)
                    ->maxLength(255),
                
                    /*
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Taxon')
                    ->options(function () {
                        return Taxon::all()->pluck('title', 'id');
                    })
                    ->nullable()
                    ->searchable()
                    ->placeholder('Select Parent Taxon'),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('title')
                        ->sortable()
                        ->label('Název'),
                    
                    TextColumn::make('slug')
                        ->sortable()
                        ->label('Slug'),
                
                    TextColumn::make('description')
                        ->sortable()
                        ->label('Popisek')->limit(50),
        
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
            'index' => Pages\ListTaxa::route('/'),
            'create' => Pages\CreateTaxon::route('/create'),
            'edit' => Pages\EditTaxon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
