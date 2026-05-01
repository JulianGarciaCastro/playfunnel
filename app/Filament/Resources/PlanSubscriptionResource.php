<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanSubscriptionResource\Pages;
use App\Models\PlanSubscription;


use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;

use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

class PlanSubscriptionResource extends Resource
{
    protected static ?string $model = PlanSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Suscripciones';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('userid')
                ->label('Usuario')
                ->relationship('user', 'email')
                ->searchable()
                ->required(),

            Select::make('plantypeid')
                ->label('Plan')
                ->relationship('plan', 'name') // si tu PlanType no tiene "name", dime el campo
                ->searchable()
                ->required(),

            Toggle::make('active')
                ->label('Activa')
                ->default(true),

            TextInput::make('invoicenum')
                ->label('Stripe Subscription ID')
                ->maxLength(255),

            DateTimePicker::make('startdate')->label('Inicio'),
            DateTimePicker::make('enddate')->label('Fin'),
            DateTimePicker::make('canceldate')->label('Cancelada el'),
            DateTimePicker::make('enterdate')->label('Creada el'),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('user.email')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('plan.name')
                    ->label('Plan')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('active')
                    ->label('Activa')
                    ->boolean(),

                BadgeColumn::make('canceldate')
                    ->label('Cancelada')
                    ->getStateUsing(fn ($record) => $record->canceldate ? 'Sí' : 'No')
                    ->colors([
                        'danger' => 'Sí',
                        'success' => 'No',
                    ]),

                TextColumn::make('startdate')->label('Inicio')->dateTime('d/m/Y')->sortable(),
                TextColumn::make('enddate')->label('Fin')->dateTime('d/m/Y')->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlanSubscriptions::route('/'),
            'create' => Pages\CreatePlanSubscription::route('/create'),
            'edit' => Pages\EditPlanSubscription::route('/{record}/edit'),
        ];
    }
}
