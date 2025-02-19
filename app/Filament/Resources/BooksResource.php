<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use App\Models\Kategori;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\BooksResource\Pages;

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
                    ->directory('cover')
                    ->visibility('public')
                    ->required(),

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
                    ->height(100),
            ])
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
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBooks::route('/create'),
            'edit' => Pages\EditBooks::route('/{record}/edit'),
        ];
    }
}
