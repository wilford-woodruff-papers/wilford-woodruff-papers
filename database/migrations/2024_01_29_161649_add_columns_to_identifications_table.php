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
        Schema::table('identifications', function (Blueprint $table) {
            $table->dateTime('ftp_url_checked_at')
                ->nullable();
            $table->string('ftp_status')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identifications', function (Blueprint $table) {
            $table->dropColumn('ftp_url_checked_at');
            $table->dropColumn('ftp_status');
        });
    }
};
