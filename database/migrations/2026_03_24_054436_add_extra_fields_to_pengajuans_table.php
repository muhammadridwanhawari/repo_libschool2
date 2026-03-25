<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('penulis');
            $table->string('penerbit')->nullable()->after('isbn');
            $table->string('tahun_terbit')->nullable()->after('penerbit');
            $table->text('alasan')->nullable()->after('tahun_terbit');
            // Make category_id nullable since it's optional in the form
            $table->unsignedBigInteger('category_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengajuans', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'penerbit', 'tahun_terbit', 'alasan']);
            $table->unsignedBigInteger('category_id')->nullable(false)->change();
        });
    }
};
