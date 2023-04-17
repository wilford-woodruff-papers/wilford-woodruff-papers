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
        Schema::table('subjects', function (Blueprint $table) {
            $table->string('country')
                ->nullable();
            $table->string('state_province')
                ->nullable();
            $table->string('county')
                ->nullable();
            $table->string('city')
                ->nullable();
            $table->string('specific_place')
                ->nullable();
            $table->string('years')
                ->nullable();
            $table->string('modern_location')
                ->nullable();
            $table->boolean('visited')
                ->default(false);
            $table->boolean('mentioned')
                ->default(false);

            $table->string('reference', 2048)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [
            'country',
            'state_province',
            'county',
            'city',
            'specific_place',
            'years',
            'modern_location',
            'visited',
            'mentioned',
        ];

        Schema::table('subjects', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                if (Schema::hasColumn('subjects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
