<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use voku\helper\HtmlDomParser;

class TestTranscriptProcessing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transcript:testimport {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test transcript processing';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $ftpTranscript = Http::get($this->argument('url'))->json('resources.0.resource.chars');

        //logger()->info(['FTP: ', $ftpTranscript]);

        $transcript = $this->convertSubjectTags($ftpTranscript);

        logger()->info(['Tagged Transcript: ', $transcript]);

        return Command::SUCCESS;
    }

    private function convertSubjectTags($transcript)
    {
        $dom = HtmlDomParser::str_get_html($transcript);
        $transcript = Str::of($transcript);
        $links = $dom->findMulti('a');
        foreach ($links as $link) {
            //dd($link->outerHtml(), $link->getAttribute('title'), $link->innerHtml());
            if (str($link->outerHtml())->contains('Phebe')) {
                logger()->info(['Outer HTML: ', str($link->outerHtml())->replace('<br /> ', '<br/>')]);
            }
            $transcript = $transcript->replace(str($link->outerHtml())->replace('<br /> ', "<br/>\n"), '[['.html_entity_decode($link->getAttribute('title')).'|'.$link->innerHtml().']]');
        }

        return $transcript;
    }
}
