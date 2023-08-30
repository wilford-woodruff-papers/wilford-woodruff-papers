<?php

namespace App\Http\Livewire\Forms;

use App\Mail\ContactFormSubmitted;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Contact extends Component
{
    public $email;

    public $firstName;

    public $lastName;

    public $message;

    public $role; // Honeypot

    public $success = false;

    protected $rules = [
        'email' => 'required|email',
        'firstName' => 'required',
        'lastName' => 'required',
        'message' => 'required',
    ];

    public function mount()
    {
        $this->message = request()->get('message');
    }

    public function render()
    {
        return view('livewire.forms.contact');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

        $submission = Submission::create([
            'form' => 'Contact',
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'message' => $this->message,
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
