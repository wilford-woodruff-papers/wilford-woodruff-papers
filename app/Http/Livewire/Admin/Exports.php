<?php

namespace App\Http\Livewire\Admin;

use App\Exports\PcfExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Exports extends Component
{
    public $report = null;

    public $message = '';

    public $reports = [
        PcfExport::class => 'PCF Export',
    ];

    public $exports = [];

    public function render()
    {
        $this->exports = Export::query()
            ->with('user')
            ->latest()
            ->limit(20)
            ->get();

        return view('livewire.admin.exports')
            ->layout('layouts.admin');
    }

    public function export()
    {
        if (! empty($this->report)) {
            (new $this->report(auth()->user()))
                ->store($filename = now('America/Denver')->toDateTimeString().'_'.str(class_basename($this->report))->lower().'.xlsx', 'exports')
                ->onQueue('exports')
                ->chain([
                    new NotifyUserOfCompletedExport(class_basename($this->report), $filename, auth()->user()),
                ]);

            $this->message = 'Export queued.';
        }
    }

    public function delete($id)
    {
        $export = Export::find($id);
        Storage::disk('exports')->delete($export->filename);
        $export->delete();
        $this->message = 'Export deleted.';
    }
}
