<?php

namespace App\Http\Livewire\Admin;

use App\Exports\PcfExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Livewire\Component;

class Exports extends Component
{
    public function render()
    {
        (new PcfExport)
            ->store($filename = now('America/Denver')->toDateTimeString().'_pcf.xlsx', 'exports')
            ->onQueue('exports')
            ->chain([
                new NotifyUserOfCompletedExport($filename, auth()->user()),
            ]);

        return view('livewire.admin.exports')
            ->layout('layouts.admin');
    }
}
