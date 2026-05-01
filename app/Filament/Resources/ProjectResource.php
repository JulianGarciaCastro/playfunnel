<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;



class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {

        return $form->schema([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->maxLength(30),

            Select::make('user_id')
                ->label('Usuario')
                ->relationship('user', 'name') // requiere Project::user()
                ->searchable()
                ->required(),

            TextInput::make('aspect')
                ->label('Aspecto')
                ->maxLength(10)
                ->default('d-main'),

            Select::make('project_status_id')
                ->label('Estado')
                ->options([
                    1 => 'Borrador',
                    2 => 'Publicado',
                    3 => 'Archivado',
                ])
                ->default(1)
                ->required(),

            Textarea::make('publish_div')
                ->label('Publish DIV')
                ->rows(3)
                ->columnSpanFull(),

            Textarea::make('landing_page')
                ->label('Landing Page')
                ->rows(8)
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('user.name')
                    ->label('Usuario')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('aspect')
                    ->label('Aspecto')
                    ->toggleable(),

                BadgeColumn::make('project_status_id')
                    ->label('Estado')
                    ->enum([
                        1 => 'Borrador',
                        2 => 'Publicado',
                        3 => 'Archivado',
                    ])
                    ->colors([
                        'secondary' => 1,
                        'success'   => 2,
                        'warning'   => 3,
                    ])
                    ->sortable(),

                TextColumn::make('creation_date')
                    ->label('Creación')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // opcional
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
