<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volumes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

        \App\Models\Scriptures\Volume::insert([
            ['name' => 'Old Testament', 'slug' => 'ot'],
            ['name' => 'New Testament', 'slug' => 'nt'],
            ['name' => 'Book of Mormon', 'slug' => 'bofm'],
            ['name' => 'Doctrine and Covenants', 'slug' => 'dc-testament'],
        ]);

        Schema::create('page_volume', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')
                ->constrained('pages')
                ->cascadeOnDelete();
            $table->foreignId('volume_id')
                ->constrained('volumes')
                ->cascadeOnDelete();
            $table->string('book')
                ->nullable();
            $table->integer('chapter')
                ->nullable();
            $table->string('verse')
                ->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_volume');
        Schema::dropIfExists('volumes');
    }
};
