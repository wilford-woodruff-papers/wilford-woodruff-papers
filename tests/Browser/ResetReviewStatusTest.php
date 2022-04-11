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
        set_time_limit(7200);

        Role::create(['name'=> 'Super Admin']);



        $this->browse(function (Browser $browser){

            $browser->visit('https://fromthepage.com/users/sign_in')
                    ->type('user[login_id]', env('FTP_USER'))
                    ->type('user[password]', env('FTP_PASSWORD'))
                    ->press('Sign In')
                    ->pause(3000);

            // $items = collect(json_decode(file_get_contents(__DIR__ . '/Fixtures/970.json'), true)['manifests']);
            $items = collect(Http::get('https://fromthepage.com/iiif/collection/970')->json('manifests', []));

            foreach($items as $item){
                if( Str::of($item['label'])->startsWith('Letter')
                    && $item['service']['pctComplete'] == 100.0
                ){
                    logger()->info($item['label']);
                    $pages = collect(Http::timeout(60)
                        ->connectTimeout(60)
                        ->retry(3, 2000)
                        ->get($item['@id'])
                        ->json('sequences.0.canvases', []));

                    try{
                        foreach($pages as $page) {
                            $id = str($page['@id'])->afterLast('/');
                            $transcriptionLink = collect($page['related'])->where('label', 'Transcribe this page')->first()['@id'];
                            logger()->info($transcriptionLink);
                            $browser->visit($transcriptionLink)
                                    ->pause(200)
                                    ->with('.page-toolbar', function ($toolbar) {
                                        $toolbar->press('Save');
                                    })
                                    ->pause(1000);
                                //->waitForText('Saved', 30)
                                //->screenshot($id)
                                //->pause(2000);
                        }
                    }catch(\Exception $exception){
                        logger()->info('Failed: '.$exception->getMessage());
                    }

                }
            }
        });
    }
}
