<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use \App\Http\Controllers\ReportController;

class ReportsExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $data = app(ReportController::class)
            ->getData($this->request);

        return view('reports.excel', compact('data'));
    }
}