<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\SearchPage;
use Tests\DuskTestCase;

class SearchPageTest extends DuskTestCase
{
    use RefreshDatabase;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testBasicElements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new SearchPage);
        });
    }
}
