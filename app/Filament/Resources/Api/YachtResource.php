<?php

namespace App\Filament\Resources\Api;

use App\Filament\Resources\Api\YachtResource\Pages;
use App\Filament\Resources\Api\YachtResource\RelationManagers;
use App\Models\Api\Yacht;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class YachtResource extends Resource
{
    protected static ?string $model = Yacht::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';
    protected static ?int $navigationSort = 0;
    protected static ?string $navigationBadgeTooltip = 'The number of yachts';
    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;
    protected static ?string $navigationLabel = 'Yachts';
    
    protected static ?string $navigationGroup = 'Přehled';

    // Optional: Define a custom navigation label for the parent
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id')->label('ID')->disabled(),
            TextInput::make('name')->label('Name')->disabled(),
            TextInput::make('model')->label('Model')->disabled(),
            TextInput::make('modelId')->label('Model ID')->disabled(),
            TextInput::make('shipyardId')->label('Shipyard ID')->disabled(),
            TextInput::make('year')->label('Year')->disabled(),
            TextInput::make('kind')->label('Kind')->disabled(),
            TextInput::make('certificate')->label('certificate')->disabled(),
            TextInput::make('homeBaseId')->label('Home Base ID')->disabled(),
            TextInput::make('homeBase')->label('Home Base')->disabled(),
            TextInput::make('companyId')->label('Company ID')->disabled(),
            TextInput::make('company')->label('Company')->disabled(),
            TextInput::make('draught')->label('Draught')->disabled(),
            TextInput::make('beam')->label('Beam')->disabled(),
            TextInput::make('length')->label('Length')->disabled(),
            TextInput::make('waterCapacity')->label('Water Capacity')->disabled(),
            TextInput::make('fuelCapacity')->label('Fuel Capacity')->disabled(),
            TextInput::make('engine')->label('Engine')->disabled(),
            TextInput::make('deposit')->label('Deposit')->disabled(),
            TextInput::make('depositWithWaiver')->label('Deposit With Waiver')->disabled(),
            TextInput::make('currency')->label('Currency')->disabled(),
            TextInput::make('commissionPercentage')->label('Commission Percentage')->disabled(),
            TextInput::make('maxDiscountFromCommissionPercentage')->label('Max Discount')->disabled(),
            TextInput::make('wc')->label('WC')->disabled(),
            TextInput::make('berths')->label('Berths')->disabled(),
            TextInput::make('cabins')->label('Cabins')->disabled(),
            TextInput::make('wcNote')->label('WC Note')->disabled(),
            TextInput::make('berthsNote')->label('Berths Note')->disabled(),
            TextInput::make('cabinsNote')->label('Cabins Note')->disabled(),
            TextInput::make('transitLog')->label('Transit Log')->disabled(),
            TextInput::make('mainsailArea')->label('Mainsail Area')->disabled(),
            TextInput::make('genoaArea')->label('Genoa Area')->disabled(),
            TextInput::make('mainsailType')->label('Mainsail Type')->disabled(),
            TextInput::make('genoaType')->label('Genoa Type')->disabled(),
            TextInput::make('requiredSkipperLicense')->label('Required Skipper License')->disabled(),
            TextInput::make('defaultCheckInDay')->label('Default Check-In Day')->disabled(),
            TextInput::make('allCheckInDays')->label('All Check-In Days')->disabled(),
            TextInput::make('defaultCheckInTime')->label('Default Check-In Time')->disabled(),
            TextInput::make('defaultCheckOutTime')->label('Default Check-Out Time')->disabled(),
            TextInput::make('minimumCharterDuration')->label('Minimum Charter Duration')->disabled(),
            TextInput::make('maximumCharterDuration')->label('Maximum Charter Duration')->disabled(),
            TextInput::make('maxPeopleOnBoard')->label('Max People On Board')->disabled(),
            RichEditor::make('comment')->label('Comment')->columnSpan('full')->disabled(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Yacht Name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('model')->label('Yacht Model')->sortable(),
                Tables\Columns\TextColumn::make('company')->label('Yacht Company')->sortable(),
                Tables\Columns\TextColumn::make('homeBase')->label('Home Base')->sortable(),
                Tables\Columns\TextColumn::make('year')->label('Yacht Year')->sortable(),
                Tables\Columns\TextColumn::make('shipyard.name')->label('Shipyard')->sortable(),
                Tables\Columns\TextColumn::make('id')->label('id')->sortable(),
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
            'index' => Pages\ListYachts::route('/'),
            'create' => Pages\CreateYacht::route('/create'),
            'edit' => Pages\EditYacht::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    
}
