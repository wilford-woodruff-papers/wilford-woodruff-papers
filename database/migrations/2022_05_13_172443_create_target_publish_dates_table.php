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
        Schema::create('target_publish_dates', function (Blueprint $table) {
            $table->id();
            $table->date('publish_at');
            $table->timestamps();
        });

        Schema::create('item_target_publish_date', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Item::class);
            $table->foreignIdFor(\App\Models\TargetPublishDate::class);
            $table->primary(['item_id', 'target_publish_date_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_target_publish_date');
        Schema::dropIfExists('target_publish_dates');
    }
};
