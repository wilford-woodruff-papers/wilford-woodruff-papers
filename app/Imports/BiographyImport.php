<?php

namespace App\Imports;

use App\Models\Subject;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BiographyImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $subject = Subject::updateOrCreate([
                'name' => trim($row['ftp_name_formula_do_not_edit']),
            ], [
                'bio' => trim($row['biography']),
                'footnotes' => trim($row['footnotes']),
            ]);
        }
    }
}
