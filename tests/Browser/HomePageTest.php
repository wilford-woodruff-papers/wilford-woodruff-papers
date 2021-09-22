<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;

class HomePageTest extends DuskTestCase
{
    use RefreshDatabase;
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testBasicElements()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage);
        });
    }
}
