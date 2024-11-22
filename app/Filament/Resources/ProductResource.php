<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Product Name'),
            Forms\Components\Textarea::make('description')
            ->nullable()
                ->label('Description'),
            Forms\Components\TextInput::make('price')
                ->numeric()
                ->required()
                ->label('Price'),
            Forms\Components\TextInput::make('stock')
                ->numeric()
                ->required()
                ->label('Stock Quantity'),
            Forms\Components\Select::make('category_id')
            ->relationship('category', 'name') // Ensure the `category` relationship is defined in Product model
                ->label('Category')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->limit(50) // Show a truncated version of the description
                    ->toggleable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('usd') // Format as currency
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock Quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                ->label('Category') // Display category name
                ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('M d, Y h:i A')
                ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                ->label('Last Updated')
                ->dateTime('M d, Y h:i A')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
            Tables\Actions\ViewAction::make(), // Show button
            Tables\Actions\EditAction::make(), // Edit button
            Tables\Actions\DeleteAction::make(), // Delete button,
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
