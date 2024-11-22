<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('User Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->label('Email'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->nullable()
                    ->helperText('Leave blank to keep current password.'),
                Forms\Components\Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
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
                ->label('Name')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('role')
                ->label('Role')
                ->formatStateUsing(fn($state) => ucfirst($state)) // Capitalizes the first letter
                ->colors([
                    'success' => 'admin',
                    'primary' => 'user',
                ]),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn($state) => ucfirst($state)) // Capitalizes the first letter
                ->colors([
                    'success' => 'active',
                    'danger' => 'inactive',
                ]),
            Tables\Columns\TextColumn::make('created_at')
            ->label('Created At')
            ->dateTime('M d, Y h:i A')
            ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'user' => 'User',
                ]),
            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                ]),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),Tables\Actions\Action::make('toggleStatus')
                ->label('Toggle Status')
                ->action(function ($record) {
                    $record->status = $record->status === 'active' ? 'inactive' : 'active';
                    $record->save();
                })


        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
