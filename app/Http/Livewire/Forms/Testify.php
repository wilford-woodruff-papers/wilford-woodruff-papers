<?php

namespace App\Http\Livewire\Forms;

use App\Mail\ContactFormSubmitted;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Testify extends ModalComponent
{
    public $age;

    public $shareAnonymously;

    public $email;

    public $firstName;

    public $location;

    public $message;

    public $phone;

    public $role; // Honeypot

    public $source;

    public $success = false;

    public $topic;

    protected $rules = [
        'email' => 'required|email',
        'phone' => '',
        'firstName' => 'required',
        'age' => '',
        'location' => '',
        'source' => '',
        'topic' => '',
        'message' => 'required',
    ];

    public static function modalMaxWidth(): string
    {
        return '5xl';
    }

    protected static array $maxWidths = [
        '5xl' => 'max-w-5xl',
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
            'phone' => $this->phone,
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
