<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make("name")->required(),
                TextInput::make("email")->required()->email(),
                TextInput::make("password")->password()->visibleOn("create"), // also ->readonly()
                /*Select::make("name")->options([
                    // database_key => shown_to_user
                    "test" => "test",
                    "youtube" => "another one",
                ]),
                ColorPicker::make("name"),*/
                Select::make("role")->options([
                    "ADMIN" => "ADMIN",
                    "EDITOR" => "EDITOR",
                    "USER" => "USER",
                ])
                    ->default(auth()->user()->role),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                    ->searchable(),
                TextColumn::make("name")
                    ->searchable(),
                TextColumn::make("email")
                    ->searchable(),
                TextColumn::make(name: "role")
                    ->badge()
                    ->color(function(string $state): string {
                        return match($state) {
                            "ADMIN" => "danger", // RED
                            "EDITOR" => "info", // BLUE
                            "USER" => "success", // GREEN
                            default => "gray",
                        };
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
