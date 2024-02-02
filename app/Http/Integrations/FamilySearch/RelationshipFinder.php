<?php

namespace App\Http\Integrations\FamilySearch;

use Illuminate\Support\Facades\Cache;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Saloon\RateLimitPlugin\Contracts\RateLimitStore;
use Saloon\RateLimitPlugin\Helpers\RetryAfterHelper;
use Saloon\RateLimitPlugin\Limit;
use Saloon\RateLimitPlugin\Stores\LaravelCacheStore;
use Saloon\RateLimitPlugin\Traits\HasRateLimits;
use Saloon\Traits\Plugins\AcceptsJson;

class RelationshipFinder extends Connector
{
    use AcceptsJson;
    use HasRateLimits;

    protected int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl(): string
    {
        return config('services.familysearch.base_uri');
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
        ];
    }

    /**
     * Default HTTP client options
     */
    protected function defaultConfig(): array
    {
        return [
            'timeout' => 20,
        ];
    }

    protected function resolveLimits(): array
    {
        return [
            Limit::allow(requests: 500)
                ->everySeconds(seconds: 60)
                ->sleep(),
        ];
    }

    protected function getLimiterPrefix(): ?string
    {
        return 'familysearch-user-'.$this->userId;
    }

    protected function resolveRateLimitStore(): RateLimitStore
    {
        return new LaravelCacheStore(Cache::store(config('cache.default')));
    }

    protected function handleTooManyAttempts(Response $response, Limit $limit): void
    {
        if ($response->status() !== 429) {
            return;
        }

        info('handleTooManyAttempts: '.RetryAfterHelper::parse($response->header('Retry-After')));

        $limit->exceeded(
            releaseInSeconds: RetryAfterHelper::parse($response->header('Retry-After')),
        );
    }
}
