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
                'values',
                'values.property',
                'values.source',
                'values.repository',
                'values.copyright',
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
                ->map(function ($page) {
                    $page->transcript = str($page->transcript)->replaceMatches(
                        '/(<time datetime=")/',
                        function ($matches) use ($page) {
                            return '@Page '.$page->uuid.'@ '.$matches[0];
                        });

                    return $page;
                })
                ->pluck('transcript')
                ->join("\n")
        );

        $properties = [];

        foreach ($document->values as $value) {
            $text = match ($value->property->type) {
                'relationship' => $value?->{str($value?->property->relationship)->lower()}?->name,
                default => $value->value,
            };
            $properties[] = Element::make($text)
                ->setAttributes([
                    'name' => $value->property->name,
                ]);
        }

        $xml = $writer->write('document', [
            'type' => $document->type->name,
            'name' => $document->name,
            'uuid' => $document->uuid,
            'properties' => [
                'property' => $properties,
            ],
            'entries' => [
                'entry' => $dates
                    ->map(function ($date) use ($fullTranscript) {
                        $transcript = $fullTranscript->extractContentOnDate($date->date);
                        $pageUuid = $transcript->match('/(@Page .*@)/U')->trim('@')->after('Page ');
                        $transcript = $transcript->replaceMatches('/(<span class="hidden">.*<\/span>\s)/U', '');
                        $subjects = Subject::extractFromText($transcript);

                        $element = [
                            'page' => [
                                'uuid' => $pageUuid->toString(),
                            ],
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

        Storage::put('xml/'.str($document->name)->slug().'.xml', $xml);

        info($document->name.' exported to XML successfully!');

    }
}
