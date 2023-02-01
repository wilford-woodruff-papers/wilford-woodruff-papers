<?php

namespace App\Http\Livewire\Forms;

use App\Actions\SubscribeToConstantContactAction;
use Livewire\Component;

class EmailCapture extends Component
{
    public $component = [
        'title' => '',
        'description' => '',
        'success_title' => '',
        'success_description' => '',
    ];

    public $contact = [
        'email' => '',
        'first_name' => '',
        'last_name' => '',
    ];

    public $listMemberships = [];

    public $role; // Honeypot

    public $success = false;

    public function mount($lists = [], $title = '', $description = '', $success_title = '', $success_description = '')
    {
        $this->fill([
            'listMemberships' => ! empty($lists) ? $lists : [config('wwp.list_memberships.newsletter')],
            'component.title' => $title,
            'component.description' => $description,
            'component.success_title' => $success_title,
            'component.success_description' => $success_description,
        ]);
    }

    public function render()
    {
        return view('livewire.forms.email-capture');
    }

    protected $rules = [
        'contact.email' => 'required|email|max:255',
        'contact.first_name' => 'max:255',
        'contact.last_name' => 'max:255',
    ];

    protected $messages = [
        'contact.email.required' => 'You must provide an email address.',
        'contact.email.email' => 'The email address format is not valid.',
    ];

    public function save(SubscribeToConstantContactAction $subscribeToConstantContactAction)
    {
        $this->spamFilter();

        $this->validate();

        activity('email')
            ->event('captured')
            ->withProperties(
                ['list_memberships' => $this->listMemberships],
            )
            ->log(collect($this->contact)->reject(function ($value, $key) {
            return empty($value);
            })->implode(','));

        $subscribeToConstantContactAction->execute($this->contact, $this->listMemberships);

        $this->success = true;
    }

    public function spamFilter()
    {
        if (! empty($this->role)) {
            abort(422, 'Error processing form');
        }
    }
}
