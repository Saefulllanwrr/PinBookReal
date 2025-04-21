<?php

namespace App\Filament\Resources;

use App\Models\Peminjaman;
use DateTime;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\PeminjamanResource\Pages;

class PeminjamanResource extends Resource
{
    // Model yang digunakan untuk resource ini
    protected static ?string $model = Peminjaman::class;

    // Ikon yang akan ditampilkan di navigasi
    protected static ?string $navigationIcon = 'heroicon-o-document';

    // Label navigasi
    protected static ?string $navigationLabel = 'Laporan Peminjaman';

    // Grup navigasi
    protected static ?string $navigationGroup = 'Manajemen Laporan';

    // Method untuk menentukan apakah resource ini bisa membuat data baru
    public static function canCreate(): bool
    {
        return false;
    }

    // Method untuk mendefinisikan form input
    public static function form(Form $form): Form
    {
        return $form->schema([
            // Dropdown untuk memilih peminjam (user)
            Select::make('user_id')
                ->label('Nama Peminjam')
                ->relationship('user', 'name') // Relasi ke model User
                ->searchable()
                ->disabled(), // Field ini tidak bisa diubah

            // Dropdown untuk memilih buku
            Select::make('buku_id')
                ->label('Buku')
                ->relationship('book', 'judul') // Relasi ke model Book
                ->searchable()
                ->disabled(), // Field ini tidak bisa diubah

            // Date picker untuk tanggal pinjam
            DatePicker::make('tanggal_pinjam')
                ->label('Tanggal Pinjam')
                ->disabled(), // Field ini tidak bisa diubah

            // Date picker untuk tanggal kembali
            DatePicker::make('tanggal_kembali')
                ->label('Tanggal Kembali')
                ->disabled(), // Field ini tidak bisa diubah

            DatePicker::make('tanggal_dikembalikan')
                ->label('Tanggal Dikembalikan')
                ->disabled(),


            // Dropdown untuk status peminjaman
            Select::make('status')
                ->options([
                    'menunggu' => 'Menunggu',
                    'ditolak' => 'Ditolak',
                    'dipinjam' => 'Dipinjam',
                    'dikembalikan' => 'Dikembalikan',
                    'terlambat' => 'Terlambat',
                ])
                ->disabled(), // Field ini tidak bisa diubah
        ]);
    }

    // Method untuk mendefinisikan tabel data
    public static function table(Table $table): Table
    {
        return $table->columns([
            // Kolom untuk menampilkan nama peminjam
            TextColumn::make('user.name')->label('Nama Peminjam')->sortable()->searchable(),

            // Kolom untuk menampilkan judul buku
            TextColumn::make('book.judul')->label('Judul Buku')->sortable()->searchable(),

            // Kolom untuk menampilkan tanggal pinjam
            TextColumn::make('tanggal_pinjam')->label('Tanggal Pinjam')->sortable(),

            // Kolom untuk menampilkan tanggal kembali
            TextColumn::make('tanggal_kembali')->label('Tanggal Kembali')->sortable(),

            // Kolom untuk menampilkan denda
            TextColumn::make('denda')
                ->label('Denda')
                ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')) // Format denda ke dalam Rupiah
                ->sortable(),

            // Kolom untuk menampilkan status peminjaman dengan warna yang berbeda
            TextColumn::make('status')
                ->label('Status')
                ->colors([
                    'info' => 'menunggu',
                    'danger' => 'ditolak',
                    'warning' => 'dipinjam',
                    'success' => 'dikembalikan',
                    'orange' => 'terlambat',
                ])
                ->searchable(),
        ])->actions([
            // Menambahkan action untuk mengembalikan buku
            self::kembalikanAction(),

            // Menambahkan action untuk menyetujui peminjaman
            self::setujuiAction(),

            // Menambahkan action untuk menolak peminjaman
            self::tolakAction(),

            // Menambahkan action untuk melihat detail peminjaman
            Tables\Actions\ViewAction::make(),
        ]);
    }

