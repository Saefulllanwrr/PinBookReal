<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Mail\PasswordResetMail;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Mail;
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
                    ->unique(User::class, 'username', ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('no_telepon')
                    ->numeric()
                    ->label('No Telepon')
                    ->tel(), // Tambahkan validasi nomor telepon

                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->hiddenOn('edit')
                    ->suffixActions([
                        Action::make('generatePassword')
                            ->icon('heroicon-o-arrow-path')
                            ->action(function (Set $set) {
                                $password = Str::random(8);
                                $set('password', $password);

                                // Notifikasi password generated
                                Notification::make()
                                    ->title('Password Generated')
                                    ->body("Password: $password")
                                    ->success()
                                    ->send();
                            })
                            ->tooltip('Generate random password'),
                    ])
                    ->confirmed() // Jika ada confirm password field
                    ->dehydrated(fn($state) => filled($state)), // Hanya update jika diisi
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('no_telepon')
                    ->label('No Telepon')
                    ->searchable(),

                TextColumn::make('is_blocked')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Diblokir' : 'Aktif')
                    ->badge()
                    ->color(fn($state) => $state ? 'danger' : 'success')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('is_blocked')
                    ->label('Status')
                    ->options([
                        '0' => 'Aktif',
                        '1' => 'Diblokir',
                    ])
                    ->default('0'), // Default filter aktif
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('block')
                    ->label('Blokir')
                    ->icon('heroicon-o-lock-closed')
                    ->color('danger')
                    ->action(function (User $record) {
                        $record->update(['is_blocked' => true]);

                        Notification::make()
                            ->title('Akun Diblokir')
                            ->body("Akun {$record->name} telah diblokir.")
                            ->danger()
                            ->send();
                    })
                    ->hidden(fn(User $record) => $record->is_blocked)
                    ->requiresConfirmation()
                    ->modalHeading('Blokir Pengguna')
                    ->modalDescription('Apakah Anda yakin ingin memblokir pengguna ini?')
                    ->modalSubmitActionLabel('Ya, Blokir'),

                Tables\Actions\Action::make('unblock')
                    ->label('Buka Blokir')
                    ->icon('heroicon-o-lock-open')
                    ->color('success')
                    ->action(function (User $record) {
                        $record->update(['is_blocked' => false]);

                        Notification::make()
                            ->title('Akun Dibuka Blokir')
                            ->body("Akun {$record->name} telah dibuka blokir.")
                            ->success()
                            ->send();
                    })
                    ->hidden(fn(User $record) => !$record->is_blocked)
                    ->requiresConfirmation()
                    ->modalHeading('Buka Blokir Pengguna')
                    ->modalDescription('Apakah Anda yakin ingin membuka blokir pengguna ini?')
                    ->modalSubmitActionLabel('Ya, Buka Blokir'),

                Tables\Actions\Action::make('resetPassword')
                    ->label('Reset Password')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->action(function (User $record) {
                        $newPassword = Str::random(8);
                        $record->update(['password' => bcrypt($newPassword)]);

                        try {
                            Mail::to($record->email)
                                ->send(new PasswordResetMail($record, $newPassword));

                            Notification::make()
                                ->title('Password Reset Berhasil')
                                ->body("Password untuk {$record->name} telah direset. Email notifikasi terkirim.")
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal Mengirim Email Reset')
                                ->body("Password direset tapi email tidak terkirim: " . $e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Reset Password')
                    ->modalDescription('Apakah Anda yakin ingin reset password user ini? Password baru akan dikirim via email.')
                    ->modalSubmitActionLabel('Ya, Reset Password'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    // Tambahkan bulk action untuk blokir banyak user
                    Tables\Actions\BulkAction::make('block')
                        ->label('Blokir Selected')
                        ->icon('heroicon-o-lock-closed')
                        ->action(function ($records) {
                            $records->each->update(['is_blocked' => true]);
                            Notification::make()
                                ->title('Users Blocked')
                                ->body("Selected users have been blocked.")
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
