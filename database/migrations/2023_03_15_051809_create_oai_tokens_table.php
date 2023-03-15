<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oai_tokens');
    }
};
