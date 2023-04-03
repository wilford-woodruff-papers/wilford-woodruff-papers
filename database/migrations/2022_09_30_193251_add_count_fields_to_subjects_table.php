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
        try {
            Schema::table('subjects', function (Blueprint $table) {
                $table->integer('tagged_count')->default(0);
                $table->integer('text_count')->default(0);
                $table->integer('total_usage_count')->default(0);
                $table->index('index');
            });

            // Todo add last name letter to index column
            $subjects = \App\Models\Subject::query()
                                                ->get();

            foreach ($subjects as $subject) {
                $subject->calculateNames();
                $subject->save();
            }
        } catch (Exception $exception) {
            logger()->error($exception->getMessage());
            $this->down();
            throw $exception;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropIndex(['index']);
            $table->dropColumn('total_usage_count');
            $table->dropColumn('text_count');
            $table->dropColumn('tagged_count');
        });
    }
};
