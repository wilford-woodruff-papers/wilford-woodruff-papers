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
        if (Schema::hasTable('parters')) {
            Schema::rename('parters', 'partners');
        }

        Schema::create('partner_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')
                ->nullable();
            $table->unsignedInteger('order_column')
                ->nullable();
            $table->timestamps();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->unsignedBigInteger('partner_category_id')
                ->after('id');
        });

        $foundational = \App\Models\PartnerCategory::create([
            'name' => 'Foundational Partners',
        ]);

        $outreach = \App\Models\PartnerCategory::create([
            'name' => 'Outreach Partners',
        ]);

        $technology = \App\Models\PartnerCategory::create([
            'name' => 'Technology Partners',
        ]);

        $foundationalPartners = \App\Models\Partner::query()->where('category', 'Foundational Partners')->get();
        $outreachPartners = \App\Models\Partner::query()->whereIn('category', ['Outreach Partners', 'Media Partners'])->get();
        $technologyPartners = \App\Models\Partner::query()->where('category', 'Technology Partners')->get();

        foreach ($foundationalPartners as $partner) {
            $partner->partner_category_id = $foundational->id;
            $partner->save();
        }
        foreach ($outreachPartners as $partner) {
            $partner->partner_category_id = $outreach->id;
            $partner->save();
        }
        foreach ($technologyPartners as $partner) {
            $partner->partner_category_id = $technology->id;
            $partner->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn('partner_category_id');
        });
        Schema::dropIfExists('partner_categories');
    }
};
