<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->change();
            $table->string('telepon')->nullable()->change();
            $table->date('tanggal_lahir')->nullable()->change();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable(false)->change();
            $table->string('telepon')->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable(false)->change();
        });
    }
};
