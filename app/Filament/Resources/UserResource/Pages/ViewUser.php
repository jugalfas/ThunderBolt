<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Html;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.view-user';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Profile')->schema([
                    Tab::make('User Information')->schema([
                        Grid::make(3)->schema([
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
                        ]),
                        Grid::make(2)->schema([
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
                ])->columnSpanFull()
            ]);
    }
}
