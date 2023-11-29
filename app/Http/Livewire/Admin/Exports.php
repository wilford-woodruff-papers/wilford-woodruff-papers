<?php

namespace App\Http\Livewire\Admin;

use App\Exports\OverdueTaskExport;
use App\Exports\PageExport;
use App\Exports\PcfExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Models\Export;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Exports extends Component
{
    public $export = null;

    public $message = '';

    public $reports = [
        PcfExport::class => 'PCF Export',
        PageExport::class => 'Page Export',
        OverdueTaskExport::class => 'Overdue Tasks Export',
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
        if (! empty($this->export)) {
            (new $this->export(auth()->user()))
                ->store($filename = now('America/Denver')->toDateTimeString().'_'.str(class_basename($this->export))->lower().'.xlsx', 'exports')
                ->onQueue('exports')
                ->chain([
                    new NotifyUserOfCompletedExport(class_basename($this->export), $filename, auth()->user()),
                ]);

            $this->message = 'Export queued.';
        } else {
            $this->message = 'Error queuing Export.';
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
