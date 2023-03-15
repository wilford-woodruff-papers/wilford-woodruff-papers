<?php

namespace App\Http\Controllers\OAI;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\OaiToken;
use Illuminate\Support\Str;

class OaiController extends Controller
{
    private $perPage = 20;

    public function __invoke()
    {
        if (request('resumptionToken')) {
            $resumptionToken = OaiToken::query()
                ->firstWhere('token', request('resumptionToken'));
            $verb = $resumptionToken->verb;
        } else {
            $verb = request('verb');
        }

        if (! empty($verb)) {
            switch ($verb) {
                case 'Identify':
                    return response()->view('oai.identify')
                        ->header('Content-Type', 'text/xml');

                case 'GetRecord':
                    $item = Item::whereUuid(str(request('Identifier'))->replace('oai:', '')->toString())
                        ->firstOrFail();

                    return response()->view('oai.record', ['item' => $item])
                        ->header('Content-Type', 'text/xml');

                case 'ListRecords':
                    if (request('resumptionToken')) {
                        $cursor = $resumptionToken->cursor;
                    } else {
                        $cursor = 0;
                        $resumptionToken = OaiToken::create([
                            'token' => Str::ulid(),
                            'verb' => request('verb'),
                            'from' => request('from'),
                            'until' => request('until'),
                            'set' => request('set'),
                            'cursor' => $cursor,
                            'expires_at' => now()->addDays(1)->toDateTimeString(),
                            'metadataPrefix' => request('metadataPrefix', 'oai_dc'),
                        ]);
                    }

                    $items = Item::query()
                        ->paginate($this->perPage, ['*'], 'page', (($cursor / $this->perPage) + 1));

                    $resumptionToken->increment('cursor', $this->perPage);

                    return response()->view('oai.records', [
                        'items' => $items,
                        'from' => $resumptionToken->from,
                        'until' => $resumptionToken->until,
                        'set' => request('set'),
                        'metadataPrefix' => request('metadataPrefix', 'oai_dc'),
                        'resumptionToken' => $resumptionToken,
                        'cursor' => $cursor,
                    ])
                        ->header('Content-Type', 'text/xml');

            }
        }
    }
}
