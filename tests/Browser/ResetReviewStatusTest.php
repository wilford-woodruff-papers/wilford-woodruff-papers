<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResetReviewStatusTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group ftp
     * @return void
     */
    public function testResetLetters()
    {

        $items = collect(Http::get('https://fromthepage.com/iiif/collection/970')->json('manifests', []));
        ray($items);
        /*$this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });*/
    }
}
