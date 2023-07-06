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
        set_time_limit(2400);

        $people = Category::query()
            ->where('name', 'People')
            ->first();

        $peopleCategories = Category::query()
            ->where('category_id', $people->id)
            ->get();

        foreach ($rows as $row) {
            ImportPerson::class::dispatch(
                $row,
                $peopleCategories->push($people)
            )
                ->onQueue('import');
        }
    }
}
