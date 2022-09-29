<?php

namespace App\Imports;

use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JournalsPcfImport implements ToCollection, WithHeadingRow
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(600);

        foreach ($rows as $row) {
            $slug = $this->getSLug(data_get($row, str('URL of Column E')->lower()->snake()->toString()));

            if (! empty($slug)) {
                $item = Item::query()
                                ->firstWhere('ftp_slug', $slug);
                if (! empty($item)) {
                    $uniqueID = data_get($row, str('Unique Identifier')->lower()->snake()->toString());
                    $transcriptionCompleted = $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString()));
                    $twoLVCompleted = $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString()));
                    $subjectLinksCompleted = $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString()));
                    $stylizationCompleted = $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString()));
                    $topicTaggingAssigned = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString()));
                    $topicTaggingComplete = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString()));

                    $item->pcf_unique_id = $uniqueID;
                    $item->save();
                } else {
                    logger()->warning('Could not find item for: '.$slug);
                }

                /*logger()->info(
                    collect([
                        data_get($row, str('Unique Identifier')->lower()->snake()->toString()),
                        $this->getSlug(data_get($row, str('URL of Column E')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString())),
                        $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString())),
                    ])
                    ->join(' | ')
                );*/
            }
        }
    }

    private function getSlug($url)
    {
        return str($url)->afterLast('/')->before('?')->toString();
    }

    private function toCarbonDate($stringDate)
    {
        if (empty($stringDate)) {
            return null;
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate));
            } else {
                return Carbon::createFromFormat('d-m-Y', $stringDate);
            }
        } catch (\Exception $exception) {
            return $stringDate;
        }
    }
}
