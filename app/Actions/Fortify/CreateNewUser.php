<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        if ($input['subscribe_to_newsletter'] ?? 'false' == 'true') {
            $subscribeToConstantContactAction = new \App\Actions\SubscribeToConstantContactAction;
            $subscribeToConstantContactAction->execute([
                'email' => $input['email'],
                'first_name' => str($input['name'])->explode(' ')->first(),
                'last_name' => str($input['name'])->explode(' ')->count() > 1
                    ? str($input['name'])->explode(' ')->last()
                    : '',
            ],
                [
                    config('wwp.list_memberships.newsletter'),
                ]
            );
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'accepted_terms' => 1,
        ]);
    }
}
