<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PostResource\Pages;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\RelationManagers;
use Filament\Tables\Columns\ViewColumn;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section for Basic Information
                Section::make('Basic Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(191)
                            ->label('Title')
                            ->placeholder('Enter the title of the post')
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
                            ->maxLength(191)
                            ->label('Slug')
                            ->placeholder('Enter a URL-friendly slug'),
                    ]),

                    Forms\Components\Textarea::make('content')
                        ->required()
                        ->columnSpanFull()
                        ->label('Content')
                        ->placeholder('Write the main content here...'),

                    Forms\Components\Textarea::make('excerpt')
                        ->columnSpanFull()
                        ->label('Excerpt')
                        ->placeholder('Enter a short summary of the content...'),
                ]),

                // Section for Media
                Section::make('Media')->schema([
                    Forms\Components\FileUpload::make('featured_image')
                        ->image()
                        ->label('Featured Image')
                        ->directory('featured-images') // Specify the directory to store images
                        ->maxSize(2048) // Limit size to 2MB
                        ->required(false)
                        ->helperText('Upload an image to represent the post (Max 2MB).'),
                ]),

                // Section for Additional Information
                Section::make('Additional Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name') // Assuming you have a Category model
                            ->required()
                            ->placeholder('Select a category'),

                        Forms\Components\TextInput::make('tags')
                            ->maxLength(191)
                            ->label('Tags')
                            ->placeholder('Add tags, separated by commas'),
                    ]),

                    Grid::make(2)->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'scheduled' => 'Scheduled',
                                'pending_review' => 'Pending Review',
                                'archived' => 'Archived',
                            ])
                            ->required()
                            ->placeholder('Select the post status')
                            ->reactive() // Make the status field reactive
                            ->afterStateUpdated(function (Set $set, $state) {
                                // If the status changes, update the 'published_at' field accordingly
                                if ($state !== 'scheduled') {
                                    $set('published_at', null); // Clear the field if not scheduled
                                }
                            }),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Published At')
                            ->required()
                            ->visible(fn(Get $get) => $get('status') === 'scheduled') // Show only when status is 'scheduled'
                            ->placeholder('Select a publish date and time'),
                    ]),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('post')->view('tables.columns.post-data')->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                }),
                Tables\Columns\TextColumn::make('author.full_name')
                    ->label('Author')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tags')
                    ->searchable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
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

    public static function getRelations(): array
    {
        return [
            //
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
