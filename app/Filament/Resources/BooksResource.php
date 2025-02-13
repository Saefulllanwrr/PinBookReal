<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Book;
use Filament\Tables;
use App\Models\Books;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BooksResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BooksResource\RelationManagers;
use App\Models\Kategori;
use Filament\Tables\Columns\ImageColumn;

class BooksResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Buku';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('judul')->label('Judul Buku'),
                TextInput::make('penerbit')->label('Penerbit'),
                TextInput::make('penulis')->label('Penulis'),
                DatePicker::make('diterbitkan')->label('Tanggal Terbit'),
                FileUpload::make('cover')
                    ->disk('public') // Pastikan menggunakan disk 'public'
                    ->directory('cover') // File disimpan di direktori 'cover'
                    ->visibility('public'),
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'nama_kategori')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('judul'),
                TextColumn::make('penulis'),
                TextColumn::make('penerbit'),
                TextColumn::make('diterbitkan')->label('Tanggal Terbit'),
                TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(),
                ImageColumn::make('cover')
                    ->disk('public') // Pastikan menggunakan disk yang sama dengan FileUpload
                    ->width(100) // Atur lebar gambar
                    ->height(100),
            ])
            ->filters([])
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
