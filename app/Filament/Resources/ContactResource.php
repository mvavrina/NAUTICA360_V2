<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                        ->disabled()
                        ->label('Name')
                        ->default(fn ($record) => $record->name),
                    
                    Forms\Components\TextInput::make('email')
                        ->disabled()
                        ->label('Email')
                        ->default(fn ($record) => $record->email),
                    
                    Forms\Components\TextInput::make('tel')
                        ->disabled()
                        ->label('Phone')
                        ->default(fn ($record) => $record->tel),
                        
                    Forms\Components\DateTimePicker::make('at')
                        ->disabled()
                        ->label('Received At')
                        ->default(fn ($record) => $record->at),

                    Forms\Components\TextArea::make('message')
                        ->disabled()
                        ->label('Message')
                        ->default(fn ($record) => $record->message)
                        ->rows(10)
                        ->columnSpan('full'),
        ]);
    }

     public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable()->limit(30),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tel'),
                Tables\Columns\TextColumn::make('message')->sortable()->limit(50),
                Tables\Columns\TextColumn::make('at')->sortable()->dateTime(),
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
            ])
            ->defaultSort('at', 'desc');
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
            'index' => Pages\ListContacts::route('/'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
