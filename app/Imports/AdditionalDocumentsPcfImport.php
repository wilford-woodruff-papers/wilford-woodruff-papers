<?php

namespace App\Imports;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AdditionalDocumentsPcfImport implements ToCollection, WithHeadingRow
{
    public string $id;

    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(36000);

        $actionTypes = ActionType::all();
        $additionalType = Type::firstWhere('name', 'Additional');

        foreach ($rows as $row) {
            if (empty(data_get($row, str('Unique Identifier')->lower()->snake()->toString()))) {
                info('No ID');

                continue;
            }
            if (empty(data_get($row, str('Uploaded to FTP')->lower()->snake()->toString()))) {
                info('Not yet in FTP');

                continue;
            }

            $slug = $this->getSLug(data_get($row, str('Uploaded to FTP')->lower()->snake()->toString()));
            info($slug);

            if (! empty($slug)) {
                $item = Item::query()
                                ->firstWhere('ftp_slug', $slug);
                if (empty($item)) {
                    $name = data_get($row, 'name_original_document_link_formula');
                    if (! empty($name)) {
                        $item = Item::query()
                                        ->firstWhere('name', $name);
                    }
                }

                if (! empty($item)) {
                    info($item->name);

                    $uniqueID = data_get($row, str('Unique Identifier')->lower()->snake()->toString());
                    $item->pcf_unique_id_prefix = str($uniqueID)->explode('-')->first();
                    $item->pcf_unique_id = str($uniqueID)->explode('-')->last();
                    $item->category = data_get($row, 'category_formula');
                    $item->description = data_get($row, 'description_formula');
                    $item->type_id = $additionalType->id;
                    $item->save();
                    $this->id = $uniqueID;

                    $this->proccessItem($row, $item, $actionTypes);

                    foreach ($item->items as $section) {
                        $this->proccessItem($row, $section, $actionTypes);
                    }
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

    private function proccessItem($row, $item, $actionTypes)
    {
        DB::transaction(function () use ($row, $item, $actionTypes) {
            activity('activity')
                ->on($item)
                ->event('imported')
                ->log('Item imported from PCF');

            $transcriptionAssignedTo = data_get($row, str('Transcriber Name')->lower()->snake()->toString());
            $transcriptionCompletedAt = $this->toCarbonDate(data_get($row, str('Transcription Completion Date')->lower()->snake()->toString()));

            $twoLVAssignedTo = data_get($row, str('2LV Assigned Name')->lower()->snake()->toString());
            $twoLVAssignedAt = $this->toCarbonDate(data_get($row, str('2LV Assigned Date')->lower()->snake()->toString()));
            $twoLVCompletedAt = $this->toCarbonDate(data_get($row, str('2LV Completed')->lower()->snake()->toString()));

            $subjectLinksAssignedTo = data_get($row, str('Subject Links Assigned Name')->lower()->snake()->toString());
            $subjectLinksAssignedAt = $this->toCarbonDate(data_get($row, str('Subject Links Assigned Date')->lower()->snake()->toString()));
            $subjectLinksCompletedAt = $this->toCarbonDate(data_get($row, str('Subject Links Completed Date')->lower()->snake()->toString()));

            //$placesIdentificationCompletedAt = $this->toCarbonDate(data_get($row, str('Places Identification Completed')->lower()->snake()->toString()));
            //$peopleIdentificationCompletedAt = $this->toCarbonDate(data_get($row, str('People Identification Completed')->lower()->snake()->toString()));

            $topicTaggingAssignedTo = data_get($row, str('Topic Tags Assigned Name')->lower()->snake()->toString());
            $topicTaggingAssignedAt = $this->toCarbonDate(data_get($row, str('Topic Tags Assigned Date')->lower()->snake()->toString()));
            $topicTaggingCompleteAt = $this->toCarbonDate(data_get($row, str('Topic Tags Completed')->lower()->snake()->toString()));

            $stylizationAssignedTo = data_get($row, str('Stylization Assigned Name')->lower()->snake()->toString());
            $stylizationAssignedAt = $this->toCarbonDate(data_get($row, str('Stylization Assigned Date')->lower()->snake()->toString()));
            $stylizationCompletedAt = $this->toCarbonDate(data_get($row, str('Stylization Completed Date')->lower()->snake()->toString()));

            //$dateTaggingAssigned = data_get($row, str('Date Tags Completed')->lower()->snake()->toString());
            // Start here
            if (! empty($transcriptionCompletedAt)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($transcriptionAssignedTo),
                    'assigned_at' => ! empty($transcriptionCompletedAt) ? $transcriptionCompletedAt : now(),
                    'completed_by' => $this->getUserID($transcriptionAssignedTo),
                    'completed_at' => $transcriptionCompletedAt,
                    'created_at' => $transcriptionCompletedAt,
                    'updated_at' => $transcriptionCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($transcriptionAssignedTo),
                        'assigned_at' => ! empty($transcriptionCompletedAt) ? $transcriptionCompletedAt : now(),
                        'completed_by' => $this->getUserID($transcriptionAssignedTo),
                        'completed_at' => $transcriptionCompletedAt,
                        'created_at' => $transcriptionCompletedAt,
                        'updated_at' => $transcriptionCompletedAt,
                    ]);
                }
            }

            if (! empty($twoLVAssignedTo)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($twoLVAssignedTo),
                    'assigned_at' => ! empty($twoLVAssignedAt) ? $twoLVAssignedAt : now(),
                    'completed_by' => ! empty($twoLVCompletedAt) ? $this->getUserID($twoLVAssignedTo) : null,
                    'completed_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : null,
                    'created_at' => $twoLVAssignedAt,
                    'updated_at' => $twoLVCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($twoLVAssignedTo),
                        'assigned_at' => ! empty($twoLVAssignedAt) ? $twoLVAssignedAt : now(),
                        'completed_by' => ! empty($twoLVCompletedAt) ? $this->getUserID($twoLVAssignedTo) : null,
                        'completed_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : null,
                        'created_at' => $twoLVAssignedAt,
                        'updated_at' => $twoLVCompletedAt,
                    ]);
                }
            }

