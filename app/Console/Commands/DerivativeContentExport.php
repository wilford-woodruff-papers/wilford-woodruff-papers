<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Faq;
use App\Models\Video;
use CloudConvert\CloudConvert;
use CloudConvert\Models\Job;
use CloudConvert\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\info;

class DerivativeContentExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:content {--convert=false}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export derivative as text';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $text = '';
        $documents = Faq::query()
            ->select([
                'question',
                'answer',
            ])
            ->get()
            ->each(function ($faq) use (&$text) {
                $text .= $faq->question."\n";
                $text .= $faq->answer."\n\n";
            });

        $documentName = 'faqs/frequently-asked-questions';

        Storage::put(
            'text/'.$documentName.'.html',
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$text.'</body></html>'
        );
        $this->convertDocument(storage_path('app/text/'.$documentName.'.html'), $documentName.'.docx');

        $documents = Article::query()
            ->select([
                'id',
                'type',
                'title',
                'description',
            ])
            ->whereNotNull('description')
            ->get();
        foreach ($documents as $document) {
            $this->exportDocument($document);
        }

        $documents = Video::query()
            ->select([
                'id',
                'type',
                'title',
                'transcript',
            ])
            ->whereNotNull('transcript')
            ->get();
        foreach ($documents as $document) {
            $this->exportDocument($document);
        }

        info('https://cloudconvert.com/html-to-docx');

    }

    private function exportDocument($document)
    {
        $documentName = match ($document->type) {
            'Article' => class_basename($document).'/'.str($document->title)->slug(),
            'Video' => class_basename($document).'/'.str($document->title)->slug(),
            default => class_basename($document).'/'.$document->id,
        };

        $fullTranscript = match ($document->type) {
            'Article' => $document->description,
            'Video' => $document->transcript,
            default => '',
        };

        Storage::put(
            'text/'.$documentName.'.txt',
            $fullTranscript
        );

        // I was able to save the text and then use this online converter to convert to Word:
        // https://cloudconvert.com/html-to-docx

        $filepath = Storage::put(
            'text/'.$documentName.'.html',
            '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>'.$fullTranscript.'</body></html>'
        );

        if ($this->option('convert') == 'true') {
            if (! Storage::fileExists('conversions/'.$documentName.'.docx')) {
                info('Converting '.$documentName);
                $this->convertDocument(storage_path('app/text/'.$documentName.'.html'), $documentName.'.docx');
            }
        } else {
            info('Skip converting '.$documentName);
        }

        info($documentName.' exported to text successfully!');
    }

    private function convertDocument($path, $documentName = null)
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
        if (! Storage::exists('conversions/'.dirname($documentName))) {
            Storage::createDirectory('conversions/'.dirname($documentName));
        }
        if (Storage::fileExists('conversions/'.$documentName)) {
            Storage::delete('conversions/'.$documentName);
        }

        $dest = fopen(storage_path('app/conversions/'.$documentName), 'w');

        stream_copy_to_stream($source, $dest);
    }
}
