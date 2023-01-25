<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::transaction(function () {
            $properties = $this->addProperties();

            $type = \App\Models\Type::query()
                ->firstWhere('name', 'Letters');
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Letters',
                    'type_id' => $type->id,
                ]);
            $this->addLetterTemplateProperties($template, $properties);

            /*$type = \App\Models\Type::query()
                ->firstWhere('name', 'Additional');
            $template = \App\Models\Template::query()
                ->firstOrCreate([
                    'name' => 'Additional',
                    'type_id' => $type->id,
                ]);
            $this->addAdditionalTemplateProperties($template, $properties);*/
        });
    }

    private function addProperties()
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

    private function addLetterTemplateProperties($template, $properties)
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
     *
     * @return void
     */
    public function down()
    {
    }
};
