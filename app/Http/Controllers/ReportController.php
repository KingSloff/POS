<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Report\StatsReport;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Display the stats report
     */
    public function stats()
    {
        $report = new StatsReport();

        return view('reports.report.stats', compact('report'));
    }
}
