<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class SearchPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url(): string
    {
        return '/advanced-search';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @return void
     */
    public function assert(Browser $browser): void
    {
        $browser->with('#results', function ($body) {
            $body->assertSee('Documents');
        });
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements(): array
    {
        return [
            '@element' => '#selector',
        ];
    }
}
