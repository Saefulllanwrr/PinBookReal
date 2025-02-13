<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menambahkan kolom kategori_id sebagai foreign key
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('set null')->change();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            // Menghapus kolom kategori_id
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
