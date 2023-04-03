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
        try {
            Schema::table('actions', function (Blueprint $table) {
                $table->foreignIdFor(\App\Models\ActionType::class)
                    ->after('id');
                $table->dropColumn('description');
            });
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            $this->down();
            throw $exception;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('action_type_id');
            $table->text('description')->after('id');
        });
    }
};
