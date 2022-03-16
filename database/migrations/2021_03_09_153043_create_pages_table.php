<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_id');
            $table->efficientUuid('uuid')->index();
            $table->string('name');
            $table->string('ftp_id')->nullable()->index();
            $table->string('ftp_link')->nullable();
            $table->longText('transcript')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->timestamps();

            $table->foreign('item_id')
                ->references('id')
                ->on('items');
        });

        Schema::create('page_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('page_id');
            $table->unsignedBigInteger('subject_id');
            $table->primary(['page_id', 'subject_id']);
        });
        if (config('database.default') == 'mysql') {
            DB::statement('ALTER TABLE `pages` ADD FULLTEXT INDEX page_transcript_index (name, transcript)');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (config('database.default') == 'mysql') {
            Schema::table('pages', function ($table) {
                $table->dropIndex('page_transcript_index');
            });
        }
        Schema::dropIfExists('page_subject');
        Schema::dropIfExists('pages');
    }
};
