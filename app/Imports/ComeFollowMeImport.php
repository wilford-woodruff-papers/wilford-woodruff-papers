<?php

namespace App\Imports;

use App\Models\ComeFollowMe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ComeFollowMeImport implements ToCollection, WithHeadingRow
{
    public function __construct(public string $book)
    {
    }

    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['week'])) {
                continue;
            }
            $cfm = ComeFollowMe::updateOrCreate([
                'book' => $this->book,
                'week' => $row['week'],
            ], [
                'date' => $row['cfm_calendar_date'],
                'reference' => $this->getReference($row['title']),
                'title' => $this->getTitle($row['title']),
                'quote' => $row['1_quotestory_shauna'],
                'page_id' => $this->getPageId($row['1_link_to_document_journal_discourse_etc']),
                'article_link' => $row['article_short_message_ww_gem_1_2_paragraphs_include_links_to_documents'],
                'video_link' => $row['video_big_questions_testimony_interview_destinations_day_in_life'],
            ]);

            if ($cfm->media->count() < 1) {
                $cfm
                    ->addMediaFromBase64(
                        base64_encode(
                            file_get_contents(
                                storage_path('app/cfm/'.str($cfm->date)->replace('-', '–')->toString().'.webp')
                            )
                        )
                    )
                    ->usingFileName($cfm->date.'.webp')
                    ->preservingOriginal()
                    ->toMediaCollection(collectionName: 'cover_image', diskName: 'come_follow_me');
            }

            $links = [];
            $links = [
                $row['link_to_document_journal_discourse_etc'] => $row['people_michael'],
            ];
            $eventDescriptions = str($row['events_ashlyn_places_matthew'])
                ->explode("\n")
                ->map(function ($item) {
                    return trim($item);
                })
                ->filter(function ($item) {
                    return ! empty($item);
                })
                ->values()
                ->all();

            $eventLinks = str($row['jons_event_links_to_document_journal_discourse_etc'])
                ->explode("\n")
                ->map(function ($item) {
                    return trim($item);
                })
                ->filter(function ($item) {
                    return ! empty($item);
                })
                ->values()
                ->all();

            ray($eventLinks, $eventDescriptions);
            $events = array_combine($eventLinks, $eventDescriptions);

            $links = array_merge($links, $events);

            $cfm->events()->delete();
            foreach ($links as $link => $description) {
                if (str($link)->contains('documents')) {
                    $cfm->events()->create([
                        'description' => $description,
                        'page_id' => $this->getPageId($link),
                    ]);
                }
            }
        }
    }

    private function getReference($title)
    {
        return str($title)
            ->before(':')
            ->trim(' "')
            ->toString();
    }

    private function getTitle($title)
    {
        return str($title)
            ->after(':')
            ->trim(' "')
            ->toString();
    }

    private function getPageId(?string $reference): ?int
    {
        $page = null;
        logger()->info($reference);
        if (str($reference)->afterLast('/')->isUuid()) {
            logger()->info(str($reference)->afterLast('/'));
            $page = \App\Models\Page::whereUuid(str($reference)->afterLast('/')->toString())->first();
        } elseif (str($reference)->afterLast('/')->isNotEmpty()) {
            logger()->info(str($reference)->afterLast('/'));
            $page = \App\Models\Page::findByHashidOrFail(str($reference)->afterLast('/')->toString());
        }

        return $page?->id;
    }
}
