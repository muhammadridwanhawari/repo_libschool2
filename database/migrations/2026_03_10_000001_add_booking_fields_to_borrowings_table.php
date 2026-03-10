<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // booking_code dan deadline sudah ada di tabel, hanya update enum status
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('booking','dipinjam','dikembalikan') NOT NULL DEFAULT 'booking'");

        // Tambah unique index jika belum ada
        try {
            Schema::table('borrowings', function (Blueprint $table) {
                $table->unique('booking_code', 'borrowings_booking_code_unique');
            });
        } catch (\Exception $e) {
            // Index mungkin sudah ada, abaikan
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE borrowings MODIFY COLUMN status ENUM('dipinjam','dikembalikan') NOT NULL DEFAULT 'dipinjam'");
    }
};
