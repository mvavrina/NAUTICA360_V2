<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\CompanyResource\Pages;
use App\Filament\Resources\Api\CompanyResource\RelationManagers;
use App\Models\Api\Company;
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

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?string $navigationGroup = 'Přehled';
    
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Companies';
    

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('id')->label('ID')->disabled(),
            TextInput::make('name')->label('Name')->disabled(),
            TextInput::make('address')->label('Address')->columnSpan('full')->disabled(),
            TextInput::make('city')->label('City')->disabled(),
            TextInput::make('zip')->label('ZIP')->disabled(),
            TextInput::make('country')->label('Country')->disabled(),
            TextInput::make('telephone')->label('Telephone')->disabled(),
            TextInput::make('telephone2')->label('Telephone 2')->disabled(),
            TextInput::make('mobile')->label('Mobile')->disabled(),
            TextInput::make('mobile2')->label('Mobile 2')->disabled(),
            TextInput::make('vatCode')->label('VAT Code')->disabled(),
            TextInput::make('email')->label('Email')->disabled(),
            TextInput::make('web')->label('Website')->disabled(),
            TextInput::make('bankAccountNumber')->label('Bank Account Number')->disabled(),
            TextInput::make('maxDiscountFromCommissionPercentage')->label('Max Discount')->disabled(),
            Textarea::make('termsAndConditions')->label('Terms and Conditions')->columnSpan('full')
            ->rows(5)->disabled(),
            Textarea::make('checkoutNote')->label('Checkout Note')->columnSpan('full')
            ->rows(5)->disabled(),
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
                TextColumn::make('maxDiscountFromCommissionPercentage')
                    ->label('Max Discount')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state . '%'; // Append % to the value
                    }),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
