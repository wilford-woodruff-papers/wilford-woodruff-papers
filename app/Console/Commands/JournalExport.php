<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Subject;
use App\Models\Type;
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
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
    protected $signature = 'export:journals {--convert=false}';

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
            ->whereIn('name', [
                'Journal (December 29, 1833 – January 3, 1838)',
                //'Journal (January 1, 1838 – December 31, 1839)',
                //'Journal (January 1, 1840 – December 31, 1840)',
            ])
            //->limit(1)
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
            ->replaceMatches("/(?<!^)<br\/>(?=$)/mi", ' ')// Remove line breaks at the end of a line, but not the beginning of a line
            ->replaceMatches('/<sup>/mi', '')
            ->replaceMatches("/<\/sup>/mi", '')
            ->clearText();

        $lines = preg_split("/\r\n|\n|\r/", $fullTranscript);

        $allPeople = collect();
        $allPlaces = collect();
        $allTopics = collect();
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
                    ->filter(fn ($match) => str($match)->contains('|'))
                    ->map(fn ($match) => str($match)
                        ->explode('|')
                        ->first())
                    ->filter(fn ($match) => str($match)->explode(' ')->count() > 1)
                    ->unique()
                    ->values()
                    ->all();

                $subjects = Subject::query()
                    ->with([
                        'category',
                    ])
                    ->whereIn('name', $matches)
                    ->get();

                $index = 0;
                $references = [];
                $partial = str($partial)
                    ->replaceMatches('/(?:\[\[)(.*?)(?:\]\])/s', function (array $matches) use (&$index, &$references, $subjects) {
                        $key = str($matches[0])
                            ->trim('[]')
                            ->explode('|')
                            ->first();
                        $subject = $subjects->where('name', $key)
                            ->where('incomplete_identification', 0)
                            ->first();
                        if (
                            empty($subject)
                            || in_array($key, $references)
                            || (
                                (
                                    (
                                        $subject?->category->contains('name', 'Topics')
                                        || $subject?->category->contains('name', 'Index')
                                    )
                                    && ! in_array($subject->name, [
                                        'Deseret News',
                                        'Frontier Guardian',
                                        'Gospel Reflector',
                                        'Juvenile Instructor',
                                        'Latter-day Saints\' Millennial Star',
                                        'Latter Day Saints\' Messenger and Advocate',
                                        'Liverpool Papers',
                                        'Nauvoo Neighbor',
                                        'New York Messenger',
                                        'The Evening and the Morning Star',
                                        'The Prophet',
                                        'The Seer',
                                        'Times and Seasons',
                                        'Zion\'s Watchman',
                                    ])
                                )
                                || $subject?->category->contains('name', 'Scriptural Figures')
                            )
                        ) {
                            return str($matches[0])
                                ->trim('[]')
                                ->explode('|')
                                ->last();
                        } else {
                            $index++;
                            $references[] = $key;

                            return str($matches[0])
                                ->trim('[]')
                                ->explode('|')
                                ->last()."<sup>$index</sup>";
                        }
                    });

                $partial = $partial->replaceMatches('/(?<!-)(?:{)(.*?)(?:})/m', function (array $match) {
                    $text = str($match[1]);
                    $parts = $text->explode('|');

                    switch ($parts->count()) {
                        case 1:
                            return '{Shorthand: '.$parts->first().'}';
                        case 2:
                            return '{'.$parts->last().': '.$parts->first().'}';
                        case 3:
                            return '{'.$parts->last().': '.$parts->first().'}';
                        default:
                            return '{'.$match[1].'}';
                    }
                });

                $footnotes = '';
                // TODO: Need to fix super script numbers and footnotes numbering
                // All tags superscript is getting incremented, but I'm de-duplicating in footnotes
                foreach ($matches as $key => $match) {
                    $subject = $subjects->where('name', $match)
                        ->where('incomplete_identification', 0)
                        ->first();
                    if (
                        empty($subject)
                        || $subject?->category->contains('name', 'Scriptural Figures')
                        || $subject?->category->contains('name', 'CBI')
                    ) {
                        logger()->info('Subject not found: '.$match);

                        continue;
                    }

                    if (
                        $subject?->category->contains('name', 'People')
                    ) {
                        $allPeople->push($subject);
                        $footnotes .= '<p>';
                        $footnotes .= (array_search($subject->name, $references) + 1).' '.$subject->short_bio;
                        $footnotes .= '</p>'."\n";
                    }

                    if ($subject?->category->contains('name', 'Places')) {
                        $allPlaces->push($subject);
                        $footnotes .= '<p>'.(array_search($subject->name, $references) + 1).' '.$subject->name;
                        $footnotes .= '</p>'."\n";
                    }

                    if (
                        ($subject?->category->contains('name', 'Topics') || $subject?->category->contains('name', 'Index'))
                        && in_array($subject->name, [
                            'Deseret News',
                            'Frontier Guardian',
                            'Gospel Reflector',
                            'Juvenile Instructor',
                            'Latter-day Saints\' Millennial Star',
                            'Latter Day Saints\' Messenger and Advocate',
                            'Liverpool Papers',
                            'Nauvoo Neighbor',
                            'New York Messenger',
                            'The Evening and the Morning Star',
                            'The Prophet',
                            'The Seer',
                            'Times and Seasons',
                            'Zion\'s Watchman',
                        ])
                    ) {
                        $allTopics->push($subject);
                        $footnotes .= '<p>'.(array_search($subject->name, $references) + 1).' '.$subject->name;
                        $footnotes .= '</p>'."\n";
                    }

                    /* try {
                         $footnotes .= '<p>'.(array_search($subject->name, $matches) + 1).' '.$subject->name.' ('.$subject->display_life_years.')'.'</p>'."\n";
                     } catch (\Exception $e) {
                         logger()->info('Error: '.$e->getMessage());
                         logger()->info('Match: '.$match);
                     }*/

                }
                logger()->info($footnotes);
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
            /*->replaceMatches('/(?<!-)(?:{)(.*?)(?:})/m', function (array $match) {
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
            })*/
            ->toString();

        $printTranscript .= "\n".'<h2>People</h2>'."\n";
        $printTranscript .= $allPeople
            ->unique('id')
            ->sortBy('name')
            ->map(fn ($subject) => '<p>'.$subject->short_bio.'</p>')
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

        $filepath = Storage::put(
            'text/'.str($document->name)->slug().'.html',
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$printTranscript.'</body></html>'
        );

        if ($this->option('convert') == 'true') {
            info('Converting '.$document->name);
            $this->convertDocument(storage_path('app/text/'.str($document->name)->slug().'.html'));
        } else {
            info('Skip converting '.$document->name);
        }

        info($document->name.' exported to text successfully!');
    }

    private function convertDocument($path)
    {
        $cloudconvert = new CloudConvert([
            'api_key' => config('services.coudconvert.api_key'),
            'sandbox' => false,
        ]);

        $job = (new Job())
            ->addTask(new Task('import/upload', 'upload-my-file'))
            ->addTask(
                (new Task('convert', 'convert-my-file'))
                    ->set('input', 'upload-my-file')
                    ->set('output_format', 'docx')
            )
            ->addTask(
                (new Task('export/url', 'export-my-file'))
                    ->set('input', 'convert-my-file')
            );

        $job = $cloudconvert->jobs()->create($job);

        $uploadTask = $job->getTasks()->whereName('upload-my-file')[0];
        $cloudconvert->tasks()->upload($uploadTask, fopen($path, 'r'), basename($path));

        $cloudconvert->jobs()->wait($job);
        $file = $job->getExportUrls()[0];

        $source = $cloudconvert->getHttpTransport()->download($file->url)->detach();
        if (! Storage::exists('conversions')) {
            Storage::createDirectory('conversions');
        }
        if (Storage::fileExists('conversions/'.$file->filename)) {
            Storage::delete('conversions/'.$file->filename);
        }

        $dest = fopen(storage_path('app/conversions/'.$file->filename), 'w');

        stream_copy_to_stream($source, $dest);
    }
}
