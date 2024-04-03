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
        Schema::create('figures', function (Blueprint $table) {
            $table->id();
            $table->string('filename')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('design_description')->nullable();
            $table->string('period_usage')->nullable();
            $table->string('quantitative_utilization')->nullable();
            $table->string('qualitative_utilization')->nullable();
            $table->timestamps();
        });

        \App\Models\Figure::create([
            'tracking_number' => '1',
            'design_description' => 'A Hand Pointing to the Right',
            'period_usage' => 'February 1838 – March 1897 (3,800+ Uses)',
            'quantitative_utilization' => 'Letters Written',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '2',
            'design_description' => 'A Hand Pointing to the Left',
            'period_usage' => 'February 1838 – November 1856 (21 Uses)',
            'quantitative_utilization' => 'Letters Written/Received',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '3',
            'design_description' => 'A Heart',
            'period_usage' => 'August 1838 – March 1897 (37 Uses)',
            'quantitative_utilization' => 'Births, Marriages, Deaths',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '4',
            'design_description' => 'A Crown',
            'period_usage' => 'April 1839 – November 1896 (400 uses)',
            'quantitative_utilization' => 'Activities Requiring Executive Authority',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '5',
            'design_description' => 'An Arrow Piercing a Hear',
            'period_usage' => 'April 1839 – March 1882 (32 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Troubling News, Circumstances, or Persecution',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '6',
            'design_description' => 'A Single Key with Teeth to the Left',
            'period_usage' => 'June 1839 – April 1877 (130 Uses)',
            'quantitative_utilization' => '1851–1877 Recording of Sermons or Meeting Minutes',
            'qualitative_utilization' => '1839–1850 Personal Moments of Priesthood Use',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '7',
            'design_description' => 'A Single Key with Teeth to the Right',
            'period_usage' => 'June 1839 – April 1895 (314 Uses)',
            'quantitative_utilization' => 'Performing Priesthood Ordinances; Meetings of the Quorum of the Twelve',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '8',
            'design_description' => 'A Vertical Key with Teeth Pointing Upward',
            'period_usage' => 'July 1839 – April 1845 (9 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Key of Knowledge',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '9',
            'design_description' => 'An Arrow',
            'period_usage' => 'July 1839 – November 1896 (440 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Sickness, Distress, Aggression, Death',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '10',
            'design_description' => 'A Folded Letter/Box',
            'period_usage' => 'October 1839 – March 1897 (1,963 Uses)',
            'quantitative_utilization' => 'Letters Received',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '11',
            'design_description' => 'A Humanoid',
            'period_usage' => 'February 1840 – November 1892 (49 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Childbirth, Important Figures, Portraits, Human Bodies',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '12',
            'design_description' => 'A Coffin',
            'period_usage' => 'June 1840 – January 1897 (200 Uses)',
            'quantitative_utilization' => 'Deaths, Funeral Sermons, Family Deaths',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '13',
            'design_description' => 'A Building',
            'period_usage' => 'July 1841 – June 1885 (25 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Visiting Architectural Structures',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '14',
            'design_description' => 'Wheat Sheaves',
            'period_usage' => 'March 1842 – February 1847; May 1857–June 1858 (39 Uses)',
            'quantitative_utilization' => 'Council Meetings of the Twelve',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '15',
            'design_description' => 'A Heart with a Key Inside',
            'period_usage' => 'January 1844 – March 1894 (24 Uses)',
            'quantitative_utilization' => 'Sealing Ordinances',
            'qualitative_utilization' => 'Eternal Unions of Family',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '16',
            'design_description' => 'Keys Crossed',
            'period_usage' => 'March 1844 – December 1896 (877 Uses)',
            'quantitative_utilization' => '',
            'qualitative_utilization' => 'Priesthood Ordinances',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '17',
            'design_description' => 'A Council Table',
            'period_usage' => 'March – May 1844 (14 Uses)',
            'quantitative_utilization' => 'Council Meetings',
            'qualitative_utilization' => '',
        ]);

        \App\Models\Figure::create([
            'tracking_number' => '18',
            'design_description' => 'A Circle of Stars',
            'period_usage' => 'August 1844 (5 Uses)',
            'quantitative_utilization' => 'Meetings of the Twelve',
            'qualitative_utilization' => '',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('figures');
    }
};
