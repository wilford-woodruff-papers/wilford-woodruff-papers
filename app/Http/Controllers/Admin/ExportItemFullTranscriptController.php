<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ItemsTranscriptExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Regex\Regex;

class ExportItemFullTranscriptController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $uniqueIdentifiers = str($request->input('items'))->explode(',');
        $items = collect([]);
        foreach ($uniqueIdentifiers as $uniqueIdentifier) {
            $result = Regex::match('/([a-z]{1,2})-([0-9]+)([a-z]{0,2})/i', $uniqueIdentifier);
            $prefix = $result->group(1);
            $uniqueId = $result->group(2);
            $suffix = ! empty($result->group(3)) ? $result->group(3) : null;
            $items->push(Item::query()
                ->where('pcf_unique_id_prefix', $prefix)
                ->where('pcf_unique_id', $uniqueId)
                ->when($suffix, function ($query, $suffix) {
                    $query->where('pcf_unique_id_suffix', $suffix);
                })
                ->first());
        }

        $transcripts = collect([]);
        foreach ($items as $item) {
            $transcription = '';
            foreach ($item->pages as $page) {
                $transcription = $transcription.$page->transcript."\n";
            }
            $transcripts->push([
                'Unique ID' => $item->pcf_unique_id_full,
                'Transcription' => strip_tags($transcription),
            ]);
        }

        return Excel::download(new ItemsTranscriptExport($transcripts), 'item_transcripts.xlsx');
    }
}
