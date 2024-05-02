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
        Schema::create('come_follow_me_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('come_follow_me_id');
            $table->unsignedBigInteger('page_id');
            $table->mediumText('description');
            $table->unsignedInteger('order_column')
                ->nullable();
            $table->timestamps();

            $table->foreign('come_follow_me_id')
                ->references('id')
                ->on('come_follow_mes')
                ->onDelete('cascade');
            $table->foreign('page_id')
                ->references('id')
                ->on('pages')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('come_follow_me_events');
    }
};
