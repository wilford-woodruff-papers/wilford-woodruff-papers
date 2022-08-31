<?php

namespace App\Http\Livewire\Forms;

use App\Models\Contestant;
use App\Models\ContestSubmission;
use Livewire\Component;

class ContestantContactInformationForm extends Component
{

    public $address;

    public $appropriate;

    public Contestant $contestant;

    public $email;

    public $firstName;

    public $lastName;

    public $original;

    public $phone;

    public $role; // Honeypot

    public ContestSubmission $submission;

    public $subscribeToNewsletter = false;

    public $success = false;

    protected $rules = [
        'address' => 'max:4096',
        'appropriate' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'original' => 'required',
        'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'subscribeToNewsletter' => '',
    ];

    public function mount($submission, $contestant)
    {
        $this->submission = ContestSubmission::whereUuid($submission);
        $this->contestant = Contestant::whereUuid($contestant);
    }

    public function render()
    {
        return view('livewire.forms.contestant-contact-information-form')
                ->layout('layouts.guest');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

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
