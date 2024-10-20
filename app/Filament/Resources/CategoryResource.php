<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use App\Filament\Resources\CategoryResource\Pages;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use App\Filament\Resources\CategoryResource\Pages\EditCategory;
use App\Filament\Resources\CategoryResource\Pages\CreateCategory;
use App\Filament\Resources\CategoryResource\Pages\ListCategories;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Category Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Category Name')
                            ->maxLength(255)
                            ->placeholder('Enter category name')
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
                            ->unique(Category::class, 'slug')
                            ->maxLength(255)
                            ->label('Category Slug')
                            ->placeholder('Enter category slug (lowercase, no spaces)'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')->placeholder('Enter category description'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->default('active')
                            ->label('Status'),
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
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
