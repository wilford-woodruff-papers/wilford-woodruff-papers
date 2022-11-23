<?php

namespace App\Imports;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\Page;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class JournalsPcfImport implements ToCollection, WithHeadingRow
{
    public int $id;

    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        set_time_limit(36000);

        $actionTypes = ActionType::all();

        foreach ($rows as $row) {
            $slug = $this->getSLug(data_get($row, str('URL of Column E')->lower()->snake()->toString()));

            if (! empty($slug)) {
                $item = Item::query()
                                ->firstWhere('ftp_slug', $slug);
                if (empty($item)) {
                    $name = data_get($row, str('Genre/Date or Title/Section on FTP')->replace('/', '')->lower()->snake()->toString());
                    if (! empty($name)) {
                        $item = Item::query()
                                        ->firstWhere('name', $name);
                    }
                }

                if (! empty($item)) {
                    DB::transaction(function () use ($row, $item, $actionTypes) {
                        activity('activity')
                            ->on($item)
                            ->event('imported')
                            ->log('Item imported from PCF');

                        $uniqueID = data_get($row, str('UI')->lower()->snake()->toString());
                        $item->pcf_unique_id = $uniqueID;
                        $item->save();
                        $this->id = $uniqueID;

                        $transcriptionCompleted = $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString()));
                        $twoLVCompleted = $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString()));
                        $twoLVAssigned = data_get($row, str('2LV Assigned')->lower()->snake()->toString());
                        $subjectLinksCompleted = $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString()));
                        $subjectLinksAssigned = data_get($row, str('Subject Links Assigned')->lower()->snake()->toString());
                        $dateTaggingAssigned = data_get($row, str('Date Tags Completed')->lower()->snake()->toString());
                        $stylizationCompleted = $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString()));
                        $stylizationAssigned = data_get($row, str('Stylization Assigned')->lower()->snake()->toString());
                        $topicTaggingAssigned = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString()));
                        $topicTaggingAssignedTo = data_get($row, str('Topic Tagging Assigned')->lower()->snake()->toString());
                        $topicTaggingComplete = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString()));

                        if (! empty($transcriptionCompleted)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID('JM'),
                                'assigned_at' => ! empty($transcriptionCompleted) ? $transcriptionCompleted : now(),
                                'completed_by' => $this->getUserID('JM'),
                                'completed_at' => $transcriptionCompleted,
                                'created_at' => $transcriptionCompleted,
                                'updated_at' => $transcriptionCompleted,
                            ]);

                            foreach ($item->pages as $page) {
                                Action::updateOrCreate([
                                    'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                                    'actionable_type' => Page::class,
                                    'actionable_id' => $page->id,
                                ], [
                                    'assigned_to' => $this->getUserID('JM'),
                                    'assigned_at' => ! empty($transcriptionCompleted) ? $transcriptionCompleted : now(),
                                    'completed_by' => $this->getUserID('JM'),
                                    'completed_at' => $transcriptionCompleted,
                                    'created_at' => $transcriptionCompleted,
                                    'updated_at' => $transcriptionCompleted,
                                ]);
                            }
                        }

                        if (! empty($twoLVAssigned)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($twoLVAssigned),
                                'assigned_at' => ! empty($twoLVCompleted) ? $twoLVCompleted : now(),
                                'completed_by' => ! empty($twoLVCompleted) ? $this->getUserID($twoLVAssigned) : null,
                                'completed_at' => ! empty($twoLVCompleted) ? $twoLVCompleted : null,
                                'created_at' => $twoLVCompleted,
                                'updated_at' => $twoLVCompleted,
                            ]);

                            foreach ($item->pages as $page) {
                                Action::updateOrCreate([
                                    'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                                    'actionable_type' => Page::class,
                                    'actionable_id' => $page->id,
                                ], [
                                    'assigned_to' => $this->getUserID($twoLVAssigned),
                                    'assigned_at' => ! empty($twoLVCompleted) ? $twoLVCompleted : now(),
                                    'completed_by' => ! empty($twoLVCompleted) ? $this->getUserID($twoLVAssigned) : null,
                                    'completed_at' => ! empty($twoLVCompleted) ? $twoLVCompleted : null,
                                    'created_at' => $twoLVCompleted,
                                    'updated_at' => $twoLVCompleted,
                                ]);
                            }
                        }

                        if (! empty($subjectLinksAssigned)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($subjectLinksAssigned),
                                'assigned_at' => ! empty($subjectLinksCompleted) ? $subjectLinksCompleted : now(),
                                'completed_by' => ! empty($subjectLinksCompleted) ? $this->getUserID($subjectLinksAssigned) : null,
                                'completed_at' => ! empty($subjectLinksCompleted) ? $subjectLinksCompleted : null,
                                'created_at' => $subjectLinksCompleted,
                                'updated_at' => $subjectLinksCompleted,
                            ]);

                            foreach ($item->pages as $page) {
                                Action::updateOrCreate([
                                    'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                                    'actionable_type' => Page::class,
                                    'actionable_id' => $page->id,
                                ], [
                                    'assigned_to' => $this->getUserID($subjectLinksAssigned),
                                    'assigned_at' => ! empty($subjectLinksCompleted) ? $subjectLinksCompleted : now(),
                                    'completed_by' => ! empty($subjectLinksCompleted) ? $this->getUserID($subjectLinksAssigned) : null,
                                    'completed_at' => ! empty($subjectLinksCompleted) ? $subjectLinksCompleted : null,
                                    'created_at' => $subjectLinksCompleted,
                                    'updated_at' => $subjectLinksCompleted,
                                ]);
                            }
                        }

                        if (! empty($dateTaggingAssigned)) {
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
                        }

                        if (! empty($stylizationAssigned)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($stylizationAssigned),
                                'assigned_at' => ! empty($stylizationCompleted) ? $stylizationCompleted : now(),
                                'completed_by' => ! empty($stylizationCompleted) ? $this->getUserID($stylizationAssigned) : null,
                                'completed_at' => ! empty($stylizationCompleted) ? $stylizationCompleted : null,
                                'created_at' => $stylizationCompleted,
                                'updated_at' => $stylizationCompleted,
                            ]);

                            foreach ($item->pages as $page) {
                                Action::updateOrCreate([
                                    'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                                    'actionable_type' => Page::class,
                                    'actionable_id' => $page->id,
                                ], [
                                    'assigned_to' => $this->getUserID($stylizationAssigned),
                                    'assigned_at' => ! empty($stylizationCompleted) ? $stylizationCompleted : now(),
                                    'completed_by' => ! empty($stylizationCompleted) ? $this->getUserID($stylizationAssigned) : null,
                                    'completed_at' => ! empty($stylizationCompleted) ? $stylizationCompleted : null,
                                    'created_at' => $stylizationCompleted,
                                    'updated_at' => $stylizationCompleted,
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
                                'assigned_at' => ! empty($topicTaggingComplete) ? $topicTaggingComplete : now(),
                                'completed_by' => ! empty($topicTaggingComplete) ? $this->getUserID($topicTaggingAssignedTo) : null,
                                'completed_at' => ! empty($topicTaggingComplete) ? $topicTaggingComplete : null,
                                'created_at' => $topicTaggingAssigned,
                                'updated_at' => $topicTaggingComplete,
                            ]);

                            foreach ($item->pages as $page) {
                                Action::updateOrCreate([
                                    'action_type_id' => $actionTypes->firstWhere('name', 'Topic Tagging')->id,
                                    'actionable_type' => Page::class,
                                    'actionable_id' => $page->id,
                                ], [
                                    'assigned_to' => $this->getUserID($topicTaggingAssignedTo),
                                    'assigned_at' => ! empty($topicTaggingComplete) ? $topicTaggingComplete : now(),
                                    'completed_by' => ! empty($topicTaggingComplete) ? $this->getUserID($topicTaggingAssignedTo) : null,
                                    'completed_at' => ! empty($topicTaggingComplete) ? $topicTaggingComplete : null,
                                    'created_at' => $topicTaggingAssigned,
                                    'updated_at' => $topicTaggingComplete,
                                ]);
                            }
                        }
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
            case 'KL':
            case 'Karly':
            case 'Karly Lay':
                $name = 'Karly Lay';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
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
