<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable()->after('title');
            $table->string('cover')->nullable()->after('publisher');
            $table->string('location')->nullable()->after('cover');
        });

        Schema::table('borrowings', function (Blueprint $table) {
            $table->date('deadline')->nullable()->after('borrow_date');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['isbn', 'cover', 'location']);
        });
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropColumn('deadline');
        });
    }
};
