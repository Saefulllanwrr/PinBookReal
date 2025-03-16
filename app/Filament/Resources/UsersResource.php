<?php

namespace App\Filament\Resources;


use App\Models\User;
use Filament\Tables;
use App\Models\Admin;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;

use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\UsersResource\Pages;


class UsersResource extends Resource

{

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Daftar Pengguna';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique(User::class, 'username', ignoreRecord: true) // Tambahkan ignoreRecord untuk mengabaikan record saat edit
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true) // Tambahkan ignoreRecord untuk mengabaikan record saat edit
                    ->maxLength(255),

                TextInput::make('no_telepon')
                    ->numeric()
                    ->label('No Telepon'),

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->hiddenOn('edit') // Sembunyikan field password saat mode edit
                    ->suffixActions([
                        Action::make('generatePassword')
                            ->icon('heroicon-o-arrow-path') // Ikon refresh
                            ->action(function (Set $set) {
                                $password = Str::random(8); // Generate password random
                                $set('password', $password);

                                // Menampilkan password dalam notifikasi
                                Notification::make()
                                    ->title('Password Generated')
                                    ->body("Password: $password")
                                    ->success()
                                    ->send();
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('username')->label('Username')
                    ->searchable(),
                TextColumn::make('email')->label('Email')
                    ->searchable(),
                TextColumn::make('no_telepon')->label('No Telepon')
                    ->searchable(),
                TextColumn::make('is_blocked')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Diblokir' : 'Aktif')
                    ->badge()
                    ->colors([
                        'danger' => fn($state) => $state,
                        'success' => fn($state) => !$state,
                    ]),
            ])
            ->filters([
                // Filter berdasarkan status (Aktif atau Diblokir)
                SelectFilter::make('is_blocked')
                    ->label('Status')
                    ->options([
                        '0' => 'Aktif', // Nilai 0 untuk pengguna aktif
                        '1' => 'Diblokir', // Nilai 1 untuk pengguna diblokir
                    ])
                // Secara default, tampilkan pengguna aktif

            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                // Aksi Blokir
                Tables\Actions\Action::make('block')
                    ->label('Blokir')
                    ->icon('heroicon-o-lock-closed')
                    ->action(function (User $record) {
                        $record->update(['is_blocked' => true]);

                        // Kirim notifikasi ke semua admin
                        Notification::make()
                            ->title('Akun Diblokir')
                            ->body("Akun {$record->name} telah diblokir.")
                            ->danger()
                            ->send();
                    })
                    ->hidden(fn(User $record) => $record->is_blocked)
                    ->requiresConfirmation(),

                // Aksi Unblokir
                Tables\Actions\Action::make('unblock')
                    ->label('Buka Blokir')
                    ->icon('heroicon-o-lock-open')
                    ->action(function (User $record) {
                        $record->update(['is_blocked' => false]);

                        Notification::make()
                            ->title('Akun Dibuka Blokir')
                            ->body("Akun {$record->name} telah dibuka blokir.")
                            ->success()
                            ->send();
                    })
                    ->hidden(fn(User $record) => !$record->is_blocked)
                    ->requiresConfirmation(),

                // Aksi Reset Password
                Tables\Actions\Action::make('resetPassword')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->action(function (User $record) {
                        $password = Str::random(8); // Generate password random
                        $record->update(['password' => bcrypt($password)]);

                        Notification::make()
                            ->title('Password Reset')
                            ->body("Password baru untuk {$record->name} adalah: $password")
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUsers::route('/create'),
            'edit' => Pages\EditUsers::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return 'Daftar Pengguna';
    }
}
