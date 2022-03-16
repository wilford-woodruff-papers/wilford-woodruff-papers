<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemNameToPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->text('full_name')->nullable();
            });

            \App\Models\Page::with('parent')->chunkById(100, function ($pages) {
                $pages->each(function ($page, $key) {
                    $page->full_name = $page->parent->name.': Page'.$page->order;
                    $page->save();
                });
            }, $column = 'id');
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            $this->down();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });
    }
}
