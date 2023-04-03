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
        Schema::create('action_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('action_type_id')->nullable();
            $table->unsignedInteger('default_days_until_due')->nullable();
            $table->unsignedInteger('order_column')->nullable();
            $table->timestamps();
        });

        $transcription = \App\Models\ActionType::create([
            'name' => 'Transcription',
        ]);
        \App\Models\ActionType::create([
            'name' => 'Verification',
            'action_type_id' => $transcription->id,
        ]);
        \App\Models\ActionType::create([
            'name' => 'Stylization',
            'action_type_id' => $transcription->id,
        ]);
        \App\Models\ActionType::create([
            'name' => 'Subject Tagging',
            'action_type_id' => $transcription->id,
        ]);
        \App\Models\ActionType::create([
            'name' => 'Topic Tagging',
            'action_type_id' => $transcription->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('action_types');
    }
};
