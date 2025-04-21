<?php

namespace App\Filament\Resources;


use App\Models\Book;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\BooksResource\Pages;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BooksResource extends Resource
{
    protected static ?string $model = Book::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku';
    protected static ?string $navigationGroup = 'Manajemen Buku';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('isbn')
                    ->label('ISBN')
                    ->numeric()
                    ->length(13)
                    ->required(),

                TextInput::make('judul')
                    ->label('Judul Buku')
                    ->required(),

                TextInput::make('penerbit')
                    ->label('Penerbit')
                    ->required(),

                TextInput::make('penulis')
                    ->label('Penulis')
                    ->required(),

                Textarea::make('deskripsi')
                    ->label('Deskripsi')
                    ->required(),

                DatePicker::make('diterbitkan')
                    ->label('Tanggal Terbit')
                    ->required(),

                FileUpload::make('cover')
                    ->disk('public')
                    ->directory('covers')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']),
                

                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('stok')
                    ->label('Stok Buku')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('status', $state > 0 ? 'available' : 'borrowed');
                    }),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Tersedia',
                        'borrowed' => 'Dipinjam',
                    ])
                    ->disabled()
                    ->default('available'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('isbn')->label('ISBN')->sortable()->searchable(),
                TextColumn::make('judul')->label('Judul Buku')->sortable()->searchable(),
                TextColumn::make('penulis')->label('Penulis')->sortable()->searchable(),
                TextColumn::make('penerbit')->label('Penerbit')->sortable()->searchable(),
                TextColumn::make('diterbitkan')->label('Tanggal Terbit')->date(),
                TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable()->searchable(),
                TextColumn::make('stok')->label('Stok')->sortable(),
                TextColumn::make('status')->label('Status')->sortable(),

                ImageColumn::make('cover')
                    ->disk('public')
                    ->width(100)
                    ->height(100)
                    
            ])
            ->emptyStateHeading('Tidak ada data buku')
            ->emptyStateDescription('Mulai dengan menambahkan data buku baru')
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                // Tables\Actions\Action::make('pdf')
                //     ->label('PDF')
                //     ->color('success')
                //     ->url(fn(Book $record) => route('pdf', $record))
                //     ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('table')->fromTable(),
                        ExcelExport::make('form')->fromForm(),
                    ])
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBooks::route('/create'),
            'edit' => Pages\EditBooks::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): ?string
    {
        return 'Manajemen Buku';
    }

    public function getTableBulkActions()
    {
        return  [
            ExportBulkAction::make()
        ];
    }
}