            if (! empty($subjectLinksAssignedTo)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($subjectLinksAssignedTo),
                    'assigned_at' => ! empty($subjectLinksCompletedAt) ? $subjectLinksCompletedAt : now(),
                    'completed_by' => ! empty($subjectLinksCompletedAt) ? $this->getUserID($subjectLinksAssignedTo) : null,
                    'completed_at' => ! empty($subjectLinksCompletedAt) ? $subjectLinksCompletedAt : null,
                    'created_at' => $subjectLinksCompletedAt,
                    'updated_at' => $subjectLinksCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($subjectLinksAssignedTo),
                        'assigned_at' => ! empty($subjectLinksAssignedAt) ? $subjectLinksAssignedAt : now(),
                        'completed_by' => ! empty($subjectLinksCompletedAt) ? $this->getUserID($subjectLinksAssignedTo) : null,
                        'completed_at' => ! empty($subjectLinksCompletedAt) ? $subjectLinksCompletedAt : null,
                        'created_at' => $subjectLinksAssignedAt,
                        'updated_at' => $subjectLinksCompletedAt,
                    ]);
                }
            }

            /*if (! empty($dateTaggingAssigned)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Date Tagging')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($dateTaggingAssigned),
                    'assigned_at' => $this->toCarbonDate('2021-02-23'),
                    'completed_by' => $this->getUserID($dateTaggingAssigned),
                    'completed_at' => $this->toCarbonDate('2021-02-23'),
                    'created_at' => $this->toCarbonDate('2021-02-23'),
                    'updated_at' => $this->toCarbonDate('2021-02-23'),
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Date Tagging')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($dateTaggingAssigned),
                        'assigned_at' => $this->toCarbonDate('2021-02-23'),
                        'completed_by' => $this->getUserID($dateTaggingAssigned),
                        'completed_at' => $this->toCarbonDate('2021-02-23'),
                        'created_at' => $this->toCarbonDate('2021-02-23'),
                        'updated_at' => $this->toCarbonDate('2021-02-23'),
                    ]);
                }
            }*/

            if (! empty($stylizationAssignedTo)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($stylizationAssignedTo),
                    'assigned_at' => ! empty($stylizationAssignedAt) ? $stylizationAssignedAt : now(),
                    'completed_by' => ! empty($stylizationCompletedAt) ? $this->getUserID($stylizationAssignedTo) : null,
                    'completed_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : null,
                    'created_at' => $stylizationAssignedAt,
                    'updated_at' => $stylizationCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($stylizationAssignedTo),
                        'assigned_at' => ! empty($stylizationAssignedAt) ? $stylizationAssignedAt : now(),
                        'completed_by' => ! empty($stylizationCompletedAt) ? $this->getUserID($stylizationAssignedTo) : null,
                        'completed_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : null,
                        'created_at' => $stylizationAssignedAt,
                        'updated_at' => $stylizationCompletedAt,
                    ]);
                }
            }

            if (! empty($topicTaggingAssignedTo)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Topic Tagging')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($topicTaggingAssignedTo),
                    'assigned_at' => ! empty($topicTaggingAssignedAt) ? $topicTaggingAssignedAt : now(),
                    'completed_by' => ! empty($topicTaggingCompleteAt) ? $this->getUserID($topicTaggingAssignedTo) : null,
                    'completed_at' => ! empty($topicTaggingCompleteAt) ? $topicTaggingCompleteAt : null,
                    'created_at' => $topicTaggingAssignedAt,
                    'updated_at' => $topicTaggingCompleteAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Topic Tagging')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($topicTaggingAssignedTo),
                        'assigned_at' => ! empty($topicTaggingAssignedAt) ? $topicTaggingAssignedAt : now(),
                        'completed_by' => ! empty($topicTaggingCompleteAt) ? $this->getUserID($topicTaggingAssignedTo) : null,
                        'completed_at' => ! empty($topicTaggingCompleteAt) ? $topicTaggingCompleteAt : null,
                        'created_at' => $topicTaggingAssignedAt,
                        'updated_at' => $topicTaggingCompleteAt,
                    ]);
                }
            }

            /*if (! empty($placesIdentificationCompletedAt)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Places Identification')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID('JM'),
                    'assigned_at' => ! empty($placesIdentificationCompletedAt) ? $placesIdentificationCompletedAt : now(),
                    'completed_by' => $this->getUserID('JM'),
                    'completed_at' => $placesIdentificationCompletedAt,
                    'created_at' => $placesIdentificationCompletedAt,
                    'updated_at' => $placesIdentificationCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Places Identification')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID('JM'),
                        'assigned_at' => ! empty($transcriptionCompletedAt) ? $transcriptionCompletedAt : now(),
                        'completed_by' => $this->getUserID('JM'),
                        'completed_at' => $transcriptionCompletedAt,
                        'created_at' => $transcriptionCompletedAt,
                        'updated_at' => $transcriptionCompletedAt,
                    ]);
                }
            }*/

            /*if (! empty($peopleIdentificationCompletedAt)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'People Identification')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID('JM'),
                    'assigned_at' => ! empty($peopleIdentificationCompletedAt) ? $peopleIdentificationCompletedAt : now(),
                    'completed_by' => $this->getUserID('JM'),
                    'completed_at' => $peopleIdentificationCompletedAt,
                    'created_at' => $peopleIdentificationCompletedAt,
                    'updated_at' => $peopleIdentificationCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'People Identification')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID('JM'),
                        'assigned_at' => ! empty($peopleIdentificationCompletedAt) ? $peopleIdentificationCompletedAt : now(),
                        'completed_by' => $this->getUserID('JM'),
                        'completed_at' => $peopleIdentificationCompletedAt,
                        'created_at' => $peopleIdentificationCompletedAt,
                        'updated_at' => $peopleIdentificationCompletedAt,
                    ]);
                }
            }*/
        });
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
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } else {
                return Carbon::createFromFormat('Y-m-d', $stringDate);
            }
        } catch (\Exception $exception) {
            return null;
        }
    }

    private function getUserID($initials)
    {
        if (in_array($initials, [
            'n/a',
        ])) {
            return null;
        }

        $initials = trim(str($initials)->before('/')->trim()->toString());

        switch ($initials) {
            case 'SCH':
            case 'Steve Harper':
                $name = 'Steve Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'TH':
            case 'Thomas Harper':
                $name = 'Thomas Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AD':
            case 'AP':
            case 'Ashlyn':
            case 'Ashlyn Pells':
            case 'Ashlyn Dyer':
                $name = 'Ashlyn Pells';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KT':
            case 'Kristy Taylor':
                $name = 'Kristy Taylor';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JM':
            case 'Jennifer':
            case 'Jennifer Mackley':
                $name = 'Jennifer Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EM':
            case 'Elise':
            case 'Elise Mackley':
                $name = 'Elise Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Eli M':
            case 'Eli M.':
            case 'Eli Mackley':
                $name = 'Eli Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Lorin':
            case 'LG':
            case 'Lorin Groesbeck':
                $name = 'Lorin Groesbeck';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EE':
            case 'Elaine':
            case 'Elaine Esposito':
                $name = 'Elaine Esposito';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EH':
            case 'Emma Hadfield':
                $name = 'Emma Hadfield';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SF':
            case 'Sherilyn Farnes':
                $name = 'Sherilyn Farnes';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JG':
            case 'Jason':
            case 'Jason Godfrey':
                $name = 'Jason Godfrey';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'HK':
            case 'Hailee Kotter':
                $name = 'Hailee Kotter';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'RM':
            case 'Rebecca Matos':
                $name = 'Rebecca Matos';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MS':
            case 'Marinda Smith':
                $name = 'Marinda Smith';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Abigail Harper':
                $name = 'Abigail Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'DG':
            case 'Darby Glass':
                $name = 'Darby Glass';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SJ':
            case 'Sarah Jorgensen':
                $name = 'Sarah Jorgensen';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'ELH':
            case 'Ellie':
            case 'Ellie Hancock':
                $name = 'Ellie Hancock';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'BD':
            case 'Braeden':
            case 'Braeden Dyer':
                $name = 'Braeden Dyer';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AA':
            case 'Allison (AA)':
            case 'Allison Andrews':
                $name = 'Allison Andrews';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'NH':
            case 'Natalie Hancock':
                $name = 'Natalie Hancock';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'CC':
            case 'Cory Clay':
                $name = 'Cory Clay';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SW':
            case 'Samuel Webb':
                $name = 'Samuel Webb';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'OC':
            case 'Oliver Carson':
                $name = 'Oliver Carson';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
                /*case 'KL':
                case 'Karly':
                case 'Karly Lay':
                    $name = 'Karly Lay';
                    $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                    break;*/
            case 'SH':
            case 'Shauna Horne':
                $name = 'Shauna Horne';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KD':
            case 'Karen Dupaix':
                $name = 'Karen Dupaix';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'CH':
            case 'Camille Homer':
                $name = 'Camille Homer';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'RB':
            case 'Rachel Huntsman Baldwin':
                $name = 'Rachel Huntsman Baldwin';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MH':
            case 'Marilyn Henrie':
                $name = 'Marilyn Henrie';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'HL':
            case 'Hovan Lawton':
                $name = 'Hovan Lawton';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'LR':
            case 'Lisa Reising':
                $name = 'Lisa Reising';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AF':
            case 'Anna Featherstone':
                $name = 'Anna Featherstone';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AH':
            case 'Abigail Harper':
                $name = 'Abigail Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Mackenzie':
            case 'Mackenzie Jaggi':
                $name = 'Mackenzie Jaggi';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MP':
            case 'Michael Proudfoot':
                $name = 'Michael Proudfoot';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SC':
            case 'Samuel Collier':
                $name = 'Samuel Collier';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MF':
            case 'Miriam Foulke':
                $name = 'Miriam Foulke';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KL':
            case 'Katlyn Linville':
                $name = 'Katlyn Linville';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'crowd':
            case 'crowdsource':
            case 'crowdsourced':
                $name = 'Crowdsource';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            default:
                logger()->info($this->id.' - Could not find user for: '.$initials);
                $name = 'Jon Fackrell';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
        }
        $user = User::firstOrCreate([
            'email' => $email,
        ], [
            'name' => $name,
            'password' => Hash::make(Str::uuid()),
            'provider' => 'email',
        ]);

        return $user->id;
    }
}
