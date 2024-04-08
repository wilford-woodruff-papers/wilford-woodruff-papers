<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Subject;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\info;

class JournalExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:journals';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Journals as text';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $documents = Item::query()
            ->with([
                'type',
                'containerPages',
            ])
            ->whereIn('type_id', Type::where('name', 'Journals')->pluck('id')->toArray())
            ->limit(1)
            ->get();

        foreach ($documents as $document) {
            $this->exportDocument($document);
        }

        info('https://cloudconvert.com/html-to-docx');

    }

    private function exportDocument($document)
    {
        info($document->name.' will be exported to text');

        $fullTranscript = str(
            $document
                ->containerPages
                ->pluck('transcript')
                ->join("\n")
        );

        Storage::put(
            'text/'.str($document->name)->slug().'.txt',
            $fullTranscript
        );

        $fullTranscript = $fullTranscript
            ->replace('<br/>', ' ')
            ->replace('##', '');

        $lines = preg_split("/\r\n|\n|\r/", $fullTranscript);

        $allPeople = collect();
        $allPlaces = collect();
        $printTranscript = '';
        $partial = '';
        foreach ($lines as $line) {
            $line = str($line);
            if (
                $line->contains('<strong><time datetime="')
            ) {
                //$subjects = Subject::extractFromText($partial);

                $matches = str($partial)->matchAll('/(?:\[\[)(.*?)(?:\]\])/s');
                $matches = collect($matches)
                    ->map(fn ($match) => str($match)
                        ->explode('|')
                        ->first())
                    ->toArray();

                $subjects = Subject::query()
                    ->with([
                        'category',
                    ])
                    ->whereIn('name', $matches)
                    ->get();

                $index = 0;
                $partial = str($partial)
                    ->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function (array $matches) use (&$index) {
                        $index++;

                        return str($matches[0])
                            ->trim('[]')
                            ->explode('|')
                            ->last()."<sup>$index</sup>";
                    });
                $footnotes = '';
                //logger()->info('Matches: ');
                //logger()->info($matches);
                foreach ($matches as $key => $match) {
                    $subject = $subjects->firstWhere('name', $match);
                    $footnotes .= '<p>'.(array_search($subject->name, $matches) + 1).' '.$subject->name;
                    if ($subject?->category->contains('name', 'People')) {
                        $allPeople = $allPeople->push($subject);
                        $footnotes .= ' ('.$subject->display_life_years.')';
                    }

                    if ($subject?->category->contains('name', 'Places')) {
                        $allPlaces = $allPlaces->push($subject);
                        $footnotes .= '<p>'.(array_search($subject->name, $matches) + 1).' '.$subject->name.'</p>'."\n";
                        break;
                    }

                    $footnotes .= '</p>'."\n";
                    /* try {
                         $footnotes .= '<p>'.(array_search($subject->name, $matches) + 1).' '.$subject->name.' ('.$subject->display_life_years.')'.'</p>'."\n";
                     } catch (\Exception $e) {
                         logger()->info('Error: '.$e->getMessage());
                         logger()->info('Match: '.$match);
                     }*/

                }
                //$partial .= $footnotes."\n<hr />";
                $printTranscript .= "$partial \n $footnotes \n <hr />";
                $partial = '';
            }
            $partial .= $line;
        }

        $printTranscript = str($printTranscript)
            ->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function (array $matches) use ($allPeople, $allPlaces) {
                if (
                    $allPeople->contains('name', str($matches[1])->explode('|')->first())
                    || $allPlaces->contains('name', str($matches[1])->explode('|')->first())
                ) {
                    return $matches[0];
                } else {
                    logger()->info('Removing: '.$matches[1]);

                    return str($matches[1])->explode('|')->last();
                }
            })
            ->replaceMatches('/(?<!-)(?:{)(.*?)(?:})/m', function (array $match) {
                $parts = str($match[1])->explode('|');
                switch ($parts->count()) {
                    case 1:
                        return '{shorthand: '.$parts->first().'}';
                    case 2:
                        return '{'.$parts->last().': '.$parts->first().'}';
                    case 3:
                        return '{'.$parts->last().': '.$parts->first().'}';
                    default:
                        return '{'.$match[1].'}';
                }
            })
            ->toString();

        $printTranscript .= "\n".'<h2>People</h2>'."\n";
        $printTranscript .= $allPeople
            ->unique('id')
            ->sortBy('name')
            ->map(fn ($subject) => '<p>'.$subject->name.' ('.$subject->display_life_years.')'.'</p>')
            ->values()
            ->join("\n");
        $printTranscript .= "\n".'<h2>Places</h2>'."\n";
        $printTranscript .= $allPlaces
            ->unique('id')
            ->sortBy('name')
            ->map(fn ($subject) => '<p>'.$subject->name.'</p>')
            ->values()
            ->join("\n");

        // I was able to save the text and then use this online converter to convert to Word:
        // https://cloudconvert.com/html-to-docx

        Storage::put(
            'text/'.str($document->name)->slug().'.html',
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$printTranscript.'</body></html>'
        );

        info($document->name.' exported to text successfully!');
    }
}
