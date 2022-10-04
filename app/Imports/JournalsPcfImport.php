<?php

namespace App\Imports;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
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
                if (empty($item)) {
                    $name = data_get($row, str('URL of Column E')->lower()->snake()->toString());
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

                        $uniqueID = data_get($row, str('Unique Identifier')->lower()->snake()->toString());
                        $transcriptionCompleted = $this->toCarbonDate(data_get($row, str('Completed Transcriptions Uploaded to FTP')->lower()->snake()->toString()));
                        $twoLVCompleted = $this->toCarbonDate(data_get($row, str('2LV Completion Date')->lower()->snake()->toString()));
                        $twoLVAssigned = data_get($row, str('2LV Assigned')->lower()->snake()->toString());
                        $subjectLinksCompleted = $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString()));
                        $subjectLinksAssigned = data_get($row, str('Subject Links Assigned')->lower()->snake()->toString());
                        $stylizationCompleted = $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString()));
                        $stylizationAssigned = data_get($row, str('Stylization Assigned')->lower()->snake()->toString());
                        $topicTaggingAssigned = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString()));
                        $topicTaggingAssignedTo = data_get($row, str('Topic Tagging Assigned')->lower()->snake()->toString());
                        $topicTaggingComplete = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString()));

                        $item->pcf_unique_id = $uniqueID;
                        $item->save();

                        if (! empty($transcriptionCompleted)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Transcription')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => null,
                                'assigned_at' => $transcriptionCompleted,
                                'completed_by' => null,
                                'completed_at' => $transcriptionCompleted,
                                'created_at' => $transcriptionCompleted,
                                'updated_at' => $transcriptionCompleted,
                            ]);
                        }

                        if (! empty($twoLVCompleted)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($twoLVAssigned),
                                'assigned_at' => $twoLVCompleted,
                                'completed_by' => $this->getUserID($twoLVAssigned),
                                'completed_at' => $twoLVCompleted,
                                'created_at' => $twoLVCompleted,
                                'updated_at' => $twoLVCompleted,
                            ]);
                        }

                        if (! empty($subjectLinksCompleted)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Subject Tagging')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($subjectLinksAssigned),
                                'assigned_at' => $subjectLinksCompleted,
                                'completed_by' => $this->getUserID($subjectLinksAssigned),
                                'completed_at' => $subjectLinksCompleted,
                                'created_at' => $subjectLinksCompleted,
                                'updated_at' => $subjectLinksCompleted,
                            ]);
                        }

                        if (! empty($stylizationCompleted)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($stylizationAssigned),
                                'assigned_at' => $stylizationCompleted,
                                'completed_by' => $this->getUserID($stylizationAssigned),
                                'completed_at' => $stylizationCompleted,
                                'created_at' => $stylizationCompleted,
                                'updated_at' => $stylizationCompleted,
                            ]);
                        }

                        if (! empty($topicTaggingAssigned)) {
                            Action::updateOrCreate([
                                'action_type_id' => $actionTypes->firstWhere('name', 'Topic Tagging')->id,
                                'actionable_type' => Item::class,
                                'actionable_id' => $item->id,
                            ], [
                                'assigned_to' => $this->getUserID($topicTaggingAssignedTo),
                                'assigned_at' => $topicTaggingAssigned,
                                'completed_by' => $this->getUserID($topicTaggingAssignedTo),
                                'completed_at' => $topicTaggingComplete,
                                'created_at' => $topicTaggingAssigned,
                                'updated_at' => $topicTaggingComplete,
                            ]);
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
        switch ($initials) {
            case 'SCH':
                $name = 'Steve Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'TH':
                $name = 'Thomas Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AD':
            case 'AP':
                $name = 'Ashlyn Pells';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KT':
                $name = 'Kristy Taylor';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JM':
                $name = 'Jennifer Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EM':
                $name = 'Elise Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Eli M':
                $name = 'Eli Mackley';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Lorin':
            case 'LG':
                $name = 'Lorin Groesbeck';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EE':
                $name = 'Elaine Esposito';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'EH':
                $name = 'Emma Hadfield';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SF':
                $name = 'Sherilyn Farnes';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JG':
                $name = 'Jason Godfrey';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'HK':
                $name = 'Hailee Kotter';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'RM':
                $name = 'Rebecca Matos';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MS':
                $name = 'Marinda Smith';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AH':
                $name = 'Abigail Harper';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'DG':
                $name = 'Darby Glass';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SJ':
                $name = 'Sarah Jorgensen';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'ELH':
                $name = 'Ellie Hancock';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'BD':
                $name = 'Braeden Dyer';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AA':
                $name = 'Allison Andrews';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'NH':
                $name = 'Natalie Hancock';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'CC':
                $name = 'Cory Clay';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SW':
                $name = 'Samuel Webb';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'OC':
                $name = 'Oliver Carson';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KL':
                $name = 'Karly Lay';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            default:
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
