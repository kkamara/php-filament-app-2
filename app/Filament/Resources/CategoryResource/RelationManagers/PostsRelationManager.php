<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make("Create a Post")
                ->description("Create posts over here.")
                // ->aside()
                ->collapsible()
                ->schema([
                    TextInput::make("title")->rules("min:3|max:10")->required(), // ->rules([]) can accept an array
                        // ->in(["test", "hello"])
                        // ->minLength(3) for text inputs
                        // ->maxLength(10) for text inputs
                        // ->numeric() for numbers
                        // ->minValue(3) for numbers
                        // ->maxValue(10) for numbers
                    TextInput::make("slug")->unique(ignoreRecord: true)->required(),
                    // Omitting category because Filament will automatically select that,
                    // being on the category resource.
                    ColorPicker::make("color")->required(),

                    MarkdownEditor::make("content")->required()->columnSpan("full"), // or ->columnSpanFull()
                ])->columnSpan(2)->columns(2),
            Group::make()->schema([
                Section::make("Image")->collapsible()->schema([
                    FileUpload::make("thumbnail")->disk("public")->directory("thumbnails"),
                ])->columnSpan(span: 1),
                Section::make("Meta")->collapsible()->schema([
                    TagsInput::make("tags")->required(),
                    Checkbox::make("published"),
                ]),
            ]),
        ])->columns([
            // Tailwind responsive sizes
            "default" => 1,
            "md" => 2,
            "lg" => 3,
            "xl" => 4,
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\CheckboxColumn::make('published'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
