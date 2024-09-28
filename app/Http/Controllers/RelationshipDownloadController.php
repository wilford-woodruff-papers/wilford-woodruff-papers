<?php

namespace App\Http\Controllers;

use App\Exports\RelationshipExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RelationshipDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Excel::download(
            new RelationshipExport,
            'my-wilford-woodruff-papers-relationships.xlsx',
            \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
