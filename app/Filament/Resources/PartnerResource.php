<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PartnerResource extends Resource
{
    protected static ?string $model = Partner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('img')
                    ->label('Partner logo')
                    ->disk('public')
                    ->directory('partner-images')
                    ->visibility('public')
                    ->image()
                    ->getUploadedFileNameForStorageUsing(fn ($file) => time() . '_' . $file->getClientOriginalName())
                    ->saveRelationshipsUsing(function ($state, $record) {
                        if (!empty($state)) {
                            $filePath = is_array($state) ? reset($state) : $state;
                            if (!is_string($filePath) || empty($filePath)) {
                                return;
                            }
                            $record->img = 'partner-images/' . basename($filePath);
                            $record->save();
                        }                        
                    })
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('img')
                ->label('Image')
                ->disk('public')
                ->visibility(function ($record) {
                    return !empty($record->img);
                })
                ->width(100),
            
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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string { return static::getModel()::count(); }
}
