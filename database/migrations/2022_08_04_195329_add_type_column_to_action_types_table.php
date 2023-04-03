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
        Schema::table('action_types', function (Blueprint $table) {
            $table->string('type')->nullable();
        });

        $actionTypes = \App\Models\ActionType::all();
        $actionTypes->each(function ($actionType) {
            $actionType->type = 'Documents';
            $actionType->save();
        });

        \App\Models\ActionType::create([
            'name' => 'Approval',
            'type' => 'Quotes',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('action_types', function (Blueprint $table) {
            //
        });
    }
};
