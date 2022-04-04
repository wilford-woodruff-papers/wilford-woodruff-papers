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
        Schema::create('actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('description');
            $table->nullableNumericMorphs('actionable', 'actionable');
            $table->foreignIdFor(\App\Models\User::class, 'assigned_to')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'completed_by')->nullable();
            $table->json('properties')->nullable();
            $table->dateTime('assigned_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
};
