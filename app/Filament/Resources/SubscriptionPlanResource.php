<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SubscriptionPlan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionPlanResource\Pages;
use App\Filament\Resources\SubscriptionPlanResource\RelationManagers;
use App\Filament\Resources\SubscriptionPlanResource\Pages\EditSubscriptionPlan;
use App\Filament\Resources\SubscriptionPlanResource\Pages\ListSubscriptionPlans;
use App\Filament\Resources\SubscriptionPlanResource\Pages\CreateSubscriptionPlan;
use Filament\Forms\Components\RichEditor;

class SubscriptionPlanResource extends Resource
{
    protected static ?string $model = SubscriptionPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Plan Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->label('Name')
                            ->placeholder('Enter the plan name')
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->required()
                            ->label('Description')
                            ->placeholder('Enter a brief description')
                            ->disableToolbarButtons(['attachFiles'])
                            ->columnSpanFull(),

                        TextInput::make('price')
                            ->required()
                            ->label('Price')
                            ->placeholder('Enter the price'),

                        TextInput::make('post_limit')
                            ->nullable()
                            ->label('Post Limit')
                            ->placeholder('Enter the post limit'),

                        TextInput::make('stripe_plan_id')
                            ->nullable()
                            ->label('Stripe Plan ID')
                            ->placeholder('Enter the Stripe Plan ID'),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive'
                            ])
                            ->default('active')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('price')->prefix('₹ ')->default('-'),
                Tables\Columns\TextColumn::make('post_limit')->default('-')->formatStateUsing(function ($record) {
                    if ($record->post_limit == -1) {
                        return 'Unlimited';
                    } else {
                        return $record->post_limit;
                    }
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
            'index' => Pages\ListSubscriptionPlans::route('/'),
            'create' => Pages\CreateSubscriptionPlan::route('/create'),
            'edit' => Pages\EditSubscriptionPlan::route('/{record}/edit'),
        ];
    }
}
