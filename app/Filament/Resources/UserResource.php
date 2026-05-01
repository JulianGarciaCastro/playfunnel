<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Services\ImpersonationAuditService;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Datos')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn ($state) => filled($state))
                        ->maxLength(255),
                ])->columns(2),

            Section::make('Verificación')
                ->schema([
                    DateTimePicker::make('email_verified_at')
                        ->label('Email verificado el'),
                ])->columns(2),

            Section::make('Acceso administrativo')
                ->schema([
                    Select::make('roles')
                        ->label('Roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->visible(fn (): bool => static::canManageAdmins())
                        ->dehydrated(fn (): bool => static::canManageAdmins()),

                    Select::make('permissions')
                        ->label('Permisos directos')
                        ->relationship(
                            'permissions',
                            'name',
                            fn (Builder $query) => $query->whereIn('name', ['users.impersonate'])
                        )
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->helperText('Usa este permiso para permitir impersonación a admins específicos.')
                        ->visible(fn (): bool => static::canManageAdmins())
                        ->dehydrated(fn (): bool => static::canManageAdmins()),
                ])
                ->visible(fn (): bool => static::canManageAdmins()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),

                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('roles_list')
                    ->label('Roles')
                    ->getStateUsing(fn (User $record): string => $record->roles->pluck('name')->implode(', ') ?: '-'),

                TextColumn::make('impersonation_permission')
                    ->label('Puede impersonar')
                    ->getStateUsing(fn (User $record): string => $record->hasPermissionSafely('users.impersonate') ? 'Si' : 'No'),

                IconColumn::make('email_verified_at')
                    ->label('Verificado')
                    ->boolean()
                    ->getStateUsing(fn (User $record) => ! is_null($record->email_verified_at)),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                Tables\Actions\Action::make('impersonate')
                    ->label('Impersonar')
                    ->icon('heroicon-o-user')
                    ->color('warning')
                    ->visible(fn (User $record): bool => static::canImpersonateUsers() && static::isValidImpersonationTarget($record))
                    ->requiresConfirmation()
                    ->form([
                        Textarea::make('reason')
                            ->label('Motivo de impersonación')
                            ->helperText('Opcional')
                            ->maxLength(500),
                    ])
                    ->action(function (User $record, array $data) {
                        /** @var User|null $actor */
                        $actor = Auth::user();
                        $request = request();
                        $reason = trim((string) ($data['reason'] ?? ''));

                        if (! $actor) {
                            Notification::make()->title('Sesión inválida')->danger()->send();
                            return;
                        }

                        if (! $actor->canImpersonate()) {
                            ImpersonationAuditService::logFailure($request, $actor, $record, 'actor_without_permission', $reason ?: null);
                            Notification::make()->title('No tienes permiso para impersonar usuarios.')->danger()->send();
                            return;
                        }

                        if (static::isImpersonatingNow()) {
                            ImpersonationAuditService::logFailure($request, $actor, $record, 'nested_impersonation_blocked', $reason ?: null);
                            Notification::make()->title('Ya existe una impersonación activa.')->danger()->send();
                            return;
                        }

                        if ((int) $actor->id === (int) $record->id) {
                            ImpersonationAuditService::logFailure($request, $actor, $record, 'self_impersonation_blocked', $reason ?: null);
                            Notification::make()->title('No puedes impersonarte a ti mismo.')->danger()->send();
                            return;
                        }

                        if (! $record->canBeImpersonated()) {
                            ImpersonationAuditService::logFailure($request, $actor, $record, 'target_cannot_be_impersonated', $reason ?: null);
                            Notification::make()->title('Este usuario no puede ser impersonado.')->danger()->send();
                            return;
                        }

                        $auditData = ImpersonationAuditService::logStart($request, $actor, $record, $reason);
                        $request->session()->put('impersonation.audit', $auditData);

                        $actor->impersonate($record);

                        Notification::make()->title('Impersonación iniciada.')->success()->send();

                        return redirect()->to('/dashboard');
                    }),

                Tables\Actions\EditAction::make()
                    ->visible(fn (): bool => static::canManageAdmins()),
            ])
            ->bulkActions([]);
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

    public static function canViewAny(): bool
    {
        return static::canManageAdmins() || static::canImpersonateUsers();
    }

    public static function canCreate(): bool
    {
        return static::canManageAdmins();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canManageAdmins();
    }

    public static function canDelete(Model $record): bool
    {
        return static::canManageAdmins();
    }

    public static function canManageAdmins(): bool
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        return $currentUser instanceof User && $currentUser->hasPermissionSafely('users.manage_admins');
    }

    protected static function canImpersonateUsers(): bool
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        return $currentUser instanceof User
            && $currentUser->canImpersonate()
            && ! static::isImpersonatingNow();
    }

    protected static function isValidImpersonationTarget(User $record): bool
    {
        /** @var User|null $currentUser */
        $currentUser = Auth::user();

        if (! $currentUser instanceof User) {
            return false;
        }

        return (int) $currentUser->id !== (int) $record->id;
    }

    protected static function isImpersonatingNow(): bool
    {
        return app()->bound('impersonate') && app('impersonate')->isImpersonating();
    }
}

