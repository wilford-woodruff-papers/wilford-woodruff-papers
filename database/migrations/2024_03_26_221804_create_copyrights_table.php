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
        Schema::create('copyrights', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->unsignedBigInteger('copyright_id')
                ->nullable();
        });
        \Illuminate\Support\Facades\DB::table('copyrights')
            ->insert([
                ['description' => 'No known copyright. {Although there are no known restrictions on this item, you are responsible for determining whether the item may be used, copied, published, or distributed.}'],
                ['description' => 'Copyright not evaluated. (You may request that we evaluate the rights by clicking the "Ask Us" button.).'],
                ['description' => 'In copyright - Licensed to Intellectual Reserve, Inc. (You may request permission to use the item by contacting the Intellectual Property Office who will review your request. When making your request please include the citation and link for each item.)'],
                ['description' => 'Public Domain'],
                ['description' => 'In copyright - Owned by Intellectual Reserve, Inc. (You may request permission to use the item by contacting the Intellectual Property Office who will review your request. When making your request please include the citation and link for each item.)'],
                ['description' => 'In copyright -Other Rights Holder (You are responsible for requesting permission from the rights holder before use. If you need a copy click the "Ask Us" button.)'],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('copyright_id');
        });
        Schema::dropIfExists('copyrights');
    }
};
