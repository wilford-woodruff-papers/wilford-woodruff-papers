<?php

namespace App\Http\Livewire\Forms;

use App\Mail\ContactFormSubmitted;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Testify extends Component
{
    public $age;

    public $shareAnonymously;

    public $email;

    public $firstName;

    public $location;

    public $message;

    public $role; // Honeypot

    public $source;

    public $success = false;

    public $topic;

    protected $rules = [
        'email' => 'required|email',
        'firstName' => 'required',
        'age' => 'integer',
        'location' => 'string|max:255',
        'source' => 'string|max:255',
        'topic' => 'string|max:255',
        'message' => 'required',
    ];

    public function render()
    {
        return view('livewire.forms.testify');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

        $submission = Submission::create([
            'form' => 'Testify',
            'first_name' => $this->firstName,
            'email' => $this->email,
            'message' => view('components.forms.share-testimony-body', [
                'message' => $this->message,
                'age' => $this->age,
                'shareAnonymously' => $this->shareAnonymously,
                'first_name' => $this->firstName,
                'location' => $this->location,
                'source' => $this->source,
                'topic' => $this->topic,
            ])->render(),
        ]);

        Mail::to(User::whereIn('email', explode('|', config('wwp.form_emails.contact')))->get())
            ->send(new ContactFormSubmitted($submission));

        $this->success = true;
    }

    public function spamFilter()
    {
        if (! empty($this->role)) {
            abort(422, 'Error processing form');
        }
    }
}
