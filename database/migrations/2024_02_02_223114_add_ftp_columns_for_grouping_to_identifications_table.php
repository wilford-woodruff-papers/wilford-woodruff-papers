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
            $table->string('ftp_item_id')
                ->nullable()
                ->after('guesses');
            $table->string('ftp_page_id')
                ->nullable()
                ->after('ftp_item_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identifications', function (Blueprint $table) {
            $table->dropColumn('ftp_item_id');
            $table->dropColumn('ftp_page_id');
        });
    }
};
