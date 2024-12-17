<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;
use App\Filament\Resources\SubscriptionResource\Pages\EditSubscription;
use App\Filament\Resources\SubscriptionResource\Pages\ListSubscriptions;
use App\Filament\Resources\SubscriptionResource\Pages\CreateSubscription;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->required()
                    ->relationship('user', 'first_name')
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                    ->label('User')
                    ->placeholder('Select a user'),
                Forms\Components\Select::make('subscription_plan_id')
                    ->required()
                    ->relationship('subscriptionPlan', 'name')
                    ->label('Subscription Plan')
                    ->placeholder('Select a subscription plan'),
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->maxLength(191)
                    ->placeholder('Enter the transaction ID'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->placeholder('Enter the amount'),
                DatePicker::make('start_date')
                    ->required()
                    ->label('Start Date')
                    ->rules(['required', 'date'])
                    ->reactive()
                    ->maxDate(fn(Get $get) => $get('end_date')),
                DatePicker::make('end_date')
                    ->required()
                    ->label('End Date')
                    ->rules(['required', 'date'])
                    ->reactive()
                    ->minDate(fn(Get $get) => $get('start_date')),

                Forms\Components\Toggle::make('active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.full_name')
                    ->label('User')
                    ->sortable()->searchable(query: function (Builder $query, string $search) {
                        $query->whereHas('user', function (Builder $query) use ($search) {
                            $query->whereRaw('CONCAT(first_name, " ", last_name) LIKE ?', ["%{$search}%"]);
                        });
                    }),
                Tables\Columns\TextColumn::make('subscriptionPlan.name')
                    ->label('Subscription Plan')
                    ->sortable()->searchable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()->prefix('₹ ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
