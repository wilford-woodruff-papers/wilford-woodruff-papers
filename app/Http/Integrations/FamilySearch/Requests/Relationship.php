<?php

namespace App\Http\Integrations\FamilySearch\Requests;

use App\Models\User;
use Saloon\Enums\Method;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Request;

class Relationship extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    public function __construct(protected User $user, protected readonly string $pid)
    {
        //
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->user->familysearch_token);
    }

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return '/platform/tree/persons/CURRENT/relationships/'.$this->pid;
    }
}
