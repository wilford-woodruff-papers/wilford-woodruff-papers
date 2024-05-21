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

        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['to_subject_id']);
            $table->dropForeign(['from_subject_id']);
            $table->dropColumn('to_subject_id');
            $table->dropColumn('from_subject_id');
        });
    }
};
