<?php

namespace App\Livewire\Forms;

use App\Mail\ContactFormSubmitted;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContributeDocuments extends Component
{
    use WithFileUploads;

    public $email;

    public $file;

    public $firstName;

    public $lastName;

    public $message;

    public $phone;

    public $role; // Honeypot

    public $success = false;

    public $type;

    protected $rules = [
        'email' => 'required|email',
        'file' => 'file|max:20000',
        'firstName' => 'required',
        'lastName' => 'required',
        'message' => 'required',
        'phone' => 'required|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'type' => 'required|string|max:16',
    ];

    public function render()
    {
        return view('livewire.forms.contribute-documents');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

        $submission = Submission::create([
            'form' => 'Contribute Documents',
            'email' => $this->email,
            'file' => 'file|max:20000',
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        if ($this->file) {
            $submission->file = $this->file->store('files', 'submissions');
            $submission->save();
        }

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
