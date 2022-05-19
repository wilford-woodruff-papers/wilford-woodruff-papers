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
        Schema::create('action_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('default_days_until_due')->nullable();
            $table->timestamps();
        });

        \App\Models\ActionType::create([
            'name' => 'Transcription',
        ]);
        \App\Models\ActionType::create([
            'name' => 'Stylization',
        ]);
        \App\Models\ActionType::create([
            'name' => 'Topic Tagging',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_types');
    }
};
