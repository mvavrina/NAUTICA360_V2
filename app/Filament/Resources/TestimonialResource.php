<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('text')
                    ->label('Testimonial')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('customer_type')
                    ->label('Customer type')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('img')
                    ->disk('public')
                    ->directory('testimonials')
                    ->visibility('public')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(fn ($file) => time() . '_' . $file->getClientOriginalName())
                    ->saveRelationshipsUsing(function ($state, $record) {
                        if (!empty($state)) {
                            $filePath = is_array($state) ? reset($state) : $state;
                            if (!is_string($filePath) || empty($filePath)) {
                                return;
                            }
                            $record->img = 'testimonials/' . basename($filePath);
                            $record->save();
                        }                        
                    })
                    ->nullable(),

                Toggle::make('show_hp')
                    ->label('Show on Homepage')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('customer_type'),
                BooleanColumn::make('show_hp')->sortable()->label('Homepage Featured'),
                TextColumn::make('text')->limit(50),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string { return static::getModel()::count(); }
}
