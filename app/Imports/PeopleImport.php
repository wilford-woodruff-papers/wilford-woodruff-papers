<?php

namespace App\Imports;

use App\Jobs\ImportPerson;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PeopleImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(24000);

        $people = Category::query()
            ->where('name', 'People')
            ->first();

        $peopleCategories = Category::query()
            ->where('category_id', $people->id)
            ->get();

        $categories = $peopleCategories->push($people);

        foreach ($rows as $row) {

            $commonValues = array_intersect(
                $categories
                    ->pluck('name')
                    ->toArray(),
                collect(explode(';', $row['categories']))
                    ->map(function ($category) {
                        return trim($category);
                    })
                    ->toArray()
            );

            if (empty($commonValues)) {
                logger()->info($row['title'].' is not a person.');

                continue;
            }

            logger()->info($row['title'].' is a person.');

            ImportPerson::class::dispatch(
                $row,
                $categories
            )
                ->onQueue('import');
        }
    }
}
