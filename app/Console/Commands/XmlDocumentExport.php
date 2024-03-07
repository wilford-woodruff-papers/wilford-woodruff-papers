<?php

namespace App\Console\Commands;

use App\Models\Item;
use App\Models\Subject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Saloon\XmlWrangler\Data\CDATA;
use Saloon\XmlWrangler\Data\Element;
use Saloon\XmlWrangler\XmlWriter;

use function Laravel\Prompts\info;

class XmlDocumentExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export XML Document';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //        $id = search(
        //            'Search for the document by name',
        //            fn (string $value) => strlen($value) > 0
        //                ? Item::query()
        //                    ->where('name', 'like', "%{$value}%")
        //                    ->pluck('name', 'id')
        //                    ->all()
        //                : []
        //        );

        $document = Item::query()
            ->with([
                'type',
                'containerPages',
                'containerPages.dates',
            ])
            ->where('name', 'Journal (January 1, 1838 – December 31, 1839)')
            ->first();

        info($document->name.' will be exported to XML');

        $writer = new XmlWriter;

        $dates = collect();
        $document->containerPages->each(function ($page) use (&$dates) {
            foreach ($page->dates as $date) {
                $dates->push($date);
            }
        });
        $dates = $dates
            ->unique('date')
            ->sortBy('date', SORT_REGULAR);

        $fullTranscript = str(
            $document
                ->containerPages
                ->pluck('transcript')
                ->join("\n")
        );

        $xml = $writer->write('document', [
            'type' => $document->type->name,
            'name' => $document->name,

            'entries' => [
                'entry' => $dates
                    ->map(function ($date) use ($fullTranscript) {
                        $transcript = $fullTranscript->extractContentOnDate($date->date);
                        $subjects = Subject::extractFromText($transcript);

                        $element = [
                            'transcript' => CDATA::make($transcript),
                        ];

                        foreach (['people' => 'People', 'places' => 'Places', 'topics' => 'Index'] as $key => $subject) {
                            if ($subjects->get($subject)?->count() > 0) {
                                $element[$key] = [
                                    str($key)->singular()->toString() => $subjects->get($subject)
                                        ?->sortBy('name')
                                        ->map(fn ($subject) => $subject->name)
                                        ->values()
                                        ->toArray(),
                                ];
                            }
                        }

                        return Element::make($element)
                            ->setAttributes([
                                'date' => $date->date->toDateString(),
                            ]);
                    })
                    ->toArray(),
            ],
        ]);

        Storage::put('document.xml', $xml);

        info($document->name.' exported to XML successfully!');

    }
}