    private static function setujuiAction(): Action
    {
        return Action::make('setujui')
            ->label('Setujui')
            ->color('primary')
            ->requiresConfirmation()
            ->action(function (Peminjaman $record) {
                if ($record->status !== 'menunggu') {
                    return Notification::make()
                        ->title('Peminjaman tidak dapat disetujui!')
                        ->danger()
                        ->send();
                }

                DB::transaction(function () use ($record) {
                    $record->update(['status' => 'dipinjam']);
                    $record->book->decrement('stok');
                });

                // Generate PDF
                $pdf = Pdf::loadView('struk.index', ['peminjaman' => $record]);

                // Simpan PDF ke storage sementara
                $pdfPath = 'struk/struk_peminjaman_' . $record->id . '.pdf';
                Storage::put($pdfPath, $pdf->output());

                // Kirim notifikasi
                Notification::make()
                    ->title('Peminjaman disetujui!')
                    ->success()
                    ->send();

                // Redirect ke route untuk membuka PDF di tab baru
                return redirect()->route('struk.peminjaman', ['id' => $record->id]);
            });
    }


    // Method untuk action "Tolak"
    private static function tolakAction(): Action
    {
        return Action::make('tolak')
            ->label('Tolak')
            ->color('danger')
            ->requiresConfirmation() // Memerlukan konfirmasi sebelum dijalankan
            ->action(function (Peminjaman $record) {
                // Cek apakah status peminjaman adalah 'menunggu'
                if ($record->status !== 'menunggu') {
                    return Notification::make()
                        ->title('Peminjaman tidak dapat ditolak!')
                        ->danger()
                        ->send();
                }

                // Mulai transaksi database
                DB::transaction(function () use ($record) {
                    // Hapus record peminjaman
                    $record->delete();
                });

                // Kirim notifikasi bahwa peminjaman ditolak dan dihapus
                return Notification::make()
                    ->title('Peminjaman ditolak dan dihapus!')
                    ->danger()
                    ->send();
            });
    }

    // Method untuk action "Kembalikan"
    private static function kembalikanAction(): Action
    {
        return Action::make('kembalikan')
            ->label('Kembalikan')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (Peminjaman $record) {
                if ($record->status !== 'dipinjam') {
                    return Notification::make()
                        ->title('Peminjaman tidak dapat dikembalikan!')
                        ->body('Status peminjaman harus "dipinjam" untuk dikembalikan.')
                        ->danger()
                        ->send();
                }

                DB::transaction(function () use ($record) {
                    $tanggalDikembalikan = Carbon::now();
                    $jatuhTempo = new DateTime($record->tanggal_kembali);
                    $pengembalian = new DateTime($tanggalDikembalikan);


                    $denda = 0;
                    $status = 'dikembalikan';

                    if ($pengembalian > $jatuhTempo) {
                        $interval = $jatuhTempo->diff($pengembalian);
                        $selisihHari = $interval->days;
                        $denda = $selisihHari * 1000;
                        $status = 'terlambat';
                    }

                    // Pastikan denda tidak negatif
                    $denda = max(0, $denda);

                    $record->update([
                        'status' => $status,
                        'denda' => $denda,
                        'tanggal_dikembalikan' => $tanggalDikembalikan,
                    ]);

                    if ($record->book) {
                        $record->book->increment('stok');
                    }

                    Notification::make()
                        ->title('Buku berhasil dikembalikan!')
                        ->body('Dengan denda denda: Rp ' . number_format($denda, 0, ',', '.'))
                        ->success()
                        ->send();
                });
            });
    }





    // Method untuk mendefinisikan halaman yang terkait dengan resource ini
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjamen::route('/'),
        ];
    }

    // Method untuk mendapatkan label plural dari resource ini
    public static function getPluralLabel(): ?string
    {
        return 'Laporan Peminjaman';
    }
}
