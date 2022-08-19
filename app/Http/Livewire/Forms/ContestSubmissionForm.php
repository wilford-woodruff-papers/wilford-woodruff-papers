<?php

namespace App\Http\Livewire\Forms;

use App\Mail\ContactFormSubmitted;
use App\Models\Contestant;
use App\Models\ContestSubmission;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContestSubmissionForm extends Component
{
    use WithFileUploads;

    public $address;

    public $appropriate;

    public $category;

    public $collaborators;

    public $division;

    public $email;

    public $file;

    public $firstName;

    public $lastName;

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
        'collaborators' => 'max:4096',
        'division' => 'required|string|max:32',
        'email' => 'required|email',
        'file' => 'file|max:20000',
        'firstName' => 'required',
        'lastName' => 'required',
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

        $submission = ContestSubmission::create([
            'title' => $this->title,
            'division' => $this->division,
            'category' => $this->category,
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

        if(! app()->environment(['local'])){
            if ($this->file) {
                $submission->addMedia($this->file)
                    ->toMediaCollection('art');
            }
        }

        /*Mail::to(User::whereIn('email', explode('|', config('wwp.form_emails.contest_submission')))->get())
            ->send(new ContactFormSubmitted($submission));*/

        $this->success = true;
    }

    public function spamFilter()
    {
        if (! empty($this->role)) {
            abort(422, 'Error processing form');
        }
    }
}
