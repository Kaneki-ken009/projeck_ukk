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
        Schema::table('laporan_log', function (Blueprint $table) {
            $table->string('period_type')->default('monthly')->after('file_type');
            $table->date('period_start')->nullable()->after('period_type');
            $table->date('period_end')->nullable()->after('period_start');
            $table->string('file_path')->nullable()->after('period_end');
            $table->string('note', 300)->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_log', function (Blueprint $table) {
            $table->dropColumn(['period_type', 'period_start', 'period_end', 'file_path', 'note']);
        });
    }
};
