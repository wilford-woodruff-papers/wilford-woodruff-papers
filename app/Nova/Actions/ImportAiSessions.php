<?php

namespace App\Nova\Actions;

use App\Imports\AiSessionImport;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Facades\Excel;

class ImportAiSessions extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Import AI Sessions';

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $zip = new \ZipArchive();
        $status = $zip->open($fields->file->getRealPath());
        if ($status !== true) {
            throw new \Exception($status);
        } else {
            $storageDestinationPath = storage_path('temp/'.str($fields->file->getClientOriginalName())->slug());

            if (\File::exists($storageDestinationPath)) {
                \File::deleteDirectory($storageDestinationPath);
                \File::makeDirectory($storageDestinationPath, 0755, true);
            }

            $zip->extractTo($storageDestinationPath);
            $zip->close();

            ray('Zip file extracted to '.$storageDestinationPath);

            $files = \File::allFiles($storageDestinationPath);

            foreach ($files as $file) {
                $handle = fopen($storageDestinationPath.'/'.$file->getFilename(), 'r');
                $contents = fgetcsv($handle);
                fclose($handle);
                $sessionId = str(array_shift($contents))->afterLast('/');
                ray($file->getFilename());
                Excel::import(new AiSessionImport($sessionId), $storageDestinationPath.'/'.$file->getFilename());
            }

            return Action::message('Files have been unzipped and are queued for processing.');
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            File::make('File')
                ->disk('temp'),
        ];
    }
}
