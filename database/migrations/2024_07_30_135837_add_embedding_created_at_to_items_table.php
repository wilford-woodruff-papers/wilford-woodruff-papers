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
        Schema::table('items', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('presses', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('board_members', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('updates', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('quotes', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
        Schema::table('website_pages', function (Blueprint $table) {
            $table->dateTime('embedding_created_at')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('presses', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('board_members', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('updates', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
        Schema::table('website_pages', function (Blueprint $table) {
            $table->dropColumn('embedding_created_at');
        });
    }
};
