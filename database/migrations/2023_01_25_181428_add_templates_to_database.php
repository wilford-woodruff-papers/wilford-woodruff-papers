<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::transaction(function () {
            // Letters
            $properties = $this->addLetterProperties();

            $type = \App\Models\Type::query()
                ->firstWhere('name', 'Letters');
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Letters',
                    'type_id' => $type->id,
                ]);
            $this->addTemplateProperties($template, $properties);

            // Discourses
            $properties = $this->addDiscourseProperties();

            $type = \App\Models\Type::query()
                ->firstWhere('name', 'Discourses');
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Discourses',
                    'type_id' => $type->id,
                ]);
            $this->addTemplateProperties($template, $properties);

            // Additional
            $properties = $this->addAdditionalProperties();

            $type = \App\Models\Type::query()
                ->firstWhere('name', 'Additional');
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Additional',
                    'type_id' => $type->id,
                ]);
            $this->addTemplateProperties($template, $properties);

            // Daybooks
            $properties = $this->addDaybookProperties();

            $type = \App\Models\Type::query()
                ->firstOrCreate(['name' => 'Daybooks']);
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Daybooks',
                    'type_id' => $type->id,
                ]);
            $this->addTemplateProperties($template, $properties);
        });
    }

    private function addAdditionalProperties()
    {
        $properties = [
            [
                'type' => 'html',
                'name' => 'Notes',
            ],
            [
                'type' => 'text',
                'name' => 'Source',
            ],
            [
                'type' => 'link',
                'name' => 'Source Link',
            ],
            [
                'type' => 'text',
                'name' => 'Access Needed From CHL (Y/N)',
            ],
            [
                'type' => 'text',
                'name' => 'File Format',
            ],
            [
                'type' => 'text',
                'name' => 'Doc Date',
            ],
            [
                'type' => 'text',
                'name' => 'WW Journals',
            ],
            [
                'type' => 'link',
                'name' => 'WW Journals Link',
            ],
            [
                'type' => 'html',
                'name' => 'Description',
            ],
            [
                'type' => 'text',
                'name' => 'Occasion',
            ],
            [
                'type' => 'text',
                'name' => 'Location',
            ],
            [
                'type' => 'text',
                'name' => 'City',
            ],
            [
                'type' => 'text',
                'name' => 'County',
            ],
            [
                'type' => 'text',
                'name' => 'State',
            ],
        ];

        $propertyModels = [];
        foreach ($properties as $property) {
            $propertyModels[] = \App\Models\Property::query()
                ->firstOrCreate($property);
        }

        return $propertyModels;
    }

    private function addDaybookProperties()
    {
        $properties = [
            [
                'type' => 'html',
                'name' => 'Notes',
            ],
            [
                'type' => 'text',
                'name' => 'Source',
            ],
            [
                'type' => 'link',
                'name' => 'Source Link',
            ],
            [
                'type' => 'text',
                'name' => 'Access Needed From CHL (Y/N)',
            ],
            [
                'type' => 'text',
                'name' => 'File Format',
            ],
            [
                'type' => 'text',
                'name' => 'Doc Date',
            ],
            [
                'type' => 'text',
                'name' => 'WW Journals',
            ],
            [
                'type' => 'link',
                'name' => 'WW Journals Link',
            ],
            [
                'type' => 'html',
                'name' => 'Description',
            ],
            [
                'type' => 'text',
                'name' => 'Occasion',
            ],
            [
                'type' => 'text',
                'name' => 'Location',
            ],
            [
                'type' => 'text',
                'name' => 'City',
            ],
            [
                'type' => 'text',
                'name' => 'County',
            ],
            [
                'type' => 'text',
                'name' => 'State',
            ],
        ];

        $propertyModels = [];
        foreach ($properties as $property) {
            $propertyModels[] = \App\Models\Property::query()
                ->firstOrCreate($property);
        }

        return $propertyModels;
    }

    private function addDiscourseProperties()
    {
        $properties = [
            [
                'type' => 'html',
                'name' => 'Notes',
            ],
            [
                'type' => 'text',
                'name' => 'Year',
            ],
            [
                'type' => 'text',
                'name' => 'Discourse Date',
            ],
            [
                'type' => 'text',
                'name' => 'WWJ Date',
            ],
            [
                'type' => 'html',
                'name' => 'Journal Entry Description',
            ],
            [
                'type' => 'text',
                'name' => 'Day of the Week',
            ],
            [
                'type' => 'text',
                'name' => 'Speaker\'s Title',
            ],
            [
                'type' => 'html',
                'name' => 'Discourse Description',
            ],
            [
                'type' => 'text',
                'name' => 'City',
            ],
            [
                'type' => 'text',
                'name' => 'County',
            ],
            [
                'type' => 'text',
                'name' => 'State',
            ],
            [
                'type' => 'text',
                'name' => 'Location',
            ],
            [
                'type' => 'text',
                'name' => 'Occasion',
            ],
            [
                'type' => 'link',
                'name' => 'Google Text Doc',
            ],
            [
                'type' => 'link',
                'name' => 'PDF/Image',
            ],
            [
                'type' => 'text',
                'name' => 'Entity',
            ],
            [
                'type' => 'text',
                'name' => 'Source',
            ],
            [
                'type' => 'link',
                'name' => 'Source Link',
            ],
            [
                'type' => 'text',
                'name' => 'Deseret News',
            ],
            [
                'type' => 'link',
                'name' => 'Deseret News Link',
            ],
            [
                'type' => 'text',
                'name' => 'Millennial Star',
            ],
            [
                'type' => 'link',
                'name' => 'Millennial Star Link',
            ],
            [
                'type' => 'text',
                'name' => 'Access Needed From CHL (Y/N)',
            ],
            [
                'type' => 'html',
                'name' => 'Bibliographic Reference',
            ],
        ];

        $propertyModels = [];
        foreach ($properties as $property) {
            $propertyModels[] = \App\Models\Property::query()
                ->firstOrCreate($property);
        }

        return $propertyModels;
    }

    private function addLetterProperties()
    {
        $properties = [
            [
                'type' => 'link',
                'name' => 'PDF/Image',
            ],
            [
                'type' => 'link',
                'name' => 'Transcript',
            ],
            [
                'type' => 'text',
                'name' => 'Format',
            ],
            [
                'type' => 'text',
                'name' => 'Held',
            ],
            [
                'type' => 'text',
                'name' => 'Collection #',
            ],
            [
                'type' => 'date',
                'name' => 'WWJ Date',
            ],
            [
                'type' => 'html',
                'name' => 'Summary',
            ],
            [
                'type' => 'date',
                'name' => 'Doc Date',
            ],
            [
                'type' => 'text',
                'name' => 'WWJ',
            ],
            [
                'type' => 'html',
                'name' => 'WWJ Description',
            ],
            [
                'type' => 'text',
                'name' => 'Author Last Name',
            ],
            [
                'type' => 'text',
                'name' => 'Author First Name',
            ],
            [
                'type' => 'text',
                'name' => 'Author City',
            ],
            [
                'type' => 'text',
                'name' => 'Author State',
            ],
            [
                'type' => 'text',
                'name' => 'Recipient Last Name',
            ],
            [
                'type' => 'text',
                'name' => 'Recipient First Name',
            ],
            [
                'type' => 'text',
                'name' => 'Recipient City',
            ],
            [
                'type' => 'text',
                'name' => 'Recipient State',
            ],
            [
                'type' => 'html',
                'name' => 'Description from Collection',
            ],
            [
                'type' => 'text',
                'name' => 'Document Type',
            ],
        ];

        $propertyModels = [];
        foreach ($properties as $property) {
            $propertyModels[] = \App\Models\Property::query()
                ->firstOrCreate($property);
        }

        return $propertyModels;
    }

    private function addTemplateProperties($template, $properties)
    {
        foreach ($properties as $property) {
            \App\Models\PropertyTemplate::query()
                ->create([
                    'template_id' => $template->id,
                    'property_id' => $property->id,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
