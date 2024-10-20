<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\FileUpload::make('profile_image')
                            ->label('Profile Photo')
                            ->image()  // Restrict to image files
                            ->directory('profile-photos')  // Directory to store images
                            ->maxSize(2048)  // Limit size to 2MB
                            ->required(false)
                            ->helperText('Upload a profile picture (Max 2MB).'),
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(191)
                            ->label('First Name')
                            ->placeholder('Enter your first name'),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(191)
                            ->label('Last Name')
                            ->placeholder('Enter your last name'),
                        Forms\Components\TextInput::make('public_name')
                            ->required()
                            ->maxLength(191)
                            ->label('Public Name')
                            ->placeholder('Enter your public name'),
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->required()
                            ->label('Date of Birth'),
                        Forms\Components\Select::make('gender')
                            ->required()
                            ->options([
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Other',
                            ])
                            ->label('Gender'),
                    ]),
                ]),
                Forms\Components\Section::make('Contact Information')->schema([
                    Grid::make(2)->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(191)
                            ->label('Email Address')
                            ->placeholder('Enter your email address'),
                        Forms\Components\TextInput::make('phone_number')
                            ->nullable()
                            ->label('Phone Number')
                            ->required()
                            ->placeholder('Enter your phone number'),
                    ]),

                    Grid::make(1)->schema([
                        Forms\Components\Textarea::make('address')
                            ->required()
                            ->columnSpanFull()
                            ->label('Address')
                            ->placeholder('Enter your address'),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('user')->view('tables.columns.user-data'),
                Tables\Columns\TextColumn::make('public_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('password')
                    ->label('Is Password Set')
                    ->default('No')
                    ->formatStateUsing(function ($record) {
                        // Check if the 'password' field exists and is not null
                        return isset($record->password) && $record->password != '' ? 'Yes' : 'No';
                    })
                    ->badge()
                    ->colors([
                        'success' => 'Yes',  // Green badge for "Yes"
                        'danger' => 'No',    // Red badge for "No"
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            1 => 'Male',
                            2 => 'Female',
                            3 => 'Other',
                        };
                    }),
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
            ])->modifyQueryUsing(function (Builder $query): Builder {
                return $query->whereNot('id', 1);
            });
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
