<?php

namespace App\Imports;

use App\Jobs\ImportSubject;
use App\Models\Category;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SubjectImport implements ToCollection, WithHeadingRow
{
    public $assignCategories;

    public function __construct($assignCategories = true)
    {
        $this->assignCategories = $assignCategories;
    }

    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(2400);

        $categories = Category::all();

        foreach ($rows as $row) {
            ImportSubject::dispatch($row, [$categories, $this->assignCategories])
                ->onQueue('import');
        }
    }
}
