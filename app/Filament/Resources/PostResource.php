<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\AuthorsRelationManager;
use App\Models\Category;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make("Create New Post")->tabs([
                    Tab::make("Tab 1")
                        ->icon("heroicon-m-folder")
                        ->iconPosition(IconPosition::After)
                        ->badge("Hi")
                        ->schema([
                            TextInput::make("title")->rules("min:3|max:10")->required(), // ->rules([]) can accept an array
                            // ->in(["test", "hello"])
                            // ->minLength(3) for text inputs
                            // ->maxLength(10) for text inputs
                            // ->numeric() for numbers
                            // ->minValue(3) for numbers
                            // ->maxValue(10) for numbers
                            TextInput::make("slug")->unique(ignoreRecord: true)->required(),

                            Select::make("category_id")
                                ->label("Category")
                                // ->options(Category::all()->pluck("name", "id")) // old
                                ->relationship("category", "name") // Better load select options (for large table sizes)
                                ->searchable()
                                ->required(),
                            ColorPicker::make("color")->required(),
                        ]),
                    Tab::make("Content")->schema([
                        MarkdownEditor::make("content")->required()->columnSpan("full"), // or ->columnSpanFull()
                    ]),
                    Tab::make("Meta")->schema([
                        FileUpload::make("thumbnail")->disk("public")->directory("thumbnails"),
                        TagsInput::make("tags")->required(),
                        Checkbox::make("published"),
                    ]),
                ])->columnSpanFull()->activeTab(2)->persistTabInQueryString(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("id")
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make("thumbnail")
                    ->toggleable(),
                ColorColumn::make("color")
                    ->toggleable(),
                TextColumn::make("title")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("slug")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("category.name")
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make("tags")
                    ->toggleable(),
                CheckboxColumn::make("published")
                    ->toggleable(),
                TextColumn::make("created_at")
                    ->label("Published On")
                    ->date("Y-m-d H:i")
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                // Filter::make("Published Posts")
                //     ->query(
                //         function(Builder $query) { // Builder for type suggestions and IDE documentation hinting.
                //             $query->where("published", true);
                //         }
                //     ),
                // Filter::make("Unpublished Posts")
                //     ->query(
                //         function(Builder $query) { // Builder for type suggestions and IDE documentation hinting.
                //             $query->where("published", false);
                //         }
                //     ),
                TernaryFilter::make("published"), // Replaces the 2 previous commented out filters.
                SelectFilter::make("category_id")
                    ->label("Category")
                    ->relationship("category", "name")
                    ->multiple()
                    ->searchable()
                    ->preload(), // ->preload() shows relationship value (name) in select dropdown filter.
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

    public static function getRelations(): array
    {
        return [
            AuthorsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
