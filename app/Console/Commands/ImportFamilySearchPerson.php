<?php

namespace App\Console\Commands;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportFamilySearchPerson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'familysearch:import-person {userid?} {subject?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a person from FamilySearch.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::findOrFail($this->argument('userid'));
        $subjectId = $this->argument('subject');

        $peopleCount = Subject::query()
            ->people()
            ->when($subjectId, function ($query, $subjectId) {
                $query->where('id', $subjectId);
            })
            ->where(function ($query) {
                $query->whereNotNull('pid')
                    ->orWhere('pid', '!=', 'n/a');
            })
            ->where(function ($query) {
                $query->whereNull('portrait')
                    ->orWhereNull('familysearch_person');
            })
            ->count();

        $bar = $this->output->createProgressBar($peopleCount);

        $bar->start();

        Subject::query()
            ->select('id', 'name', 'pid', 'portrait', 'familysearch_person')
            ->people()
            ->where(function ($query) {
                $query->whereNotNull('pid')
                    ->orWhere('pid', '!=', 'n/a');
            })
            ->where(function ($query) {
                $query->whereNull('portrait')
                    ->orWhereNull('familysearch_person');
            })
            //->limit(10)
            ->chunkById(20, function ($people) use (&$bar, $user) {
                foreach ($people as $person) {
                    if (empty($person->familysearch_person)) {
                        $response = Http::withToken($user->familysearch_token)
                            ->withHeaders([
                                'Accept' => 'application/json',
                            ])
                            ->get(
                                config('services.familysearch.base_uri').'/platform/tree/persons/'.$person->pid
                            );
                        if ($response->ok()) {
                            $person->update([
                                'familysearch_person' => $response->json(),
                            ]);
                        }
                        unset($response);
                    }
                    if (empty($person->portrait)) {
                        $response = Http::withOptions([
                            'allow_redirects' => ['track_redirects' => true],
                        ])->get(
                            config('services.familysearch.base_uri').'/platform/tree/persons/'.$person->pid.'/portrait?default='.asset('img/familysearch/'.$person->gender.'.png').'&access_token='.$user->familysearch_token
                        );
                        if (
                            $response->ok()
                            && ! empty($response->header(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER))
                            && ! str($response->header(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER))->contains('access_token')
                        ) {
                            $person->update([
                                'portrait' => $response->header(\GuzzleHttp\RedirectMiddleware::HISTORY_HEADER),
                            ]);
                        } elseif ($response->tooManyRequests()) {
                            sleep($response->header('Retry-After'));
                        }
                        unset($response);
                    }
                    $bar->advance();
                    //usleep(300000);
                }
            });
        $bar->finish();
    }
}
