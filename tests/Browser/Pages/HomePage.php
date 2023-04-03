<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class HomePage extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return '/';
    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertSee('DOCUMENTS');
        $browser->assertSee('PEOPLE');
        $browser->assertSee('PLACES');
        $browser->assertSee('TIMELINE');
        $browser->assertSee('SEARCH');
        $browser->assertSee('ABOUT');
        $browser->assertSee('GET INVOLVED');
        $browser->assertSee('MEDIA');
        $browser->assertSee('DONATE');

        $browser->assertSee('WHAT IS THE WILFORD WOODRUFF PAPERS PROJECT?');
        $browser->assertSee('PROGRESS');
        $browser->assertSee('READ THE BOOK');
        $browser->assertSee('PURPOSE');

        $browser->assertSee('Wilford Woodruff Papers');
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
