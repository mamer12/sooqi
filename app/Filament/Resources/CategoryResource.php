<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                    ->label('Category Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                ->label('Slug')
                ->maxLength(255)
                    ->nullable()
                    ->helperText('Leave blank to auto-generate'),
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
                ->label('Category Name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('slug')
                ->label('Slug')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('M d, Y h:i A')
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->label('Updated At')
                ->dateTime('M d, Y h:i A')
                ->sortable(),
        ])

            ->filters([
                //
            ])
            ->actions([
            Tables\Actions\ViewAction::make(), // Show button
            Tables\Actions\EditAction::make(), // Edit button
            Tables\Actions\DeleteAction::make(), // Delete button
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
