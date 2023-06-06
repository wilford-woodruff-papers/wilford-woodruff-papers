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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('accepted_api_terms')
                ->after('accepted_terms')
                ->default(false);
            $table->boolean('provided_api_fields')
                ->after('accepted_api_terms')
                ->default(false);
            $table->string('organization_name')
                ->nullable();
            $table->text('proposed_use')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('proposed_use');
            $table->dropColumn('organization_name');
            $table->dropColumn('provided_api_fields');
            $table->dropColumn('accepted_api_terms');
        });
    }
};
