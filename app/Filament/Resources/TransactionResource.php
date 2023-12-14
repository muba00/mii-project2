<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Item;
use App\Models\WarehouseLocation;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    // enum('received','shipped','moved','adjusted','damaged','expired','lost')
                    ->options([
                        'received' => 'Received',
                        'shipped' => 'Shipped',
                        'moved' => 'Moved',
                        'adjusted' => 'Adjusted',
                        'damaged' => 'Damaged',
                        'expired' => 'Expired',
                        'lost' => 'Lost',
                    ])
                    ->required(),
                Forms\Components\Select::make('warehouse_location_id')
                    ->options(
                        WarehouseLocation::query()
                            ->get()
                            ->mapWithKeys(function ($location) {
                                return [$location->id => $location->longName];
                            })
                    )
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('item_id')
                    ->options(
                        Item::query()
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->id => $item->name];
                            })
                    )
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label("Type"),
                Tables\Columns\TextColumn::make('warehouseLocation.longName')
                    ->label('Warehouse Location'),
                Tables\Columns\TextColumn::make('item.name')
                    ->label('Item'),
                Tables\Columns\TextColumn::make('quantity'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            // 'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
