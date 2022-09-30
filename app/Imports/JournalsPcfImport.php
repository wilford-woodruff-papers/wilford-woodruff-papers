<?php

namespace App\Imports;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

        $actionTypes = ActionType::all();

        foreach ($rows as $row) {
            $slug = $this->getSLug(data_get($row, str('URL of Column E')->lower()->snake()->toString()));

            if (! empty($slug)) {
                $item = Item::query()
                                ->firstWhere('ftp_slug', $slug);

                if (! empty($item)) {
                    DB::transaction(function () use ($row, $item, $actionTypes) {
                        $uniqueID = data_get($row, str('Unique Identifier')->lower()->snake()->toString());
                        $transcriptionCompleted = $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString()));
                        $twoLVCompleted = $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString()));
                        $subjectLinksCompleted = $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString()));
                        $stylizationCompleted = $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString()));
                        $topicTaggingAssigned = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString()));
                        $topicTaggingComplete = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString()));

                        $item->pcf_unique_id = $uniqueID;
                        $item->save();

                        Action::firstOrCreate([
                            'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                            'actionable_type' => Item::class,
                            'action_id' => $item->id,
                        ], [
                            'assigned_to' => null,
                            'assigned_at' => $transcriptionCompleted,
                            'completed_by' => null,
                            'completed_at' => $transcriptionCompleted,
                            'created_at' => $transcriptionCompleted,
                            'updated_at' => $transcriptionCompleted,
                        ]);

                        Action::firstOrCreate([
                            'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                            'actionable_type' => Item::class,
                            'action_id' => $item->id,
                        ], [
                            'assigned_to' => null,
                            'assigned_at' => $twoLVCompleted,
                            'completed_by' => null,
                            'completed_at' => $twoLVCompleted,
                            'created_at' => $twoLVCompleted,
                            'updated_at' => $twoLVCompleted,
                        ]);

                        Action::firstOrCreate([
                            'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                            'actionable_type' => Item::class,
                            'action_id' => $item->id,
                        ], [
                            'assigned_to' => null,
                            'assigned_at' => $subjectLinksCompleted,
                            'completed_by' => null,
                            'completed_at' => $subjectLinksCompleted,
                            'created_at' => $subjectLinksCompleted,
                            'updated_at' => $subjectLinksCompleted,
                        ]);

                        Action::firstOrCreate([
                            'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                            'actionable_type' => Item::class,
                            'action_id' => $item->id,
                        ], [
                            'assigned_to' => null,
                            'assigned_at' => $stylizationCompleted,
                            'completed_by' => null,
                            'completed_at' => $stylizationCompleted,
                            'created_at' => $stylizationCompleted,
                            'updated_at' => $stylizationCompleted,
                        ]);

                        Action::firstOrCreate([
                            'action_type_id' => $actionTypes->firstWhere('name', 'Topic Tagging')->id,
                            'actionable_type' => Item::class,
                            'action_id' => $item->id,
                        ], [
                            'assigned_to' => null,
                            'assigned_at' => $topicTaggingAssigned,
                            'completed_by' => null,
                            'completed_at' => $topicTaggingComplete,
                            'created_at' => $topicTaggingAssigned,
                            'updated_at' => $topicTaggingComplete,
                        ]);
                    });
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
