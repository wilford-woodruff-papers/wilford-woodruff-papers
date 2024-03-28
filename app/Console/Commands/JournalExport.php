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
                'containerPages.dates',
                'values',
                'values.property',
                'values.source',
                'values.repository',
            ])
            ->whereIn('type_id', Type::where('name', 'Journals')->pluck('id')->toArray())
            ->limit(1)
            ->get();

        foreach ($documents as $document) {
            $this->exportDocument($document);
        }

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
                $line->contains('<time datetime="')
            ) {
                $subjects = Subject::extractFromText($partial);
                $footnotes = '';
                foreach (['people' => 'People', 'places' => 'Places'] as $key => $category) {
                    if ($subjects->get($category)?->count() > 0) {
                        switch ($category) {
                            case 'People':
                                $footnotes .= '<h3>'.$category.'</h3>';
                                $allPeople = $allPeople->merge($subjects->get($category));
                                $footnotes .= $subjects->get($category)
                                    ?->sortBy('name')
                                    ->map(fn ($subject) => '<p>'.$subject->name.' ('.$subject->display_life_years.')'.'</p>')
                                    ->values()
                                    ->join("\n");
                                break;
                            case 'Places':
                                $footnotes .= '<h3>'.$category.'</h3>';
                                $allPlaces = $allPlaces->merge($subjects->get($category));
                                $footnotes .= $subjects->get($category)
                                    ?->sortBy('name')
                                    ->map(fn ($subject) => '<p>'.$subject->name.'</p>')
                                    ->values()
                                    ->join("\n");
                                break;
                        }

                    }
                }
                $partial .= $footnotes."\n";
                $printTranscript .= $partial;
                $partial = '';
            }
            $partial .= $line;
        }

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
