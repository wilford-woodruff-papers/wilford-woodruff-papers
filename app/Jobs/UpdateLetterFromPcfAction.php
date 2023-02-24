<?php

namespace App\Jobs;

use App\Models\Action;
use App\Models\ActionType;
use App\Models\Item;
use App\Models\Page;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UpdateLetterFromPcfAction implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $row;

    public $actionTypes;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($row)
    {
        $this->row = $row;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! empty($this->batch()) && $this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...
            return;
        }

        $actionTypeNames = [
            'Transcription',
            'Verification',
            'Stylization',
            'Subject Tagging',
            'Topic Tagging',
            'Date Tagging',
        ];

        $document = Item::query()
            ->where('pcf_unique_id', data_get($this->row, 'unique_identifier'))
            ->where('type_id', Type::firstWhere('name', 'Letters')->id)
            ->first();

        if (empty($document)) {
            return;
        }

        $this->actionTypes = ActionType::query()->whereIn('name', $actionTypeNames)->get();

        $this->checkTranscription($document);
        $this->checkVerification($document);
        $this->checkStylization($document);
        $this->checkSubjectTagging($document);
        $this->checkTopicTagging($document);
        $this->checkDateTagging($document);
    }

    private function checkTranscription($document)
    {
        $actionName = 'Transcription';
        $columns = [
            'name' => 'Transcriber Name',
            'assigned_date' => null,
            'completed_date' => 'Transcription Completion Date',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt);
        }
    }

    private function checkVerification($document)
    {
        $actionName = 'Verification';
        $columns = [
            'name' => '2LV Assigned',
            'assigned_date' => null,
            'completed_date' => '2LV Completed',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt);
        }
    }

    private function checkStylization($document)
    {
        $actionName = 'Stylization';
        $columns = [
            'name' => 'Stylization Assigned',
            'assigned_date' => null,
            'completed_date' => 'Stylization Completed',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt);
        }
    }

    private function checkSubjectTagging($document)
    {
        $actionName = 'Subject Tagging';
        $columns = [
            'name' => 'Subject Links Assigned',
            'assigned_date' => null,
            'completed_date' => 'Subject Links Completed',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt);
        }
    }

    private function checkTopicTagging($document)
    {
        $actionName = 'Topic Tagging';
        $columns = [
            'name' => 'Topic Tagging Assigned',
            'assigned_date' => 'Date Topic Tagging Assigned',
            'completed_date' => 'Date Topic Tagging Completed',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $assignedAt = $this->toCarbonDate(data_get($this->row, str($columns['assigned_date'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt, $assignedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt, $assignedAt);
        }
    }

    private function checkDateTagging($document)
    {
        $actionName = 'Date Tagging';
        $columns = [
            'name' => null,
            'assigned_date' => null,
            'completed_date' => 'Date Tags Added',
        ];
        if (empty(trim(data_get($this->row, str($columns['name'])->lower()->snake()->toString())))) {
            return;
        }

        $actionType = $this->actionTypes->firstWhere('name', $actionName);

        $action = Action::query()
            ->where('action_type_id', $actionType->id)
            ->where('actionable_type', 'App\Models\Item')
            ->where('actionable_id', $document->id)
            ->first();

        $assignedTo = $this->getUserID(data_get($this->row, str($columns['name'])->lower()->snake()->toString()));
        $completedAt = $this->toCarbonDate(data_get($this->row, str($columns['completed_date'])->lower()->snake()->toString()));

        if (empty($action)) {
            $this->createAction($actionType, $document, $assignedTo, $completedAt);
        } else {
            $this->updateAction($action, $document, $assignedTo, $completedAt);
        }
    }

    private function updateAction($action, $document, $assignedTo, $completedAt, $assignedAt = null)
    {
        if (! empty($assignedTo) && $assignedTo !== $action->assigned_to) {
            logger()->alert($action->type->name.' Assigned to wrong person: '.$document->name);
            logger()->alert(User::find($action->assigned_to)?->name.' <- '.User::find($assignedTo)?->name);
            logger()->alert($action->completed_at.' <- '.$completedAt);
        }

        if (! empty($assignedTo)) {
            $action->assigned_to = $assignedTo;
            $action->completed_by = $assignedTo;
        }

        if (! empty($completedAt)) {
            if (empty($assignedAt)) {
                $action->assigned_at = $completedAt;
            } else {
                $action->assigned_at = $assignedAt;
            }

            $action->completed_at = $completedAt;
        }

        $action->save();
    }

    private function createAction($actionType, $document, $assignedTo, $completedAt, $assignedAt = null)
    {
        if (empty($assignedAt)) {
            $assignedAt = $completedAt;
        }
        if (! empty($assignedTo) || ! empty($completedAt)) {
            $action = Action::create([
                'action_type_id' => $actionType->id,
                'actionable_type' => Item::class,
                'actionable_id' => $document->id,
                'assigned_to' => ((! empty($assignedTo)) ? $assignedTo : null),
                'assigned_at' => ((! empty($assignedAt)) ? $assignedAt : now()),
                'completed_by' => ((! empty($completedAt)) ? $assignedTo : null),
                'completed_at' => ((! empty($completedAt)) ? $completedAt : null),
            ]);

            foreach ($document->pages as $page) {
                Action::updateOrCreate([
                    'action_type_id' => $actionType->id,
                    'actionable_type' => Page::class,
                    'actionable_id' => $page->id,
                    'assigned_to' => ((! empty($assignedTo)) ? $assignedTo : null),
                    'assigned_at' => ((! empty($assignedAt)) ? $assignedAt : now()),
                    'completed_by' => ((! empty($completedAt)) ? $assignedTo : null),
                    'completed_at' => ((! empty($completedAt)) ? $completedAt : null),
                ]);
            }
        } else {
            logger()
                ->channel('imports')
                ->alert('Action not found: '.$document->name.' - '.$actionType->name);
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

            $twoLVAssignedTo = data_get($row, str('2LV Assigned')->lower()->snake()->toString());
            //$twoLVAssignedAt = $this->toCarbonDate(data_get($row, str('2LV Assigned Date')->lower()->snake()->toString()));
            $twoLVCompletedAt = $this->toCarbonDate(data_get($row, str('2LV Completed')->lower()->snake()->toString()));

            $subjectLinksAssignedTo = data_get($row, str('Subject Links Assigned')->lower()->snake()->toString());
            //$subjectLinksAssignedAt = $this->toCarbonDate(data_get($row, str('Subject Links Assigned Date')->lower()->snake()->toString()));
            $subjectLinksCompletedAt = $this->toCarbonDate(data_get($row, str('Subject Links Completed')->lower()->snake()->toString()));

            //$placesIdentificationCompletedAt = $this->toCarbonDate(data_get($row, str('Places Identification Completed')->lower()->snake()->toString()));
            //$peopleIdentificationCompletedAt = $this->toCarbonDate(data_get($row, str('People Identification Completed')->lower()->snake()->toString()));

            $topicTaggingAssignedTo = data_get($row, str('Topic Tagging Assigned')->lower()->snake()->toString());
            $topicTaggingAssignedAt = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Assigned')->lower()->snake()->toString()));
            $topicTaggingCompleteAt = $this->toCarbonDate(data_get($row, str('Date Topic Tagging Completed')->lower()->snake()->toString()));

            $stylizationAssignedTo = data_get($row, str('Stylization Assigned')->lower()->snake()->toString());
            //$stylizationAssignedAt = $this->toCarbonDate(data_get($row, str('Stylization Assigned Date')->lower()->snake()->toString()));
            $stylizationCompletedAt = $this->toCarbonDate(data_get($row, str('Stylization Completed')->lower()->snake()->toString()));

            $dateTaggingAssignedAt = $this->toCarbonDate(data_get($row, str('Date Tags Added')->lower()->snake()->toString()));
            $dateTaggingCompletedAt = $this->toCarbonDate(data_get($row, str('Date Tags Added')->lower()->snake()->toString()));

            // Start here
            if (! empty($transcriptionAssignedTo)) {
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
                    'assigned_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : now(),
                    'completed_by' => ! empty($twoLVCompletedAt) ? $this->getUserID($twoLVAssignedTo) : null,
                    'completed_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : null,
                    'created_at' => $twoLVCompletedAt,
                    'updated_at' => $twoLVCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Verification')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($twoLVAssignedTo),
                        'assigned_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : now(),
                        'completed_by' => ! empty($twoLVCompletedAt) ? $this->getUserID($twoLVAssignedTo) : null,
                        'completed_at' => ! empty($twoLVCompletedAt) ? $twoLVCompletedAt : null,
                        'created_at' => $twoLVCompletedAt,
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
                        'created_at' => $subjectLinksCompletedAt,
                        'updated_at' => $subjectLinksCompletedAt,
                    ]);
                }
            }

            if (! empty($dateTaggingAssignedAt)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Date Tagging')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID('JM'),
                    'assigned_at' => $dateTaggingAssignedAt,
                    'completed_by' => $this->getUserID('JM'),
                    'completed_at' => $dateTaggingCompletedAt,
                    'created_at' => $dateTaggingAssignedAt,
                    'updated_at' => $dateTaggingCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Date Tagging')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID('JM'),
                        'assigned_at' => $dateTaggingAssignedAt,
                        'completed_by' => $this->getUserID('JM'),
                        'completed_at' => $dateTaggingCompletedAt,
                        'created_at' => $dateTaggingAssignedAt,
                        'updated_at' => $dateTaggingCompletedAt,
                    ]);
                }
            }

            if (! empty($stylizationAssignedTo)) {
                Action::updateOrCreate([
                    'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                    'actionable_type' => Item::class,
                    'actionable_id' => $item->id,
                ], [
                    'assigned_to' => $this->getUserID($stylizationAssignedTo),
                    'assigned_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : now(),
                    'completed_by' => ! empty($stylizationCompletedAt) ? $this->getUserID($stylizationAssignedTo) : null,
                    'completed_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : null,
                    'created_at' => $stylizationCompletedAt,
                    'updated_at' => $stylizationCompletedAt,
                ]);

                foreach ($item->pages as $page) {
                    Action::updateOrCreate([
                        'action_type_id' => $actionTypes->firstWhere('name', 'Stylization')->id,
                        'actionable_type' => Page::class,
                        'actionable_id' => $page->id,
                    ], [
                        'assigned_to' => $this->getUserID($stylizationAssignedTo),
                        'assigned_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : now(),
                        'completed_by' => ! empty($stylizationCompletedAt) ? $this->getUserID($stylizationAssignedTo) : null,
                        'completed_at' => ! empty($stylizationCompletedAt) ? $stylizationCompletedAt : null,
                        'created_at' => $stylizationCompletedAt,
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
        if (str($stringDate)->lower()->toString() == 'n/a') {
            return now();
        }

        try {
            if (is_numeric($stringDate)) {
                return Carbon::instance(Date::excelToDateTimeObject($stringDate))->toDateString();
            } elseif (str($stringDate)->contains('/')) {
                return Carbon::createFromFormat('Y/m/d', $stringDate);
            } elseif (str($stringDate)->contains('-')) {
                return Carbon::createFromFormat('Y-m-d', $stringDate);
            } elseif (str($stringDate)->length() == 4) {
                return Carbon::createFromFormat('Y', $stringDate);
            }
        } catch (\Exception $exception) {
            return null;
        }
    }

    private function getUserID($initials)
    {
        $initials = trim(str($initials)->before(',')->before('and')->trim()->toString());

        switch ($initials) {
            case 'N/A':
            case 'n/a':
            case 'X':
            case 'crowd':
            case 'crowdsource':
            case 'crowdsourced':
                $name = 'Crowdsource';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
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
            case 'KWT':
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
            case 'Shauna':
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
            case 'MJ':
            case 'Mackenzie':
            case 'Mackenzie Jaggi':
                $name = 'Mackenzie Jaggi';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'Stina':
                $name = 'Stina';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JC':
            case 'Jc':
            case 'Julia Collings':
                $name = 'Julia Collings';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'El':
            case 'EL':
            case 'Elizabeth Lisberg':
                $name = 'Elizabeth Lisberg';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AM':
            case 'Ashlin':
            case 'Ashlin Malcolm':
                $name = 'Ashlin Malcolm';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MF':
            case 'Miriam Foulke':
                $name = 'Miriam Foulke';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SC':
            case 'Samuel Collier':
                $name = 'Samuel Collier';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MP':
            case 'Michael Proudfoot':
            case 'MIchael Proudfoot':
                $name = 'Michael Proudfoot';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KNL':
            case 'Katlyn Linville':
                $name = 'Katlyn Linville';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'NT':
            case 'Nikayla Tolman':
                $name = 'Nikayla Tolman';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'KC':
            case 'Kaeleigh Carberry':
                $name = 'Kaeleigh Carberry';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'NR':
            case 'Neal Rhoades':
                $name = 'Neal Rhoades';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MR':
            case 'Matthew Roberts':
                $name = 'Matthew Roberts';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JF':
                $name = 'JF';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'LL':
                $name = 'LL';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AR':
            case 'Avery Reeve':
                $name = 'Avery Reeve';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'SWW':
                $name = 'SWW';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'DS':
                $name = 'DS';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'JH':
                $name = 'JH';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'MW':
            case 'Margaret Wheelwright':
                $name = 'Margaret Wheelwright';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'x':
                $name = 'x';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'AMC':
                $name = 'AMC';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'HT':
                $name = 'HT';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            case 'DW':
                $name = 'DW';
                $email = str($name)->lower()->replace(' ', '.').'@wilfordwoodruffpapers.org';
                break;
            default:
                logger()->info('Could not find user for: '.$initials);
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
