<?php

namespace App\Http\Livewire\Forms;

use App\Mail\MediaRequested;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class MediaRequest extends Component
{
    public $deadline;

    public $email;

    public $firstName;

    public $lastName;

    public $message;

    public $orgName;

    public $orgPosition;

    public $phone;

    public $role; // Honeypot

    public $salutation;

    public $speaker;

    public $success = false;

    protected $rules = [
        'deadline' => 'date',
        'email' => 'required|email',
        'firstName' => 'required|max:100',
        'lastName' => 'required|max:100',
        'message' => 'required|max:1000',
        'orgName' => 'required|string|max:100',
        'orgPosition' => 'string|max:100',
        'phone' => 'required|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'salutation' => 'required|string|max:3',
        'speaker' => 'string|max:3',
    ];

    public function render()
    {
        return view('livewire.forms.media-request');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

        $submission = Submission::create([
            'form' => 'Media Request',
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'message' => view('components.forms.media-request-body', [
                'message' => $this->message,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'org_name' => $this->orgName,
                'org_position' => $this->orgPosition,
                'salutation' => $this->salutation,
                'speaker' => $this->speaker,
                'deadline' => $this->deadline,
            ])->render(),
            'phone' => $this->phone,
            'salutation' => $this->salutation,
        ]);

        Mail::to(User::whereIn('email', explode('|', config('wwp.form_emails.media_request')))->get())
            ->send(new MediaRequested($submission));

        $this->success = true;
    }

    public function spamFilter()
    {
        if (! empty($this->role)) {
            abort(422, 'Error processing form');
        }
    }
}
