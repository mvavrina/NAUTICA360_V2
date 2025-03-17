<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\Taxon;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Validation\Rule;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                DateTimePicker::make('published')->nullable(),
                FileUpload::make('thumbnail')
                    ->disk('public')
                    ->directory('post-images')
                    ->visibility('public')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(fn ($file) => time() . '_' . $file->getClientOriginalName())
                    ->saveRelationshipsUsing(function ($state, $record) {
                        if (!empty($state)) {
                            $filePath = is_array($state) ? reset($state) : $state;
                            if (!is_string($filePath) || empty($filePath)) {
                                return;
                            }
                            $record->thumbnail = 'post-images/' . basename($filePath);
                            $record->save();
                        }                        
                    })
                    ->nullable(),

                TextInput::make('slug')
                    ->required()
                    ->rules(fn ($record) => [
                        Rule::unique('posts', 'slug')->ignore($record?->id)
                    ]),

                
                
                TextInput::make('tooltip')->nullable(),
                Checkbox::make('hp')->nullable()->label('Homepage Featured'),
                Textarea::make('exceprt')
                    ->columnSpan('full')
                    ->rows(5)
                    ->nullable(),
                    TinyEditor::make('content')
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads/posts')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->rtl()
                    ->columnSpan('full'),

                    Select::make('taxons')
                    ->label('Categories') 
                    ->nullable()
                    ->multiple()
                    ->relationship('taxons', 'title') // Automatické načítání hodnot
                    ->options(Taxon::all()->pluck('title', 'id'))
                    ->saveRelationshipsUsing(function ($state, $record) {
                        $record->taxons()->sync($state);
                    }),
                    

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                ->label('Thumbnail') // Název sloupce
                ->disk('public') // Volitelný disk, pokud používáš jiný než výchozí
                ->visibility(fn ($record) => !empty($record->thumbnail)) // Zobrazí pouze, pokud je thumbnail k dispozici
                ->width(100),
    
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable()->limit(40),
                TextColumn::make('exceprt')->sortable()->searchable()->limit(40),
                BooleanColumn::make('hp')->sortable()->label('Homepage Featured'),
                TextColumn::make('published')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->after(function ($record) {
                    // Delete the thumbnail if it exists
                    if ($record->thumbnail) {
                        Storage::disk('public')->delete($record->thumbnail);
                    }

                    // If you have multiple images (e.g., gallery), loop through and delete them
                    if ($record->gallery) {
                        foreach ($record->gallery as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
