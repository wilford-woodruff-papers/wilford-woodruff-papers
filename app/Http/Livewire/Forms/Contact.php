<?php

namespace App\Http\Livewire\Forms;

use App\Models\Submission;
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

    public function render()
    {
        return view('livewire.forms.contact');
    }

    public function save()
    {
        $this->spamFilter();

        $this->validate();

        Submission::create([
            'form' => 'Contact',
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        $this->success = true;
    }

    public function spamFilter()
    {
        if(! empty($this->role)){
            abort(422, 'Error processing form');
        }
    }
}
