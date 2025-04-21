<?php

namespace App\Filament\Resources\UsersResource\Pages;

use App\Filament\Resources\UsersResource;
use App\Mail\UserAccountCreatedMail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CreateUsers extends CreateRecord
{
    protected static string $resource = UsersResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Akun pengguna berhasil dibuat';
    }

    protected function afterCreate(): void
    {
        $user = $this->record;
        $password = $this->data['password'] ?? null;

        try {
            // Kirim email ke user
            Mail::to($user->email)
                ->send(new UserAccountCreatedMail($user, $password));

            // Notifikasi ke admin
            Notification::make()
                ->title('Email notifikasi terkirim')
                ->body("Email verifikasi telah dikirim ke {$user->email}")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Log::error('Gagal mengirim email: ' . $e->getMessage());

            Notification::make()
                ->title('Gagal mengirim email')
                ->body("Email tidak terkirim ke {$user->email}. Error: " . $e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }
}
