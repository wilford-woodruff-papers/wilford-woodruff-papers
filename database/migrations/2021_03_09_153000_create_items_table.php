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
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->string('name');
            $table->string('ftp_id')->nullable()->index();
            $table->efficientUuid('uuid')->index();
            $table->boolean('enabled')->default(0);
            $table->date('added_to_collection_at')->nullable();
            $table->timestamps();

            $table->foreign('type_id')
                ->references('id')
                ->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
