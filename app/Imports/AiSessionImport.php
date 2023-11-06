<?php

namespace App\Imports;

use App\Models\AiQuestion;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AiSessionImport implements ToCollection, WithHeadingRow
{
    public function __construct(
        public string $sessionId
    ) {
        //
    }

    public function collection(Collection $rows)
    {
        // Source options:
        //   - Inworld User
        //   - Wilford Woodruff
        $text = '';
        $question = new AiQuestion();
        $session = \App\Models\AiSession::firstOrCreate([
            'session_id' => $this->sessionId,
        ]);

        if (! $session->wasRecentlyCreated) {
            logger('Session already exists: '.$this->sessionId);

            return;
        }

        foreach ($rows as $row) {
            //            if($row['source'] != $oldSource){
            //                $newSource = $row['source'];
            //            }

            if ($row['source'] == 'Inworld User') {
                if (! empty($question->question)) {
                    $question->answer .= $text."\n";
                    $question->session()->associate($session);
                    $question->save();
                    $text = '';
                }
                $question = new AiQuestion();
                $question->question = $row['text'];
            } else {
                $text .= $row['text']."\n";
            }

            if (! empty($question->question)) {
                $question->answer .= $text."\n";
                $question->session()->associate($session);
                $question->save();
                $text = '';
            }

            //            if($newSource != $oldSource){
            //
            //                $question->save();
            //            }
            //
            //            $oldSource = $newSource;
        }

    }

    public function headingRow(): int
    {
        return 3;
    }
}
