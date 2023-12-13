<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Tests\TestCase;

class ApiPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_cannot_be_accessed_without_personal_access_token()
    {
        // Make a request to the API endpoint with the token
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])
            ->withoutMiddleware(ThrottleRequestsWithRedis::class)
            ->get(route('api.pages.index'));

        // Assert that the response is successful
        $response->assertStatus(401);
    }

    public function test_documents_can_be_accessed_with_personal_access_token()
    {
        // Create a new user
        $user = User::factory()->create();

        // Generate a personal access token for the user
        $token = $user->createToken('Test Token')->plainTextToken;

        // Make a request to the API endpoint with the token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])
            ->withoutMiddleware(ThrottleRequestsWithRedis::class)
            ->get(route('api.documents.index'));

        // Assert that the response is successful
        $response->assertStatus(200);
    }

    public function test_pages_can_be_accessed_with_personal_access_token()
    {
        // Create a new user
        $user = User::factory()->create();

        // Generate a personal access token for the user
        $token = $user->createToken('Test Token')->plainTextToken;

        // Make a request to the API endpoint with the token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
            'Accept' => 'application/json',
        ])
            ->withoutMiddleware(ThrottleRequestsWithRedis::class)
            ->get(route('api.pages.index'));

        // Assert that the response is successful
        $response->assertStatus(200);
    }
}
