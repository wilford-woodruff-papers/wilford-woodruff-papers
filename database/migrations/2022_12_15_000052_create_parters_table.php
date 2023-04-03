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
        Schema::create('parters', function (Blueprint $table) {
            $table->id();
            $table->string('category')->nullable();
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->string('url')->nullable();
            $table->unsignedBigInteger('order_column');
            $table->timestamps();
        });

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Foundational Partners',
            'name' => 'The Church of Jesus Christ of Latter-day Saints',
        ], [
            'url' => 'https://www.churchofjesuschrist.org/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Foundational Partners',
            'name' => 'Brigham Young University',
        ], [
            'url' => 'https://www.byu.edu/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Foundational Partners',
            'name' => 'Church History Library',
        ], [
            'url' => 'https://history.churchofjesuschrist.org/landing/church-history-library',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Foundational Partners',
            'name' => 'The Church Historian’s Press',
        ], [
            'url' => 'https://www.churchhistorianspress.org/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Outreach Partners',
            'name' => 'FamilySearch',
        ], [
            'url' => 'https://www.familysearch.org/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Outreach Partners',
            'name' => 'Meridian Magazine',
        ], [
            'url' => 'https://latterdaysaintmag.com/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Outreach Partners',
            'name' => 'FAIR',
        ], [
            'url' => 'https://www.fairlatterdaysaints.org/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Outreach Partners',
            'name' => 'Book of Mormon Central',
        ], [
            'url' => 'https://bookofmormoncentral.org/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Media Partners',
            'name' => 'Church News',
        ], [
            'url' => 'https://www.thechurchnews.com/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Media Partners',
            'name' => 'Deseret News',
        ], [
            'url' => 'https://www.deseret.com/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Media Partners',
            'name' => 'Desert Book',
        ], [
            'url' => 'https://deseretbook.com/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Technology Partners',
            'name' => 'FromThePage',
        ], [
            'url' => 'https://fromthepage.com/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Technology Partners',
            'name' => 'BYU Record Linking Lab',
        ], [
            'url' => 'https://rll.byu.edu/',
        ]);

        \App\Models\Partner::query()->firstOrCreate([
            'category' => 'Technology Partners',
            'name' => 'BYU-Idaho Data Science',
        ], [
            'url' => 'https://www.byui.edu/mathematics/student-resources/data-science',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('parters');
    }
};
