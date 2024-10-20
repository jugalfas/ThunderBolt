<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use App\Filament\Resources\TagResource\Pages;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\TagResource\Pages\EditTag;
use App\Filament\Resources\TagResource\Pages\ListTags;
use App\Filament\Resources\TagResource\Pages\CreateTag;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Tag Name')
                            ->maxLength(255)
                            ->reactive() // Make the title field reactive
                            ->afterStateUpdated(function (Set $set, $state) {
                                // Generate slug from title when the title changes
                                if ($state) {
                                    $slug = Str::slug($state); // Create a slug from the title
                                    $set('slug', $slug); // Set the generated slug
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(Tag::class, 'slug')
                            ->maxLength(255)
                            ->label('Tag Slug'),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')->columnSpanFull(),
                    ])
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()->iconButton()->icon('heroicon-o-eye')->tooltip('View'),
                EditAction::make()->iconButton()->icon('heroicon-o-pencil')->tooltip('Edit'),
                DeleteAction::make()->iconButton()->icon('heroicon-o-trash')->requiresConfirmation()->label('Delete')->tooltip('Delete'),
                RestoreAction::make()->iconButton()->icon('heroicon-o-arrow-path')->tooltip('Restore'),
                ForceDeleteAction::make()->iconButton()->icon('heroicon-o-trash')->requiresConfirmation()->label('Force Delete')->tooltip('Force Delete'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
