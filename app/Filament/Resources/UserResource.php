<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use App\Mail\SetPassword;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Password;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Personal Information')->schema([
                    Grid::make(2)->schema([
                        FileUpload::make('profile_image')
                            ->label('Profile Photo')
                            ->image()  // Restrict to image files
                            ->directory('profile-photos')  // Directory to store images
                            ->maxSize(2048)  // Limit size to 2MB
                            ->required(false)
                            ->helperText('Upload a profile picture (Max 2MB).'),
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(191)
                            ->label('First Name')
                            ->placeholder('Enter your first name'),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(191)
                            ->label('Last Name')
                            ->placeholder('Enter your last name'),
                        TextInput::make('public_name')
                            ->required()
                            ->maxLength(191)
                            ->label('Public Name')
                            ->placeholder('Enter your public name'),
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->label('Date of Birth'),
                        Select::make('gender')
                            ->required()
                            ->options([
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Other',
                            ])
                            ->label('Gender'),
                    ]),
                ]),
                Section::make('Contact Information')->schema([
                    Grid::make(2)->schema([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(191)
                            ->label('Email Address')
                            ->placeholder('Enter your email address'),
                        TextInput::make('phone_number')
                            ->nullable()
                            ->label('Phone Number')
                            ->required()
                            ->placeholder('Enter your phone number'),
                    ]),

                    Grid::make(1)->schema([
                        Textarea::make('address')
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
                ViewColumn::make('user')->view('tables.columns.user-data')->searchable(query: function (Builder $query, string $search): Builder {
                    return $query
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                }),
                TextColumn::make('public_name')
                    ->searchable(),
                TextColumn::make('password')
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
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable(),
                TextColumn::make('gender')
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Action::make('resend-password')->requiresConfirmation()->label('Resend Password')->action(function (User $record) {
                    $token = Password::broker()->createToken($record);

                    // Need to change for UserPanel
                    $url = Filament::getResetPasswordUrl($token, $record);
                    Mail::to($record->email)->send(new SetPassword($url));

                    Notification::make()
                        ->title(__('Mail Sent!'))
                        ->body(__('Mail has been sent to :email', ['email' => $record->email]))
                        ->success()
                        ->send();
                })->iconButton()->icon('heroicon-o-paper-airplane')->tooltip('Resend Password'),
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
            ])->modifyQueryUsing(function (Builder $query): Builder {
                // Exclude the user with ID 1
                $query->whereNot('id', 1);

                return $query;
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
