<?php

namespace Tests\Browser;

use App\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ResetReviewStatusTest extends DuskTestCase
{

    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @group ftp
     * @return void
     */
    public function testResetLetters()
    {
        Role::create(['name'=> 'Super Admin']);

        $this->browse(function (Browser $browser) {
            $browser->visit('https://fromthepage.com/users/sign_in')
                    ->type('user[login_id]', env('FTP_USER'))
                    ->type('user[password]', env('FTP_PASSWORD'))
                    ->press('Sign In');

            $items = collect(json_decode(file_get_contents(__DIR__ . '/Fixtures/970.json'), true)['manifests']);

            $items->each(function($item) use ($browser){
                if( Str::of($item['label'])->startsWith('Letter')
                    && $item['service']['pctComplete'] == 100.0
                ){
                    $pages = collect(Http::get($item['@id'])->json('sequences.0.canvases', []));
                    ray($pages);
                    $pages->each(function($page) use ($browser){
                        $id = str($page['@id'])->afterLast('/');
                        $transcriptionLink = collect($page['related'])->where('label', 'Transcribe this page')->first()['@id'];

                        $browser->visit($transcriptionLink)
                                ->assertSee('Transcribe')
                                ->press('Save')
                                ->screenshot($id);

                    });
                    dd('Stop');
                }
            });
        });
    }
}
