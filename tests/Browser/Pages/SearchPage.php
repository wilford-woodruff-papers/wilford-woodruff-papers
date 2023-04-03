<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class SearchPage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/advanced-search';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->with('#results', function ($body) {
            $body->assertSee('Documents');
        });
    }

    /**
     * Get the element shortcuts for the page.
     */
    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
