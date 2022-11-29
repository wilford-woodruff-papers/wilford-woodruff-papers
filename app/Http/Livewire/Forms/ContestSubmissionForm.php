<?php

namespace App\Http\Livewire\Forms;

use App\Mail\ContestFormSubmitted;
use App\Models\Contestant;
use App\Models\ContestSubmission;
use App\Models\User;
use App\Notifications\CollaboratorNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContestSubmissionForm extends Component
{
    use WithFileUploads;

    public $address;

    public $appropriate;

    public $category = '';

    public $collaborators;

    public $connection;

    public $division;

    public $email;

    public $fileUpload;

    public $firstName;

    public $lastName;

    public $link;

    public $medium;

    public $original;

    public $phone;

    public $role; // Honeypot

    public $subscribeToNewsletter = false;

    public $success = false;

    public $title;

    protected $rules = [
        'address' => 'max:4096',
        'appropriate' => 'required',
        'category' => 'required|string|max:32',
        'medium' => 'required|string|max:32',
        'collaborators' => 'max:4096',
        'connection' => 'required|max:10000',
        'division' => 'required|string|max:32',
        'email' => 'required|email',
        'fileUpload' => 'max:20000',
        'firstName' => 'required',
        'lastName' => 'required',
        'link' => 'max:255',
        'original' => 'required',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'subscribeToNewsletter' => '',
        'title' => 'required|string|max:254',
    ];

    public function render()
    {
        return view('livewire.forms.contest-submission-form')
                ->layout('layouts.guest');
    }

    public function save()
    {
        config()->set(['filesystems.default' => 'contest_submissions']);

        $this->spamFilter();

        $this->validate();

        DB::transaction(function () {
            $submission = ContestSubmission::create([
                'title' => $this->title,
                'division' => $this->division,
                'category' => $this->category,
                'medium' => $this->medium,
                'collaborators' => $this->collaborators,
                'connection' => $this->connection,
                'link' => $this->link,
            ]);

            $contestant = new Contestant([
                'email' => $this->email,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'phone' => $this->phone,
                'address' => $this->address,
                'is_primary_contact' => true,
                'is_original' => $this->original,
                'is_appropriate' => $this->appropriate,
                'subscribe_to_newsletter' => $this->subscribeToNewsletter,
            ]);

            $submission->contestants()->save($contestant);

            if (! app()->environment(['local'])) {
                if ($this->fileUpload) {
                    $submission->addMedia($this->fileUpload)
                        ->toMediaCollection('art');
                }
            }

            if (! empty($this->collaborators)) {
                $this->notifyCollaborators($submission);
            }

            Mail::to(User::whereIn('email', explode('|', config('wwp.form_emails.contest_submission')))->get())
                ->send(new ContestFormSubmitted($submission));

            $this->success = true;
        });
    }

    public function updatedFileUpload()
    {
        $this->validate([
            'fileUpload' => 'image|max:20000',
        ]);
    }

    public function notifyCollaborators($submission)
    {
        // TODO: Store and send email to collaborators
        $emails = str($this->collaborators)
                    ->explode(';')
                    ->transform(function ($item, $key) {
                        return str($item)->trim();
                    })
                    ->map(function ($item, $key) {
                        return Contestant::make([
                            'email' => $item,
                        ]);
                    })
                    ->all();

        $contestants = $submission->contestants()->saveMany($emails);

        Notification::send($contestants, new CollaboratorNotification($submission));
    }

    public function spamFilter()
    {
        if (! empty($this->role)) {
            abort(422, 'Error processing form');
        }
    }
}
