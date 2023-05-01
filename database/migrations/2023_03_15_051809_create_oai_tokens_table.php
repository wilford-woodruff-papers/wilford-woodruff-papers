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
        Schema::create('oai_tokens', function (Blueprint $table) {
            $table->id();
            $table->ulid('token')
                ->unique();
            $table->string('verb');
            $table->string('metadataPrefix');
            $table->string('cursor');
            $table->string('set')->nullable();
            $table->date('from')->nullable();
            $table->date('until')->nullable();
            $table->dateTime('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oai_tokens');
    }
};
